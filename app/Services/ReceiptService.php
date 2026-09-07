<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use App\Core\Logger;

class ReceiptService
{
    /**
     * Convert numeric amount to Thai Baht Text
     * Example: 1520.50 => หนึ่งพันห้าร้อยยี่สิบบาทห้าสิบสตางค์
     */
    public static function thaiBahtText(float|int $amount): string
    {
        $amount = round($amount, 2);
        if ($amount == 0) {
            return 'ศูนย์บาทถ้วน';
        }

        $isNegative = $amount < 0;
        $amount = abs($amount);

        $numberParts = explode('.', sprintf('%.2f', $amount));
        $baht = $numberParts[0];
        $satang = $numberParts[1] ?? '00';

        $thaiDigits = ['', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า'];
        $thaiPositions = ['', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน'];

        $convertGroup = function (string $numStr) use ($thaiDigits, $thaiPositions): string {
            $len = strlen($numStr);
            $text = '';
            for ($i = 0; $i < $len; $i++) {
                $digit = (int)$numStr[$i];
                $pos = $len - $i - 1;

                if ($digit === 0) {
                    continue;
                }

                if ($pos === 0 && $digit === 1 && $len > 1 && $numStr[$len - 2] !== '0') {
                    $text .= 'เอ็ด';
                } elseif ($pos === 1 && $digit === 2) {
                    $text .= 'ยี่สิบ';
                } elseif ($pos === 1 && $digit === 1) {
                    $text .= 'สิบ';
                } else {
                    $text .= $thaiDigits[$digit] . $thaiPositions[$pos];
                }
            }
            return $text;
        };

        $bahtText = '';
        if ((int)$baht > 0) {
            $bahtGroups = [];
            $str = (string)$baht;
            while (strlen($str) > 0) {
                $len = strlen($str);
                $cut = $len > 6 ? $len - 6 : 0;
                $bahtGroups[] = substr($str, $cut);
                $str = substr($str, 0, $cut);
            }

            $groupTexts = [];
            foreach ($bahtGroups as $idx => $g) {
                $gt = $convertGroup($g);
                if (!empty($gt)) {
                    $groupTexts[] = $gt . str_repeat('ล้าน', $idx);
                }
            }
            $bahtText = implode('', array_reverse($groupTexts)) . 'บาท';
        }

        $satangText = '';
        if ((int)$satang > 0) {
            $satangText = $convertGroup($satang) . 'สตางค์';
        } else {
            $satangText = 'ถ้วน';
        }

        return ($isNegative ? 'ลบ' : '') . $bahtText . $satangText;
    }

    /**
     * Generate unique Receipt Number (e.g. RCP-256709-0012)
     */
    public static function generateReceiptNo(int $year, int $month, int $sequence = 0): string
    {
        $thaiYear = $year + 543;
        $prefix = sprintf('RCP-%04d%02d-', $thaiYear, $month);
        
        if ($sequence > 0) {
            return $prefix . str_pad((string)$sequence, 5, '0', STR_PAD_LEFT);
        }

        $count = (int)Database::value(
            "SELECT COUNT(*) FROM receipts WHERE billing_year = ? AND billing_month = ?",
            [$year, $month]
        );

        return $prefix . str_pad((string)($count + 1), 5, '0', STR_PAD_LEFT);
    }

    /**
     * Get receipts for a member with optional filters
     */
    public static function getMemberReceipts(int $memberId, ?int $year = null, ?int $month = null): array
    {
        $sql = "SELECT * FROM receipts WHERE member_id = ?";
        $params = [$memberId];

        if ($year !== null && $year > 0) {
            $sql .= " AND billing_year = ?";
            $params[] = $year;
        }

        if ($month !== null && $month > 0) {
            $sql .= " AND billing_month = ?";
            $params[] = $month;
        }

        $sql .= " ORDER BY billing_year DESC, billing_month DESC, id DESC";

        return Database::query($sql, $params);
    }

    /**
     * Get single receipt by receipt_no with full member and details
     */
    public static function getReceiptDetails(string $receiptNo): ?array
    {
        $receipt = Database::first(
            "SELECT r.*, 
                    m.member_no, m.prefix, m.first_name, m.last_name, m.department, m.position, m.id_card, m.phone, m.address,
                    s.total_shares, s.total_amount as share_accumulated
             FROM receipts r
             JOIN members m ON r.member_id = m.id
             LEFT JOIN member_shares s ON m.id = s.member_id
             WHERE r.receipt_no = ? 
             LIMIT 1",
            [$receiptNo]
        );

        if (!$receipt) {
            return null;
        }

        $receipt['baht_text'] = self::thaiBahtText((float)$receipt['total_amount']);
        $receipt['thai_year'] = (int)$receipt['billing_year'] + 543;

        // Fetch loan contract details if loan principal/interest > 0
        $receipt['loan_contracts'] = Database::query(
            "SELECT contract_no, loan_type, loan_name, principal_balance, interest_rate 
             FROM loan_contracts 
             WHERE member_id = ? AND status = 'active'",
            [$receipt['member_id']]
        );

        return $receipt;
    }

    /**
     * Verify receipt by QR verification token
     */
    public static function verifyByToken(string $token): ?array
    {
        $receipt = Database::first(
            "SELECT r.*, m.member_no, m.prefix, m.first_name, m.last_name, m.department, m.position
             FROM receipts r
             JOIN members m ON r.member_id = m.id
             WHERE r.qr_verify_token = ? 
             LIMIT 1",
            [$token]
        );

        if (!$receipt) {
            return null;
        }

        $receipt['baht_text'] = self::thaiBahtText((float)$receipt['total_amount']);
        $receipt['thai_year'] = (int)$receipt['billing_year'] + 543;
        return $receipt;
    }

    /**
     * Generate or create monthly receipt for a single member
     */
    public static function createMonthlyReceipt(int $memberId, int $year, int $month, ?string $issueDate = null): array
    {
        $issueDate = $issueDate ?: date('Y-m-d');

        // Check if receipt already exists
        $existing = Database::first(
            "SELECT * FROM receipts WHERE member_id = ? AND billing_year = ? AND billing_month = ? LIMIT 1",
            [$memberId, $year, $month]
        );

        if ($existing) {
            return [
                'success' => true,
                'is_existing' => true,
                'receipt' => $existing,
                'receipt_no' => $existing['receipt_no'],
                'message' => "มีใบเสร็จงวด {$month}/{$year} อยู่แล้ว"
            ];
        }

        // 1. Get Member Shares monthly deduction
        $shares = Database::first("SELECT monthly_share FROM member_shares WHERE member_id = ? LIMIT 1", [$memberId]);
        $shareAmount = $shares ? (float)$shares['monthly_share'] : 0.0;

        // 2. Get Active Loans monthly deduction
        $loans = Database::query(
            "SELECT loan_amount, principal_balance, interest_rate, monthly_installment 
             FROM loan_contracts 
             WHERE member_id = ? AND status = 'active'",
            [$memberId]
        );

        $loanPrincipal = 0.0;
        $loanInterest = 0.0;

        foreach ($loans as $ln) {
            $balance = (float)$ln['principal_balance'];
            $rate = (float)$ln['interest_rate'];
            $installment = (float)$ln['monthly_installment'];

            $interest = round(($balance * ($rate / 100)) / 12, 2);
            $principal = round(max(0, $installment - $interest), 2);
            if ($principal > $balance) {
                $principal = $balance;
            }

            $loanPrincipal += $principal;
            $loanInterest += $interest;
        }

        // 3. Get Deposit Accounts monthly deduction (if any recurring saving)
        $depositAmount = 0.0;

        $otherAmount = 0.0;
        $totalAmount = $shareAmount + $loanPrincipal + $loanInterest + $depositAmount + $otherAmount;

        // If total is 0, set standard share minimum if member is active
        if ($totalAmount <= 0) {
            $shareAmount = 1000.0;
            $totalAmount = 1000.0;
        }

        $receiptNo = self::generateReceiptNo($year, $month);
        $qrToken = bin2hex(random_bytes(24));

        $newId = Database::insert(
            "INSERT INTO receipts (
                receipt_no, member_id, billing_month, billing_year, issue_date,
                share_amount, loan_principal, loan_interest, deposit_amount, other_amount,
                total_amount, qr_verify_token, status, created_at
             ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'paid', NOW())",
            [
                $receiptNo, $memberId, $month, $year, $issueDate,
                $shareAmount, $loanPrincipal, $loanInterest, $depositAmount, $otherAmount,
                $totalAmount, $qrToken
            ]
        );

        // Send notification to member
        Database::insert(
            "INSERT INTO notifications (member_id, title, message, type, link_url, is_read, created_at) 
             VALUES (?, ?, ?, 'receipt', ?, 0, NOW())",
            [
                $memberId,
                "ใบเสร็จรับเงินประจำเดือน {$month}/" . ($year + 543),
                "ออกใบเสร็จรับเงินประจำงวดเรียบร้อยแล้ว ยอดรวม " . number_format($totalAmount, 2) . " บาท เลขที่ {$receiptNo}",
                "/member/receipts"
            ]
        );

        $receipt = self::getReceiptDetails($receiptNo);

        return [
            'success' => true,
            'is_existing' => false,
            'id' => $newId,
            'receipt_no' => $receiptNo,
            'receipt' => $receipt,
            'message' => "สร้างใบเสร็จรับเงินสำเร็จ เลขที่ {$receiptNo}"
        ];
    }

    /**
     * Batch Generate Monthly Receipts for ALL active members (Staff Month-End Run)
     */
    public static function batchGenerateMonthlyReceipts(int $year, int $month): array
    {
        $members = Database::query("SELECT id, member_no, prefix, first_name, last_name FROM members WHERE status = 'active'");
        
        $createdCount = 0;
        $skippedCount = 0;
        $errors = [];

        foreach ($members as $m) {
            try {
                $res = self::createMonthlyReceipt((int)$m['id'], $year, $month);
                if (!empty($res['is_existing'])) {
                    $skippedCount++;
                } else {
                    $createdCount++;
                }
            } catch (\Throwable $e) {
                $errors[] = "สมาชิก {$m['member_no']}: " . $e->getMessage();
                Logger::error("Batch receipt generation error for member {$m['id']}: " . $e->getMessage());
            }
        }

        AuditService::log('billing', 'batch_receipt_generation', 'staff', null, [
            'year' => $year,
            'month' => $month,
            'created' => $createdCount,
            'skipped' => $skippedCount,
            'errors' => count($errors)
        ]);

        return [
            'success' => true,
            'year' => $year,
            'month' => $month,
            'created_count' => $createdCount,
            'skipped_count' => $skippedCount,
            'total_members' => count($members),
            'errors' => $errors,
            'message' => "ประมวลผลใบเสร็จงวด {$month}/" . ($year + 543) . " สำเร็จ: สร้างใหม่ {$createdCount} ฉบับ, มีอยู่แล้ว {$skippedCount} ฉบับ"
        ];
    }
}
