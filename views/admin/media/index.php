<?php
$mediaList = $mediaList ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-folder2-open me-2 text-primary"></i> คลังสื่อและรูปภาพ (Media Library)</h3>
        <p class="text-muted small mb-0">ระบบจัดเก็บรูปภาพ แบนเนอร์ และสื่อมีเดีย พร้อมการตรวจสอบความปลอดภัยของไฟล์</p>
    </div>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadMediaModal">
        <i class="bi bi-upload me-1"></i> อัปโหลดไฟล์สื่อ
    </button>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle coop-datatable mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>พรีวิว</th>
                        <th>ชื่อไฟล์</th>
                        <th>โฟลเดอร์</th>
                        <th>ขนาด / MIME</th>
                        <th>ผู้อัปโหลด</th>
                        <th>วันที่</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mediaList as $i => $m): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <div class="rounded border bg-light d-flex align-items-center justify-content-center overflow-hidden" style="width: 48px; height: 48px;">
                                    <?php if (str_starts_with($m['mime_type'], 'image/')): ?>
                                        <img src="<?= storage_url($m['path']) ?>" class="w-100 h-100 object-fit-cover" alt="Preview">
                                    <?php else: ?>
                                        <i class="bi bi-file-earmark-text fs-4 text-primary"></i>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold small text-navy"><?= e($m['original_name']) ?></div>
                                <small class="text-muted font-monospace"><?= e($m['filename']) ?></small>
                            </td>
                            <td><span class="badge bg-light text-navy border"><?= e($m['folder']) ?></span></td>
                            <td class="small font-monospace">
                                <div><?= number_format($m['file_size'] / 1024, 1) ?> KB</div>
                                <small class="text-muted"><?= e($m['mime_type']) ?></small>
                            </td>
                            <td class="small"><?= e($m['uploader_name'] ?? 'Admin') ?></td>
                            <td class="small text-muted"><?= date('d/m/Y H:i', strtotime($m['created_at'])) ?></td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="navigator.clipboard.writeText('<?= storage_url($m['path']) ?>'); showToast('info', 'คัดลอก URL แล้ว');" title="คัดลอก URL">
                                    <i class="bi bi-link-45deg"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteMedia(<?= $m['id'] ?>)">
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

<!-- Upload Media Modal -->
<div class="modal fade" id="uploadMediaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy">อัปโหลดไฟล์สื่อใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/media/upload') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">เลือกไฟล์รูปภาพ / สื่อ (JPG, PNG, WebP, PDF สูงสุด 20MB) <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" required accept="image/*,.pdf">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">โฟลเดอร์จัดเก็บ</label>
                        <select name="folder" class="form-select">
                            <option value="general">ทั่วไป (General)</option>
                            <option value="hero">Hero Slides</option>
                            <option value="news">News Articles</option>
                            <option value="popups">Popups</option>
                            <option value="board">Board / Staff</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Alt Text (คำอธิบายภาพเพื่อ SEO และ Accessibility)</label>
                        <input type="text" name="alt_text" class="form-control" placeholder="คำอธิบายภาพสั้นๆ">
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">อัปโหลด</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteMedia(id) {
    showDeleteConfirm(() => {
        fetch(window.APP_URL + '/admin/media/' + id + '/delete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'ลบไฟล์เรียบร้อยแล้ว');
                setTimeout(() => location.reload(), 800);
            }
        });
    });
}
</script>
