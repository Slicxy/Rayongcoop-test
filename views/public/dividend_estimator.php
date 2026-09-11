<?php
$defaultDividendRate = $defaultDividendRate ?? 5.10;
$defaultRefundRate = $defaultRefundRate ?? 12.50;
?>
<div class="py-5" style="background: linear-gradient(135deg, #073B74 0%, #0052A3 100%); color: #ffffff;">
    <div class="container-xl text-center">
        <span class="badge bg-gold text-white px-3 py-1 rounded-pill mb-2 fw-semibold">
            <i class="bi bi-stars me-1"></i> เครื่องมือช่วยคำนวณออนไลน์
        </span>
        <h1 class="fw-bold mb-2 text-white">โปรแกรมจำลองและประมาณการเงินปันผล-เฉลี่ยคืน</h1>
        <p class="text-white small mb-0" style="max-width: 650px; margin: 0 auto;">
            คำนวณผลตอบแทนจากเงินปันผลตามหุ้นและเงินเฉลี่ยคืนจากดอกเบี้ยเงินกู้
        </p>
    </div>
</div>

<div class="py-5">
    <div class="container-xl">
        <div class="row g-4">
            <!-- Left inputs -->
            <div class="col-lg-7">
                <div class="card border-0 rounded-4 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="fw-bold text-navy mb-0"><i class="bi bi-sliders me-2 text-primary"></i> กรอกข้อมูลเพื่อจำลองผลประโยชน์</h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Shares Section -->
                        <div class="p-3 bg-light-subtle rounded-4 border mb-4">
                            <div class="fw-bold text-navy mb-3">
                                <i class="bi bi-piggy-bank-fill text-success me-1"></i> 1. ทุนเรือนหุ้น (Share Capital)
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-muted">จำนวนทุนเรือนหุ้นที่ถือครอง (บาท)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-cash-stack text-success"></i></span>
                                    <input type="number" class="form-control form-control-lg fw-bold text-navy" id="pubInputShares" value="100000" step="1000">
                                    <span class="input-group-text bg-white">บาท</span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label small text-muted mb-0">อัตราเงินปันผลจำลอง (%)</label>
                                    <span class="fw-bold text-success fs-5 font-monospace" id="pubLabelDivRate"><?= number_format((float)$defaultDividendRate, 2) ?>%</span>
                                </div>
                                <input type="range" class="form-range" id="pubRangeDivRate" min="3.0" max="7.0" step="0.05" value="<?= (float)$defaultDividendRate ?>">
                                <div class="d-flex justify-content-between text-muted" style="font-size: 11px;">
                                    <span>3.00%</span>
                                    <span>อัตราเฉลี่ยปีก่อนหน้า: <?= number_format((float)$defaultDividendRate, 2) ?>%</span>
                                    <span>7.00%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Loan Interest Section -->
                        <div class="p-3 bg-light-subtle rounded-4 border">
                            <div class="fw-bold text-navy mb-3">
                                <i class="bi bi-arrow-repeat text-primary me-1"></i> 2. ดอกเบี้ยเงินกู้จ่ายสะสมในรอบปี (Loan Interest)
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-muted">ยอดดอกเบี้ยเงินกู้ที่จ่ายให้สหกรณ์ทั้งปี (บาท)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-receipt text-primary"></i></span>
                                    <input type="number" class="form-control form-control-lg fw-bold text-navy" id="pubInputInterest" value="30000" step="500">
                                    <span class="input-group-text bg-white">บาท</span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label small text-muted mb-0">อัตราเงินเฉลี่ยคืนจำลอง (%)</label>
                                    <span class="fw-bold text-primary fs-5 font-monospace" id="pubLabelRefundRate"><?= number_format((float)$defaultRefundRate, 2) ?>%</span>
                                </div>
                                <input type="range" class="form-range" id="pubRangeRefundRate" min="5.0" max="25.0" step="0.5" value="<?= (float)$defaultRefundRate ?>">
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

            <!-- Right Results -->
            <div class="col-lg-5">
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100" style="background: linear-gradient(135deg, #073B74 0%, #0052A3 100%); color: #ffffff;">
                    <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold">
                                    <i class="bi bi-stars me-1"></i> ประมาณการผลตอบแทน
                                </span>
                                <span class="small text-white">รอบปีบัญชี</span>
                            </div>

                            <div class="text-center my-4">
                                <div class="small text-white-70 mb-1">ยอดเงินปันผลและเฉลี่ยคืนรวมสุทธิ</div>
                                <div class="display-5 fw-bold text-white font-monospace" id="pubTotalReturns">฿0.00</div>
                            </div>

                            <!-- Breakdown Box -->
                            <div class="bg-white bg-opacity-10 rounded-4 p-3 border border-white-20 mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom border-white-20">
                                    <div>
                                        <div class="fw-semibold text-white small"><i class="bi bi-pie-chart text-success me-1"></i> เงินปันผลตามหุ้น:</div>
                                        <small class="text-white-50" id="pubDivNote">-</small>
                                    </div>
                                    <div class="fw-bold fs-6 font-monospace text-success-emphasis bg-white px-2 py-1 rounded-3" id="pubDivAmount">
                                        +฿0.00
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold text-white small"><i class="bi bi-arrow-repeat text-info me-1"></i> เงินเฉลี่ยคืนดอกเบี้ยเงินกู้:</div>
                                        <small class="text-white-50" id="pubRefNote">-</small>
                                    </div>
                                    <div class="fw-bold fs-6 font-monospace text-primary-emphasis bg-white px-2 py-1 rounded-3" id="pubRefAmount">
                                        +฿0.00
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="small text-white-50 text-center mb-3">
                                * สมาชิกสหกรณ์สามารถเข้าสู่ระบบเพื่อดูยอดหุ้นและดอกเบี้ยจ่ายจริงได้ทันที
                            </div>
                            <a href="<?= url('login') ?>" class="btn btn-warning text-dark fw-bold w-100 py-2 rounded-pill shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบเพื่อดึงข้อมูลจริงของท่าน
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputShares = document.getElementById('pubInputShares');
        const rangeDivRate = document.getElementById('pubRangeDivRate');
        const labelDivRate = document.getElementById('pubLabelDivRate');

        const inputInterest = document.getElementById('pubInputInterest');
        const rangeRefundRate = document.getElementById('pubRangeRefundRate');
        const labelRefundRate = document.getElementById('pubLabelRefundRate');

        const pubTotalReturns = document.getElementById('pubTotalReturns');
        const pubDivAmount = document.getElementById('pubDivAmount');
        const pubRefAmount = document.getElementById('pubRefAmount');
        const pubDivNote = document.getElementById('pubDivNote');
        const pubRefNote = document.getElementById('pubRefNote');

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

            pubDivAmount.textContent = '+฿' + divAmount.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            pubRefAmount.textContent = '+฿' + refAmount.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            pubTotalReturns.textContent = '฿' + total.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            pubDivNote.textContent = '(' + shares.toLocaleString('en-US') + ' ฿ × ' + divRate.toFixed(2) + '%)';
            pubRefNote.textContent = '(' + interest.toLocaleString('en-US') + ' ฿ × ' + refundRate.toFixed(2) + '%)';
        }

        inputShares.addEventListener('input', calculate);
        rangeDivRate.addEventListener('input', calculate);
        inputInterest.addEventListener('input', calculate);
        rangeRefundRate.addEventListener('input', calculate);

        calculate();
    });
</script>