<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-transparent border-0 p-4 pb-0 text-center">
        <h4 class="fw-bold text-navy mb-1"><i class="bi bi-cash-coin text-warning me-2"></i>ยื่นคำขอกู้เงินออนไลน์ (Online Loan Wizard)</h4>
        <p class="text-muted small mb-0">ระบบคำนวณวงเงินกู้ ตรวจสอบเอกสาร และยื่นคำขอแบบเรียลไทม์ 6 ขั้นตอน</p>
    </div>

    <!-- Wizard Step Indicator -->
    <div class="card-body p-4">
        <div class="d-flex justify-content-between position-relative mb-4 px-2" id="wizardStepsIndicator">
            <div class="text-center position-relative" style="z-index: 2;">
                <div class="wizard-step-circle active" id="stepIndicator1">1</div>
                <div class="small fw-bold text-navy mt-1">ประเภทเงินกู้</div>
            </div>
            <div class="text-center position-relative" style="z-index: 2;">
                <div class="wizard-step-circle" id="stepIndicator2">2</div>
                <div class="small text-muted mt-1">จำนวนเงิน/งวด</div>
            </div>
            <div class="text-center position-relative" style="z-index: 2;">
                <div class="wizard-step-circle" id="stepIndicator3">3</div>
                <div class="small text-muted mt-1">ประเมินวงเงิน</div>
            </div>
            <div class="text-center position-relative" style="z-index: 2;">
                <div class="wizard-step-circle" id="stepIndicator4">4</div>
                <div class="small text-muted mt-1">แนบเอกสาร</div>
            </div>
            <div class="text-center position-relative" style="z-index: 2;">
                <div class="wizard-step-circle" id="stepIndicator5">5</div>
                <div class="small text-muted mt-1">ตรวจสอบ</div>
            </div>
            <div class="text-center position-relative" style="z-index: 2;">
                <div class="wizard-step-circle" id="stepIndicator6">6</div>
                <div class="small text-muted mt-1">ยืนยันคำขอ</div>
            </div>
        </div>

        <form id="loanWizardForm" action="<?= url('member/loan-apply') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- STEP 1: Select Loan Type -->
            <div class="wizard-pane active" id="wizardStep1">
                <h5 class="fw-bold text-navy mb-3">ขั้นตอนที่ 1: เลือกประเภทเงินกู้ที่ต้องการ</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="card border rounded-4 p-4 text-center h-100 cursor-pointer loan-type-card selected" for="loanTypeOrdinary">
                            <input type="radio" name="loan_type" id="loanTypeOrdinary" value="ordinary" checked class="d-none">
                            <div class="bg-primary-subtle text-primary rounded-circle p-3 mx-auto mb-3" style="width: 58px; height: 58px;"><i class="bi bi-bank2 fs-4"></i></div>
                            <h6 class="fw-bold text-navy mb-1">เงินกู้สามัญ</h6>
                            <p class="small text-muted mb-2">ดอกเบี้ย 4.75% ผ่อนสูงสุด 84 งวด</p>
                            <span class="badge bg-primary">วงเงินสูงสุด 1.5 ล้านบาท</span>
                        </label>
                    </div>

                    <div class="col-md-4">
                        <label class="card border rounded-4 p-4 text-center h-100 cursor-pointer loan-type-card" for="loanTypeEmergency">
                            <input type="radio" name="loan_type" id="loanTypeEmergency" value="emergency" class="d-none">
                            <div class="bg-danger-subtle text-danger rounded-circle p-3 mx-auto mb-3" style="width: 58px; height: 58px;"><i class="bi bi-lightning-fill fs-4"></i></div>
                            <h6 class="fw-bold text-navy mb-1">เงินกู้ฉุกเฉิน</h6>
                            <p class="small text-muted mb-2">ดอกเบี้ย 5.25% ผ่อนสูงสุด 12 งวด</p>
                            <span class="badge bg-danger">อนุมัติเร็วใน 1 วันทำการ</span>
                        </label>
                    </div>

                    <div class="col-md-4">
                        <label class="card border rounded-4 p-4 text-center h-100 cursor-pointer loan-type-card" for="loanTypeSpecial">
                            <input type="radio" name="loan_type" id="loanTypeSpecial" value="special" class="d-none">
                            <div class="bg-warning-subtle text-warning rounded-circle p-3 mx-auto mb-3" style="width: 58px; height: 58px;"><i class="bi bi-house-door-fill fs-4"></i></div>
                            <h6 class="fw-bold text-navy mb-1">เงินกู้พิเศษเพื่อที่อยู่อาศัย</h6>
                            <p class="small text-muted mb-2">ดอกเบี้ย 4.50% ผ่อนสูงสุด 180 งวด</p>
                            <span class="badge bg-warning text-dark">วงเงินสูงสุด 3.0 ล้านบาท</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- STEP 2: Amount & Term -->
            <div class="wizard-pane d-none" id="wizardStep2">
                <h5 class="fw-bold text-navy mb-3">ขั้นตอนที่ 2: ระบุวงเงินและจำนวนงวดที่ต้องการ</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">วงเงินกู้ที่ต้องการ (บาท) <span class="text-danger">*</span></label>
                        <input type="number" name="request_amount" id="requestAmountInput" class="form-control form-control-lg font-monospace" value="100000" step="5000" min="10000" max="1500000" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">ระยะเวลาผ่อนชำระ (งวด) <span class="text-danger">*</span></label>
                        <select name="request_term" id="requestTermInput" class="form-select form-select-lg" required>
                            <option value="12">12 งวด (1 ปี)</option>
                            <option value="24">24 งวด (2 ปี)</option>
                            <option value="36" selected>36 งวด (3 ปี)</option>
                            <option value="48">48 งวด (4 ปี)</option>
                            <option value="60">60 งวด (5 ปี)</option>
                            <option value="84">84 งวด (7 ปี)</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">วัตถุประสงค์ในการกู้เงิน <span class="text-danger">*</span></label>
                        <textarea name="purpose" class="form-control" rows="2" placeholder="เช่น เพื่อการศึกษาบุตร, ต่อเติมที่อยู่อาศัย, ชำระหนี้สถาบันการเงินอื่น" required>เพื่อการพัฒนาคุณภาพชีวิตและซ่อมแซมที่อยู่อาศัย</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">รายได้รวมต่อเดือน (บาท) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-wallet2"></i></span>
                            <input type="number" name="salary" id="salaryInput" class="form-control font-monospace" value="38500" min="10000" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">ภาระหนี้เดิมที่ต้องผ่อนชำระต่อเดือน (บาท)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-credit-card"></i></span>
                            <input type="number" name="existing_debt" id="existingDebtInput" class="form-control font-monospace" value="5000" min="0">
                        </div>
                        <small class="text-muted">เช่น หนี้สหกรณ์เดิม, กู้ซื้อบ้าน, รถยนต์, บัตรเครดิต</small>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">รหัสสมาชิกผู้ค้ำประกัน (ถ้ามี)</label>
                        <input type="text" name="guarantor_member_no" class="form-control" placeholder="เช่น MEM-2024-0002" value="MEM-2024-0002">
                    </div>
                </div>
            </div>

            <!-- STEP 3: Smart DSR & Affordability Evaluation -->
            <div class="wizard-pane d-none" id="wizardStep3">
                <h5 class="fw-bold text-navy mb-3"><i class="bi bi-speedometer2 text-primary me-2"></i>ขั้นตอนที่ 3: ผลการประเมินภาระหนี้ (DSR) และเงินได้คงเหลือสุทธิ</h5>
                
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 bg-primary-subtle rounded-4 p-3 text-center h-100">
                            <span class="text-primary small fw-semibold">วงเงินที่สามารถกู้ได้สูงสุด</span>
                            <h3 class="fw-bold text-primary font-monospace mt-1 mb-0" id="dispMaxLimit">1,500,000 บาท</h3>
                            <small class="text-muted">ตามระเบียบประเภทเงินกู้</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-danger-subtle rounded-4 p-3 text-center h-100">
                            <span class="text-danger small fw-semibold">ประมาณการค่างวดผ่อนต่อเดือน</span>
                            <h3 class="fw-bold text-danger font-monospace mt-1 mb-0" id="dispEstimatedMonthly">3,173.61 บาท</h3>
                            <small class="text-muted">รวมเงินต้นและดอกเบี้ย</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 rounded-4 p-3 text-center h-100" id="statusCard">
                            <span class="small fw-semibold text-muted">สถานะความพร้อมทางการเงิน</span>
                            <h4 class="fw-bold mt-1 mb-0" id="dispStatus"><i class="bi bi-check-circle-fill"></i> ผ่านเกณฑ์</h4>
                            <small id="dispStatusSub">เงินเดือนคงเหลือ > 30%</small>
                        </div>
                    </div>
                </div>

                <!-- DSR & Remaining Salary Meter -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-light mb-3">
                    <h6 class="fw-bold text-navy mb-3"><i class="bi bi-pie-chart-fill text-warning me-2"></i>สัดส่วนภาระหนี้ต่อรายได้ (Debt Service Ratio - DSR)</h6>
                    
                    <div class="d-flex justify-content-between small fw-bold mb-2">
                        <span>ภาระหนี้รวมต่อเดือน (DSR): <b id="dispDsrPercent" class="text-danger font-monospace">0%</b></span>
                        <span>เงินได้คงเหลือสุทธิ: <b id="dispRemainingPercent" class="text-success font-monospace">0%</b> (ขั้นต่ำตามเกณฑ์ 30%)</span>
                    </div>

                    <div class="progress rounded-pill mb-3" style="height: 16px;">
                        <div class="progress-bar bg-danger" role="progressbar" id="barDsr" style="width: 25%" title="ภาระหนี้"></div>
                        <div class="progress-bar bg-success" role="progressbar" id="barRemaining" style="width: 75%" title="เงินได้คงเหลือ"></div>
                    </div>

                    <div class="row g-3 small border-top pt-3">
                        <div class="col-6 col-md-3">
                            <span class="text-muted">รายได้รวม:</span>
                            <div class="fw-bold text-navy font-monospace" id="statSalary">฿38,500.00</div>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="text-muted">หนี้เดิมต่อเดือน:</span>
                            <div class="fw-bold text-muted font-monospace" id="statOldDebt">฿5,000.00</div>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="text-muted">ค่างวดใหม่:</span>
                            <div class="fw-bold text-danger font-monospace" id="statNewDebt">฿3,173.61</div>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="text-muted">เงินได้สุทธิคงเหลือ:</span>
                            <div class="fw-bold text-success font-monospace" id="statNetRemaining">฿30,326.39</div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info border-0 rounded-4 py-2 px-3 small mb-0 d-flex align-items-center">
                    <i class="bi bi-info-circle-fill fs-5 me-2 flex-shrink-0 text-primary"></i>
                    <div>
                        <b>เกณฑ์ระเบียบสหกรณ์:</b> ผู้กู้ต้องมีเงินได้รายเดือนคงเหลือสุทธิหลังหักชำระหนี้ทั้งหมดไม่น้อยกว่า <b>30%</b> ของเงินได้รายเดือน
                    </div>
                </div>
            </div>

            <!-- STEP 4: Document Upload -->
            <div class="wizard-pane d-none" id="wizardStep4">
                <h5 class="fw-bold text-navy mb-3">ขั้นตอนที่ 4: แนบเอกสารประกอบการขอกู้</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <label class="form-label small fw-bold"><i class="bi bi-file-earmark-pdf text-danger me-1"></i> สลิปเงินเดือนเดือนล่าสุด <span class="text-danger">*</span></label>
                            <input type="file" name="doc_salary" class="form-control form-control-sm">
                            <small class="text-muted">รองรับไฟล์ PDF, JPG, PNG ขนาดไม่เกิน 5MB</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <label class="form-label small fw-bold"><i class="bi bi-file-earmark-person text-primary me-1"></i> สำเนาบัตรประชาชน <span class="text-danger">*</span></label>
                            <input type="file" name="doc_id_card" class="form-control form-control-sm">
                            <small class="text-muted">พร้อมลงนามสำเนาถูกต้อง</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 5: Review -->
            <div class="wizard-pane d-none" id="wizardStep5">
                <h5 class="fw-bold text-navy mb-3">ขั้นตอนที่ 5: ตรวจสอบข้อมูลคำขอกู้เงินก่อนยืนยัน</h5>
                <div class="table-responsive">
                    <table class="table table-bordered small">
                        <tbody>
                            <tr><th class="bg-light" style="width: 35%;">ผู้ขอกู้</th><td><?= e(($member['prefix'] ?? '') . ($member['first_name'] ?? '') . ' ' . ($member['last_name'] ?? '')) ?> (<?= e($member['member_no']) ?>)</td></tr>
                            <tr><th class="bg-light">ประเภทเงินกู้</th><td id="reviewType">เงินกู้สามัญ</td></tr>
                            <tr><th class="bg-light">วงเงินขอกู้</th><td id="reviewAmount" class="fw-bold font-monospace text-primary">100,000 บาท</td></tr>
                            <tr><th class="bg-light">ระยะเวลาผ่อนชำระ</th><td id="reviewTerm">36 งวด</td></tr>
                            <tr><th class="bg-light">ประมาณการค่างวด</th><td id="reviewMonthly" class="fw-bold font-monospace text-danger">3,173.61 บาท/เดือน</td></tr>
                            <tr><th class="bg-light">สัดส่วนเงินคงเหลือ (Net Ratio)</th><td id="reviewNetRatio" class="fw-bold font-monospace text-success">78.77% (ผ่านเกณฑ์)</td></tr>
                            <tr><th class="bg-light">วัตถุประสงค์</th><td id="reviewPurpose">เพื่อการพัฒนาคุณภาพชีวิต</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- STEP 6: Confirmation -->
            <div class="wizard-pane d-none" id="wizardStep6">
                <div class="text-center py-4">
                    <div class="bg-success-subtle text-success rounded-circle p-3 d-inline-flex mb-3" style="width: 68px; height: 68px;"><i class="bi bi-check-circle-fill fs-2"></i></div>
                    <h5 class="fw-bold text-navy">พร้อมส่งคำขอกู้เงิน</h5>
                    <p class="text-muted small">เมื่อคลิกยืนยัน ระบบจะสร้างเลขที่คำขอและส่งข้อมูลไปยังเจ้าหน้าที่เพื่อดำเนินการตรวจสอบทันที</p>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                <button type="button" class="btn btn-light px-4 d-none" id="btnWizardPrev"><i class="bi bi-arrow-left me-1"></i> ย้อนกลับ</button>
                <button type="button" class="btn btn-primary px-4 ms-auto shadow-sm" id="btnWizardNext">ถัดไป <i class="bi bi-arrow-right ms-1"></i></button>
                <button type="submit" class="btn btn-success px-5 ms-auto d-none shadow-sm" id="btnWizardSubmit"><i class="bi bi-send-check me-1"></i> ยืนยันและส่งคำขอ</button>
            </div>
        </form>
    </div>
