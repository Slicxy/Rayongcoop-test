<?php
$faqs = $faqs ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-question-circle me-2 text-primary"></i> จัดการคำถามที่พบบ่อย (FAQ)</h3>
        <p class="text-muted small mb-0">คำถามและคำตอบสำหรับสมาชิก</p>
    </div>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createFaqModal">
        <i class="bi bi-plus-lg me-1"></i> เพิ่มคำถามใหม่
    </button>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>คำถาม</th>
                        <th>คำตอบ</th>
                        <th>หมวดหมู่</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faqs as $i => $f): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-bold text-navy small" style="max-width: 260px;"><?= e($f['question']) ?></td>
                            <td class="small text-muted text-truncate" style="max-width: 320px;"><?= e($f['answer']) ?></td>
                            <td><span class="badge bg-light text-navy border"><?= e($f['category']) ?></span></td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteFaq(<?= $f['id'] ?>)">
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

<!-- Create FAQ Modal -->
<div class="modal fade" id="createFaqModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy">เพิ่มคำถามที่พบบ่อย</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/faqs/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">หมวดหมู่</label>
                        <select name="category" class="form-select">
                            <option value="general">ทั่วไป</option>
                            <option value="deposit">เงินฝาก</option>
                            <option value="loan">เงินกู้</option>
                            <option value="welfare">สวัสดิการ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">คำถาม <span class="text-danger">*</span></label>
                        <input type="text" name="question" class="form-control" required placeholder="เช่น การเปิดบัญชีเงินฝากต้องใช้อะไรบ้าง...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">คำตอบ <span class="text-danger">*</span></label>
                        <textarea name="answer" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">บันทึกคำถาม</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteFaq(id) {
    showDeleteConfirm(() => {
        fetch(window.APP_URL + '/admin/faqs/' + id + '/delete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'ลบคำถามเรียบร้อยแล้ว');
                setTimeout(() => location.reload(), 800);
            }
        });
    });
}
</script>
