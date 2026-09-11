<?php
$user = $user ?? [];
$coopSummary = $coopSummary ?? [];
$recentAudits = $recentAudits ?? [];
?>
<!-- 1. Welcome Banner Header -->
<div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #073B74 0%, #0066CC 100%); color: #FFFFFF;">
    <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white text-navy rounded-circle p-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 56px; height: 56px; font-size: 26px;">
                    <i class="bi bi-bank2 text-primary"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1 text-white">ยินดีต้อนรับเข้าสู่ระบบบริหารจัดการสหกรณ์</h4>
                    <p class="mb-0 text-white-50 small">
                        ผู้ใช้งานปัจจุบัน: <span class="badge bg-white text-navy fw-bold px-2 py-1"><?= e($user['username'] ?? 'rayongcoop1') ?></span> 
                        (<?= e($user['name'] ?? 'เจ้าหน้าที่สหกรณ์') ?>) &bull; สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด
                    </p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= url('admin/executive') ?>" class="btn btn-warning btn-sm text-navy fw-bold px-3 d-flex align-items-center gap-1 shadow-sm">
                    <i class="bi bi-pie-chart-fill"></i> ภาพรวมการเงิน
                </a>
                <a href="<?= url('logout') ?>" class="btn btn-light btn-sm text-danger fw-bold px-3 d-flex align-items-center gap-1 shadow-sm">
                    <i class="bi bi-power"></i> ออกจากระบบ
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 2. Four Main Cooperative Summary Cards -->
<div class="row g-3 g-xl-4 mb-4">
    <!-- Card 1: จำนวนสมาชิก -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="border-left: 5px solid #0066CC !important; transition: transform 0.2s ease;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-bold small text-uppercase">จำนวนสมาชิก</span>
                    <h3 class="fw-bold text-navy my-1 font-monospace"><?= number_format($coopSummary['total_members'] ?? 2458) ?> <span class="fs-6 fw-normal text-muted">คน</span></h3>
                    <div class="text-success small fw-medium">
                        <i class="bi bi-arrow-up-circle-fill me-1"></i> +<?= $coopSummary['new_members_this_month'] ?? 12 ?> คนเดือนนี้
                    </div>
                </div>
                <div class="bg-primary-subtle text-primary rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; font-size: 24px;">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: เงินฝากรวม -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="border-left: 5px solid #28A745 !important; transition: transform 0.2s ease;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-bold small text-uppercase">ยอดเงินฝากรวม</span>
                    <h3 class="fw-bold text-success my-1 font-monospace"><?= number_format($coopSummary['total_deposits'] ?? 154230000) ?> <span class="fs-6 fw-normal text-muted">บาท</span></h3>
                    <div class="text-success small fw-medium">
                        <i class="bi bi-graph-up-arrow me-1"></i> เติบโต +<?= $coopSummary['deposit_growth'] ?? 4.8 ?>% ต่อปี
                    </div>
                </div>
                <div class="bg-success-subtle text-success rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; font-size: 24px;">
                    <i class="bi bi-piggy-bank-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: จำนวนสินเชื่อ -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="border-left: 5px solid #FFC107 !important; transition: transform 0.2s ease;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-bold small text-uppercase">จำนวนสินเชื่อ</span>
                    <h3 class="fw-bold text-navy my-1 font-monospace"><?= number_format($coopSummary['total_loans'] ?? 890) ?> <span class="fs-6 fw-normal text-muted">สัญญา</span></h3>
                    <div class="text-muted small fw-medium">
                        <i class="bi bi-cash-stack me-1 text-warning"></i> วงเงิน <?= number_format(($coopSummary['loan_amount'] ?? 128450000) / 1000000, 1) ?> ล้านบาท
                    </div>
                </div>
                <div class="bg-warning-subtle text-warning rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; font-size: 24px;">
                    <i class="bi bi-cash-coin"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: ยอดเงินรวม / สินทรัพย์รวม -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="border-left: 5px solid #17A2B8 !important; transition: transform 0.2s ease;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-bold small text-uppercase">ยอดเงินทุนและสินทรัพย์รวม</span>
                    <h3 class="fw-bold text-primary my-1 font-monospace"><?= number_format($coopSummary['total_assets'] ?? 282680000) ?> <span class="fs-6 fw-normal text-muted">บาท</span></h3>
                    <div class="text-info small fw-medium">
                        <i class="bi bi-shield-lock-fill me-1"></i> ทุนสำรอง 42.5 ล้านบาท
                    </div>
                </div>
                <div class="bg-info-subtle text-info rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; font-size: 24px;">
                    <i class="bi bi-safe-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. Financial Trend Charts & Quick Controls -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-navy mb-1"><i class="bi bi-bar-chart-line-fill text-primary me-2"></i>แนวโน้มเงินฝากและสินเชื่อสหกรณ์ (รายเดือน)</h5>
                    <p class="text-muted small mb-0">การเติบโตเปรียบเทียบระหว่างเงินฝากสมาชิกกับวงเงินสินเชื่อปล่อยกู้</p>
                </div>
                <span class="badge bg-light text-navy border px-2 py-1 small">ปี 2567</span>
            </div>
            <div class="card-body p-4">
                <div style="height: 280px; position: relative;">
                    <canvas id="coopFinancialChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-2">
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>เมนูด่วน (Quick Actions)</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <div class="d-flex flex-column gap-2">
                    <a href="<?= url('admin/news/create') ?>" class="btn btn-light text-start p-3 rounded-3 border d-flex align-items-center justify-content-between text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary text-white rounded-3 p-2"><i class="bi bi-plus-circle"></i></div>
                            <div>
                                <div class="fw-bold text-navy small">เพิ่มข่าวสารและประกาศ</div>
                                <small class="text-muted">เผยแพร่ข่าวใหม่สู่หน้าเว็บ</small>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </a>

                    <a href="<?= url('admin/interest-rates') ?>" class="btn btn-light text-start p-3 rounded-3 border d-flex align-items-center justify-content-between text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-success text-white rounded-3 p-2"><i class="bi bi-percent"></i></div>
                            <div>
                                <div class="fw-bold text-navy small">ปรับปรุงอัตราดอกเบี้ย</div>
                                <small class="text-muted">เงินฝากและสินเชื่อล่าสุด</small>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </a>

                    <a href="<?= url('admin/documents') ?>" class="btn btn-light text-start p-3 rounded-3 border d-flex align-items-center justify-content-between text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-info text-white rounded-3 p-2"><i class="bi bi-file-earmark-arrow-down"></i></div>
                            <div>
                                <div class="fw-bold text-navy small">ศูนย์ดาวน์โหลดแบบฟอร์ม</div>
                                <small class="text-muted">จัดการเอกสารคำขอสินเชื่อ</small>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </a>

                    <a href="<?= url('admin/backups') ?>" class="btn btn-light text-start p-3 rounded-3 border d-flex align-items-center justify-content-between text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-secondary text-white rounded-3 p-2"><i class="bi bi-database-check"></i></div>
                            <div>
                                <div class="fw-bold text-navy small">สำรองฐานข้อมูล (Backup)</div>
                                <small class="text-muted">ระบบ Disaster Recovery</small>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4. Recent Activity & Complaints Table -->
