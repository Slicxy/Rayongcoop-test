<?php
$settings = $settings ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-gear me-2 text-primary"></i> ตั้งค่าระบบและองค์กร (Site Settings)</h3>
        <p class="text-muted small mb-0">ข้อมูลพื้นฐานของสหกรณ์ ข้อมูลการติดต่อ และการเปิด/ปิดโหมดปรับปรุงระบบ</p>
    </div>
</div>

<form action="<?= url('admin/settings/update') ?>" method="POST">
    <?= csrf_field() ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Organization Info -->
            <div class="admin-card p-4 mb-4">
                <h5 class="admin-card-title mb-3"><i class="bi bi-building me-2 text-primary"></i> ข้อมูลองค์กรและเว็บไซต์</h5>

                <div class="mb-3">
                    <label class="form-label fw-bold small">ชื่อสหกรณ์ (ภาษาไทย)</label>
                    <input type="text" name="site_title" class="form-control" value="<?= e($settings['site_title'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">ชื่อสหกรณ์ (ภาษาอังกฤษ)</label>
                    <input type="text" name="site_subtitle" class="form-control" value="<?= e($settings['site_subtitle'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">ที่อยู่สำนักงาน</label>
                    <textarea name="site_address" class="form-control" rows="2"><?= e($settings['site_address'] ?? '') ?></textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">หมายเลขโทรศัพท์</label>
                        <input type="text" name="site_phone" class="form-control" value="<?= e($settings['site_phone'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">หมายเลขโทรสาร (Fax)</label>
                        <input type="text" name="site_fax" class="form-control" value="<?= e($settings['site_fax'] ?? '') ?>">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">อีเมลทางการ</label>
                        <input type="email" name="site_email" class="form-control" value="<?= e($settings['site_email'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">เวลาทำการ</label>
                        <input type="text" name="office_hours" class="form-control" value="<?= e($settings['office_hours'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <!-- Maintenance Mode Card -->
            <div class="admin-card p-4">
                <h5 class="admin-card-title mb-3"><i class="bi bi-tools text-warning me-2"></i> โหมดปิดปรับปรุงระบบ (Maintenance Mode)</h5>
                
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1" id="chkMaintenanceMode" <?= ($settings['maintenance_mode'] ?? '0') === '1' ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold small" for="chkMaintenanceMode">เปิดใช้งาน Maintenance Mode (เฉพาะ IP ที่ได้รับอนุญาตเท่านั้นที่จะเข้าเว็บได้)</label>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">ข้อความแจ้งผู้ใช้งาน</label>
                    <input type="text" name="maintenance_message" class="form-control" value="<?= e($settings['maintenance_message'] ?? 'เว็บไซต์อยู่ระหว่างการปรับปรุงระบบชั่วคราว') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">IP Address ที่ได้รับอนุญาต (คั่นด้วยจุลภาค ,)</label>
                    <input type="text" name="allowed_maintenance_ips" class="form-control font-monospace" value="<?= e($settings['allowed_maintenance_ips'] ?? '127.0.0.1') ?>">
                </div>
            </div>
        </div>

        <!-- Submit Column -->
        <div class="col-lg-4">
            <div class="admin-card p-4">
                <h6 class="fw-bold text-navy mb-3">บันทึกการเปลี่ยนแปลง</h6>
                <p class="text-muted small mb-4">การปรับปรุงค่าจะมีผลต่อการแสดงผลบนหน้าเว็บไซต์ทันที</p>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                    <i class="bi bi-save me-1"></i> บันทึกการตั้งค่าทั้งหมด
                </button>
            </div>
        </div>
    </div>
</form>
