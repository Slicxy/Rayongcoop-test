<?php
$news = $news ?? null;
$categories = $categories ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><?= $news ? 'แก้ไขข่าวสาร' : 'สร้างข่าวสารใหม่' ?></h3>
        <p class="text-muted small mb-0">กรอกข้อมูลรายละเอียดข่าวสารและกำหนดสถานะการเผยแพร่</p>
    </div>
    <a href="<?= url('admin/news') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> ย้อนกลับ
    </a>
</div>

<form action="<?= $news ? url('admin/news/' . $news['id'] . '/update') : url('admin/news/store') ?>" method="POST" id="newsForm">
    <?= csrf_field() ?>

    <div class="row g-4">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="admin-card p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold small">หัวข้อข่าว <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control form-control-lg" value="<?= e($news['title'] ?? old('title')) ?>" placeholder="ระบุหัวข้อข่าวสาร..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">บทคัดย่อ / สรุปย่อ (Summary)</label>
                    <textarea name="summary" class="form-control" rows="3" placeholder="สรุปเนื้อหาสำคัญ 2-3 บรรทัด..."><?= e($news['summary'] ?? old('summary')) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">เนื้อหาข่าว (Content HTML / Rich Text) <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control" rows="12" placeholder="เขียนรายละเอียดเนื้อหาข่าวสารที่นี่..." required><?= e($news['content'] ?? old('content')) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">แท็ก (คั่นด้วยเครื่องหมายจุลภาค ,)</label>
                    <input type="text" name="tags" class="form-control" value="<?= e($news['tags'] ?? old('tags')) ?>" placeholder="ประชาสัมพันธ์, การเงิน, ประชุม">
                </div>
            </div>
        </div>

        <!-- Sidebar Options -->
        <div class="col-lg-4">
            <div class="admin-card p-4 mb-4">
                <h6 class="fw-bold text-navy mb-3">การตั้งค่าการเผยแพร่</h6>

                <div class="mb-3">
                    <label class="form-label fw-bold small">หมวดหมู่ข่าว <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (($news['category_id'] ?? old('category_id')) == $cat['id']) ? 'selected' : '' ?>>
                                <?= e($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">สถานะ Workflow</label>
                    <select name="workflow_status" class="form-select">
                        <option value="draft" <?= (($news['workflow_status'] ?? '') === 'draft') ? 'selected' : '' ?>>Draft (ฉบับร่าง)</option>
                        <option value="submitted" <?= (($news['workflow_status'] ?? '') === 'submitted') ? 'selected' : '' ?>>Submitted (ส่งตรวจ)</option>
                        <option value="under_review" <?= (($news['workflow_status'] ?? '') === 'under_review') ? 'selected' : '' ?>>Under Review (กำลังตรวจสอบ)</option>
                        <option value="approved" <?= (($news['workflow_status'] ?? '') === 'approved') ? 'selected' : '' ?>>Approved (อนุมัติแล้ว)</option>
                        <option value="published" <?= (($news['workflow_status'] ?? 'published') === 'published') ? 'selected' : '' ?>>Published (เผยแพร่สู่สาธารณะ)</option>
                        <option value="archived" <?= (($news['workflow_status'] ?? '') === 'archived') ? 'selected' : '' ?>>Archived (จัดเก็บถาวร)</option>
                    </select>
                </div>

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="is_pinned" id="chkPinned" value="1" <?= (!empty($news['is_pinned'])) ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="chkPinned">ปักหมุดไว้บนสุด (Pinned)</label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="chkFeatured" value="1" <?= (!empty($news['is_featured'])) ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="chkFeatured">แสดงเป็นข่าวเด่น (Featured)</label>
                </div>

                <div class="pt-3 border-top">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                        <i class="bi bi-save me-1"></i> บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
