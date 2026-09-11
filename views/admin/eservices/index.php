<?php
$eservices = $eservices ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-grid-3x3-gap me-2 text-primary"></i> จัดการ E-Service Gateway</h3>
        <p class="text-muted small mb-0">ระบบศูนย์รวมบริการออนไลน์และลิงก์เชื่อมต่อระบบเดิม/ระบบภายนอก</p>
    </div>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createEServiceModal">
        <i class="bi bi-plus-lg me-1"></i> เพิ่มบริการออนไลน์
    </button>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>ชื่อบริการ</th>
                        <th>URL ปลายทาง</th>
                        <th>หมวดหมู่</th>
                        <th>ถามยืนยันก่อนออก</th>
                        <th>สถานะ</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($eservices as $i => $es): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi <?= e($es['icon']) ?> fs-5 me-2 text-primary"></i>
                                    <div>
                                        <div class="fw-bold text-navy"><?= e($es['name']) ?></div>
                                        <small class="text-muted"><?= e($es['description'] ?? '') ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="<?= e($es['url']) ?>" target="_blank" class="small text-truncate d-inline-block font-monospace" style="max-width: 220px;">
                                    <?= e($es['url']) ?> <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            </td>
                            <td><span class="badge bg-light text-navy border"><?= e($es['category']) ?></span></td>
                            <td>
                                <?= $es['confirm_before_redirect'] ? '<span class="badge bg-info text-dark">เปิดแจ้งเตือน</span>' : '<span class="badge bg-light text-muted">ปิด</span>' ?>
                            </td>
                            <td>
                                <?php if ($es['is_maintenance']): ?>
                                    <span class="badge bg-danger">ปิดปรับปรุง</span>
                                <?php else: ?>
                                    <span class="badge bg-success">เปิดใช้งาน</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteEService(<?= $es['id'] ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create E-Service Modal -->
<div class="modal fade" id="createEServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy">เพิ่มลิงก์บริการออนไลน์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/eservices/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">ชื่อระบบบริการ <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="เช่น ระบบตรวจสอบข้อมูลสมาชิกและเงินปันผล...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">URL ปลายทาง <span class="text-danger">*</span></label>
                        <input type="url" name="url" class="form-control font-monospace" required placeholder="https://rayongcoop.com/member/">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">คำอธิบาย</label>
                        <input type="text" name="description" class="form-control" placeholder="ตรวจสอบหุ้น เงินฝาก เงินกู้...">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Bootstrap Icon Class</label>
                            <input type="text" name="icon" class="form-control" value="bi-person-badge">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">หมวดหมู่</label>
                            <select name="category" class="form-select">
                                <option value="member">บริการสมาชิก</option>
                                <option value="deposit">เงินฝาก</option>
                                <option value="loan">สินเชื่อ</option>
                                <option value="external">สมาคมภายนอก (สสธท./กสธท.)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="confirm_before_redirect" value="1" id="chkConfirmRedirect" checked>
                        <label class="form-check-label small" for="chkConfirmRedirect">แสดงหน้าต่าง SweetAlert แจ้งเตือนยืนยันก่อนออกจากเว็บไซต์</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="open_new_tab" value="1" id="chkOpenTab" checked>
                        <label class="form-check-label small" for="chkOpenTab">เปิดในแท็บใหม่ (Open in new tab)</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="is_maintenance" value="1" id="chkMaintenance">
                        <label class="form-check-label small" for="chkMaintenance">ระบุว่าอยู่ระหว่างปิดปรับปรุง (Maintenance)</label>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">บันทึกบริการ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteEService(id) {
    showDeleteConfirm(() => {
        fetch(window.APP_URL + '/admin/eservices/' + id + '/delete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'ลบลิงก์บริการเรียบร้อยแล้ว');
                setTimeout(() => location.reload(), 800);
            } else {
                showError('เกิดข้อผิดพลาด', data.message);
            }
        });
    });
}
</script>
