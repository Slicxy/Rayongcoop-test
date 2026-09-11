<?php
$receipt = array_merge([
    'receipt_no' => 'REC-2569-0001',
    'issue_date' => date('Y-m-d'),
    'billing_month' => date('m'),
    'thai_year' => (int)date('Y') + 543,
    'member_no' => 'MEM-2569-001',
    'prefix' => 'นาย',
    'first_name' => 'สมาชิก',
    'last_name' => 'สหกรณ์',
    'department' => '-',
    'position' => '-',
    'share_amount' => 0,
    'loan_principal' => 0,
    'loan_interest' => 0,
    'deposit_amount' => 0,
    'other_amount' => 0,
    'total_amount' => 0,
    'baht_text' => 'ศูนย์บาทถ้วน',
    'qr_verify_token' => ''
], $receipt ?? []);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบเสร็จรับเงิน <?= e($receipt['receipt_no'] ?? '') ?> - สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- html2pdf.js for client-side direct PDF generation & download -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            line-height: 1.4;
            font-size: 14px;
            padding: 24px;
        }
        .no-print-bar {
            max-width: 800px;
            margin: 0 auto 16px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 14px 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 8px;
            font-family: 'Sarabun', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.2s;
        }
        .btn-primary {
            background-color: #0066CC;
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #0052a3;
        }
        .btn-pdf {
            background-color: #dc2626;
            color: #ffffff;
        }
        .btn-pdf:hover {
            background-color: #b91c1c;
        }
        .btn-secondary {
            background-color: #e2e8f0;
            color: #334155;
        }
        .btn-secondary:hover {
            background-color: #cbd5e1;
        }

        /* A4 Document Container */
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 72px;
            font-weight: 700;
            color: rgba(0, 102, 204, 0.03);
            text-transform: uppercase;
            pointer-events: none;
            user-select: none;
            white-space: nowrap;
        }

        /* Header */
        .receipt-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #0066CC;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .coop-logo-area {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .coop-logo-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #0066CC, #004080);
            color: #ffffff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }
        .coop-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 2px;
        }
        .coop-subtitle {
            font-size: 12px;
            color: #64748b;
        }
        .receipt-title-box {
            text-align: right;
        }
        .receipt-badge {
            display: inline-block;
            background: #0066CC;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: 6px;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }
        .receipt-meta {
            font-size: 12px;
            color: #475569;
        }
        .receipt-meta strong {
            color: #0f172a;
            font-family: monospace;
            font-size: 13px;
        }

        /* Member Info Box */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 24px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
            font-size: 13px;
        }
        .info-item {
            display: flex;
        }
        .info-label {
            width: 130px;
            color: #64748b;
            flex-shrink: 0;
        }
        .info-value {
            font-weight: 600;
            color: #0f172a;
        }

        /* Table */
        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .receipt-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: 700;
            text-align: left;
            padding: 10px 12px;
            border-top: 1px solid #cbd5e1;
            border-bottom: 1px solid #cbd5e1;
        }
        .receipt-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .font-mono {
            font-family: 'Consolas', 'Monaco', monospace;
        }

        /* Total Section */
        .total-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 12px 18px;
            margin-bottom: 24px;
        }
        .baht-text {
            font-weight: 700;
            color: #0066CC;
            font-size: 14px;
        }
        .total-number-area {
            text-align: right;
        }
        .total-number-label {
            font-size: 12px;
            color: #64748b;
            margin-right: 8px;
        }
        .total-number {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            font-family: 'Consolas', monospace;
        }

        /* Summary Badges */
        .summary-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 28px;
        }
        .summary-card {
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
            background-color: #fafafa;
        }

        /* Signatures & QR Section */
        .footer-grid {
            display: grid;
            grid-template-columns: 1fr 120px 1fr;
            gap: 20px;
            align-items: center;
            margin-top: 10px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
        }
        .sig-box {
            text-align: center;
            font-size: 12px;
        }
        .sig-line {
            width: 160px;
            border-bottom: 1px dotted #94a3b8;
            margin: 36px auto 6px auto;
        }
        .qr-box {
            text-align: center;
        }
        .qr-img {
            width: 88px;
            height: 88px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 3px;
            background: #fff;
        }
        .qr-label {
            font-size: 10px;
            color: #64748b;
            margin-top: 4px;
            display: block;
        }

        /* Note */
        .receipt-legal-note {
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
        }

        /* Loading Indicator */
        #pdfLoadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            color: #ffffff;
            font-family: 'Sarabun', sans-serif;
            text-align: center;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
                color: #000000;
            }
            .no-print-bar {
                display: none !important;
            }
            .receipt-container {
                box-shadow: none;
                border: none;
                padding: 20px;
                max-width: 100%;
                width: 100%;
            }
            @page {
                size: A4 portrait;
                margin: 10mm;
            }
        }
    </style>
