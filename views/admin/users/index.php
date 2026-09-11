<?php
$users = $users ?? [];
$roles = $roles ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-person-gear me-2 text-primary"></i> จัดการผู้ใช้งานและสิทธิ์ (User & RBAC)</h3>
        <p class="text-muted small mb-0">บัญชีผู้ใช้งานระบบและบทบาทหน้าที่ 11 Roles</p>
    </div>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
        <i class="bi bi-person-plus me-1"></i> เพิ่มผู้ใช้งานใหม่
    </button>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>ชื่อ - นามสกุล</th>
                        <th>ชื่อผู้ใช้ / อีเมล</th>
                        <th>บทบาท (Role)</th>
                        <th>สถานะ 2FA</th>
                        <th>เข้าสู่ระบบล่าสุด</th>
                        <th>สถานะ</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $i => $u): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-bold text-navy"><?= e($u['name']) ?></td>
                            <td class="small">
                                <div><?= e($u['username']) ?></div>
                                <small class="text-muted"><?= e($u['email']) ?></small>
                            </td>
                            <td><span class="badge bg-primary"><?= e($u['role_name'] ?? 'No Role') ?></span></td>
                            <td>
                                <?= $u['two_factor_enabled'] ? '<span class="badge bg-success"><i class="bi bi-shield-check me-1"></i> เปิด 2FA</span>' : '<span class="badge bg-light text-muted border">ปิด</span>' ?>
                            </td>
                            <td class="small text-muted">
                                <?= $u['last_login_at'] ? thai_date($u['last_login_at'], true) : 'ยังไม่เคยเข้าใช้' ?>
                            </td>
                            <td>
                                <span class="badge <?= $u['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= e(strtoupper($u['status'])) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteUser(<?= $u['id'] ?>)">
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

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy">เพิ่มผู้ใช้งานใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/users/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">ชื่อผู้ใช้ (Username) <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">อีเมล (Email) <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">รหัสผ่านเริ่มต้น <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" minlength="6" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">กำหนดบทบาท (Role) <span class="text-danger">*</span></label>
                        <select name="role_id" class="form-select" required>
                            <?php foreach ($roles as $r): ?>
                                <option value="<?= $r['id'] ?>"><?= e($r['name']) ?> (<?= e($r['slug']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">สร้างบัญชีผู้ใช้</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteUser(id) {
    showDeleteConfirm(() => {
        fetch(window.APP_URL + '/admin/users/' + id + '/delete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'ลบผู้ใช้งานเรียบร้อยแล้ว');
                setTimeout(() => location.reload(), 800);
            }
        });
    });
}
</script>
