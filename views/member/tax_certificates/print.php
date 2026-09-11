<?php
$title = $title ?? 'หนังสือรับรองดอกเบี้ยเงินกู้';
$cert = array_merge([
    'thai_year' => date('Y') + 543,
    'tax_year' => date('Y'),
    'certificate_no' => 'TAX-' . date('Ymd-0001'),
    'issue_date' => date('Y-m-d'),
    'borrower_name' => '-',
    'member_no' => '-',
    'id_card_no' => '-',
    'department' => '-',
    'contract_no' => '-',
    'loan_type' => '-',
    'property_address' => 'ตามสัญญาเงินกู้ที่ระบุไว้กับสหกรณ์',
    'monthly_breakdown' => [],
    'total_principal_paid' => 0,
    'total_interest_paid' => 0,
    'total_paid' => 0,
    'interest_baht_text' => 'ศูนย์บาทถ้วน',
    'qr_verify_token' => ''
], $cert ?? []);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?> - สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Sarabun', sans-serif;
            font-size: 14px;
            color: #000000;
            background-color: #525659;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }
        .page-wrapper {
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            background: #ffffff;
            padding: 20mm 20mm 15mm 20mm;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            position: relative;
        }
        @media print {
            body {
                background: none;
                margin: 0;
            }
            .page-wrapper {
                margin: 0;
                padding: 15mm 15mm 10mm 15mm;
                box-shadow: none;
                width: 100%;
                min-height: auto;
            }
            .no-print {
                display: none !important;
            }
        }

        .action-bar {
            position: fixed;
            top: 15px;
            right: 20px;
            z-index: 9999;
            background: rgba(255, 255, 255, 0.95);
            padding: 10px 16px;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            display: flex;
            gap: 10px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 30px;
            font-family: 'Sarabun', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }
        .btn-primary {
            background-color: #0066CC;
            color: #ffffff;
        }
        .btn-secondary {
            background-color: #e2e8f0;
            color: #334155;
        }

        /* Header */
        .doc-header {
            text-align: center;
            border-bottom: 2px solid #000000;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .coop-logo {
            width: 60px;
            height: 60px;
            margin-bottom: 6px;
        }
        .doc-title {
            font-size: 17px;
            font-weight: 700;
            margin-top: 4px;
        }
        .doc-subtitle {
            font-size: 15px;
            font-weight: 600;
        }
        .doc-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 14px;
            font-size: 13.5px;
        }

        /* Content info */
        .info-grid {
            margin-bottom: 14px;
            font-size: 14px;
        }
        .info-row {
            display: flex;
            margin-bottom: 6px;
        }
        .info-label {
            width: 170px;
            font-weight: 600;
            flex-shrink: 0;
        }
        .info-value {
            flex-grow: 1;
            border-bottom: 1px dotted #94a3b8;
            padding-bottom: 2px;
        }

        /* Table */
        .table-breakdown {
            width: 100%;
            border-collapse: collapse;
            margin: 14px 0;
            font-size: 12.5px;
        }
        .table-breakdown th, .table-breakdown td {
            border: 1px solid #334155;
            padding: 5px 8px;
        }
        .table-breakdown th {
            background-color: #f1f5f9;
            font-weight: 700;
            text-align: center;
        }
        .text-end { text-align: right; }
        .text-center { text-align: center; }

        /* Total Box */
        .total-box {
            border: 1.5px solid #000000;
            padding: 10px 14px;
            margin-bottom: 18px;
            background-color: #fafafa;
        }

        /* Signatures */
        .sig-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 25px;
            padding-top: 10px;
        }
        .qr-box {
            text-align: center;
            font-size: 11px;
            color: #475569;
        }
        .sig-box {
            text-align: center;
            width: 250px;
        }
        .sig-line {
            margin-top: 40px;
            border-bottom: 1px dotted #000;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>

<!-- Floating Action Bar -->
<div class="action-bar no-print">
    <button onclick="window.print()" class="btn btn-primary">
        <i class="bi bi-printer-fill"></i> พิมพ์เอกสาร / บันทึกเป็น PDF
    </button>
    <a href="<?= url('member/tax-certificates') ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> กลับ
    </a>
</div>

<div class="page-wrapper">
    <!-- Header -->
    <div class="doc-header">
        <div style="font-size: 28px; color: #0066CC; margin-bottom: 2px;"><i class="bi bi-bank2"></i></div>
        <h2 style="font-size: 18px; font-weight: 700;">สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</h2>
        <div style="font-size: 12px; color: #475569;">สำนักงานสาธารณสุขจังหวัดระยอง ต.เชิงเนิน อ.เมือง จ.ระยอง 21000 โทรศัพท์ 0-3861-1234</div>
        <div class="doc-title">หนังสือรับรองการชำระดอกเบี้ยเงินกู้ยืมเพื่อซื้อ เช่าซื้อ หรือสร้างอาคารที่อยู่อาศัย</div>
        <div class="doc-subtitle">ประจำปีภาษี พ.ศ. <?= $cert['thai_year'] ?> (ค.ศ. <?= $cert['tax_year'] ?>)</div>
    </div>

    <!-- Meta -->
    <div class="doc-meta">
        <div><strong>เลขที่เอกสาร:</strong> <?= e($cert['certificate_no']) ?></div>
        <div><strong>วันที่ออกเอกสาร:</strong> <?= date('d/m/Y', strtotime($cert['issue_date'])) ?></div>
    </div>

    <!-- Details -->
    <div class="info-grid">
        <div class="info-row">
            <span class="info-label">ชื่อ-นามสกุล ผู้กู้ยืม:</span>
            <span class="info-value"><strong><?= e($cert['borrower_name']) ?></strong></span>
            <span class="info-label" style="width: 100px; text-align: right; padding-right: 8px;">เลขทะเบียน:</span>
            <span class="info-value" style="width: 120px; flex-grow: 0;"><?= e($cert['member_no']) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">เลขประจำตัวประชาชน:</span>
            <span class="info-value"><?= e($cert['id_card_no'] ?? '-') ?></span>
            <span class="info-label" style="width: 100px; text-align: right; padding-right: 8px;">สังกัด:</span>
            <span class="info-value"><?= e($cert['department'] ?? '-') ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">เลขที่สัญญาเงินกู้:</span>
            <span class="info-value"><strong><?= e($cert['contract_no']) ?></strong> (<?= e($cert['loan_type']) ?>)</span>
        </div>
        <div class="info-row">
            <span class="info-label">สถานที่ตั้งหลักประกัน:</span>
            <span class="info-value"><?= e($cert['property_address'] ?? 'ตามสัญญาเงินกู้ที่ระบุไว้กับสหกรณ์') ?></span>
        </div>
    </div>

    <p style="font-size: 13.5px; text-indent: 30px; margin-bottom: 10px;">
        สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด ขอรับรองว่าในรอบปีภาษี พ.ศ. <?= $cert['thai_year'] ?> ผู้กู้ยืมตามรายชื่อข้างต้น ได้ชำระดอกเบี้ยเงินกู้ยืมสำหรับที่อยู่อาศัยตามสัญญาเงินกู้ดังกล่าวข้างต้น โดยมีรายละเอียดการชำระเงินรายเดือน ดังนี้
    </p>

    <!-- 12-Month Table -->
    <table class="table-breakdown">
        <thead>
            <tr>
                <th style="width: 12%;">งวดเดือน</th>
                <th style="width: 22%;">เลขที่ใบเสร็จ</th>
                <th style="width: 22%;">เงินต้นชำระ (บาท)</th>
                <th style="width: 22%;">ดอกเบี้ยชำระ (บาท)</th>
                <th style="width: 22%;">รวมเงินชำระ (บาท)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($cert['monthly_breakdown'])): ?>
                <?php foreach ($cert['monthly_breakdown'] as $row): ?>
                    <tr>
                        <td class="text-center"><?= e($row['month_name']) ?></td>
                        <td class="text-center font-monospace"><?= e($row['receipt_no']) ?></td>
                        <td class="text-end font-monospace"><?= number_format((float)$row['principal'], 2) ?></td>
                        <td class="text-end font-monospace"><?= number_format((float)$row['interest'], 2) ?></td>
                        <td class="text-end font-monospace"><?= number_format((float)$row['total'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr style="background-color: #f8fafc; font-weight: 700;">
                <td colspan="2" class="text-center">รวมทั้งสิ้นในรอบปีภาษี</td>
                <td class="text-end font-monospace"><?= number_format((float)$cert['total_principal_paid'], 2) ?></td>
                <td class="text-end font-monospace" style="color: #0066CC;"><?= number_format((float)$cert['total_interest_paid'], 2) ?></td>
                <td class="text-end font-monospace"><?= number_format((float)$cert['total_paid'], 2) ?></td>
            </tr>
        </tfoot>
    </table>

    <!-- Total Highlight Box -->
    <div class="total-box">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-weight: 700; font-size: 15px;">ยอดดอกเบี้ยเงินกู้ยืมรวมที่สามารถนำไปหักลดหย่อนภาษีได้:</div>
                <div style="font-size: 13.5px; color: #334155;">(ตัวอักษร: <strong><?= e($cert['interest_baht_text']) ?></strong>)</div>
            </div>
            <div style="font-size: 20px; font-weight: 700; color: #0066CC;">
                ฿<?= number_format((float)$cert['total_interest_paid'], 2) ?>
            </div>
        </div>
    </div>

    <p style="font-size: 12px; color: #64748B; line-height: 1.4;">
        * หมายเหตุ: เอกสารฉบับนี้ออกโดยระบบประมวลผลสารสนเทศอิเล็กทรอนิกส์ของสหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด มีผลสมบูรณ์ตามพระราชบัญญัติว่าด้วยธุรกรรมทางอิเล็กทรอนิกส์ พ.ศ. 2544 ผู้มีหน้าที่เสียภาษีสามารถสแกน QR Code ด้านล่างเพื่อตรวจสอบความถูกต้องของเอกสารได้ทันที
    </p>

    <!-- Signatures and QR Code -->
    <div class="sig-section">
        <div class="qr-box">
            <?php
                $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode(url("verify-tax-cert/{$cert['qr_verify_token']}"));
            ?>
            <img src="<?= $qrUrl ?>" alt="QR Verification" style="width: 85px; height: 85px; border: 1px solid #cbd5e1; padding: 2px; border-radius: 6px;">
            <div style="margin-top: 4px; font-size: 10px;">สแกนเพื่อตรวจสอบเอกสาร</div>
        </div>

        <div class="sig-box">
            <div style="font-size: 13px; margin-bottom: 25px;">ขอรับรองว่าข้อความข้างต้นถูกต้องตรงตามความเป็นจริง</div>
            <div style="position: relative; display: inline-block;">
                <span style="font-family: cursive; font-size: 18px; color: #003366;">สอ.สธ.ระยอง</span>
            </div>
            <div class="sig-line"></div>
            <div style="font-weight: 700; font-size: 13px;">(นายธีรพงษ์ สิทธิชัย)</div>
            <div style="font-size: 12px; color: #475569;">ผู้จัดการ สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</div>
        </div>
    </div>
</div>

</body>
</html>
