<?php
$logs = $logs ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-journal-check me-2 text-primary"></i> บันทึกประวัติการใช้งานระบบ (Audit Trail)</h3>
        <p class="text-muted small mb-0">ระบบบันทึกความเปลี่ยนแปลงทุกรายการแบบ Immutable ไม่สามารถลบหรือแก้ไขได้</p>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle coop-datatable mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>ผู้ใช้งาน</th>
                        <th>โมดูล</th>
                        <th>การกระทำ (Action)</th>
                        <th>Record ID</th>
                        <th>การเปลี่ยนแปลง (Old vs New)</th>
                        <th>IP Address</th>
                        <th>วันเวลา</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $i => $l): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <div class="fw-bold small text-navy"><?= e($l['user_name'] ?? 'System / Anonymous') ?></div>
                                <small class="text-muted"><?= e($l['user_email'] ?? '-') ?></small>
                            </td>
                            <td><span class="badge bg-light text-navy border"><?= e($l['module']) ?></span></td>
                            <td><span class="badge bg-primary"><?= e($l['action']) ?></span></td>
                            <td class="font-monospace small"><?= e($l['record_id'] ?? '-') ?></td>
                            <td class="small font-monospace" style="max-width: 250px;">
                                <?php if (!empty($l['new_values'])): ?>
                                    <span class="text-truncate d-inline-block" style="max-width: 240px;" title="<?= e($l['new_values']) ?>">
                                        <?= e($l['new_values']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="small font-monospace text-muted"><?= e($l['ip_address']) ?></td>
                            <td class="small text-muted"><?= thai_date($l['created_at'], true) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
