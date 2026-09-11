<?php
$shares = $shares ?? [];
$requests = $requests ?? [];
?>
<!-- Shares Summary Cards -->
<div class="row g-3 g-xl-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100" style="background: linear-gradient(135deg, #073B74 0%, #0066CC 100%); color: #FFFFFF;">
            <span class="text-white-50 small fw-bold text-uppercase">มูลค่าหุ้นสะสมรวม</span>
            <h2 class="fw-bold text-white my-2 font-monospace"><?= number_format($shares['total_amount'] ?? 245000) ?> <span class="fs-6 fw-normal">บาท</span></h2>
            <div class="badge bg-white text-primary rounded-pill px-3 py-1 mt-1">
                จำนวน <?= number_format($shares['total_shares'] ?? 24500) ?> หุ้น (มูลค่าหุ้นละ 10 บาท)
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100 bg-white">
            <span class="text-muted small fw-bold text-uppercase">เงินส่งค่าหุ้นรายเดือน</span>
            <h2 class="fw-bold text-navy my-2 font-monospace"><?= number_format($shares['monthly_share'] ?? 1500) ?> <span class="fs-6 fw-normal text-muted">บาท/เดือน</span></h2>
            <div class="text-muted small">
                ชำระล่าสุด: <b><?= date('d/m/Y', strtotime($shares['last_payment_date'] ?? '2026-08-31')) ?></b>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100 bg-white d-flex flex-column justify-content-center">
            <span class="text-muted small fw-bold text-uppercase">ประมาณการเงินปันผลปี 2569</span>
            <h2 class="fw-bold text-success my-2 font-monospace">13,475 <span class="fs-6 fw-normal text-muted">บาท</span></h2>
            <div class="text-success small fw-medium">
                <i class="bi bi-percent"></i> อัตราปันผลเฉลี่ย 5.50% ต่อปี
            </div>
        </div>
    </div>
</div>

<!-- Request Change Monthly Share & History -->
<div class="row g-4">
    <!-- Change Share Rate Request Form -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0">
                <h5 class="fw-bold text-navy mb-1"><i class="bi bi-sliders text-primary me-2"></i>ขอเปลี่ยนแปลงอัตราส่งค่าหุ้น</h5>
                <p class="text-muted small mb-0">สมาชิกสามารถยื่นคำขอเพิ่มหรือลดเงินส่งค่าหุ้นรายเดือนได้</p>
            </div>
            <div class="card-body p-4">
                <form action="<?= url('member/shares/change') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">อัตราส่งค่าหุ้นปัจจุบัน</label>
                        <input type="text" class="form-control bg-light font-monospace fw-bold" value="<?= number_format($shares['monthly_share'] ?? 1500) ?> บาท/เดือน" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">ประเภทคำขอ <span class="text-danger">*</span></label>
                        <select name="change_type" class="form-select" required>
                            <option value="increase">ขอเพิ่มเงินส่งค่าหุ้นรายเดือน</option>
                            <option value="decrease">ขอลดเงินส่งค่าหุ้นรายเดือน</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">จำนวนเงินส่งค่าหุ้นใหม่ที่ต้องการ (บาท/เดือน) <span class="text-danger">*</span></label>
                        <input type="number" name="requested_monthly" class="form-control" placeholder="ขั้นต่ำ 500 บาท" step="100" min="500" max="50000" required>
                        <small class="text-muted" style="font-size: 11.5px;">เพิ่ม/ลดเป็นจำนวนเต็มร้อยบาท ขั้นต่ำ 500 บาท</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">เหตุผลความจำเป็น</label>
                        <textarea name="reason" class="form-control" rows="2" placeholder="ระบุเหตุผลประกอบ เช่น มีรายได้เพิ่มขึ้น"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-medium shadow-sm">
                        <i class="bi bi-send me-1"></i> ยื่นคำขอเปลี่ยนแปลงค่าหุ้น
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Request History List -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0">
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-clock-history text-primary me-2"></i>ประวัติคำขอเปลี่ยนแปลงค่าหุ้น</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small">
                            <tr>
                                <th>เลขที่คำขอ</th>
                                <th>เดิม &rarr; ขอเปลี่ยนเป็น</th>
                                <th>สถานะ</th>
                                <th>วันที่ยื่น</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($requests)): ?>
                                <?php foreach ($requests as $r): ?>
                                    <tr>
                                        <td class="font-monospace small fw-bold text-navy"><?= e($r['request_no']) ?></td>
                                        <td class="small">
                                            <?= number_format((float)$r['current_monthly']) ?> &rarr; <b class="text-primary"><?= number_format((float)$r['requested_monthly']) ?></b> บ.
                                        </td>
                                        <td>
                                            <?php if ($r['status'] === 'approved'): ?>
                                                <span class="badge bg-success-subtle text-success">อนุมัติแล้ว</span>
                                            <?php elseif ($r['status'] === 'rejected'): ?>
                                                <span class="badge bg-danger-subtle text-danger">ไม่อนุมัติ</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning-subtle text-warning">รอตรวจสอบ</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="small text-muted"><?= date('d/m/Y', strtotime($r['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted small">
                                        <i class="bi bi-info-circle me-1"></i> ยังไม่มีประวัติการยื่นขอเปลี่ยนแปลงค่าหุ้น
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