</div>

<style>
.wizard-step-circle {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #E2E8F0;
    color: #64748B;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    margin: 0 auto;
    transition: all 0.3s ease;
}
.wizard-step-circle.active {
    background: #0066CC;
    color: #FFFFFF;
    box-shadow: 0 4px 10px rgba(0, 102, 204, 0.3);
}
.loan-type-card.selected {
    border-color: #0066CC !important;
    background-color: #F0F5FF !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 6;

    const btnPrev = document.getElementById('btnWizardPrev');
    const btnNext = document.getElementById('btnWizardNext');
    const btnSubmit = document.getElementById('btnWizardSubmit');

    function calculateDSR() {
        const amount = parseFloat(document.getElementById('requestAmountInput').value) || 100000;
        const term = parseInt(document.getElementById('requestTermInput').value) || 36;
        const salary = parseFloat(document.getElementById('salaryInput').value) || 38500;
        const existingDebt = parseFloat(document.getElementById('existingDebtInput').value) || 0;

        // Interest rates
        let rate = 4.75;
        let selectedType = document.querySelector('input[name="loan_type"]:checked')?.value || 'ordinary';
        let typeName = 'เงินกู้สามัญ';
        let maxLimit = 1500000;

        if (selectedType === 'emergency') {
            rate = 5.25;
            typeName = 'เงินกู้ฉุกเฉิน';
            maxLimit = 100000;
        } else if (selectedType === 'special') {
            rate = 4.50;
            typeName = 'เงินกู้พิเศษเพื่อที่อยู่อาศัย';
            maxLimit = 3000000;
        }

        const monthlyNewInstallment = (amount / term) + (amount * (rate / 100) / 12);
        const totalMonthlyDebt = existingDebt + monthlyNewInstallment;
        const netRemaining = Math.max(0, salary - totalMonthlyDebt);
        const dsrPercent = (totalMonthlyDebt / salary) * 100;
        const remainingPercent = (netRemaining / salary) * 100;

        // Update UI
        document.getElementById('dispMaxLimit').textContent = maxLimit.toLocaleString() + ' บาท';
        document.getElementById('dispEstimatedMonthly').textContent = monthlyNewInstallment.toLocaleString('th-TH', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' บาท';
        
        document.getElementById('dispDsrPercent').textContent = dsrPercent.toFixed(1) + '%';
        document.getElementById('dispRemainingPercent').textContent = remainingPercent.toFixed(1) + '%';
        
        document.getElementById('barDsr').style.width = Math.min(100, dsrPercent) + '%';
        document.getElementById('barRemaining').style.width = Math.min(100, remainingPercent) + '%';

        document.getElementById('statSalary').textContent = '฿' + salary.toLocaleString('th-TH', {minimumFractionDigits: 2});
        document.getElementById('statOldDebt').textContent = '฿' + existingDebt.toLocaleString('th-TH', {minimumFractionDigits: 2});
        document.getElementById('statNewDebt').textContent = '฿' + monthlyNewInstallment.toLocaleString('th-TH', {minimumFractionDigits: 2});
        document.getElementById('statNetRemaining').textContent = '฿' + netRemaining.toLocaleString('th-TH', {minimumFractionDigits: 2});

        const statusCard = document.getElementById('statusCard');
        const dispStatus = document.getElementById('dispStatus');
        const dispStatusSub = document.getElementById('dispStatusSub');

        if (remainingPercent >= 30) {
            statusCard.className = 'card border-0 bg-success-subtle rounded-4 p-3 text-center h-100';
            dispStatus.className = 'fw-bold text-success mt-1 mb-0';
            dispStatus.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> ผ่านเกณฑ์';
            dispStatusSub.textContent = 'เงินได้คงเหลือ ' + remainingPercent.toFixed(1) + '% (>= 30%)';
        } else if (remainingPercent >= 20) {
            statusCard.className = 'card border-0 bg-warning-subtle rounded-4 p-3 text-center h-100';
            dispStatus.className = 'fw-bold text-warning-emphasis mt-1 mb-0';
            dispStatus.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-1"></i> เฝ้าระวัง';
            dispStatusSub.textContent = 'เงินได้คงเหลือ ' + remainingPercent.toFixed(1) + '% (อาจต้องเพิ่มผู้ค้ำ)';
        } else {
            statusCard.className = 'card border-0 bg-danger-subtle rounded-4 p-3 text-center h-100';
            dispStatus.className = 'fw-bold text-danger mt-1 mb-0';
            dispStatus.innerHTML = '<i class="bi bi-x-circle-fill me-1"></i> เกินเกณฑ์ภาระหนี้';
            dispStatusSub.textContent = 'เงินได้คงเหลือ ' + remainingPercent.toFixed(1) + '% (< 20%)';
        }

        // Review step
        document.getElementById('reviewType').textContent = typeName;
        document.getElementById('reviewAmount').textContent = amount.toLocaleString() + ' บาท';
        document.getElementById('reviewTerm').textContent = term + ' งวด';
        document.getElementById('reviewMonthly').textContent = monthlyNewInstallment.toLocaleString('th-TH', {minimumFractionDigits: 2}) + ' บาท/เดือน';
        document.getElementById('reviewNetRatio').textContent = remainingPercent.toFixed(1) + '% (' + (remainingPercent >= 30 ? 'ผ่านเกณฑ์' : 'ต่ำกว่าเกณฑ์') + ')';
        document.getElementById('reviewPurpose').textContent = document.querySelector('textarea[name="purpose"]')?.value || 'เพื่อการพัฒนาคุณภาพชีวิต';
    }

    function updateWizardUI() {
        for (let i = 1; i <= totalSteps; i++) {
            const pane = document.getElementById('wizardStep' + i);
            const ind = document.getElementById('stepIndicator' + i);
            if (pane) pane.classList.toggle('d-none', i !== currentStep);
            if (ind) ind.classList.toggle('active', i <= currentStep);
        }

        btnPrev.classList.toggle('d-none', currentStep === 1);
        btnNext.classList.toggle('d-none', currentStep === totalSteps);
        btnSubmit.classList.toggle('d-none', currentStep !== totalSteps);

        calculateDSR();
    }

    btnNext.addEventListener('click', function() {
        if (currentStep < totalSteps) {
            currentStep++;
            updateWizardUI();
        }
    });

    btnPrev.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateWizardUI();
        }
    });

    // Inputs listener for live updates
    ['requestAmountInput', 'requestTermInput', 'salaryInput', 'existingDebtInput'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', calculateDSR);
            el.addEventListener('change', calculateDSR);
        }
    });

    // Loan Card Selection
    document.querySelectorAll('.loan-type-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.loan-type-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                calculateDSR();
            }
        });
    });

    calculateDSR();
});
</script>
