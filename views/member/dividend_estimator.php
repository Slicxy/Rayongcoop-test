<div class="row g-4">
    <!-- Header -->
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 bg-white p-4 rounded-4 shadow-sm border">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item"><a href="<?= url('member/dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">ประมาณการเงินปันผล</li>
                    </ol>
                </nav>
                <h4 class="fw-bold text-navy mb-1"><i class="bi bi-calculator me-2 text-warning"></i> เครื่องมือประมาณการเงินปันผลและเงินเฉลี่ยคืน</h4>
                <p class="text-muted small mb-0">จำลองผลประโยชน์ตอบแทนประจำปีจากทุนเรือนหุ้นและดอกเบี้ยเงินกู้สะสมของท่าน</p>
            </div>
            <div>
                <a href="<?= url('member/shares') ?>" class="btn btn-outline-primary rounded-pill px-3">
                    <i class="bi bi-graph-up-arrow me-1"></i> ดูรายละเอียดหุ้น
                </a>
            </div>
        </div>
    </div>

    <!-- Main Calculation Form & Results -->
    <div class="col-lg-7">
        <div class="card border-0 rounded-4 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h6 class="fw-bold text-navy mb-0"><i class="bi bi-sliders me-2 text-primary"></i> ปรับแต่งตัวแปรเพื่อจำลองการคำนวณ</h6>
            </div>
            <div class="card-body p-4">
                <!-- Section 1: Dividend on Shares -->
                <div class="p-3 bg-light-subtle rounded-4 border mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="fw-bold text-navy">
                            <i class="bi bi-piggy-bank-fill text-success me-1"></i> 1. เงินปันผลตามหุ้น (Dividend on Shares)
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">ดึงข้อมูลจริง</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">ทุนเรือนหุ้นสะสมของสมาชิก (บาท)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-cash-stack text-success"></i></span>
                            <input type="number" class="form-control form-control-lg fw-bold text-navy" id="inputShares" value="<?= (float)$totalShareAmount ?>" step="1000">
                            <span class="input-group-text bg-white">บาท</span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small text-muted mb-0">อัตราเงินปันผลประจำปีจำลอง (%)</label>
                            <span class="fw-bold text-success fs-5 font-monospace" id="labelDivRate"><?= number_format((float)$defaultDividendRate, 2) ?>%</span>
                        </div>
                        <input type="range" class="form-range" id="rangeDivRate" min="3.0" max="7.0" step="0.05" value="<?= (float)$defaultDividendRate ?>">
                        <div class="d-flex justify-content-between text-muted" style="font-size: 11px;">
                            <span>3.00%</span>
                            <span>อัตราเฉลี่ยปีก่อนหน้า: <?= number_format((float)$defaultDividendRate, 2) ?>%</span>
                            <span>7.00%</span>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Patronage Refund on Loan Interest -->
                <div class="p-3 bg-light-subtle rounded-4 border">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="fw-bold text-navy">
                            <i class="bi bi-arrow-repeat text-primary me-1"></i> 2. เงินเฉลี่ยคืนตามดอกเบี้ยจ่าย (Patronage Refund)
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">ดึงข้อมูลจริง</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">ยอดดอกเบี้ยเงินกู้สะสมที่จ่ายในรอบปี (บาท)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-receipt text-primary"></i></span>
                            <input type="number" class="form-control form-control-lg fw-bold text-navy" id="inputInterest" value="<?= (float)$totalInterestPaid ?>" step="500">
                            <span class="input-group-text bg-white">บาท</span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small text-muted mb-0">อัตราเงินเฉลี่ยคืนจำลอง (%)</label>
                            <span class="fw-bold text-primary fs-5 font-monospace" id="labelRefundRate"><?= number_format((float)$defaultRefundRate, 2) ?>%</span>
                        </div>
                        <input type="range" class="form-range" id="rangeRefundRate" min="5.0" max="25.0" step="0.5" value="<?= (float)$defaultRefundRate ?>">
                        <div class="d-flex justify-content-between text-muted" style="font-size: 11px;">
                            <span>5.00%</span>
                            <span>อัตราเฉลี่ยแนะนำ: <?= number_format((float)$defaultRefundRate, 2) ?>%</span>
                            <span>25.00%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Panel -->
    <div class="col-lg-5">
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100" style="background: linear-gradient(135deg, #073B74 0%, #0052A3 100%); color: #ffffff;">
            <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold">
                            <i class="bi bi-stars me-1"></i> สรุปผลประโยชน์ประมาณการ
                        </span>
                        <span class="small text-white-50">รอบสิ้นปีบัญชี</span>
                    </div>

                    <div class="text-center my-4">
                        <div class="small text-white-70 mb-1">ยอดเงินปันผลและเฉลี่ยคืนรวมสุทธิ</div>
                        <div class="display-5 fw-bold text-warning font-monospace" id="totalEstimatedReturns">฿0.00</div>
                        <div class="small text-white-70 mt-1" id="totalBahtText">(-)</div>
                    </div>

                    <!-- Breakdown Box -->
                    <div class="bg-white bg-opacity-10 rounded-4 p-3 border border-white-20 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom border-white-20">
                            <div>
                                <div class="fw-semibold text-white small"><i class="bi bi-pie-chart text-success me-1"></i> เงินปันผลตามหุ้น:</div>
                                <small class="text-white-50" id="divFormulaNote">(245,000 × 5.10%)</small>
                            </div>
                            <div class="fw-bold fs-6 font-monospace text-success-emphasis bg-white px-2 py-1 rounded-3" id="estimatedDividendAmount">
                                +฿0.00
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold text-white small"><i class="bi bi-arrow-repeat text-info me-1"></i> เงินเฉลี่ยคืนดอกเบี้ยเงินกู้:</div>
                                <small class="text-white-50" id="refundFormulaNote">(39,000 × 12.50%)</small>
                            </div>
                            <div class="fw-bold fs-6 font-monospace text-primary-emphasis bg-white px-2 py-1 rounded-3" id="estimatedRefundAmount">
                                +฿0.00
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="small text-white-50 text-center mb-3">
                        <i class="bi bi-info-circle me-1"></i> ตัวเลขนี้เป็นการคำนวณประมาณการเบื้องต้น อัตราเงินปันผลและเงินเฉลี่ยคืนจริงขึ้นอยู่กับมติที่ประชุมใหญ่สามัญประจำปีของสหกรณ์
                    </div>
                    <a href="<?= url('member/deposits') ?>" class="btn btn-warning text-dark fw-bold w-100 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-wallet2 me-1"></i> ดูบัญชีเงินฝากรับโอนเงินปันผล
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputShares = document.getElementById('inputShares');
    const rangeDivRate = document.getElementById('rangeDivRate');
    const labelDivRate = document.getElementById('labelDivRate');

    const inputInterest = document.getElementById('inputInterest');
    const rangeRefundRate = document.getElementById('rangeRefundRate');
    const labelRefundRate = document.getElementById('labelRefundRate');

    const totalEstimatedReturns = document.getElementById('totalEstimatedReturns');
    const estimatedDividendAmount = document.getElementById('estimatedDividendAmount');
    const estimatedRefundAmount = document.getElementById('estimatedRefundAmount');
    const divFormulaNote = document.getElementById('divFormulaNote');
    const refundFormulaNote = document.getElementById('refundFormulaNote');

    function calculate() {
        const shares = parseFloat(inputShares.value) || 0;
        const divRate = parseFloat(rangeDivRate.value) || 0;

        const interest = parseFloat(inputInterest.value) || 0;
        const refundRate = parseFloat(rangeRefundRate.value) || 0;

        labelDivRate.textContent = divRate.toFixed(2) + '%';
        labelRefundRate.textContent = refundRate.toFixed(2) + '%';

        const divAmount = (shares * divRate) / 100;
        const refAmount = (interest * refundRate) / 100;
        const total = divAmount + refAmount;

        estimatedDividendAmount.textContent = '+฿' + divAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        estimatedRefundAmount.textContent = '+฿' + refAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        totalEstimatedReturns.textContent = '฿' + total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        divFormulaNote.textContent = '(' + shares.toLocaleString('en-US') + ' ฿ × ' + divRate.toFixed(2) + '%)';
        refundFormulaNote.textContent = '(' + interest.toLocaleString('en-US') + ' ฿ × ' + refundRate.toFixed(2) + '%)';
    }

    inputShares.addEventListener('input', calculate);
    rangeDivRate.addEventListener('input', calculate);
    inputInterest.addEventListener('input', calculate);
    rangeRefundRate.addEventListener('input', calculate);

    calculate();
});
</script>
