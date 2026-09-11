<?php
$member = array_merge([
    'first_name' => 'สมาชิก',
    'last_name' => '',
    'prefix' => '',
    'member_no' => '-',
    'department' => '-'
], $member ?? []);

$summary = array_merge([
    'share_value' => 0,
    'total_deposit' => 0,
    'loan_balance' => 0,
    'welfare_count' => 0,
    'monthly_share' => 0,
    'deposit_count' => 0,
    'active_loans_count' => 0,
    'welfare_received_total' => 0,
    'deposits' => ['total_balance' => 0, 'count' => 0, 'total_interest' => 0],
    'loans' => ['total_principal' => 0, 'count' => 0, 'total_installment' => 0],
    'monthlyDeduction' => [
        'share' => 0,
        'loan_principal' => 0,
        'loan_interest' => 0,
        'deposit' => 0,
        'other' => 0,
        'total' => 0
    ]
], $summary ?? []);
if (!isset($summary['deposits']) || !is_array($summary['deposits'])) $summary['deposits'] = ['total_balance' => 0, 'count' => 0, 'total_interest' => 0];
if (!isset($summary['loans']) || !is_array($summary['loans'])) $summary['loans'] = ['total_principal' => 0, 'count' => 0, 'total_installment' => 0];
if (!isset($summary['monthlyDeduction']) || !is_array($summary['monthlyDeduction'])) {
    $summary['monthlyDeduction'] = ['share' => 0, 'loan_principal' => 0, 'loan_interest' => 0, 'deposit' => 0, 'other' => 0, 'total' => 0];
}
?>
<!-- 1. Member Greeting Banner -->
<div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #073B74 0%, #0066CC 100%); color: #FFFFFF;">
    <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm fw-bold fs-4" style="width: 58px; height: 58px;">
                    <?= mb_substr($member['first_name'] ?? 'ส', 0, 1, 'UTF-8') ?>
                </div>
                <div>
                    <h4 class="fw-bold mb-1 text-white">สวัสดี, <?= e(($member['prefix'] ?? '') . ($member['first_name'] ?? 'สมาชิก') . ' ' . ($member['last_name'] ?? '')) ?></h4>
                    <p class="mb-0 text-white-50 small">
                        รหัสสมาชิก: <span class="badge bg-white text-navy fw-bold"><?= e($member['member_no']) ?></span> &bull; 
                        <?= e($member['department']) ?>
                    </p>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="<?= url('member/loan-apply') ?>" class="btn btn-warning text-navy btn-sm fw-bold px-3 d-flex align-items-center gap-1 shadow-sm">
                    <i class="bi bi-cash-stack"></i> ยื่นกู้ออนไลน์
                </a>
                <a href="<?= url('member/receipts') ?>" class="btn btn-light btn-sm fw-bold px-3 d-flex align-items-center gap-1 shadow-sm">
                    <i class="bi bi-receipt"></i> ดูใบเสร็จล่าสุด
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 2. Four Member Dashboard Cards -->
<div class="row g-3 g-xl-4 mb-4">
    <!-- Card 1: หุ้นของสมาชิก -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="border-left: 5px solid #0066CC !important;">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted fw-bold small text-uppercase">หุ้นสะสมของสมาชิก</span>
                <div class="bg-primary-subtle text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-graph-up-arrow fs-5"></i>
                </div>
            </div>
            <h3 class="fw-bold text-navy my-1 font-monospace"><?= number_format($summary['shares']['total_amount'] ?? 245000) ?> <span class="fs-6 fw-normal text-muted">บาท</span></h3>
            <div class="d-flex justify-content-between small text-muted mt-2 pt-2 border-top">
                <span>จำนวนหุ้น: <b><?= number_format($summary['shares']['total_shares'] ?? 24500) ?></b></span>
                <span class="text-primary">ส่ง <b><?= number_format($summary['shares']['monthly_share'] ?? 1500) ?></b>/ด.</span>
            </div>
        </div>
    </div>

    <!-- Card 2: เงินฝากรวม -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="border-left: 5px solid #28A745 !important;">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted fw-bold small text-uppercase">ยอดเงินฝากรวม</span>
                <div class="bg-success-subtle text-success rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-piggy-bank fs-5"></i>
                </div>
            </div>
            <h3 class="fw-bold text-success my-1 font-monospace"><?= number_format($summary['deposits']['total_balance'] ?? 335400.50, 2) ?> <span class="fs-6 fw-normal text-muted">บาท</span></h3>
            <div class="d-flex justify-content-between small text-muted mt-2 pt-2 border-top">
                <span>บัญชีเปิดใช้: <b><?= $summary['deposits']['count'] ?> เล่ม</b></span>
                <span class="text-success">ดบ. สะสม: <b><?= number_format($summary['deposits']['total_interest'] ?? 4077.75, 2) ?></b></span>
            </div>
        </div>
    </div>

    <!-- Card 3: เงินกู้คงเหลือ -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="border-left: 5px solid #DC3545 !important;">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted fw-bold small text-uppercase">หนี้สินคงเหลือ</span>
                <div class="bg-danger-subtle text-danger rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-credit-card-2-front fs-5"></i>
                </div>
            </div>
            <h3 class="fw-bold text-danger my-1 font-monospace"><?= number_format($summary['loans']['total_principal'] ?? 357500, 2) ?> <span class="fs-6 fw-normal text-muted">บาท</span></h3>
            <div class="d-flex justify-content-between small text-muted mt-2 pt-2 border-top">
                <span>สัญญาคงอยู่: <b><?= $summary['loans']['count'] ?> สัญญา</b></span>
                <span class="text-danger">ผ่อน <b><?= number_format($summary['loans']['total_installment'] ?? 12200) ?></b>/ด.</span>
            </div>
        </div>
    </div>

    <!-- Card 4: ยอดหักประจำเดือน -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="border-left: 5px solid #FFC107 !important;">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted fw-bold small text-uppercase">ยอดหักเงินเดือนประจำงวด</span>
                <div class="bg-warning-subtle text-warning rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-calendar-check fs-5"></i>
                </div>
            </div>
            <h3 class="fw-bold text-navy my-1 font-monospace"><?= number_format($summary['monthlyDeduction']['total'] ?? 14450, 2) ?> <span class="fs-6 fw-normal text-muted">บาท</span></h3>
            <div class="d-flex justify-content-between small text-muted mt-2 pt-2 border-top">
                <span>งวดประจำเดือน: <b>ก.ย. 2569</b></span>
                <span class="badge bg-success-subtle text-success">หักสำเร็จ</span>
            </div>
        </div>
    </div>
