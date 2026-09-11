<?php
$consentsCount = $consentsCount ?? 0;
$analyticsConsentCount = $analyticsConsentCount ?? 0;
$marketingConsentCount = $marketingConsentCount ?? 0;
$categories = $categories ?? [];
$recentConsents = $recentConsents ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-shield-check me-2 text-primary"></i> จัดการความเป็นส่วนตัวและคุกกี้ (PDPA CMP)</h3>
        <p class="text-muted small mb-0">ระบบบริหารจัดการความยินยอมคุกกี้และตรวจสอบสถิติการยินยอมของผู้ใช้งาน</p>
    </div>
</div>

<!-- Consent Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="admin-card p-4 text-center">
            <small class="text-muted fw-bold">จำนวนการให้ความยินยอมทั้งหมด</small>
            <div class="fs-2 fw-bold text-navy mt-1"><?= number_format($consentsCount) ?></div>
            <small class="text-muted">บันทึก Anonymous Consent Log</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card p-4 text-center">
            <small class="text-muted fw-bold">ยินยอมคุกกี้วิเคราะห์ (Analytics)</small>
            <div class="fs-2 fw-bold text-success mt-1"><?= number_format($analyticsConsentCount) ?></div>
            <small class="text-success"><?= $consentsCount > 0 ? number_format(($analyticsConsentCount / $consentsCount) * 100, 1) : 0 ?>% ของผู้ใช้ทั้งหมด</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card p-4 text-center">
            <small class="text-muted fw-bold">ยินยอมคุกกี้การตลาด (Marketing)</small>
            <div class="fs-2 fw-bold text-primary mt-1"><?= number_format($marketingConsentCount) ?></div>
            <small class="text-primary"><?= $consentsCount > 0 ? number_format(($marketingConsentCount / $consentsCount) * 100, 1) : 0 ?>% ของผู้ใช้ทั้งหมด</small>
        </div>
    </div>
</div>

<!-- Cookie Categories Table -->
<div class="admin-card mb-4">
    <div class="admin-card-header">
        <h5 class="admin-card-title">ประเภทคุกกี้ในระบบ (Cookie Categories)</h5>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>รหัสประเภท</th>
                        <th>ชื่อภาษาไทย</th>
                        <th>ชื่อภาษาอังกฤษ</th>
                        <th>คำอธิบาย</th>
                        <th>จำเป็นต้องเปิด?</th>
                        <th>ค่าเริ่มต้น (Default)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td class="font-monospace fw-bold text-navy"><?= e($cat['code']) ?></td>
                            <td class="fw-semibold"><?= e($cat['name_th']) ?></td>
                            <td class="text-muted small"><?= e($cat['name_en']) ?></td>
                            <td class="small text-secondary" style="max-width: 300px;"><?= e($cat['description_th']) ?></td>
                            <td>
                                <?= $cat['is_required'] ? '<span class="badge bg-success">จำเป็น (บังคับ)</span>' : '<span class="badge bg-secondary">ผู้ใช้เลือกได้</span>' ?>
                            </td>
                            <td>
                                <?= $cat['default_state'] ? '<span class="badge bg-primary">เปิด (ON)</span>' : '<span class="badge bg-secondary">ปิด (OFF)</span>' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Consent Log Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="admin-card-title"><i class="bi bi-clock-history text-primary me-2"></i> บันทึกความยินยอมล่าสุด (Anonymous Consent Logs)</h5>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle mb-0 small font-monospace">
                <thead class="table-light">
                    <tr>
                        <th>Anonymous ID</th>
                        <th>Version</th>
                        <th>Necessary</th>
                        <th>Functional</th>
                        <th>Analytics</th>
                        <th>Marketing</th>
                        <th>Third-Party</th>
                        <th>วันที่ให้ความยินยอม</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentConsents as $rc): ?>
                        <tr>
                            <td><?= e(substr($rc['anonymous_consent_id'], 0, 18)) ?>...</td>
                            <td><?= e($rc['consent_version']) ?></td>
                            <td><span class="badge bg-success">YES</span></td>
                            <td><span class="badge <?= $rc['functional'] ? 'bg-success' : 'bg-secondary' ?>"><?= $rc['functional'] ? 'YES' : 'NO' ?></span></td>
                            <td><span class="badge <?= $rc['analytics'] ? 'bg-success' : 'bg-secondary' ?>"><?= $rc['analytics'] ? 'YES' : 'NO' ?></span></td>
                            <td><span class="badge <?= $rc['marketing'] ? 'bg-success' : 'bg-secondary' ?>"><?= $rc['marketing'] ? 'YES' : 'NO' ?></span></td>
                            <td><span class="badge <?= $rc['third_party'] ? 'bg-success' : 'bg-secondary' ?>"><?= $rc['third_party'] ? 'YES' : 'NO' ?></span></td>
                            <td><?= $rc['consented_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
