<?php
$data = $data ?? [];
$m = $data['member'] ?? [];
$shares = $data['shares'] ?? [];
$deposits = $data['deposits'] ?? [];
$loans = $data['loans'] ?? [];
$welfares = $data['welfares'] ?? [];
$beneficiaries = $data['beneficiaries'] ?? [];
$requests = $data['requests'] ?? [];
?>
<div class="container-fluid py-4">
    <!-- Breadcrumb & Top bar -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="<?= url('staff/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= url('staff/members') ?>">สมาชิก</a></li>
                    <li class="breadcrumb-item active"><?= e($m['member_no'] ?? '') ?></li>
                </ol>
            </nav>
            <h1 class="h3 fw-bold text-dark mb-0">
                <?= e(($m['prefix'] ?? '') . ($m['first_name'] ?? '') . ' ' . ($m['last_name'] ?? '')) ?>
                <span class="badge bg-success-subtle text-success fs-6 fw-normal ms-2 rounded-pill">สถานะ: <?= e($m['status'] ?? 'active') ?></span>
            </h1>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= url('staff/members') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i>ย้อนกลับ
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="bi bi-printer me-1"></i>พิมพ์ประวัติ 360°
            </button>
        </div>
    </div>

    <!-- Member Overview Header Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <div class="row g-4 align-items-center">
            <div class="col-auto">
                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-2" style="width: 70px; height: 70px;">
                    <?= mb_substr($m['first_name'], 0, 1, 'UTF-8') ?>
                </div>
            </div>
            <div class="col">
                <h4 class="fw-bold text-dark mb-1"><?= e($m['prefix'] . $m['first_name'] . ' ' . $m['last_name']) ?></h4>
                <div class="text-muted small mb-2">
                    <span class="me-3"><i class="bi bi-person-badge text-primary me-1"></i>เลขที่สมาชิก: <strong><?= e($m['member_no']) ?></strong></span>
                    <span class="me-3"><i class="bi bi-building text-primary me-1"></i>สังกัด: <?= e($m['department'] ?? '-') ?></span>
                    <span><i class="bi bi-briefcase text-primary me-1"></i>ตำแหน่ง: <?= e($m['position'] ?? '-') ?></span>
                </div>
                <div class="text-muted small">
                    <span class="me-3"><i class="bi bi-telephone text-primary me-1"></i><?= e($m['phone'] ?? '-') ?></span>
                    <span class="me-3"><i class="bi bi-envelope text-primary me-1"></i><?= e($m['email'] ?? '-') ?></span>
                    <span><i class="bi bi-calendar-check text-primary me-1"></i>เป็นสมาชิกเมื่อ: <?= date('d/m/Y', strtotime($m['join_date'] ?? 'now')) ?></span>
                </div>
            </div>
            <div class="col-lg-4 border-start-lg">
                <div class="row g-2 text-center">
                    <div class="col-4">
                        <div class="p-2 bg-light rounded-3">
                            <div class="text-muted small" style="font-size: 0.72rem;">ทุนเรือนหุ้น</div>
                            <div class="fw-bold text-primary small">฿<?= number_format((float)($shares['total_amount'] ?? 0)) ?></div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 bg-light rounded-3">
                            <div class="text-muted small" style="font-size: 0.72rem;">เงินฝากรวม</div>
                            <div class="fw-bold text-success small">฿<?= number_format(array_sum(array_column($deposits, 'balance'))) ?></div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 bg-light rounded-3">
                            <div class="text-muted small" style="font-size: 0.72rem;">หนี้คงเหลือ</div>
                            <div class="fw-bold text-danger small">฿<?= number_format(array_sum(array_column($loans, 'principal_balance'))) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 360 Tabs Navigation -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
        <div class="card-header bg-white border-bottom p-0">
            <ul class="nav nav-tabs border-0 px-3 pt-2" id="memberTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold" id="shares-tab" data-bs-toggle="tab" data-bs-target="#tab-shares" type="button" role="tab">
                        <i class="bi bi-pie-chart me-1"></i>ทุนเรือนหุ้น
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="deposits-tab" data-bs-toggle="tab" data-bs-target="#tab-deposits" type="button" role="tab">
                        <i class="bi bi-wallet2 me-1"></i>บัญชีเงินฝาก (<?= count($deposits) ?>)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="loans-tab" data-bs-toggle="tab" data-bs-target="#tab-loans" type="button" role="tab">
                        <i class="bi bi-cash-stack me-1"></i>สินเชื่อและเงินกู้ (<?= count($loans) ?>)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="welfare-tab" data-bs-toggle="tab" data-bs-target="#tab-welfare" type="button" role="tab">
                        <i class="bi bi-heart-pulse me-1"></i>สวัสดิการ (<?= count($welfares) ?>)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="beneficiary-tab" data-bs-toggle="tab" data-bs-target="#tab-beneficiary" type="button" role="tab">
                        <i class="bi bi-people me-1"></i>ผู้รับผลประโยชน์ (<?= count($beneficiaries) ?>)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="requests-tab" data-bs-toggle="tab" data-bs-target="#tab-requests" type="button" role="tab">
                        <i class="bi bi-inbox me-1"></i>ประวัติคำขอ (<?= count($requests) ?>)
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="memberTabContent">
                <!-- Tab 1: Shares -->
                <div class="tab-pane fade show active" id="tab-shares" role="tabpanel">
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3">
                                <div class="text-muted small">จำนวนหุ้นทั้งหมด</div>
                                <h4 class="fw-bold text-primary mb-0"><?= number_format((int)($shares['total_shares'] ?? 0)) ?> หุ้น</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3">
                                <div class="text-muted small">มูลค่ารวม (หุ้นละ 10 บาท)</div>
                                <h4 class="fw-bold text-success mb-0">฿<?= number_format((float)($shares['total_amount'] ?? 0), 2) ?></h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3">
                                <div class="text-muted small">ส่งค่าหุ้นรายเดือน</div>
                                <h4 class="fw-bold text-dark mb-0">฿<?= number_format((float)($shares['monthly_share'] ?? 0), 2) ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Deposits -->
                <div class="tab-pane fade" id="tab-deposits" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>เลขที่บัญชี</th>
                                    <th>ประเภทบัญชี</th>
                                    <th>อัตราดอกเบี้ย</th>
                                    <th>ยอดเงินคงเหลือ</th>
                                    <th>ดอกเบี้ยสะสม</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($deposits)): ?>
                                    <?php foreach ($deposits as $acc): ?>
                                        <tr>
                                            <td class="fw-bold font-monospace"><?= e($acc['account_no']) ?></td>
                                            <td><?= e($acc['account_type']) ?></td>
                                            <td><?= number_format((float)$acc['interest_rate'], 2) ?>% ต่อปี</td>
                                            <td class="fw-bold text-success">฿<?= number_format((float)$acc['balance'], 2) ?></td>
                                            <td>฿<?= number_format((float)$acc['accumulated_interest'], 2) ?></td>
                                            <td><span class="badge bg-success-subtle text-success"><?= e($acc['status']) ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="6" class="text-center py-3 text-muted">ไม่มีบัญชีเงินฝาก</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab 3: Loans -->
                <div class="tab-pane fade" id="tab-loans" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>เลขที่สัญญา</th>
                                    <th>ประเภทเงินกู้</th>
                                    <th>วงเงินตามสัญญา</th>
                                    <th>เงินต้นคงเหลือ</th>
                                    <th>ค่างวด/เดือน</th>
                                    <th>งวดชำระ</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($loans)): ?>
                                    <?php foreach ($loans as $ln): ?>
                                        <tr>
                                            <td class="fw-bold font-monospace"><?= e($ln['contract_no']) ?></td>
                                            <td><?= e($ln['loan_type']) ?></td>
                                            <td>฿<?= number_format((float)$ln['loan_amount'], 2) ?></td>
                                            <td class="fw-bold text-danger">฿<?= number_format((float)$ln['principal_balance'], 2) ?></td>
                                            <td>฿<?= number_format((float)$ln['monthly_payment'], 2) ?></td>
                                            <td><?= (int)$ln['paid_terms'] ?> / <?= (int)$ln['total_terms'] ?> งวด</td>
                                            <td><span class="badge bg-primary-subtle text-primary"><?= e($ln['status']) ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="7" class="text-center py-3 text-muted">ไม่มีสัญญาเงินกู้</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab 4: Welfare -->
                <div class="tab-pane fade" id="tab-welfare" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>เลขที่คำขอ</th>
                                    <th>สวัสดิการ</th>
                                    <th>ยอดขอรับ</th>
                                    <th>วันที่ยื่น</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($welfares)): ?>
                                    <?php foreach ($welfares as $w): ?>
                                        <tr>
                                            <td class="fw-bold font-monospace"><?= e($w['application_no']) ?></td>
                                            <td><?= e($w['welfare_name']) ?></td>
                                            <td class="fw-bold text-primary">฿<?= number_format((float)$w['claim_amount'], 2) ?></td>
                                            <td><?= date('d/m/Y', strtotime($w['created_at'])) ?></td>
                                            <td>
                                                <span class="badge bg-<?= $w['status'] === 'approved' ? 'success' : 'warning' ?>-subtle text-<?= $w['status'] === 'approved' ? 'success' : 'dark' ?>">
                                                    <?= e($w['status']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="text-center py-3 text-muted">ไม่มีประวัติคำขอสวัสดิการ</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab 5: Beneficiaries -->
                <div class="tab-pane fade" id="tab-beneficiary" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ชื่อ - นามสกุล</th>
                                    <th>ความสัมพันธ์</th>
                                    <th>เลขประจำตัว ปชช.</th>
                                    <th>เบอร์โทรศัพท์</th>
                                    <th>สัดส่วน %</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($beneficiaries)): ?>
                                    <?php foreach ($beneficiaries as $b): ?>
                                        <tr>
                                            <td class="fw-bold"><?= e($b['first_name'] . ' ' . $b['last_name']) ?></td>
                                            <td><?= e($b['relationship']) ?></td>
                                            <td class="font-monospace text-muted"><?= e($b['masked_id_card']) ?></td>
                                            <td><?= e($b['phone'] ?? '-') ?></td>
                                            <td><span class="badge bg-primary rounded-pill px-3"><?= (int)$b['percentage'] ?>%</span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="text-center py-3 text-muted">ไม่มีข้อมูลผู้รับผลประโยชน์</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab 6: Requests -->
                <div class="tab-pane fade" id="tab-requests" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>เลขที่คำขอ</th>
                                    <th>ประเภท</th>
                                    <th>หัวข้อ</th>
                                    <th>วันที่ยื่น</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($requests)): ?>
                                    <?php foreach ($requests as $r): ?>
                                        <tr>
                                            <td class="fw-bold font-monospace"><?= e($r['request_no']) ?></td>
                                            <td><span class="badge bg-light text-dark border"><?= e($r['request_type']) ?></span></td>
                                            <td><?= e($r['title']) ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
                                            <td><span class="badge bg-info-subtle text-info"><?= e($r['status']) ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="text-center py-3 text-muted">ไม่มีคำขอออนไลน์</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