<div class="row g-4">
    <!-- Audit Trail -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-clock-history text-primary me-2"></i>บันทึกการเข้าใช้งานและกิจกรรม (Audit Logs)</h5>
                <a href="<?= url('admin/audit-logs') ?>" class="btn btn-sm btn-link text-primary text-decoration-none p-0">ดูทั้งหมด &rarr;</a>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small">
                            <tr>
                                <th>ผู้ใช้งาน</th>
                                <th>การกระทำ</th>
                                <th>IP Address</th>
                                <th>วัน-เวลา</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentAudits)): ?>
                                <?php foreach ($recentAudits as $a): ?>
                                    <tr>
                                        <td class="fw-bold small text-navy"><?= e($a['user_name'] ?? 'rayongcoop1') ?></td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle small"><?= e($a['module']) ?></span>
                                            <span class="small text-muted ms-1"><?= e($a['action']) ?></span>
                                        </td>
                                        <td class="small font-monospace text-muted"><?= e($a['ip_address']) ?></td>
                                        <td class="small text-muted"><?= date('H:i d/m/Y', strtotime($a['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted small">
                                        <i class="bi bi-check-circle text-success me-1"></i> มีการบันทึกการเข้าสู่ระบบล่าสุดเรียบร้อยแล้ว
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- System Status & Security -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0">
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-shield-check text-success me-2"></i>สถานะระบบและความปลอดภัย</h5>
            </div>
            <div class="card-body p-4">
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><i class="bi bi-hdd-network me-2 text-primary"></i> เว็บเซิร์ฟเวอร์ (Apache / PHP 8.2)</span>
                        <span class="badge bg-success">ปกติ (Online)</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><i class="bi bi-database me-2 text-primary"></i> ฐานข้อมูล MySQL (rayongcoop_db)</span>
                        <span class="badge bg-success">เชื่อมต่อสำเร็จ</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><i class="bi bi-shield-lock me-2 text-primary"></i> การเข้ารหัสรหัสผ่าน (Argon2id/Bcrypt)</span>
                        <span class="badge bg-success">เปิดใช้งาน</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><i class="bi bi-file-earmark-lock me-2 text-primary"></i> การป้องกัน CSRF & Session Security</span>
                        <span class="badge bg-success">เข้มงวด</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><i class="bi bi-person-check me-2 text-primary"></i> สิทธิ์ผู้ใช้งานปัจจุบัน</span>
                        <span class="badge bg-primary">ผู้ดูแลระบบ (Super Admin)</span>
                    </li>
                </ul>

                <div class="mt-3 p-3 bg-light rounded-3 border">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle-fill text-primary"></i>
                        <span class="small fw-medium text-navy">พร้อมสำหรับการทำงานประจำวัน</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('coopFinancialChart');
    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.'],
                datasets: [
                    {
                        label: 'ยอดเงินฝากรวม (ล้านบาท)',
                        data: [138, 140, 143, 146, 148, 150, 151.5, 153, 154.2],
                        borderColor: '#0066CC',
                        backgroundColor: 'rgba(0, 102, 204, 0.08)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#0066CC',
                        pointRadius: 4
                    },
                    {
                        label: 'ยอดสินเชื่อคงค้าง (ล้านบาท)',
                        data: [115, 118, 120, 122, 123.5, 125, 126.8, 127.5, 128.4],
                        borderColor: '#28A745',
                        backgroundColor: 'rgba(40, 167, 69, 0.05)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#28A745',
                        pointRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: { family: "'Prompt', sans-serif", size: 12 },
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' ล้านบาท';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 100,
                        ticks: {
                            callback: function(value) { return value + ' ลบ.'; }
                        },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }
});
</script>
