<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-navy mb-1"><i class="bi bi-megaphone-fill text-warning me-2"></i> จัดการประกาศสำคัญ (Important Announcements)</h4>
        <p class="text-muted small mb-0">ประกาศ มติคณะกรรมการ และข้อมูลสำคัญที่มีผลบังคับใช้สำหรับสมาชิก</p>
    </div>
    <a href="<?= url('admin/announcements/create') ?>" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus-lg me-1"></i> สร้างประกาศใหม่
    </a>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form action="<?= url('admin/announcements') ?>" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <select name="priority" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- ทุกระดับความสำคัญ --</option>
                    <option value="urgent" <?= ($priority === 'urgent') ? 'selected' : '' ?>>ด่วนที่สุด (Urgent)</option>
                    <option value="important" <?= ($priority === 'important') ? 'selected' : '' ?>>สำคัญ (Important)</option>
                    <option value="general" <?= ($priority === 'general') ? 'selected' : '' ?>>ทั่วไป (General)</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- ทุกสถานะ --</option>
                    <option value="published" <?= ($status === 'published') ? 'selected' : '' ?>>เผยแพร่แล้ว (Published)</option>
                    <option value="draft" <?= ($status === 'draft') ? 'selected' : '' ?>>แบบร่าง (Draft)</option>
                    <option value="archived" <?= ($status === 'archived') ? 'selected' : '' ?>>จัดเก็บ (Archived)</option>
                </select>
            </div>
            <div class="col-md-4 text-md-end">
                <?php if (!empty($priority) || !empty($status)): ?>
                    <a href="<?= url('admin/announcements') ?>" class="btn btn-sm btn-outline-secondary rounded-pill">
                        <i class="bi bi-x-circle me-1"></i> ล้างตัวกรอง
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" style="width: 50px;">#</th>
                        <th>หัวข้อประกาศ</th>
                        <th>ระดับความสำคัญ</th>
                        <th>วันที่ประกาศ / วันหมดอายุ</th>
                        <th>เอกสารแนบ</th>
                        <th>สถานะ</th>
                        <th class="text-end pe-4" style="width: 150px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($announcements)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                ไม่พบรายการประกาศสำคัญ
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($announcements as $i => $item): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $i + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if ($item['is_pinned']): ?>
                                            <span class="badge bg-primary"><i class="bi bi-pin-angle-fill"></i></span>
                                        <?php endif; ?>
                                        <div class="fw-bold text-navy"><?= e($item['title']) ?></div>
                                    </div>
                                    <?php if (!empty($item['resolution_no'])): ?>
                                        <small class="text-muted"><i class="bi bi-file-earmark-check me-1"></i> <?= e($item['resolution_no']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item['priority'] === 'urgent'): ?>
                                        <span class="badge bg-danger">ด่วนที่สุด</span>
                                    <?php elseif ($item['priority'] === 'important'): ?>
                                        <span class="badge bg-warning text-dark">สำคัญ</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">ทั่วไป</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="small fw-semibold"><?= thai_date($item['publication_date']) ?></div>
                                    <?php if (!empty($item['expiry_date'])): ?>
                                        <small class="text-muted">ถึง <?= thai_date($item['expiry_date']) ?></small>
                                    <?php else: ?>
                                        <small class="text-muted">ไม่มีกำหนดหมดอายุ</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($item['attachment_path'])): ?>
                                        <a href="<?= asset('storage/' . $item['attachment_path']) ?>" target="_blank" class="badge bg-light text-primary border text-decoration-none">
                                            <i class="bi bi-paperclip me-1"></i> ไฟล์แนบ
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item['status'] === 'published'): ?>
                                        <span class="badge bg-success">เผยแพร่</span>
                                    <?php elseif ($item['status'] === 'draft'): ?>
                                        <span class="badge bg-secondary">แบบร่าง</span>
                                    <?php else: ?>
                                        <span class="badge bg-dark">จัดเก็บ</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= url("admin/announcements/{$item['id']}/edit") ?>" class="btn btn-outline-primary" title="แก้ไข">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?= url("admin/announcements/{$item['id']}/delete") ?>" method="POST" onsubmit="return confirm('คุณต้องการลบประกาศนี้ใช่หรือไม่?');" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-outline-danger" title="ลบ">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