</div>

<!-- 3. Quick Action Shortcuts -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-transparent border-0 p-4 pb-0">
        <h5 class="fw-bold text-navy mb-0"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>บริการด่วนสำหรับสมาชิก</h5>
    </div>
    <div class="card-body p-4">
        <div class="row g-3 text-center">
            <div class="col-6 col-md-3">
                <a href="<?= url('member/loan-apply') ?>" class="btn btn-light w-100 p-3 rounded-4 border d-flex flex-column align-items-center gap-2 text-decoration-none">
                    <div class="bg-primary text-white rounded-3 p-2 fs-4" style="width: 46px; height: 46px;"><i class="bi bi-cash-stack"></i></div>
                    <span class="fw-bold text-navy small">ยื่นกู้เงินออนไลน์</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="<?= url('member/receipts') ?>" class="btn btn-light w-100 p-3 rounded-4 border d-flex flex-column align-items-center gap-2 text-decoration-none">
                    <div class="bg-success text-white rounded-3 p-2 fs-4" style="width: 46px; height: 46px;"><i class="bi bi-receipt"></i></div>
                    <span class="fw-bold text-navy small">ดูใบเสร็จรับเงิน</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="<?= url('member/welfare') ?>" class="btn btn-light w-100 p-3 rounded-4 border d-flex flex-column align-items-center gap-2 text-decoration-none">
                    <div class="bg-info text-white rounded-3 p-2 fs-4" style="width: 46px; height: 46px;"><i class="bi bi-heart-pulse"></i></div>
                    <span class="fw-bold text-navy small">ยื่นขอสวัสดิการ</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="<?= url('member/shares') ?>" class="btn btn-light w-100 p-3 rounded-4 border d-flex flex-column align-items-center gap-2 text-decoration-none">
                    <div class="bg-warning text-white rounded-3 p-2 fs-4" style="width: 46px; height: 46px;"><i class="bi bi-sliders"></i></div>
                    <span class="fw-bold text-navy small">เปลี่ยนค่าหุ้นรายเดือน</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 4. Financial Charts & Monthly Deduction Breakdown -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-graph-up text-primary me-2"></i>ประวัติและแนวโน้มทางการเงินของสมาชิก</h5>
                <span class="badge bg-light text-navy border px-2 py-1 small">6 เดือนย้อนหลัง</span>
            </div>
            <div class="card-body p-4">
                <div style="height: 300px; position: relative;">
                    <canvas id="memberFinancialTrendsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0">
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-pie-chart-fill text-info me-2"></i>สัดส่วนยอดหักรายเดือน</h5>
            </div>
            <div class="card-body p-4">
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span><i class="bi bi-circle-fill text-primary me-2" style="font-size: 8px;"></i> ค่าหุ้นรายเดือน</span>
                        <span class="fw-bold font-monospace"><?= number_format($summary['monthlyDeduction']['share'], 2) ?> บาท</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span><i class="bi bi-circle-fill text-danger me-2" style="font-size: 8px;"></i> เงินต้นเงินกู้</span>
                        <span class="fw-bold font-monospace"><?= number_format($summary['monthlyDeduction']['loan_principal'], 2) ?> บาท</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span><i class="bi bi-circle-fill text-warning me-2" style="font-size: 8px;"></i> ดอกเบี้ยเงินกู้</span>
                        <span class="fw-bold font-monospace"><?= number_format($summary['monthlyDeduction']['loan_interest'], 2) ?> บาท</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span><i class="bi bi-circle-fill text-success me-2" style="font-size: 8px;"></i> เงินฝากสะสม</span>
                        <span class="fw-bold font-monospace"><?= number_format($summary['monthlyDeduction']['deposit'], 2) ?> บาท</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span><i class="bi bi-circle-fill text-secondary me-2" style="font-size: 8px;"></i> รายการอื่น/สมาคม</span>
                        <span class="fw-bold font-monospace"><?= number_format($summary['monthlyDeduction']['other'], 2) ?> บาท</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-top mt-2 fw-bold text-navy">
                        <span>ยอดรวมทั้งสิ้น</span>
                        <span class="text-primary font-monospace fs-6"><?= number_format($summary['monthlyDeduction']['total'], 2) ?> บาท</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('memberFinancialTrendsChart');
    if (ctx && typeof Chart !== 'undefined') {
        const chartData = <?= json_encode($summary['chartData'] ?? []) ?>;
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels || ['เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.'],
                datasets: [
                    {
                        label: 'หุ้นสะสม (บาท)',
                        data: chartData.shares,
                        borderColor: '#0066CC',
                        backgroundColor: 'rgba(0, 102, 204, 0.08)',
                        fill: false,
                        tension: 0.3,
                        borderWidth: 2
                    },
                    {
                        label: 'เงินฝากรวม (บาท)',
                        data: chartData.deposits,
                        borderColor: '#28A745',
                        backgroundColor: 'rgba(40, 167, 69, 0.08)',
                        fill: false,
                        tension: 0.3,
                        borderWidth: 2
                    },
                    {
                        label: 'หนี้สินคงเหลือ (บาท)',
                        data: chartData.loans,
                        borderColor: '#DC3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.08)',
                        fill: false,
                        tension: 0.3,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { font: { family: "'Prompt', sans-serif" } } }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(v) { return Number(v).toLocaleString() + ' บ.'; }
                        },
                        grid: { color: '#f1f5f9' }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }
});
</script>
