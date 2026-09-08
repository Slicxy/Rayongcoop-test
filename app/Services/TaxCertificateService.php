<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use App\Core\Logger;

class TaxCertificateService
{
    /**
     * Get or initialize annual housing loan interest deduction certificates for a member
     */
    public static function getMemberTaxCertificates(int $memberId): array
    {
        $certs = Database::query(
            "SELECT * FROM tax_certificates WHERE member_id = ? AND status = 'issued' ORDER BY tax_year DESC, id DESC",
            [$memberId]
        );

        if (empty($certs)) {
            // Auto-generate certificates for active member loans (current year and previous year)
            self::autoGenerateSampleCertificates($memberId);
            $certs = Database::query(
                "SELECT * FROM tax_certificates WHERE member_id = ? AND status = 'issued' ORDER BY tax_year DESC, id DESC",
                [$memberId]
            );
        }

        return $certs;
    }

    /**
     * Get single certificate details by ID
     */
    public static function getCertificateById(int $id, ?int $memberId = null): ?array
    {
        $sql = "SELECT c.*, m.member_no, m.prefix, m.first_name, m.last_name, m.department, m.id_card, m.phone, m.address
                FROM tax_certificates c
                JOIN members m ON c.member_id = m.id
                WHERE c.id = ? AND c.status = 'issued'";
        $params = [$id];

        if ($memberId !== null) {
            $sql .= " AND c.member_id = ?";
            $params[] = $memberId;
        }

        $cert = Database::first($sql, $params);
        if (!$cert) {
            return null;
        }

        if (!empty($cert['monthly_breakdown']) && is_string($cert['monthly_breakdown'])) {
            $cert['monthly_breakdown'] = json_decode($cert['monthly_breakdown'], true) ?? [];
        }

        return $cert;
    }

    /**
     * Verify tax certificate by QR code token
     */
    public static function verifyByToken(string $token): ?array
    {
        $cert = Database::first(
            "SELECT c.*, m.member_no, m.prefix, m.first_name, m.last_name, m.department
             FROM tax_certificates c
             JOIN members m ON c.member_id = m.id
             WHERE c.qr_verify_token = ? AND c.status = 'issued' LIMIT 1",
            [$token]
        );

        if (!$cert) {
            return null;
        }

        if (!empty($cert['monthly_breakdown']) && is_string($cert['monthly_breakdown'])) {
            $cert['monthly_breakdown'] = json_decode($cert['monthly_breakdown'], true) ?? [];
        }

        return $cert;
    }

    /**
     * Generate or recalculate tax certificate for a member in a specific year
     */
    public static function generateCertificate(
        int $memberId,
        int $taxYear,
        string $contractNo,
        string $loanType = 'เงินกู้พิเศษเพื่อการเคหะ'
    ): array {
        $member = Database::first("SELECT * FROM members WHERE id = ?", [$memberId]);
        if (!$member) {
            throw new \InvalidArgumentException("Member ID #{$memberId} not found");
        }

        $thaiYear = $taxYear + 543;
        $token = bin2hex(random_bytes(24));
        $certNo = sprintf('TAX-%d-%05d', $thaiYear, $memberId);

        // Check if existing certificate exists
        $existing = Database::first(
            "SELECT id FROM tax_certificates WHERE member_id = ? AND tax_year = ? AND contract_no = ?",
            [$memberId, $taxYear, $contractNo]
        );

        // Calculate 12-month payment breakdown from receipts or simulation
        $monthlyBreakdown = [];
        $totalInterest = 0.0;
        $totalPrincipal = 0.0;

        $thaiMonths = [
            1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
            5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
            9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
        ];

        for ($m = 1; $m <= 12; $m++) {
            // Look up from receipts if available
            $receipt = Database::first(
                "SELECT * FROM receipts WHERE member_id = ? AND billing_year = ? AND billing_month = ?",
                [$memberId, $taxYear, $m]
            );

            $pPaid = $receipt ? (float)$receipt['loan_principal'] : 4500.00;
            $iPaid = $receipt ? (float)$receipt['loan_interest'] : 3250.00;
            $mTotal = $pPaid + $iPaid;

            $totalPrincipal += $pPaid;
            $totalInterest += $iPaid;

            $monthlyBreakdown[] = [
                'month' => $m,
                'month_name' => $thaiMonths[$m],
                'principal' => $pPaid,
                'interest' => $iPaid,
                'total' => $mTotal,
                'receipt_no' => $receipt['receipt_no'] ?? sprintf('RCP-%d%02d-%05d', $thaiYear, $m, $memberId)
            ];
        }

        $totalPaid = $totalPrincipal + $totalInterest;
        $bahtText = ReceiptService::thaiBahtText($totalInterest);
        $borrowerName = ($member['prefix'] ?? '') . $member['first_name'] . ' ' . $member['last_name'];
        $idCardNo = $member['id_card'] ?? '1219900123456';
        $propAddress = $member['address'] ?? 'สำนักงานสาธารณสุขจังหวัดระยอง ต.เชิงเนิน อ.เมือง จ.ระยอง';

        if ($existing) {
            Database::execute(
                "UPDATE tax_certificates SET 
                    borrower_name = ?, id_card_no = ?, property_address = ?,
                    total_interest_paid = ?, total_principal_paid = ?, total_paid = ?,
                    interest_baht_text = ?, monthly_breakdown = ?, qr_verify_token = ?,
                    issue_date = CURDATE(), updated_at = NOW()
                 WHERE id = ?",
                [
                    $borrowerName, $idCardNo, $propAddress,
                    $totalInterest, $totalPrincipal, $totalPaid,
                    $bahtText, json_encode($monthlyBreakdown, JSON_UNESCAPED_UNICODE), $token,
                    $existing['id']
                ]
            );
            $certId = (int)$existing['id'];
        } else {
            $certId = (int)Database::insert(
                "INSERT INTO tax_certificates (
                    certificate_no, member_id, tax_year, thai_year, contract_no,
                    loan_type, borrower_name, id_card_no, property_address,
                    total_interest_paid, total_principal_paid, total_paid,
                    interest_baht_text, monthly_breakdown, qr_verify_token,
                    issue_date, status, created_at
                 ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE(), 'issued', NOW())",
                [
                    $certNo, $memberId, $taxYear, $thaiYear, $contractNo,
                    $loanType, $borrowerName, $idCardNo, $propAddress,
                    $totalInterest, $totalPrincipal, $totalPaid,
                    $bahtText, json_encode($monthlyBreakdown, JSON_UNESCAPED_UNICODE), $token
                ]
            );
        }

        return self::getCertificateById((int)$certId);
    }

    /**
     * Auto-generate sample tax certificates for demo member
     */
    private static function autoGenerateSampleCertificates(int $memberId): void
    {
        $currentYear = (int)date('Y');
        // Generate for current year 2026 (2569) and previous year 2025 (2568)
        self::generateCertificate($memberId, $currentYear, 'LN-HSG-2567-0014', 'เงินกู้พิเศษเพื่อเคหะสงเคราะห์ (ซื้อที่อยู่อาศัย)');
        self::generateCertificate($memberId, $currentYear - 1, 'LN-HSG-2567-0014', 'เงินกู้พิเศษเพื่อเคหะสงเคราะห์ (ซื้อที่อยู่อาศัย)');
    }
}
