<div class="py-5 bg-navy text-white">
    <div class="container-xl">
        <span class="badge bg-gold text-white mb-2 px-3 py-1"><i class="bi bi-clipboard2-check me-1"></i> บริการข้อมูลสินเชื่อ</span>
        <h1 class="text-white fw-bold display-6 mb-2">เช็กความพร้อมก่อนยื่นกู้เงิน</h1>
        <p class="text-light-blue lead mb-0">ตรวจสอบคุณสมบัติ วงเงิน เอกสาร และหลักเกณฑ์การยื่นกู้เงินประเภทต่างๆ ได้ด้วยตนเอง</p>
    </div>
</div>

<div class="container-xl py-5">
    <!-- 1. Select Loan Type -->
    <div class="coop-card p-4 mb-4">
        <label for="loanTypeSelect" class="form-label fw-bold text-navy mb-2">
            <i class="bi bi-cash-stack text-primary me-1"></i> เลือกประเภทเงินกู้ที่ต้องการตรวจสอบ:
        </label>
        <div class="d-flex flex-wrap gap-2">
            <?php foreach ($loans as $l): ?>
                <a href="<?= url('loan-readiness?type=' . $l['slug']) ?>" class="btn rounded-pill px-4 <?= ($currentLoan && $currentLoan['id'] === $l['id']) ? 'btn-primary' : 'btn-outline-secondary' ?>">
                    <?= e($l['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if ($currentLoan): ?>
        <!-- 2. Loan Key Highlights -->
        <div class="row g-4 mb-4">
            <div class="col-md-3 col-6">
                <div class="coop-card p-3 p-md-4 text-center h-100">
                    <div class="text-muted small mb-1"><i class="bi bi-percent text-warning me-1"></i> อัตราดอกเบี้ย</div>
                    <div class="fs-2 fw-bold text-gold"><?= number_format((float)$currentLoan['interest_rate'], 2) ?>%</div>
                    <small class="text-muted">ต่อปี (ลดต้นลดดอก)</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="coop-card p-3 p-md-4 text-center h-100">
                    <div class="text-muted small mb-1"><i class="bi bi-cash-coin text-primary me-1"></i> วงเงินกู้สูงสุด</div>
                    <div class="fs-3 fw-bold text-navy"><?= number_format((float)$currentLoan['max_loan_limit']) ?></div>
                    <small class="text-muted">บาท (ตามเกณฑ์เงินได้)</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="coop-card p-3 p-md-4 text-center h-100">
                    <div class="text-muted small mb-1"><i class="bi bi-calendar3 text-info me-1"></i> ผ่อนชำระสูงสุด</div>
                    <div class="fs-3 fw-bold text-navy"><?= $currentLoan['max_term_months'] ?></div>
                    <small class="text-muted">งวด (เดือน)</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="coop-card p-3 p-md-4 text-center h-100">
                    <div class="text-muted small mb-1"><i class="bi bi-shield-check text-success me-1"></i> ประเภทเงินกู้</div>
                    <div class="fw-bold text-navy fs-5 my-1"><?= e($currentLoan['name']) ?></div>
                    <span class="badge bg-light text-primary border">สหกรณ์ออมทรัพย์</span>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Qualifications & Guarantor -->
            <div class="col-lg-6">
                <!-- Qualifications -->
                <div class="coop-card p-4 mb-4">
                    <h5 class="fw-bold text-navy mb-3">
                        <i class="bi bi-person-check-fill text-primary me-2"></i> 1. คุณสมบัติของผู้กู้
                    </h5>
                    <?php if (!empty($currentLoan['eligibility'])): ?>
                        <div class="text-muted small" style="line-height: 1.8; white-space: pre-line;"><?= e($currentLoan['eligibility']) ?></div>
                    <?php else: ?>
                        <ul class="list-unstyled text-muted small d-flex flex-column gap-2 mb-0">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> เป็นสมาชิกสหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด มาแล้วไม่น้อยกว่า 6 เดือน</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> ส่งเงินค่าหุ้นรายเดือนสม่ำเสมอตามระเบียบสหกรณ์</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> มีเงินได้รายเดือนคงเหลือสุทธิหลังหักส่งชำระหนี้ไม่น้อยกว่า 30%</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> ไม่อยู่ระหว่างถูกตั้งกรรมการสอบสวนทางวินัยร้ายแรง หรือถูกฟ้องคดีล้มละลาย</li>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Guarantor / Collateral -->
                <div class="coop-card p-4 mb-4">
                    <h5 class="fw-bold text-navy mb-3">
                        <i class="bi bi-people-fill text-warning me-2"></i> 2. เกณฑ์ผู้ค้ำประกัน / หลักประกัน
                    </h5>
                    <?php if (!empty($currentLoan['guarantor_requirement'])): ?>
                        <div class="text-muted small" style="line-height: 1.8; white-space: pre-line;"><?= e($currentLoan['guarantor_requirement']) ?></div>
                    <?php else: ?>
                        <ul class="list-unstyled text-muted small d-flex flex-column gap-2 mb-0">
                            <li><i class="bi bi-shield-fill-check text-warning me-2"></i> ใช้สมาชิกสหกรณ์เป็นผู้ค้ำประกันร่วมตามเกณฑ์วงเงินกู้</li>
                            <li><i class="bi bi-shield-fill-check text-warning me-2"></i> ผู้ค้ำประกันต้องมีอายุสมาชิกไม่น้อยกว่า 6 เดือน และไม่มีประวัติผิดนัดชำระหนี้</li>
                            <li><i class="bi bi-shield-fill-check text-warning me-2"></i> กรณีใช้หลักทรัพย์จำนอง ต้องเป็นโฉนดที่ดินปลอดภาระผูกพัน</li>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Application Steps -->
                <div class="coop-card p-4">
                    <h5 class="fw-bold text-navy mb-3">
                        <i class="bi bi-list-ol text-info me-2"></i> 3. ขั้นตอนการยื่นกู้และอนุมัติ
                    </h5>
                    <div class="d-flex flex-column gap-3 small text-muted">
                        <div class="d-flex gap-3">
                            <span class="badge bg-primary rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px;">1</span>
                            <div><b>เตรียมเอกสาร:</b> จัดเตรียมเอกสารประกอบการกู้ของผู้กู้และผู้ค้ำประกันให้ครบถ้วน</div>
                        </div>
                        <div class="d-flex gap-3">
                            <span class="badge bg-primary rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px;">2</span>
                            <div><b>ยื่นคำขอกู้:</b> ยื่นผ่านระบบ E-Service หรือยื่นที่สำนักงานสหกรณ์ฯ ภายในรอบวันที่กำหนด</div>
                        </div>
                        <div class="d-flex gap-3">
                            <span class="badge bg-primary rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px;">3</span>
                            <div><b>พิจารณาอนุมัติ:</b> เจ้าหน้าที่ตรวจสอบเอกสาร และคณะกรรมการเงินกู้พิจารณาอนุมัติ</div>
                        </div>
                        <div class="d-flex gap-3">
                            <span class="badge bg-primary rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px;">4</span>
                            <div><b>ทำสัญญาและรับเงิน:</b> ลงนามสัญญากู้เงิน และโอนเงินกู้เข้าบัญชีเงินฝากสหกรณ์/ธนาคาร</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Interactive Document Checklist -->
            <div class="col-lg-6">
                <div class="coop-card p-4 p-md-5 h-100 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-navy mb-0">
                            <i class="bi bi-check2-square text-success me-2"></i> รายการเอกสารที่ต้องใช้ (Checklist)
                        </h5>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none" id="btnResetChecklist">รีเซ็ต</button>
                    </div>
                    <p class="text-muted small mb-3">ติ๊กเลือกเอกสารที่ท่านเตรียมพร้อมแล้ว เพื่อตรวจสอบความพร้อมก่อนยื่นคำขอ:</p>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between small fw-bold mb-1">
                            <span>ความพร้อมของเอกสาร</span>
                            <span id="progressText" class="text-primary">0 / 6 รายการ (0%)</span>
                        </div>
                        <div class="progress" style="height: 10px; border-radius: 6px;">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" id="checklistProgressBar" role="progressbar" style="width: 0%;"></div>
                        </div>
                    </div>

                    <!-- Checklist Items -->
                    <div class="d-flex flex-column gap-3 mb-4 flex-grow-1" id="checklistContainer">
                        <label class="form-check-label p-3 rounded-3 border bg-light d-flex align-items-start gap-3 cursor-pointer">
                            <input type="checkbox" class="form-check-input mt-1 doc-check">
                            <div>
                                <b class="d-block text-navy small">1. แบบฟอร์มคำขอกู้เงินและหนังสือสัญญากู้เงิน</b>
                                <span class="text-muted" style="font-size: 0.8rem;">กรอกข้อมูลครบถ้วน พร้อมลงลายมือชื่อผู้กู้และผู้ค้ำประกัน</span>
                            </div>
                        </label>

                        <label class="form-check-label p-3 rounded-3 border bg-light d-flex align-items-start gap-3 cursor-pointer">
                            <input type="checkbox" class="form-check-input mt-1 doc-check">
                            <div>
                                <b class="d-block text-navy small">2. สำเนาบัตรประชาชน / บัตรข้าราชการ (ผู้กู้และคู่สมรส)</b>
                                <span class="text-muted" style="font-size: 0.8rem;">รับรองสำเนาถูกต้อง จำนวนอย่างละ 1 ชุด</span>
                            </div>
                        </label>

                        <label class="form-check-label p-3 rounded-3 border bg-light d-flex align-items-start gap-3 cursor-pointer">
                            <input type="checkbox" class="form-check-input mt-1 doc-check">
                            <div>
                                <b class="d-block text-navy small">3. สำเนาทะเบียนบ้าน (ผู้กู้และคู่สมรส)</b>
                                <span class="text-muted" style="font-size: 0.8rem;">รับรองสำเนาถูกต้อง จำนวนอย่างละ 1 ชุด</span>
                            </div>
                        </label>

                        <label class="form-check-label p-3 rounded-3 border bg-light d-flex align-items-start gap-3 cursor-pointer">
                            <input type="checkbox" class="form-check-input mt-1 doc-check">
                            <div>
                                <b class="d-block text-navy small">4. สลิปเงินเดือน หรือหนังสือรับรองเงินเดือนล่าสุด</b>
                                <span class="text-muted" style="font-size: 0.8rem;">ฉบับจริงหรือสำเนารับรอง ย้อนหลังไม่เกิน 2 เดือน</span>
                            </div>
                        </label>

                        <label class="form-check-label p-3 rounded-3 border bg-light d-flex align-items-start gap-3 cursor-pointer">
                            <input type="checkbox" class="form-check-input mt-1 doc-check">
                            <div>
                                <b class="d-block text-navy small">5. เอกสารของผู้ค้ำประกันทุกคน</b>
                                <span class="text-muted" style="font-size: 0.8rem;">สำเนาบัตรประชาชน, สำเนาทะเบียนบ้าน และสลิปเงินเดือน</span>
                            </div>
                        </label>

                        <label class="form-check-label p-3 rounded-3 border bg-light d-flex align-items-start gap-3 cursor-pointer">
                            <input type="checkbox" class="form-check-input mt-1 doc-check">
                            <div>
                                <b class="d-block text-navy small">6. สำเนาหน้าสมุดบัญชีเงินฝากสำหรับรับเงินกู้</b>
                                <span class="text-muted" style="font-size: 0.8rem;">บัญชีเงินฝากสหกรณ์ หรือบัญชีธนาคารกรุงไทย</span>
                            </div>
                        </label>
                    </div>

                    <!-- Action Link Buttons -->
                    <div class="pt-3 border-top d-flex flex-column flex-sm-row gap-2">
                        <a href="<?= url('calculator') ?>" class="btn btn-outline-primary rounded-pill flex-fill">
                            <i class="bi bi-calculator me-1"></i> คำนวณค่างวดเงินกู้
                        </a>
                        <a href="<?= url('documents') ?>" class="btn btn-outline-secondary rounded-pill flex-fill">
                            <i class="bi bi-download me-1"></i> ดาวน์โหลดแบบฟอร์ม
                        </a>
                        <a href="<?= url('eservice') ?>" class="btn btn-primary rounded-pill flex-fill fw-bold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบยื่นกู้
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.doc-check');
    const progressBar = document.getElementById('checklistProgressBar');
    const progressText = document.getElementById('progressText');
    const btnReset = document.getElementById('btnResetChecklist');

    function updateProgress() {
        if (!checkboxes.length) return;
        let checked = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) {
                checked++;
                cb.closest('label').classList.add('border-success', 'bg-success', 'bg-opacity-10');
                cb.closest('label').classList.remove('bg-light');
            } else {
                cb.closest('label').classList.remove('border-success', 'bg-success', 'bg-opacity-10');
                cb.closest('label').classList.add('bg-light');
            }
        });

        const percent = Math.round((checked / checkboxes.length) * 100);
        if (progressBar) progressBar.style.width = percent + '%';
        if (progressText) {
            progressText.textContent = `${checked} / ${checkboxes.length} รายการ (${percent}%)`;
            if (percent === 100) {
                progressText.className = 'text-success fw-bold';
            } else {
                progressText.className = 'text-primary fw-bold';
            }
        }
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateProgress));

    if (btnReset) {
        btnReset.addEventListener('click', function() {
            checkboxes.forEach(cb => cb.checked = false);
            updateProgress();
        });
    }
});
</script>
