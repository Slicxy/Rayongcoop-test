<?php
$summary = $summary ?? [
    'netWorth' => 0,
    'monthlyDeduction' => ['total' => 0],
    'shares' => ['total_shares' => 0, 'total_amount' => 0],
    'deposits' => ['count' => 0, 'total_balance' => 0],
    'loans' => ['contracts' => [], 'total_principal' => 0]
];
?>
<!-- Financial Summary View -->
<div class="row g-4 mb-4">
    <!-- Net Worth Card -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100" style="background: linear-gradient(135deg, #073B74 0%, #0066CC 100%); color: #FFFFFF;">
            <span class="text-white-50 small fw-bold text-uppercase">ทรัพย์สินสุทธิกับสหกรณ์ (Net Assets)</span>
            <h1 class="fw-bold text-white my-3 font-monospace"><?= number_format((float)($summary['netWorth'] ?? 0), 2) ?> <span class="fs-6 fw-normal">บาท</span></h1>
            <div class="small text-white-50">คำนวณจาก (มูลค่าหุ้นสะสม + เงินฝากรวม) - หนี้สินคงเหลือ</div>
        </div>
    </div>

    <!-- Monthly Cashflow Obligation -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100 bg-white">
            <span class="text-muted small fw-bold text-uppercase">ภาระผ่อนชำระและเงินออมต่อเดือน</span>
            <h1 class="fw-bold text-navy my-3 font-monospace"><?= number_format((float)($summary['monthlyDeduction']['total'] ?? 0), 2) ?> <span class="fs-6 fw-normal text-muted">บาท/เดือน</span></h1>
            <div class="small text-muted">หักผ่านระบบบัญชีเงินเดือนอัตโนมัติทุกสิ้นเดือน</div>
        </div>
    </div>
</div>

<!-- Assets vs Liabilities Breakdown -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0">
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-shield-check text-success me-2"></i>ทรัพย์สินสมาชิก (Assets)</h5>
            </div>
            <div class="card-body p-4">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0">
                        <div>
                            <div class="fw-bold text-navy">หุ้นสะสมสหกรณ์</div>
                            <small class="text-muted"><?= number_format($summary['shares']['total_shares'] ?? 0) ?> หุ้น</small>
                        </div>
                        <span class="fw-bold font-monospace text-primary fs-5"><?= number_format((float)($summary['shares']['total_amount'] ?? 0), 2) ?> บ.</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0">
                        <div>
                            <div class="fw-bold text-navy">เงินฝากออมทรัพย์รวม</div>
                            <small class="text-muted"><?= (int)($summary['deposits']['count'] ?? 0) ?> บัญชี</small>
                        </div>
                        <span class="fw-bold font-monospace text-success fs-5"><?= number_format((float)($summary['deposits']['total_balance'] ?? 0), 2) ?> บ.</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-top mt-2 fw-bold text-navy">
                        <span>รวมทรัพย์สินทั้งหมด</span>
                        <span class="text-success font-monospace fs-5"><?= number_format((float)(($summary['shares']['total_amount'] ?? 0) + ($summary['deposits']['total_balance'] ?? 0)), 2) ?> บ.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0">
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-exclamation-octagon text-danger me-2"></i>หนี้สินคงค้าง (Liabilities)</h5>
            </div>
            <div class="card-body p-4">
                <ul class="list-group list-group-flush">
                    <?php if (!empty($summary['loans']['contracts'])): ?>
                        <?php foreach ($summary['loans']['contracts'] as $ln): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0">
                                <div>
                                    <div class="fw-bold text-navy"><?= e($ln['loan_name'] ?? 'สินเชื่อ') ?></div>
                                    <small class="text-muted">สัญญา <?= e($ln['contract_no'] ?? '-') ?></small>
                                </div>
                                <span class="fw-bold font-monospace text-danger fs-5"><?= number_format((float)($ln['principal_balance'] ?? 0), 2) ?> บ.</span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-top mt-2 fw-bold text-navy">
                        <span>รวมหนี้สินคงค้างทั้งหมด</span>
                        <span class="text-danger font-monospace fs-5"><?= number_format((float)($summary['loans']['total_principal'] ?? 0), 2) ?> บ.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
