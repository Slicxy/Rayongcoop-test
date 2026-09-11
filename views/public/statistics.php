<?php
$latest = $latest ?? null;
$statsHistory = $statsHistory ?? [];
?>
<div class="py-5 bg-navy text-white">
    <div class="container">
        <span class="badge bg-gold text-white mb-2 px-3 py-1">ความมั่นคงทางการเงิน</span>
        <h1 class="text-white fw-bold display-6 mb-2">ฐานะการเงินและสถิติการดำเนินงาน</h1>
        <p class="text-light-blue lead mb-0">รายงานข้อมูลทางการเงิน การเติบโตของทุนเรือนหุ้น เงินฝาก สินเชื่อ และสินทรัพย์รวม</p>
    </div>
</div>

<div class="container py-5">
    <?php if (!empty($latest)): ?>
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-6">
            <div class="coop-card p-4 text-center">
                <small class="text-muted text-uppercase fw-semibold">สินทรัพย์รวม (Total Assets)</small>
                <div class="stat-number text-navy mt-1"><?= number_format((float)$latest['total_assets'] / 1000000, 2) ?> ล้าน</div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="coop-card p-4 text-center">
                <small class="text-muted text-uppercase fw-semibold">ทุนเรือนหุ้น (Share Capital)</small>
                <div class="stat-number text-primary mt-1"><?= number_format((float)$latest['share_capital'] / 1000000, 2) ?> ล้าน</div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="coop-card p-4 text-center">
                <small class="text-muted text-uppercase fw-semibold">เงินรับฝากรวม (Total Deposits)</small>
                <div class="stat-number text-success mt-1"><?= number_format((float)$latest['total_deposits'] / 1000000, 2) ?> ล้าน</div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="coop-card p-4 text-center">
                <small class="text-muted text-uppercase fw-semibold">เงินให้กู้รวม (Total Loans)</small>
                <div class="stat-number text-warning mt-1"><?= number_format((float)$latest['total_loans'] / 1000000, 2) ?> ล้าน</div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Interactive Growth Chart -->
    <div class="coop-card p-4 p-md-5 mb-5">
        <h4 class="fw-bold text-navy mb-4"><i class="bi bi-graph-up me-2 text-primary"></i> กราฟแสดงการเติบโตทางการเงิน</h4>
        <div style="height: 380px;">
            <canvas id="financialStatsChart"></canvas>
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

    const ctx = document.getElementById('financialStatsChart');
    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'สินทรัพย์รวม (ล้านบาท)',
                        data: assets,
                        borderColor: '#073B74',
                        backgroundColor: 'rgba(7, 59, 116, 0.1)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'เงินรับฝาก (ล้านบาท)',
                        data: deposits,
                        borderColor: '#198754',
                        backgroundColor: 'transparent',
                        tension: 0.3
                    },
                    {
                        label: 'เงินให้กู้ (ล้านบาท)',
                        data: loans,
                        borderColor: '#0B5ED7',
                        backgroundColor: 'transparent',
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                }
            }
        });
    }
});
</script>
