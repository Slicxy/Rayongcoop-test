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

        <!-- 2.5. Interactive DSR & Loan Readiness Pre-Check Calculator -->
        <div class="coop-card p-4 p-md-5 mb-4 border-start border-4 border-primary">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <div>
                    <h5 class="fw-bold text-navy mb-1"><i class="bi bi-speedometer2 text-primary me-2"></i>เครื่องมือประเมินภาระหนี้ (DSR) และความสามารถในการกู้เงิน</h5>
                    <p class="text-muted small mb-0">ทดลองคำนวณเงินเดือนคงเหลือสุทธิและสัดส่วนภาระหนี้ตามเกณฑ์มาตรฐานสหกรณ์ (เงินเดือนคงเหลือไม่น้อยกว่า 30%)</p>
                </div>
                <span class="badge bg-primary-subtle text-primary border px-3 py-2 rounded-pill font-monospace">อัตราดอกเบี้ย <?= number_format((float)$currentLoan['interest_rate'], 2) ?>% ต่อปี</span>
            </div>

            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-navy">เงินได้รวมต่อเดือน (บาท)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-wallet2"></i></span>
                                <input type="number" id="chkSalary" class="form-control font-monospace" value="35000" step="1000" min="10000">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-navy">ภาระหนี้ผ่อนเดิม/เดือน (บาท)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-credit-card"></i></span>
                                <input type="number" id="chkOldDebt" class="form-control font-monospace" value="5000" step="500" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-navy">วงเงินกู้ที่ต้องการ (บาท)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-cash"></i></span>
                                <input type="number" id="chkLoanAmount" class="form-control font-monospace" value="100000" step="10000" min="10000" max="<?= (float)$currentLoan['max_loan_limit'] ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-navy">ระยะเวลาผ่อนชำระ (งวด)</label>
                            <select id="chkLoanTerm" class="form-select font-monospace">
                                <option value="12">12 งวด (1 ปี)</option>
                                <option value="24">24 งวด (2 ปี)</option>
                                <option value="36" selected>36 งวด (3 ปี)</option>
                                <option value="48">48 งวด (4 ปี)</option>
                                <option value="60">60 งวด (5 ปี)</option>
                                <option value="84">84 งวด (7 ปี)</option>
                                <?php if ((int)$currentLoan['max_term_months'] > 84): ?>
                                    <option value="<?= (int)$currentLoan['max_term_months'] ?>"><?= (int)$currentLoan['max_term_months'] ?> งวด (สูงสุดตามระเบียบ)</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="p-4 bg-light rounded-4 border">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">ค่างวดผ่อนใหม่:</span>
                            <span class="fw-bold text-danger font-monospace fs-5" id="chkMonthlyInstallment">฿3,173.61</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">เงินได้สุทธิคงเหลือ:</span>
                            <span class="fw-bold text-success font-monospace fs-5" id="chkNetRemaining">฿26,826.39</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center small mb-1">
                            <span class="text-muted">สัดส่วนเงินคงเหลือ:</span>
                            <span class="fw-bold font-monospace" id="chkRemainingRatio">76.6%</span>
                        </div>
                        
                        <div class="progress rounded-pill mb-3" style="height: 12px;">
                            <div class="progress-bar bg-danger" id="chkBarDsr" style="width: 23%"></div>
                            <div class="progress-bar bg-success" id="chkBarRemaining" style="width: 77%"></div>
                        </div>

                        <div class="p-2 rounded-3 text-center small fw-bold" id="chkResultBadge" style="background-color: #D1E7DD; color: #0F5132;">
                            <i class="bi bi-check-circle-fill me-1"></i> ผ่านเกณฑ์ความพร้อมทางการเงิน (เงินเหลือ > 30%)
                        </div>
                    </div>
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

    // DSR Calculator Logic
    const currentRate = <?= (float)($currentLoan['interest_rate'] ?? 4.75) ?>;
    const chkSalary = document.getElementById('chkSalary');
    const chkOldDebt = document.getElementById('chkOldDebt');
    const chkLoanAmount = document.getElementById('chkLoanAmount');
    const chkLoanTerm = document.getElementById('chkLoanTerm');

    function calculatePreCheck() {
        if (!chkSalary || !chkLoanAmount || !chkLoanTerm) return;

        const salary = parseFloat(chkSalary.value) || 35000;
        const oldDebt = parseFloat(chkOldDebt.value) || 0;
        const loanAmount = parseFloat(chkLoanAmount.value) || 100000;
        const term = parseInt(chkLoanTerm.value) || 36;

        const monthlyNew = (loanAmount / term) + (loanAmount * (currentRate / 100) / 12);
        const totalDebt = oldDebt + monthlyNew;
        const netRemaining = Math.max(0, salary - totalDebt);
        const dsr = (totalDebt / salary) * 100;
        const remainingRatio = (netRemaining / salary) * 100;

        document.getElementById('chkMonthlyInstallment').textContent = '฿' + monthlyNew.toLocaleString('th-TH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('chkNetRemaining').textContent = '฿' + netRemaining.toLocaleString('th-TH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('chkRemainingRatio').textContent = remainingRatio.toFixed(1) + '%';

        document.getElementById('chkBarDsr').style.width = Math.min(100, dsr) + '%';
        document.getElementById('chkBarRemaining').style.width = Math.min(100, remainingRatio) + '%';

        const badge = document.getElementById('chkResultBadge');
        if (remainingRatio >= 30) {
            badge.style.backgroundColor = '#D1E7DD';
            badge.style.color = '#0F5132';
            badge.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> ผ่านเกณฑ์ความพร้อมทางการเงิน (เงินเหลือ ' + remainingRatio.toFixed(1) + '% >= 30%)';
        } else if (remainingRatio >= 20) {
            badge.style.backgroundColor = '#FFF3CD';
            badge.style.color = '#664D03';
            badge.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-1"></i> เฝ้าระวัง (เงินเหลือ ' + remainingRatio.toFixed(1) + '% แนะนำขยายงวดผ่อน)';
        } else {
            badge.style.backgroundColor = '#F8D7DA';
            badge.style.color = '#842029';
            badge.innerHTML = '<i class="bi bi-x-circle-fill me-1"></i> เกินเกณฑ์ภาระหนี้ (เงินเหลือ ' + remainingRatio.toFixed(1) + '% < 20%)';
        }
    }

    [chkSalary, chkOldDebt, chkLoanAmount, chkLoanTerm].forEach(el => {
        if (el) {
            el.addEventListener('input', calculatePreCheck);
            el.addEventListener('change', calculatePreCheck);
        }
    });

    calculatePreCheck();
});
</script>
