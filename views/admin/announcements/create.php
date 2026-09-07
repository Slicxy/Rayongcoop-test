<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="<?= url('admin/announcements') ?>" class="btn btn-sm btn-outline-secondary rounded-pill mb-2">
            <i class="bi bi-arrow-left me-1"></i> กลับไปหน้ารายการประกาศ
        </a>
        <h4 class="fw-bold text-navy mb-1"><i class="bi bi-plus-circle-fill text-primary me-2"></i> สร้างประกาศสำคัญใหม่</h4>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4 p-md-5">
        <form action="<?= url('admin/announcements/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row g-4">
                <div class="col-md-8">
                    <label class="form-label fw-bold small">หัวข้อประกาศ <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="ระบุหัวข้อประกาศสำคัญ..." required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small">ระดับความสำคัญ</label>
                    <select name="priority" class="form-select">
                        <option value="general">ทั่วไป (General)</option>
                        <option value="important" selected>สำคัญ (Important)</option>
                        <option value="urgent">ด่วนที่สุด (Urgent)</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold small">สรุปย่อประกาศ (Summary)</label>
                    <textarea name="summary" rows="2" class="form-control" placeholder="ข้อความสรุปสั้นๆ สำหรับแสดงในหน้ารวมประกาศ..."></textarea>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold small">เนื้อหาประกาศฉบับเต็ม <span class="text-danger">*</span></label>
                    <textarea name="content" rows="8" class="form-control" placeholder="พิมพ์เนื้อหาประกาศ หรือข้อความมติคณะกรรมการ..." required></textarea>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold small">วันที่ประกาศ <span class="text-danger">*</span></label>
                    <input type="date" name="publication_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small">วันที่มีผลบังคับใช้ (ถ้ามี)</label>
                    <input type="date" name="effective_start_date" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small">วันที่สิ้นสุด/หมดอายุ (ถ้ามี)</label>
                    <input type="date" name="expiry_date" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold small">เลขที่มติ / เลขที่ประกาศ (ถ้ามี)</label>
                    <input type="text" name="resolution_no" class="form-control" placeholder="เช่น มติที่ 14/2569">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">ลิงก์ที่เกี่ยวข้อง (URL)</label>
                    <input type="url" name="related_link" class="form-control" placeholder="https://...">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold small">ไฟล์เอกสารแนบทางการ (PDF, DOCX)</label>
                    <input type="file" name="attachment" class="form-control" accept=".pdf,.doc,.docx">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small">สถานะ</label>
                    <select name="status" class="form-select">
                        <option value="published" selected>เผยแพร่ทันที (Published)</option>
                        <option value="draft">บันทึกแบบร่าง (Draft)</option>
                        <option value="archived">จัดเก็บ (Archived)</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="is_pinned" value="1" id="isPinnedCheck">
                        <label class="form-check-label fw-bold small" for="isPinnedCheck">ปักหมุดไว้บนสุด</label>
                    </div>
                </div>

                <div class="col-12 mt-4 pt-3 border-top d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-bold rounded-pill">
                        <i class="bi bi-check-circle-fill me-1"></i> บันทึกประกาศสำคัญ
                    </button>
                    <a href="<?= url('admin/announcements') ?>" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
                        ยกเลิก
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
