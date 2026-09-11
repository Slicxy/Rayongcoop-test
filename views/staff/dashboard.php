<?php
$kpis = $kpis ?? [];
$recentLoans = $recentLoans ?? [];
$recentMembers = $recentMembers ?? [];
?>
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-briefcase-fill text-primary me-2"></i>Staff Dashboard — ภาพรวมระบบงานเจ้าหน้าที่
            </h1>
            <p class="text-muted small mb-0">ระบบติดตามและบริหารจัดการข้อมูลสมาชิก คำขอธุรกรรม และสถานะทางการเงินของสหกรณ์</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= url('staff/members') ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="bi bi-person-search me-1"></i>ค้นหาสมาชิก
            </a>
            <a href="<?= url('staff/reports') ?>" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="bi bi-file-earmark-spreadsheet me-1"></i>ออกรายงาน
            </a>
        </div>
    </div>

    <!-- KPI Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">สมาชิกทั้งหมด</span>
                    <div class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1 text-dark"><?= number_format($kpis['total_members'] ?? 0) ?> <span class="fs-6 fw-normal text-muted">ราย</span></h3>
                <div class="text-success small fw-medium">
                    <i class="bi bi-check-circle me-1"></i>Active: <?= number_format($kpis['active_members'] ?? 0) ?> ราย
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">คำขอกู้รออนุมัติ</span>
                    <div class="badge bg-warning-subtle text-warning rounded-pill px-2 py-1">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1 text-warning"><?= number_format($kpis['pending_loans'] ?? 0) ?> <span class="fs-6 fw-normal text-muted">รายการ</span></h3>
                <div class="small">
                    <a href="<?= url('staff/loans?status=submitted') ?>" class="text-primary text-decoration-none fw-medium">
                        ตรวจสอบทันที <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">คำขอสวัสดิการรอตรวจ</span>
                    <div class="badge bg-info-subtle text-info rounded-pill px-2 py-1">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1 text-info"><?= number_format($kpis['pending_welfares'] ?? 0) ?> <span class="fs-6 fw-normal text-muted">รายการ</span></h3>
                <div class="small">
                    <a href="<?= url('staff/welfare') ?>" class="text-primary text-decoration-none fw-medium">
                        ดูรายการคำขอ <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">คำขอออนไลน์ทั้งหมด</span>
                    <div class="badge bg-secondary-subtle text-secondary rounded-pill px-2 py-1">
                        <i class="bi bi-inbox-fill"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1 text-dark"><?= number_format($kpis['pending_requests'] ?? 0) ?> <span class="fs-6 fw-normal text-muted">รายการ</span></h3>
                <div class="text-muted small">
                    <i class="bi bi-hourglass-split me-1"></i>รอดำเนินการ
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Volume Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-white" style="background: linear-gradient(135deg, #073B74, #0F6292);">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-white-50 small">มูลค่าหุ้นสะสมรวม</span>
                    <i class="bi bi-pie-chart fs-4 text-white-50"></i>
                </div>
                <h3 class="fw-bold mb-0">฿<?= number_format($kpis['total_shares_val'] ?? 0, 2) ?></h3>
                <div class="text-white-50 small mt-2">
                    <i class="bi bi-shield-check me-1"></i>ทุนเรือนหุ้นทั้งหมดของสมาชิก
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-white" style="background: linear-gradient(135deg, #0E8388, #2E4F4F);">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-white-50 small">ยอดเงินรับฝากรวม</span>
                    <i class="bi bi-wallet2 fs-4 text-white-50"></i>
                </div>
                <h3 class="fw-bold mb-0">฿<?= number_format($kpis['total_deposits_val'] ?? 0, 2) ?></h3>
                <div class="text-white-50 small mt-2">
                    <i class="bi bi-piggy-bank me-1"></i>รวมทุกประเภทบัญชีเงินฝาก
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-white" style="background: linear-gradient(135deg, #C07F00, #4C3D3D);">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-white-50 small">ยอดสินเชื่อคงค้างรวม</span>
                    <i class="bi bi-cash-coin fs-4 text-white-50"></i>
                </div>
                <h3 class="fw-bold mb-0">฿<?= number_format($kpis['total_loans_val'] ?? 0, 2) ?></h3>
                <div class="text-white-50 small mt-2">
                    <i class="bi bi-graph-up-arrow me-1"></i>ลูกหนี้เงินกู้ตามสัญญา
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Quick Queues -->
    <div class="row g-4 mb-4">
        <!-- Main Loan Queue -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="bi bi-clipboard2-check text-primary me-2"></i>คำขอกู้เงินรอดำเนินการล่าสุด
                        </h5>
                        <p class="text-muted small mb-0">รายการที่สมาชิกยื่นกู้ผ่าน Online Wizard</p>
                    </div>
                    <a href="<?= url('staff/loans') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        ดูทั้งหมด <i class="bi bi-chevron-right"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>เลขที่คำขอ</th>
                                <th>ชื่อสมาชิก</th>
                                <th>ประเภท</th>
                                <th>วงเงินกู้</th>
                                <th>สถานะ</th>
                                <th class="text-end">การดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentLoans)): ?>
                                <?php foreach ($recentLoans as $app): ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-dark"><?= e($app['application_no']) ?></span>
                                            <div class="text-muted" style="font-size: 0.75rem;"><?= date('d/m/Y H:i', strtotime($app['created_at'])) ?></div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark"><?= e($app['member_name']) ?></div>
                                            <div class="text-muted small"><?= e($app['member_no']) ?></div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border"><?= e($app['loan_type']) ?></span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-primary">฿<?= number_format((float)$app['requested_amount'], 2) ?></span>
                                            <div class="text-muted small"><?= (int)$app['term_months'] ?> งวด</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                                <?= e($app['status']) ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="<?= url('staff/loans') ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                                <i class="bi bi-eye me-1"></i>ตรวจคำขอ
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-check2-all fs-2 text-success d-block mb-2"></i>
                                        ไม่มีคำขอกู้เงินค้างตรวจในขณะนี้
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Member Search & Activity -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="bi bi-search text-primary me-2"></i>ค้นหาสมาชิกด่วน
                </h5>
                <form action="<?= url('staff/members') ?>" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control rounded-start-pill" placeholder="พิมพ์ชื่อ, สกุล, หรือเลขสมาชิก...">
                        <button class="btn btn-primary rounded-end-pill px-3" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <h6 class="fw-bold text-muted small text-uppercase mb-3">สมาชิกล่าสุด</h6>
                <div class="list-group list-group-flush">
                    <?php if (!empty($recentMembers)): ?>
                        <?php foreach ($recentMembers as $m): ?>
                            <a href="<?= url('staff/members/detail?id=' . $m['id']) ?>" class="list-group-item list-group-item-action border-0 px-0 py-2 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                                        <?= mb_substr($m['first_name'], 0, 1, 'UTF-8') ?>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark small"><?= e($m['prefix'] . $m['first_name'] . ' ' . $m['last_name']) ?></div>
                                        <div class="text-muted" style="font-size: 0.72rem;"><?= e($m['member_no']) ?> • <?= e($m['department'] ?? 'ทั่วไป') ?></div>
                                    </div>
                                </div>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-muted small text-center py-3">ไม่มีข้อมูล</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
