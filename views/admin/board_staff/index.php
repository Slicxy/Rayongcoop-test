<?php
$boards = $boards ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-people me-2 text-primary"></i> จัดการคณะกรรมการและเจ้าหน้าที่</h3>
        <p class="text-muted small mb-0">รายชื่อกรรมการดำเนินการ ผู้ตรวจสอบกิจการ ที่ปรึกษา และฝ่ายจัดการ</p>
    </div>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createBoardModal">
        <i class="bi bi-plus-lg me-1"></i> เพิ่มกรรมการ
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
                        <th>ตำแหน่ง</th>
                        <th>ประเภท</th>
                        <th>วาระการดำรงตำแหน่ง</th>
                        <th>สถานะ</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($boards as $i => $b): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-bold text-navy"><?= e($b['name']) ?></td>
                            <td><?= e($b['position']) ?></td>
                            <td><span class="badge bg-light text-navy border"><?= e($b['role_type']) ?></span></td>
                            <td class="small text-muted"><?= e($b['term_years'] ?? '-') ?></td>
                            <td>
                                <span class="badge <?= $b['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= e(strtoupper($b['status'])) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteBoard(<?= $b['id'] ?>)">
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

<!-- Create Board Modal -->
<div class="modal fade" id="createBoardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy">เพิ่มคณะกรรมการ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/board-staff/store-board') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="เช่น นายแพทย์สาธารณสุขจังหวัดระยอง">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">ตำแหน่งในสหกรณ์ <span class="text-danger">*</span></label>
                        <input type="text" name="position" class="form-control" required placeholder="เช่น ประธานกรรมการดำเนินการ">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">ประเภทบทบาท</label>
                            <select name="role_type" class="form-select">
                                <option value="director">กรรมการดำเนินการ (Director)</option>
                                <option value="auditor">ผู้ตรวจสอบกิจการ (Auditor)</option>
                                <option value="advisor">ที่ปรึกษา (Advisor)</option>
                                <option value="manager">ผู้จัดการ (Manager)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">วาระ พ.ศ.</label>
                            <input type="text" name="term_years" class="form-control" value="2568 - 2569">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteBoard(id) {
    showDeleteConfirm(() => {
        fetch(window.APP_URL + '/admin/board-staff/' + id + '/delete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'ลบรายการเรียบร้อยแล้ว');
                setTimeout(() => location.reload(), 800);
            }
        });
    });
}
</script>
