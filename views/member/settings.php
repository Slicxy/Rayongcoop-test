<?php
$lineConn = $lineConn ?? null;
$loginHistory = $loginHistory ?? [];
?>
<div class="row g-4">
    <!-- Change Password & Security -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0">
                <h5 class="fw-bold text-navy mb-1"><i class="bi bi-shield-lock text-primary me-2"></i>เปลี่ยนรหัสผ่าน (Change Password)</h5>
                <p class="text-muted small mb-0">เพื่อความปลอดภัยควรเปลี่ยนรหัสผ่านเป็นประจำ</p>
            </div>
            <div class="card-body p-4">
                <form action="<?= url('member/settings/password') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">รหัสผ่านปัจจุบัน</label>
                        <input type="password" name="current_password" class="form-control" placeholder="••••••" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">รหัสผ่านใหม่ <span class="text-danger">*</span></label>
                        <input type="password" name="new_password" class="form-control" placeholder="อย่างน้อย 4 ตัวอักษร" required minlength="4">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">ยืนยันรหัสผ่านใหม่ <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="กรอกรหัสผ่านใหม่อีกครั้ง" required minlength="4">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-medium shadow-sm">
                        <i class="bi bi-key me-1"></i> ยืนยันการเปลี่ยนรหัสผ่าน
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- LINE Official Account Integration -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0">
                <h5 class="fw-bold text-navy mb-1"><i class="bi bi-line text-success me-2"></i>บริการแจ้งเตือนผ่าน LINE OA</h5>
                <p class="text-muted small mb-0">รับการแจ้งเตือนยอดหักรายเดือน ใบเสร็จรับเงิน และผลอนุมัติเงินกู้ผ่าน LINE</p>
            </div>
            <div class="card-body p-4">
                <?php $isConnected = !empty($lineConn) && ($lineConn['status'] === 'connected'); ?>
                <div class="p-3 rounded-3 mb-3 border <?= $isConnected ? 'bg-success-subtle border-success' : 'bg-light' ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-chat-dots-fill fs-3 text-success"></i>
                            <div>
                                <div class="fw-bold text-navy small">สถานะการเชื่อมต่อ LINE</div>
                                <small class="text-muted"><?= $isConnected ? 'เชื่อมต่อกับ ' . e($lineConn['display_name'] ?? 'LINE Member') : 'ยังไม่ได้เชื่อมต่อ' ?></small>
                            </div>
                        </div>
                        <span class="badge <?= $isConnected ? 'bg-success' : 'bg-secondary' ?>">
                            <?= $isConnected ? 'เชื่อมต่อแล้ว' : 'ไม่ได้เชื่อมต่อ' ?>
                        </span>
                    </div>
                </div>

                <form action="<?= url('member/settings/line') ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="<?= $isConnected ? 'disconnect' : 'connect' ?>">
                    <button type="submit" class="btn btn-<?= $isConnected ? 'outline-danger' : 'success' ?> w-100 py-2 fw-medium shadow-sm">
                        <i class="bi bi-line me-1"></i> <?= $isConnected ? 'ยกเลิกการเชื่อมต่อ LINE' : 'เชื่อมต่อบัญชี LINE OA' ?>
                    </button>
                </form>

                <div class="small text-muted mt-3">
                    <i class="bi bi-info-circle me-1"></i> รองรับการแจ้งเตือน: ยอดเรียกเก็บประจำเดือน, ใบเสร็จรับเงิน, ผลการอนุมัติเงินกู้ และข่าวสารฉุกเฉิน
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Login Activities History & Device Security -->
<div class="row g-4 mt-2">
    <!-- Login History & Active Sessions -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-navy mb-0"><i class="bi bi-shield-shaded text-primary me-2"></i>อุปกรณ์และความปลอดภัยเซสชัน (Device Security)</h5>
                    <p class="text-muted small mb-0">ประวัติการเข้าใช้งานและจัดการการล็อกอินบนอุปกรณ์ต่างๆ</p>
                </div>
                <form action="<?= url('member/settings/revoke-sessions') ?>" method="POST" onsubmit="return confirmRevokeSessions(event, this);">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                        <i class="bi bi-box-arrow-right me-1"></i> ออกจากระบบเครื่องอื่น
                    </button>
                </form>
            </div>
            <div class="card-body p-4">
                <!-- Current Device Badge -->
                <div class="p-3 bg-light rounded-4 border mb-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <i class="bi bi-laptop fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-navy small">อุปกรณ์นี้ (เซสชันปัจจุบัน)</div>
                            <small class="text-muted">กำลังใช้งาน &bull; IP: <?= e($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1') ?></small>
                        </div>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">Active Now</span>
                </div>

                <h6 class="fw-bold text-navy small mb-2"><i class="bi bi-clock-history me-1"></i>ประวัติการเข้าสู่ระบบล่าสุด</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small">
                            <tr>
                                <th>วัน-เวลา</th>
                                <th>อุปกรณ์ (Device)</th>
                                <th>เบราว์เซอร์</th>
                                <th>IP (Masked)</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($loginHistory)): ?>
                                <?php foreach ($loginHistory as $lh): ?>
                                    <tr>
                                        <td class="small font-monospace text-muted"><?= date('d/m/Y H:i', strtotime($lh['created_at'])) ?></td>
                                        <td class="small fw-medium text-navy"><?= e($lh['device']) ?></td>
                                        <td class="small text-muted"><?= e($lh['browser']) ?></td>
                                        <td class="small font-monospace text-muted"><?= e($lh['ip_address']) ?></td>
                                        <td><span class="badge bg-success-subtle text-success small">สำเร็จ</span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td class="small font-monospace text-muted"><?= date('d/m/Y H:i') ?></td>
                                    <td class="small fw-medium text-navy">Windows PC</td>
                                    <td class="small text-muted">Chrome</td>
                                    <td class="small font-monospace text-muted"><?= e($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1') ?></td>
                                    <td><span class="badge bg-success-subtle text-success small">เซสชันปัจจุบัน</span></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- PDPA & Privacy Consent -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0">
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-shield-check text-success me-2"></i>การตั้งค่าความเป็นส่วนตัว (PDPA)</h5>
            </div>
            <div class="card-body p-4">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="consentData" checked>
                    <label class="form-check-label small" for="consentData">
                        <b>ความยินยอมในการประมวลผลข้อมูลส่วนบุคคล</b>
                        <div class="text-muted" style="font-size: 11.5px;">เพื่อการให้บริการธุรกรรมสหกรณ์และสวัสดิการ</div>
                    </label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="consentMarketing" checked>
                    <label class="form-check-label small" for="consentMarketing">
                        <b>การรับข้อมูลข่าวสารและสิทธิประโยชน์</b>
                        <div class="text-muted" style="font-size: 11.5px;">รับข้อมูลผลิตภัณฑ์เงินฝาก สินเชื่อ และกิจกรรม</div>
                    </label>
                </div>
                <a href="<?= url('privacy/policy') ?>" target="_blank" class="btn btn-outline-primary btn-sm w-100 rounded-pill mt-2">
                    <i class="bi bi-file-earmark-text me-1"></i> อ่านนโยบายคุ้มครองข้อมูลส่วนบุคคล (PDPA Policy)
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmRevokeSessions(e, form) {
    e.preventDefault();
    Swal.fire({
        title: 'ยืนยันออกจากระบบเครื่องอื่น?',
        text: 'ระบบจะบังคับให้อุปกรณ์และเบราว์เซอร์อื่นทั้งหมดออกจากระบบทันที (ยกเว้นอุปกรณ์นี้)',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DC3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'ใช่, บังคับออกจากระบบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
    return false;
}
</script>

