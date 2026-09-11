<?php
$latest = $latest ?? null;
$statsHistory = $statsHistory ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-pie-chart-fill text-warning me-2"></i> Executive Financial Dashboard</h3>
        <p class="text-muted small mb-0">รายงานตัวชี้วัดทางการเงินและผลการดำเนินงานระดับผู้บริหาร</p>
    </div>
    <a href="<?= url('admin/dashboard') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> กลับแดชบอร์ดหลัก
    </a>
</div>

<?php if (!empty($latest)): ?>
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card p-4">
            <small class="text-muted fw-bold">สินทรัพย์รวม (Total Assets)</small>
            <div class="fs-3 fw-bold text-navy mt-1"><?= number_format((float)$latest['total_assets'] / 1000000, 2) ?> ล้าน</div>
            <small class="text-success"><i class="bi bi-arrow-up-right"></i> มั่นคงระดับ AAA</small>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card p-4">
            <small class="text-muted fw-bold">ทุนเรือนหุ้น (Share Capital)</small>
            <div class="fs-3 fw-bold text-primary mt-1"><?= number_format((float)$latest['share_capital'] / 1000000, 2) ?> ล้าน</div>
            <small class="text-muted">สมาชิก <?= number_format($latest['total_members']) ?> คน</small>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card p-4">
            <small class="text-muted fw-bold">เงินรับฝากรวม (Total Deposits)</small>
            <div class="fs-3 fw-bold text-success mt-1"><?= number_format((float)$latest['total_deposits'] / 1000000, 2) ?> ล้าน</div>
            <small class="text-muted">สภาพคล่อง: <?= number_format((float)$latest['liquidity_ratio'], 2) ?>%</small>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card p-4">
            <small class="text-muted fw-bold">อัตราส่วน NPL ต่อเงินให้กู้</small>
            <div class="fs-3 fw-bold text-success mt-1"><?= number_format((float)$latest['npl_percentage'], 2) ?>%</div>
            <small class="text-success"><i class="bi bi-shield-check"></i> ต่ำกว่าเกณฑ์มาตรฐาน</small>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Executive Charts -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card p-4">
            <h5 class="admin-card-title mb-4">แนวโน้มการเติบโตของสินทรัพย์ เงินฝาก และเงินกู้</h5>
            <div style="height: 350px;">
                <canvas id="execGrowthChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card p-4">
            <h5 class="admin-card-title mb-4">สัดส่วนโครงสร้างทางการเงิน</h5>
            <div style="height: 350px;">
                <canvas id="execStructureChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statsData = <?= json_encode($statsHistory) ?>;
    if (!statsData || !statsData.length) return;

    const labels = statsData.map(d => `${d.month}/${d.year}`);
    const assets = statsData.map(d => d.total_assets / 1000000);
    const deposits = statsData.map(d => d.total_deposits / 1000000);
    const loans = statsData.map(d => d.total_loans / 1000000);

    const ctx = document.getElementById('execGrowthChart');
    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'สินทรัพย์รวม (ล้าน)',
                        data: assets,
                        backgroundColor: '#073B74'
                    },
                    {
                        label: 'เงินรับฝาก (ล้าน)',
                        data: deposits,
                        backgroundColor: '#198754'
                    },
                    {
                        label: 'เงินให้กู้ (ล้าน)',
                        data: loans,
                        backgroundColor: '#0B5ED7'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    const ctxPie = document.getElementById('execStructureChart');
    if (ctxPie && typeof Chart !== 'undefined' && statsData.length > 0) {
        const last = statsData[statsData.length - 1];
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['ทุนเรือนหุ้น', 'เงินรับฝาก', 'ทุนสำรอง'],
                datasets: [{
                    data: [last.share_capital, last.total_deposits, last.reserve_fund],
                    backgroundColor: ['#0B5ED7', '#198754', '#C99A2E']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
});
</script>
