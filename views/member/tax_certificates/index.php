<div class="row g-4">
    <!-- Header -->
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 bg-white p-4 rounded-4 shadow-sm border">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item"><a href="<?= url('member/dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">หนังสือรับรองภาษี</li>
                    </ol>
                </nav>
                <h4 class="fw-bold text-navy mb-1"><i class="bi bi-file-earmark-text me-2 text-primary"></i> หนังสือรับรองดอกเบี้ยเงินกู้เพื่อลดหย่อนภาษี</h4>
                <p class="text-muted small mb-0">สำหรับใช้เป็นหลักฐานประกอบการยื่นแบบแสดงรายการภาษีเงินได้บุคคลธรรมดา (ภ.ง.ด.90 / ภ.ง.ด.91)</p>
            </div>
            <div>
                <a href="<?= url('member/loans') ?>" class="btn btn-outline-primary rounded-pill px-3">
                    <i class="bi bi-credit-card-2-front me-1"></i> ดูสัญญาเงินกู้ทั้งหมด
                </a>
            </div>
        </div>
    </div>

    <!-- Info Alert Box -->
    <div class="col-12">
        <div class="alert alert-info border-0 rounded-4 shadow-sm p-3 p-md-4 mb-0" style="background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%);">
            <div class="d-flex gap-3">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                    <i class="bi bi-info-circle-fill fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-navy mb-1">สิทธิประโยชน์ทางภาษีตามประมวลรัษฎากร</h6>
                    <p class="small text-secondary mb-0">
                        สมาชิกที่กู้ยืมเงินเพื่อซื้อ เช่าซื้อ หรือสร้างอาคารที่อยู่อาศัย สามารถนำดอกเบี้ยเงินกู้ยืมที่จ่ายจริงในรอบปีภาษีไปหักลดหย่อนภาษีเงินได้บุคคลธรรมดาได้ตามที่จ่ายจริงสูงสุดไม่เกิน <strong>100,000 บาท</strong> ต่อปีภาษี เอกสารนี้ออกผ่านระบบอิเล็กทรอนิกส์พร้อม QR Code ตรวจสอบความถูกต้องสมบูรณ์
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificates List Cards -->
    <div class="col-12">
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                <div class="fw-bold text-navy">
                    <i class="bi bi-journal-check me-2 text-primary"></i> รายการหนังสือรับรองที่มีในระบบ
                </div>
                <span class="badge bg-light text-primary border rounded-pill px-3 py-1">
                    พบ <?= count($certificates) ?> ฉบับ
                </span>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($certificates)): ?>
                    <div class="row g-3">
                        <?php foreach ($certificates as $cert): ?>
                            <div class="col-lg-6">
                                <div class="card h-100 border rounded-4 p-4 shadow-sm hover-shadow transition-all" style="background-color: #FAFCFF;">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 fw-bold mb-2">
                                                ปีภาษี <?= $cert['thai_year'] ?> (ค.ศ. <?= $cert['tax_year'] ?>)
                                            </span>
                                            <h5 class="fw-bold text-navy mb-0">เลขที่เอกสาร: <?= e($cert['certificate_no']) ?></h5>
                                        </div>
                                        <div class="bg-success-subtle text-success rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                            <i class="bi bi-patch-check-fill fs-5"></i>
                                        </div>
                                    </div>

                                    <div class="bg-white rounded-3 p-3 border mb-3 small">
                                        <div class="row g-2">
                                            <div class="col-5 text-muted">เลขที่สัญญาเงินกู้:</div>
                                            <div class="col-7 text-end font-monospace fw-bold text-primary"><?= e($cert['contract_no']) ?></div>

                                            <div class="col-5 text-muted">ประเภทสินเชื่อ:</div>
                                            <div class="col-7 text-end"><?= e($cert['loan_type']) ?></div>

                                            <div class="col-5 text-muted">ผู้กู้ยืม:</div>
                                            <div class="col-7 text-end fw-semibold"><?= e($cert['borrower_name']) ?></div>

                                            <div class="col-12"><hr class="my-1 opacity-25"></div>

                                            <div class="col-6 fw-bold text-dark">ดอกเบี้ยจ่ายทั้งปี (หักลดหย่อนได้):</div>
                                            <div class="col-6 text-end fw-bold font-monospace text-success fs-5">
                                                ฿<?= number_format((float)$cert['total_interest_paid'], 2) ?>
                                            </div>

                                            <div class="col-6 text-muted small">เงินต้นที่ชำระทั้งปี:</div>
                                            <div class="col-6 text-end text-muted font-monospace small">
                                                ฿<?= number_format((float)$cert['total_principal_paid'], 2) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2 mt-auto">
                                        <a href="<?= url('member/tax-certificates/print/' . $cert['id']) ?>" target="_blank" class="btn btn-primary rounded-pill flex-grow-1 fw-semibold py-2">
                                            <i class="bi bi-printer me-1"></i> พิมพ์ / บันทึก PDF
                                        </a>
                                        <a href="<?= url('verify-tax-cert/' . $cert['qr_verify_token']) ?>" target="_blank" class="btn btn-outline-secondary rounded-pill px-3" title="ตรวจสอบ QR Code">
                                            <i class="bi bi-qr-code-scan"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="text-muted mb-3"><i class="bi bi-file-earmark-x fs-1"></i></div>
                        <h6 class="fw-bold text-secondary">ยังไม่มีข้อมูลหนังสือรับรองภาษีในระบบ</h6>
                        <p class="text-muted small">หากท่านมีสัญญากู้ยืมเพื่อที่อยู่อาศัย กรุณาติดต่อเจ้าหน้าที่การเงินของสหกรณ์</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
