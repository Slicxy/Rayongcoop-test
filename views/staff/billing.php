<?php
$receipts = $receipts ?? [];
$selectedYear = $selectedYear ?? (int)date('Y');
$selectedMonth = $selectedMonth ?? null;
?>
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="<?= url('staff/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">ระบบประมวลผลใบเสร็จรับเงินรายเดือน</li>
                </ol>
            </nav>
            <h1 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-receipt-cutoff text-primary me-2"></i>ระบบประมวลผลใบเสร็จรับเงินรายเดือน (Billing Engine)
            </h1>
            <p class="text-muted small mb-0">ออกใบเสร็จรับเงินค่าหุ้น เงินกู้ และเงินฝากรายเดือนอัตโนมัติสำหรับสมาชิกสหกรณ์ทุกคน</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#batchBillingModal">
                <i class="bi bi-gear-wide-connected me-1"></i> สั่งประมวลผลออกใบเสร็จประจำงวด (Batch Run)
            </button>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">ใบเสร็จทั้งหมดในระบบ</span>
                    <span class="badge bg-primary-subtle text-primary rounded-pill"><i class="bi bi-receipt"></i></span>
                </div>
                <h3 class="fw-bold text-navy mb-0"><?= number_format($totalCount ?? count($receipts)) ?> <span class="fs-6 text-muted fw-normal">ฉบับ</span></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">ยอดรับชำระค่าหุ้นรวม</span>
                    <span class="badge bg-success-subtle text-success rounded-pill"><i class="bi bi-piggy-bank"></i></span>
                </div>
                <h3 class="fw-bold text-success mb-0">฿<?= number_format($totalShareSum ?? 0, 2) ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">ยอดรับชำระเงินกู้รวม</span>
                    <span class="badge bg-warning-subtle text-warning rounded-pill"><i class="bi bi-cash-coin"></i></span>
                </div>
                <h3 class="fw-bold text-warning mb-0">฿<?= number_format($totalLoanSum ?? 0, 2) ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">ยอดรวมทั้งสิ้น</span>
                    <span class="badge bg-info-subtle text-info rounded-pill"><i class="bi bi-wallet2"></i></span>
                </div>
                <h3 class="fw-bold text-primary mb-0">฿<?= number_format($totalGrandSum ?? 0, 2) ?></h3>
            </div>
        </div>
    </div>

    <!-- Filter & Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-header bg-white border-0 p-4 pb-0">
            <form method="GET" action="<?= url('staff/billing') ?>" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">ประจำปี (พ.ศ.)</label>
                    <select name="year" class="form-select rounded-3">
                        <option value="">-- ทุกปี --</option>
                        <?php 
                            $currYear = (int)date('Y');
                            for ($y = $currYear; $y >= $currYear - 3; $y--): 
                        ?>
                            <option value="<?= $y ?>" <?= ($selectedYear == $y) ? 'selected' : '' ?>><?= $y + 543 ?> (<?= $y ?>)</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">ประจำเดือน</label>
                    <select name="month" class="form-select rounded-3">
                        <option value="">-- ทุกเดือน --</option>
                        <?php 
                            $thaiMonths = [1=>'มกราคม', 2=>'กุมภาพันธ์', 3=>'มีนาคม', 4=>'เมษายน', 5=>'พฤษภาคม', 6=>'มิถุนายน', 7=>'กรกฎาคม', 8=>'สิงหาคม', 9=>'กันยายน', 10=>'ตุลาคม', 11=>'พฤศจิกายน', 12=>'ธันวาคม'];
                            foreach ($thaiMonths as $mNum => $mName):
                        ?>
                            <option value="<?= $mNum ?>" <?= ($selectedMonth == $mNum) ? 'selected' : '' ?>><?= $mNum ?> - <?= $mName ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">ค้นหาเลขที่สมาชิก / ชื่อสมาชิก / เลขที่ใบเสร็จ</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="เช่น MEM-2024-0001 หรือ RCP-256709" value="<?= e($search ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill w-100">
                        <i class="bi bi-funnel me-1"></i> กรองข้อมูล
                    </button>
                    <a href="<?= url('staff/billing') ?>" class="btn btn-outline-secondary rounded-pill" title="ล้างตัวกรอง">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </form>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>งวดประจำเดือน</th>
                            <th>เลขที่ใบเสร็จ</th>
                            <th>สมาชิก</th>
                            <th class="text-end">ค่าหุ้น (บ.)</th>
                            <th class="text-end">เงินต้นเงินกู้ (บ.)</th>
                            <th class="text-end">ดอกเบี้ย (บ.)</th>
                            <th class="text-end">รวมทั้งสิ้น (บาท)</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($receipts)): ?>
                            <?php foreach ($receipts as $idx => $r): ?>
                                <tr>
                                    <td class="text-muted small"><?= $idx + 1 ?></td>
                                    <td class="fw-bold small text-navy">
                                        <i class="bi bi-calendar3 me-1 text-primary"></i> <?= $r['billing_month'] ?>/<?= (int)$r['billing_year'] + 543 ?>
                                    </td>
                                    <td>
                                        <a href="<?= url('member/receipts/print/' . $r['receipt_no']) ?>" target="_blank" class="font-monospace fw-bold text-primary text-decoration-none">
                                            <?= e($r['receipt_no']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark small"><?= e(($r['prefix'] ?? '') . $r['first_name'] . ' ' . $r['last_name']) ?></div>
                                        <small class="text-muted font-monospace"><?= e($r['member_no']) ?></small>
                                    </td>
                                    <td class="text-end font-monospace small"><?= number_format((float)$r['share_amount'], 2) ?></td>
                                    <td class="text-end font-monospace small"><?= number_format((float)$r['loan_principal'], 2) ?></td>
                                    <td class="text-end font-monospace small"><?= number_format((float)$r['loan_interest'], 2) ?></td>
                                    <td class="text-end font-monospace fw-bold text-success fs-6">
                                        ฿<?= number_format((float)$r['total_amount'], 2) ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="<?= url('member/receipts/print/' . $r['receipt_no']) ?>" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-2" title="เปิดดูเอกสารทางการ">
                                                <i class="bi bi-eye me-1"></i> ดูใบเสร็จ
                                            </a>
                                            <a href="<?= url('member/receipts/print/' . $r['receipt_no'] . '?download=pdf') ?>" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-2" title="ดาวน์โหลดไฟล์ PDF ทันที">
                                                <i class="bi bi-file-earmark-pdf-fill me-1"></i> PDF
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                                    <div>ไม่พบรายการใบเสร็จรับเงินตามเงื่อนไขที่เลือก</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Batch Billing Modal -->
<div class="modal fade" id="batchBillingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy">
                    <i class="bi bi-gear-wide-connected text-primary me-2"></i>สั่งประมวลผลออกใบเสร็จรายเดือน (Batch Run)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('staff/billing/generate') ?>" method="POST" id="batchRunForm">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-4">
                        ระบบจะทำการคำนวณยอดค่าหุ้น, สัญญาเงินกู้คงค้าง และเงินฝากอัตโนมัติ เพื่อสร้างใบเสร็จรับเงินสำหรับสมาชิกทุกคนที่มีสถานะ Active ในระบบ
                    </p>

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted">ประจำปี (พ.ศ.)</label>
                            <select name="billing_year" class="form-select" required>
                                <?php for ($y = (int)date('Y'); $y >= (int)date('Y') - 1; $y--): ?>
                                    <option value="<?= $y ?>"><?= $y + 543 ?> (<?= $y ?>)</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted">ประจำเดือน</label>
                            <select name="billing_month" class="form-select" required>
                                <?php 
                                    $curM = (int)date('n');
                                    foreach ($thaiMonths as $mNum => $mName): 
                                ?>
                                    <option value="<?= $mNum ?>" <?= ($curM == $mNum) ? 'selected' : '' ?>><?= $mNum ?> - <?= $mName ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 rounded-3 mt-4 mb-0 small">
                        <i class="bi bi-info-circle-fill me-1"></i> สมาชิกที่มีใบเสร็จในงวดดังกล่าวแล้ว ระบบจะข้ามอัตโนมัติเพื่อป้องกันการออกเอกสารซ้ำซ้อน
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3 px-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold" id="btnSubmitBatch">
                        <i class="bi bi-play-circle-fill me-1"></i> เริ่มประมวลผลทันที
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