</head>
<body>

    <!-- Loading Overlay -->
    <div id="pdfLoadingOverlay">
        <div style="background: #ffffff; color: #0f172a; padding: 24px 36px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            <div style="font-size: 28px; margin-bottom: 8px; color: #dc2626;"><i class="bi bi-file-earmark-pdf-fill"></i></div>
            <div style="font-size: 16px; font-weight: 700; margin-bottom: 4px;">กำลังสร้างไฟล์ PDF...</div>
            <div style="font-size: 13px; color: #64748b;">กรุณารอสักครู่ ระบบกำลังดาวน์โหลดเอกสาร</div>
        </div>
    </div>

    <!-- Action Bar (Hidden on Print) -->
    <div class="no-print-bar">
        <div>
            <span style="font-weight: 700; color: #0066CC;"><i class="bi bi-file-earmark-check-fill me-1"></i> ใบเสร็จรับเงินอิเล็กทรอนิกส์ (e-Receipt)</span>
            <span style="color: #64748b; font-size: 13px; margin-left: 8px;">เลขที่: <?= e($receipt['receipt_no']) ?></span>
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="button" class="btn-action btn-pdf" id="btnDownloadPdf" onclick="downloadPDF()">
                <i class="bi bi-file-earmark-pdf-fill"></i> ดาวน์โหลดไฟล์ PDF
            </button>
            <button type="button" class="btn-action btn-primary" onclick="window.print()">
                <i class="bi bi-printer-fill"></i> พิมพ์เอกสาร
            </button>
            <button type="button" class="btn-action btn-secondary" onclick="window.history.back()">
                <i class="bi bi-arrow-left"></i> ย้อนกลับ
            </button>
        </div>
    </div>

    <!-- Main Receipt Body (Captured for PDF) -->
    <div class="receipt-container" id="receiptContent">
        <div class="watermark">RAYONG COOP</div>

        <!-- Header -->
        <div class="receipt-header">
            <div class="coop-logo-area">
                <div class="coop-logo-icon">
                    <i class="bi bi-bank2"></i>
                </div>
                <div>
                    <div class="coop-title">สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</div>
                    <div class="coop-subtitle">RAYONG PUBLIC HEALTH COOPERATIVE LIMITED</div>
                    <div class="coop-subtitle" style="font-size: 11px; margin-top: 2px;">
                        สำนักงาน: 45/1 ถ.สุขุมวิท ต.ท่าประดู่ อ.เมือง จ.ระยอง 21000 | โทร. 038-611-123
                    </div>
                </div>
            </div>
            <div class="receipt-title-box">
                <div class="receipt-badge">ใบเสร็จรับเงิน</div>
                <div class="receipt-meta">เลขที่: <strong><?= e($receipt['receipt_no']) ?></strong></div>
                <div class="receipt-meta">วันที่ออก: <?= date('d/m/Y', strtotime($receipt['issue_date'])) ?></div>
                <div class="receipt-meta">ประจำงวด: <strong><?= $receipt['billing_month'] ?>/<?= $receipt['thai_year'] ?></strong></div>
            </div>
        </div>

        <!-- Member Info -->
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">เลขที่สมาชิก:</div>
                <div class="info-value font-mono text-primary" style="font-size: 14px;"><?= e($receipt['member_no']) ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">ชื่อ - นามสกุล:</div>
                <div class="info-value"><?= e(($receipt['prefix'] ?? '') . $receipt['first_name'] . ' ' . $receipt['last_name']) ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">สังกัด / หน่วยงาน:</div>
                <div class="info-value"><?= e($receipt['department'] ?? '-') ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">ตำแหน่ง:</div>
                <div class="info-value"><?= e($receipt['position'] ?? '-') ?></div>
            </div>
            <?php if (!empty($receipt['id_card'])): ?>
                <div class="info-item">
                    <div class="info-label">เลขบัตรประชาชน:</div>
                    <div class="info-value font-mono"><?= substr($receipt['id_card'], 0, 1) . '-' . substr($receipt['id_card'], 1, 4) . '-XXXXX-' . substr($receipt['id_card'], -2) ?></div>
                </div>
            <?php endif; ?>
            <div class="info-item">
                <div class="info-label">ประเภทการชำระ:</div>
                <div class="info-value">หักเงินได้รายเดือน / ชำระผ่านระบบดิจิทัล</div>
            </div>
        </div>

        <!-- Receipt Table -->
        <table class="receipt-table">
            <thead>
                <tr>
                    <th style="width: 50px;" class="text-center">ลำดับ</th>
                    <th>รายการชำระ</th>
                    <th style="width: 140px;" class="text-right">จำนวนเงิน (บาท)</th>
                </tr>
            </thead>
            <tbody>
                <?php $itemNo = 1; ?>
                <?php if ((float)$receipt['share_amount'] > 0): ?>
                    <tr>
                        <td class="text-center"><?= $itemNo++ ?></td>
                        <td>
                            <strong>ค่าหุ้นรายเดือน (Monthly Shares)</strong>
                            <div style="font-size: 11px; color: #64748b;">ส่งค่าหุ้นสะสมประจำเดือน</div>
                        </td>
                        <td class="text-right font-mono"><?= number_format((float)$receipt['share_amount'], 2) ?></td>
                    </tr>
                <?php endif; ?>

                <?php if ((float)$receipt['loan_principal'] > 0): ?>
                    <tr>
                        <td class="text-center"><?= $itemNo++ ?></td>
                        <td>
                            <strong>ชำระเงินต้นเงินกู้ (Loan Principal)</strong>
                            <div style="font-size: 11px; color: #64748b;">หักชำระเงินกู้ตามสัญญาเงินกู้สหกรณ์</div>
                        </td>
                        <td class="text-right font-mono"><?= number_format((float)$receipt['loan_principal'], 2) ?></td>
                    </tr>
                <?php endif; ?>

                <?php if ((float)$receipt['loan_interest'] > 0): ?>
                    <tr>
                        <td class="text-center"><?= $itemNo++ ?></td>
                        <td>
                            <strong>ดอกเบี้ยเงินกู้ (Loan Interest)</strong>
                            <div style="font-size: 11px; color: #64748b;">ดอกเบี้ยเงินกู้คำนวณแบบลดต้นลดดอก</div>
                        </td>
                        <td class="text-right font-mono"><?= number_format((float)$receipt['loan_interest'], 2) ?></td>
                    </tr>
                <?php endif; ?>

                <?php if ((float)$receipt['deposit_amount'] > 0): ?>
                    <tr>
                        <td class="text-center"><?= $itemNo++ ?></td>
                        <td>
                            <strong>เงินฝากสะสมประจำงวด (Deposit Recurring)</strong>
                            <div style="font-size: 11px; color: #64748b;">เงินฝากออมทรัพย์พิเศษ</div>
                        </td>
                        <td class="text-right font-mono"><?= number_format((float)$receipt['deposit_amount'], 2) ?></td>
                    </tr>
                <?php endif; ?>

                <?php if ((float)$receipt['other_amount'] > 0): ?>
                    <tr>
                        <td class="text-center"><?= $itemNo++ ?></td>
                        <td>
                            <strong>รายการอื่นๆ (Other Fees)</strong>
                        </td>
                        <td class="text-right font-mono"><?= number_format((float)$receipt['other_amount'], 2) ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Total Box -->
        <div class="total-box">
            <div>
                <span style="font-size: 12px; color: #64748b; margin-right: 6px;">จำนวนเงินตัวอักษร:</span>
                <span class="baht-text">(<?= $receipt['baht_text'] ?>)</span>
            </div>
            <div class="total-number-area">
                <span class="total-number-label">รวมเงินที่รับชำระทั้งสิ้น:</span>
                <span class="total-number"><?= number_format((float)$receipt['total_amount'], 2) ?></span>
                <span style="font-size: 13px; font-weight: 600; margin-left: 4px;">บาท</span>
            </div>
        </div>

        <!-- Cumulative Summary -->
        <div class="summary-row">
            <div class="summary-card">
                <span style="color: #64748b;">ทุนเรือนหุ้นสะสมรวม (ปัจจุบัน):</span>
                <strong class="font-mono text-primary"><?= number_format((float)($receipt['share_accumulated'] ?? 0), 2) ?> บาท</strong>
            </div>
            <div class="summary-card">
                <span style="color: #64748b;">สถานะเอกสาร:</span>
                <strong style="color: #16a34a;"><i class="bi bi-patch-check-fill me-1"></i> มีผลสมบูรณ์ตามระเบียบสหกรณ์</strong>
            </div>
        </div>

        <!-- Signatures & Verification -->
        <div class="footer-grid">
            <div class="sig-box">
                <div class="sig-line"></div>
                <strong>(นางสาวกานดา ใจดี)</strong>
                <div style="color: #64748b; font-size: 11px;">เจ้าหน้าที่การเงินและบัญชี</div>
            </div>

            <div class="qr-box">
                <?php
                    $verifyUrl = url('verify-receipt/' . $receipt['qr_verify_token']);
                    $qrImgSrc = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($verifyUrl);
                ?>
                <img src="<?= $qrImgSrc ?>" alt="QR Verification" class="qr-img" crossOrigin="anonymous">
                <span class="qr-label">สแกนตรวจสอบความถูกต้อง</span>
            </div>

            <div class="sig-box">
                <div class="sig-line"></div>
                <strong>(นายแพทย์ธนากร สุขเจริญ)</strong>
                <div style="color: #64748b; font-size: 11px;">ผู้จัดการสหกรณ์ออมทรัพย์ฯ</div>
            </div>
        </div>

        <!-- Legal Note -->
        <div class="receipt-legal-note">
            เอกสารฉบับนี้ออกโดยระบบสารสนเทศอิเล็กทรอนิกส์ของสหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด มีผลสมบูรณ์ตามพระราชบัญญัติธุรกรรมทางอิเล็กทรอนิกส์ พ.ศ. 2544
        </div>
    </div>

    <script>
    function downloadPDF() {
        const overlay = document.getElementById('pdfLoadingOverlay');
        overlay.style.display = 'flex';

        const element = document.getElementById('receiptContent');
        const filename = 'Receipt_<?= e($receipt['receipt_no']) ?>_<?= $receipt['billing_month'] ?>-<?= $receipt['thai_year'] ?>.pdf';

        const opt = {
            margin: [8, 8, 8, 8],
            filename: filename,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true, logging: false },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().set(opt).from(element).save().then(() => {
            overlay.style.display = 'none';
        }).catch(err => {
            console.error('PDF generation error:', err);
            overlay.style.display = 'none';
            alert('เกิดข้อผิดพลาดในการสร้าง PDF กรุณาใช้ปุ่มพิมพ์เอกสารและเลือก Save as PDF แทน');
        });
    }

    // Auto trigger download if URL parameter ?download=pdf is present
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('download') === 'pdf' || urlParams.get('download') === '1') {
            setTimeout(downloadPDF, 600);
        }
    });
    </script>
</body>
</html>
