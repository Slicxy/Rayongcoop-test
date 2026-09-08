<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'ตรวจสอบความถูกต้องของหนังสือรับรองภาษี') ?> - สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            background: linear-gradient(135deg, #F0F4F8 0%, #E2E8F0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .verify-card {
            max-width: 600px;
            width: 100%;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 51, 102, 0.12);
            overflow: hidden;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .verify-header {
            background: linear-gradient(135deg, #0066CC 0%, #004080 100%);
            color: #ffffff;
            padding: 30px 24px;
            text-align: center;
        }
        .badge-verified {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .badge-invalid {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
    </style>
</head>
<body>

<div class="verify-card shadow-lg">
    <!-- Header -->
    <div class="verify-header">
        <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex p-3 mb-3 text-white">
            <i class="bi bi-shield-check fs-1"></i>
        </div>
        <h4 class="fw-bold mb-1">ระบบตรวจสอบความถูกต้องของเอกสาร</h4>
        <div class="small opacity-75">สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</div>
    </div>

    <!-- Body -->
    <div class="p-4 p-md-5">
        <?php if ($isValid && !empty($cert)): ?>
            <div class="text-center mb-4">
                <div class="badge-verified shadow-sm">
                    <i class="bi bi-patch-check-fill fs-5"></i> หนังสือรับรองถูกต้องและมีผลสมบูรณ์
                </div>
                <p class="text-muted small mt-2 mb-0">ออกผ่านระบบสารสนเทศอิเล็กทรอนิกส์ของสหกรณ์</p>
            </div>

            <!-- Tax Cert Info Table -->
            <div class="bg-light rounded-4 p-3 mb-4 border">
                <div class="row g-3 small">
                    <div class="col-6 text-muted">ประเภทเอกสาร:</div>
                    <div class="col-6 text-end fw-bold text-primary">หนังสือรับรองดอกเบี้ยเงินกู้</div>

                    <div class="col-6 text-muted">เลขที่หนังสือรับรอง:</div>
                    <div class="col-6 text-end fw-bold font-monospace text-dark"><?= e($cert['certificate_no']) ?></div>

                    <div class="col-6 text-muted">ประจำปีภาษี:</div>
                    <div class="col-6 text-end fw-bold">พ.ศ. <?= $cert['thai_year'] ?> (ค.ศ. <?= $cert['tax_year'] ?>)</div>

                    <div class="col-6 text-muted">วันที่ออกเอกสาร:</div>
                    <div class="col-6 text-end font-monospace"><?= date('d/m/Y', strtotime($cert['issue_date'])) ?></div>

                    <div class="col-6 text-muted">ชื่อผู้กู้ยืม (Masked):</div>
                    <div class="col-6 text-end fw-bold">
                        <?php
                            $fname = $cert['first_name'] ?? '';
                            $lname = $cert['last_name'] ?? '';
                            $prefix = $cert['prefix'] ?? '';
                            $maskedName = $prefix . (mb_substr($fname, 0, 2) . '***') . ' ' . (mb_substr($lname, 0, 2) . '***');
                            echo e($maskedName);
                        ?>
                    </div>

                    <div class="col-6 text-muted">เลขที่สมาชิก:</div>
                    <div class="col-6 text-end font-monospace text-dark">
                        <?php
                            $memNo = (string)($cert['member_no'] ?? '');
                            $maskedMemNo = strlen($memNo) > 4 ? substr($memNo, 0, 2) . '***' . substr($memNo, -2) : '***';
                            echo e($maskedMemNo);
                        ?>
                    </div>

                    <div class="col-6 text-muted">เลขที่สัญญาเงินกู้:</div>
                    <div class="col-6 text-end font-monospace"><?= e($cert['contract_no']) ?></div>

                    <div class="col-12"><hr class="my-1 text-muted opacity-25"></div>

                    <div class="col-6 fw-bold text-dark fs-6">ยอดดอกเบี้ยหักลดหย่อนได้:</div>
                    <div class="col-6 text-end fw-bold font-monospace text-success fs-5">
                        ฿<?= number_format((float)$cert['total_interest_paid'], 2) ?>
                    </div>

                    <div class="col-12 text-end text-muted small">
                        (<?= e($cert['interest_baht_text']) ?>)
                    </div>
                </div>
            </div>

            <div class="alert alert-info border-0 rounded-3 small text-center mb-4">
                <i class="bi bi-shield-lock me-1"></i> ข้อมูลชื่อและเลขประจำตัวผู้กู้ยืมถูกปิดบังบางส่วนเพื่อคุ้มครองข้อมูลส่วนบุคคล (PDPA)
            </div>

            <div class="text-center">
                <a href="<?= url('/') ?>" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="bi bi-house me-1"></i> ไปยังหน้าหลักเว็บไซต์
                </a>
            </div>

        <?php else: ?>
            <div class="text-center py-3">
                <div class="badge-invalid shadow-sm mb-3">
                    <i class="bi bi-x-circle-fill fs-5"></i> ไม่พบข้อมูลเอกสาร หรือรหัสตรวจสอบไม่ถูกต้อง
                </div>
                <p class="text-muted small mb-4">
                    รหัสการตรวจสอบ (Token): <code class="text-danger"><?= e($token) ?></code><br>
                    กรุณาตรวจสอบว่าท่านสแกน QR Code จากหนังสือรับรองฉบับจริงของสหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด
                </p>
                <a href="<?= url('/') ?>" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i> กลับสู่หน้าหลัก
                </a>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Footer -->
    <div class="bg-light p-3 text-center border-top text-muted small">
        <small>© 2026 สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด | ทุกสิทธิ์ได้รับการคุ้มครอง</small>
    </div>
</div>

</body>
</html>
