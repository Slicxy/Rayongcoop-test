<?php
$event = $event ?? ['id' => 0, 'title' => '', 'category' => 'activity', 'description' => '', 'start_date' => date('Y-m-d'), 'end_date' => '', 'start_time' => '', 'end_time' => '', 'location' => '', 'related_link' => '', 'status' => 'upcoming', 'is_featured' => 0];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="<?= url('admin/events') ?>" class="btn btn-sm btn-outline-secondary rounded-pill mb-2">
            <i class="bi bi-arrow-left me-1"></i> กลับไปหน้ารายการปฏิทิน
        </a>
        <h4 class="fw-bold text-navy mb-1"><i class="bi bi-pencil-square text-primary me-2"></i> แก้ไขกิจกรรม/กำหนดการ</h4>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4 p-md-5">
        <form action="<?= url("admin/events/{$event['id']}/update") ?>" method="POST">
            <?= csrf_field() ?>

            <div class="row g-4">
                <div class="col-md-8">
                    <label class="form-label fw-bold small">ชื่อกิจกรรม / กำหนดการ <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="<?= e($event['title']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small">หมวดหมู่กิจกรรม <span class="text-danger">*</span></label>
                    <select name="category" class="form-select" required>
                        <option value="activity" <?= $event['category'] === 'activity' ? 'selected' : '' ?>>กิจกรรมทั่วไป (General Activity)</option>
                        <option value="meeting" <?= $event['category'] === 'meeting' ? 'selected' : '' ?>>การประชุมใหญ่ / สรรหา (Meeting)</option>
                        <option value="loan_window" <?= $event['category'] === 'loan_window' ? 'selected' : '' ?>>รอบยื่นกู้เงิน (Loan Application Window)</option>
                        <option value="dividend" <?= $event['category'] === 'dividend' ? 'selected' : '' ?>>จ่ายเงินปันผล (Dividend Payment)</option>
                        <option value="holiday" <?= $event['category'] === 'holiday' ? 'selected' : '' ?>>วันหยุดทำการ (Office Holiday)</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold small">รายละเอียดกิจกรรม</label>
                    <textarea name="description" rows="4" class="form-control"><?= e($event['description'] ?? '') ?></textarea>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold small">วันที่เริ่มจัดกิจกรรม <span class="text-danger">*</span></label>
                    <input type="date" name="start_date" class="form-control" value="<?= e($event['start_date']) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small">วันที่สิ้นสุด (ถ้ามี)</label>
                    <input type="date" name="end_date" class="form-control" value="<?= e($event['end_date'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small">เวลาเริ่มต้น (ถ้ามี)</label>
                    <input type="time" name="start_time" class="form-control" value="<?= e($event['start_time'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small">เวลาสิ้นสุด (ถ้ามี)</label>
                    <input type="time" name="end_time" class="form-control" value="<?= e($event['end_time'] ?? '') ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold small">สถานที่จัดกิจกรรม</label>
                    <input type="text" name="location" class="form-control" value="<?= e($event['location'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">ลิงก์ที่เกี่ยวข้อง (URL)</label>
                    <input type="url" name="related_link" class="form-control" value="<?= e($event['related_link'] ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold small">สถานะกิจกรรม</label>
                    <select name="status" class="form-select">
                        <option value="upcoming" <?= $event['status'] === 'upcoming' ? 'selected' : '' ?>>กำลังจะมาถึง (Upcoming)</option>
                        <option value="completed" <?= $event['status'] === 'completed' ? 'selected' : '' ?>>เสร็จสิ้นแล้ว (Completed)</option>
                        <option value="cancelled" <?= $event['status'] === 'cancelled' ? 'selected' : '' ?>>ยกเลิก (Cancelled)</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeaturedCheck" <?= $event['is_featured'] ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold small" for="isFeaturedCheck">เน้นเป็นกิจกรรมสำคัญ</label>
                    </div>
                </div>

                <div class="col-12 mt-4 pt-3 border-top d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-bold rounded-pill">
                        <i class="bi bi-check-circle-fill me-1"></i> บันทึกการแก้ไข
                    </button>
                    <a href="<?= url('admin/events') ?>" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
                        ยกเลิก
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
