<?php
$documents = $documents ?? [];
$categories = $categories ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-file-earmark-text me-2 text-primary"></i> จัดการศูนย์เอกสารและแบบฟอร์ม</h3>
        <p class="text-muted small mb-0">อัปโหลดและจัดการเอกสาร ระเบียบ ข้อบังคับ และแบบฟอร์มสำหรับสมาชิก</p>
    </div>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createDocModal">
        <i class="bi bi-upload me-1"></i> อัปโหลดเอกสารใหม่
    </button>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle coop-datatable mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>ชื่อเอกสาร</th>
                        <th>หมวดหมู่</th>
                        <th>เลขที่ / ประจำปี</th>
                        <th>ดาวน์โหลด</th>
                        <th>สถานะ</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documents as $i => $d): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <div class="fw-bold text-navy"><?= e($d['title']) ?></div>
                                <small class="text-muted"><i class="bi bi-paperclip"></i> <?= e($d['file_path']) ?></small>
                            </td>
                            <td><span class="badge bg-light text-navy border"><?= e($d['category_name']) ?></span></td>
                            <td class="small">
                                <div><?= e($d['document_number'] ?? '-') ?></div>
                                <small class="text-muted">ปี <?= e($d['year'] ?? '-') ?></small>
                            </td>
                            <td class="small font-monospace">
                                <i class="bi bi-download text-primary"></i> <?= number_format($d['download_count']) ?>
                            </td>
                            <td>
                                <span class="badge <?= $d['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= e(strtoupper($d['status'])) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="<?= url('documents/' . $d['id'] . '/download') ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteDoc(<?= $d['id'] ?>)">
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

<!-- Create Document Modal -->
<div class="modal fade" id="createDocModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy">อัปโหลดเอกสารใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/documents/store') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">ชื่อเอกสาร <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required placeholder="เช่น แบบฟอร์มคำขอกู้เงินสามัญ...">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">หมวดหมู่เอกสาร <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= e($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">เลขที่เอกสาร / ฉบับที่</label>
                            <input type="text" name="document_number" class="form-control" placeholder="เช่น ที่ 01/2569">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">ประจำปี พ.ศ.</label>
                            <input type="number" name="year" class="form-control" value="<?= date('Y') + 543 ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">คำค้นหา / แท็ก</label>
                            <input type="text" name="tag" class="form-control" placeholder="เงินกู้, สินเชื่อ, แบบฟอร์ม">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">สถานะ</label>
                            <select name="status" class="form-select">
                                <option value="active">Active (เปิดใช้งาน)</option>
                                <option value="inactive">Inactive (ปิด)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">เลือกไฟล์เอกสาร (PDF, Word, Excel สูงสุด 20MB)</label>
                        <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx">
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">อัปโหลดเอกสาร</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteDoc(id) {
    showDeleteConfirm(() => {
        fetch(window.APP_URL + '/admin/documents/' + id + '/delete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'ลบเอกสารเรียบร้อยแล้ว');
                setTimeout(() => location.reload(), 800);
            } else {
                showError('เกิดข้อผิดพลาด', data.message);
            }
        });
    });
}
</script>
