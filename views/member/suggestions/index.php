<!-- Header Banner -->
<div class="card border-0 shadow-sm rounded-4 bg-gradient-primary text-white p-4 mb-4" style="background: linear-gradient(135deg, #073B74 0%, #0B5ED7 100%);">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-gold text-navy fw-bold px-3 py-1 rounded-pill">Democratic Member Control</span>
                <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-3 py-1">ร่วมสร้างสรรค์สหกรณ์</span>
            </div>
            <h3 class="fw-bold text-white mb-1">
                <i class="bi bi-chat-heart-fill text-warning me-2"></i>กล่องรับฟังเสียงและข้อเสนอแนะนวัตกรรมสมาชิก (Member Voice)
            </h3>
            <p class="text-light-blue mb-0 small" style="max-width: 650px;">
                สหกรณ์เปิดรับทุกความคิดเห็น ไอเดียโครงการสวัสดิการใหม่ หรือการปรับปรุงบริการ เพื่อนำไปสู่การพัฒนาอย่างต่อเนื่อง โปร่งใส และตอบโจทย์สมาชิกทุกท่าน
            </p>
        </div>
        <div>
            <button type="button" class="btn btn-warning text-navy fw-bold rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="collapse" data-bs-target="#newSuggestionCollapse" aria-expanded="false">
                <i class="bi bi-pencil-square me-1"></i> เขียนข้อเสนอแนะใหม่
            </button>
        </div>
    </div>
</div>

<!-- KPI Summary Cards -->
<?php 
    $totalCount = count($suggestions);
    $underReviewCount = 0;
    $approvedCount = 0;
    foreach ($suggestions as $s) {
        if ($s['status'] === 'under_review' || $s['status'] === 'submitted') $underReviewCount++;
        if ($s['status'] === 'approved' || $s['status'] === 'implemented') $approvedCount++;
    }
?>
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">ข้อเสนอแนะที่ท่านส่งทั้งหมด</div>
                    <h3 class="fw-bold text-navy mb-0 font-monospace"><?= number_format($totalCount) ?> <span class="fs-6 fw-normal text-muted">เรื่อง</span></h3>
                </div>
                <div class="bg-primary-subtle text-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="bi bi-chat-square-quote-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">อยู่ระหว่างพิจารณา / ตรวจสอบ</div>
                    <h3 class="fw-bold text-warning mb-0 font-monospace"><?= number_format($underReviewCount) ?> <span class="fs-6 fw-normal text-muted">เรื่อง</span></h3>
                </div>
                <div class="bg-warning-subtle text-warning rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="bi bi-hourglass-split fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">รับหลักการ / นำไปปฏิบัติจริงแล้ว</div>
                    <h3 class="fw-bold text-success mb-0 font-monospace"><?= number_format($approvedCount) ?> <span class="fs-6 fw-normal text-muted">เรื่อง</span></h3>
                </div>
                <div class="bg-success-subtle text-success rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="bi bi-stars fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Suggestion Form (Collapse) -->
<div class="collapse mb-4 <?= empty($suggestions) ? 'show' : '' ?>" id="newSuggestionCollapse">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-top border-4 border-primary">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <div>
                <h5 class="fw-bold text-navy mb-1"><i class="bi bi-lightbulb text-warning me-2"></i>ส่งข้อเสนอแนะหรือไอเดียโครงการใหม่</h5>
                <p class="text-muted small mb-0">ร่วมแบ่งปันข้อคิดเห็นเพื่อการพัฒนาบริการและสวัสดิการของสหกรณ์เรา</p>
            </div>
            <button type="button" class="btn-close" data-bs-toggle="collapse" data-bs-target="#newSuggestionCollapse"></button>
        </div>

        <form action="<?= url('member/suggestions/store') ?>" method="POST" enctype="multipart/form-data" id="suggestionForm">
            <?= csrf_field() ?>

            <!-- 1. Category Selection -->
            <label class="form-label fw-bold small text-navy mb-2">1. เลือกหมวดหมู่ข้อเสนอแนะ <span class="text-danger">*</span></label>
            <div class="row g-3 mb-4">
                <?php foreach ($categories as $catKey => $cat): ?>
                    <div class="col-md-4 col-sm-6">
                        <label class="card border rounded-4 p-3 text-start h-100 cursor-pointer cat-card <?= ($catKey === 'welfare') ? 'selected border-primary bg-primary-subtle' : 'bg-light' ?>" for="cat_<?= $catKey ?>" style="transition: all 0.2s ease;">
                            <input type="radio" name="category" id="cat_<?= $catKey ?>" value="<?= $catKey ?>" <?= ($catKey === 'welfare') ? 'checked' : '' ?> class="d-none">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi <?= $cat['icon'] ?> text-<?= $cat['color'] ?> fs-5"></i>
                                <span class="fw-bold text-navy small"><?= e($cat['name']) ?></span>
                            </div>
                            <small class="text-muted" style="font-size: 11.5px;"><?= e($cat['desc']) ?></small>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- 2. Title & Details -->
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label small fw-bold text-navy">2. หัวข้อข้อเสนอแนะ / ชื่อโครงการที่เสนอ <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="เช่น ขอเสนอโครงการสวัสดิการตรวจสุขภาพประจำปีเพิ่มเติม, ปรับปรุงระบบจองคิวออนไลน์..." required minlength="5" maxlength="255">
                </div>

                <div class="col-12">
                    <label class="form-label small fw-bold text-navy">3. รายละเอียดและเหตุผลข้อเสนอแนะ <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control" rows="4" placeholder="อธิบายรายละเอียด สิ่งที่ต้องการให้ปรับปรุง เหตุผลความจำเป็น หรือประโยชน์ที่สมาชิกจะได้รับ..." required minlength="10"></textarea>
                </div>
            </div>

            <!-- 3. Attachment & Anonymous Option -->
            <div class="row g-3 align-items-center mb-4 p-3 bg-light rounded-4 border">
                <div class="col-md-7">
                    <label class="form-label small fw-bold text-navy mb-1"><i class="bi bi-paperclip me-1"></i>แนบไฟล์ประกอบหรือรูปภาพ (ไม่บังคับ)</label>
                    <input type="file" name="attachment" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                    <small class="text-muted" style="font-size: 11.5px;">รองรับไฟล์ PDF, JPG, PNG, DOC ขนาดไม่เกิน 5MB</small>
                </div>
                <div class="col-md-5 border-start-md ps-md-4">
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="is_anonymous" value="1" id="chkAnonymous">
                        <label class="form-check-label fw-semibold small text-navy" for="chkAnonymous">
                            <i class="bi bi-incognito me-1"></i> ส่งแบบไม่เปิดเผยตัวตน (Anonymous)
                        </label>
                    </div>
                    <small class="text-muted d-block" style="font-size: 11.5px;">ชื่อของท่านจะไม่ถูกแสดงต่อเจ้าหน้าที่ทั่วไป</small>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-toggle="collapse" data-bs-target="#newSuggestionCollapse">ยกเลิก</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                    <i class="bi bi-send-fill me-1"></i> ส่งข้อเสนอแนะทันที
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Submitted Suggestions List -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <h5 class="fw-bold text-navy mb-4"><i class="bi bi-journal-text text-primary me-2"></i>ประวัติข้อเสนอแนะและสถานะการพิจารณา</h5>

    <?php if (!empty($suggestions)): ?>
        <div class="d-flex flex-column gap-3">
            <?php foreach ($suggestions as $item): ?>
                <?php 
                    $catMeta = $categories[$item['category']] ?? ['name' => $item['category'], 'color' => 'secondary', 'icon' => 'bi-tag'];
                    $stMeta = $statuses[$item['status']] ?? ['name' => $item['status'], 'badge' => 'bg-secondary', 'icon' => 'bi-info-circle'];
                ?>
                <div class="card border rounded-4 p-4 shadow-none position-relative overflow-hidden <?= !empty($item['admin_response']) ? 'border-primary-subtle' : '' ?>">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 border-bottom pb-2 mb-3">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="badge bg-light text-navy border font-monospace"><?= e($item['suggestion_no']) ?></span>
                            <span class="badge bg-<?= $catMeta['color'] ?>-subtle text-<?= $catMeta['color'] ?> border border-<?= $catMeta['color'] ?>-subtle rounded-pill">
                                <i class="bi <?= $catMeta['icon'] ?> me-1"></i> <?= e($catMeta['name']) ?>
                            </span>
                            <?php if ($item['is_anonymous']): ?>
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill small"><i class="bi bi-incognito me-1"></i>ไม่ระบุชื่อ</span>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <small class="text-muted"><i class="bi bi-calendar3 me-1"></i> <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></small>
                            <span class="badge <?= $stMeta['badge'] ?> px-3 py-1 rounded-pill small">
                                <i class="bi <?= $stMeta['icon'] ?> me-1"></i> <?= e($stMeta['name']) ?>
                            </span>
                        </div>
                    </div>

                    <h5 class="fw-bold text-navy mb-2"><?= e($item['title']) ?></h5>
                    <p class="text-muted small mb-3" style="line-height: 1.7; white-space: pre-line;"><?= e($item['content']) ?></p>

                    <?php if (!empty($item['attachment_path'])): ?>
                        <div class="mb-3">
                            <a href="<?= asset($item['attachment_path']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill">
                                <i class="bi bi-paperclip me-1"></i> ดูเอกสารแนบประกอบ
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Admin Response Timeline Block -->
                    <?php if (!empty($item['admin_response'])): ?>
                        <div class="p-3 rounded-4 bg-primary-subtle border border-primary-subtle mt-2">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 12px;">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <b class="text-navy small">คำชี้แจง / ผลการพิจารณาจากสหกรณ์:</b>
                                </div>
                                <?php if (!empty($item['responded_at'])): ?>
                                    <small class="text-muted" style="font-size: 11px;">
                                        <?= date('d/m/Y H:i', strtotime($item['responded_at'])) ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <p class="text-dark small mb-0 ps-4" style="line-height: 1.6; white-space: pre-line;"><?= e($item['admin_response']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5 text-muted">
            <i class="bi bi-chat-heart fs-1 d-block mb-2 text-secondary opacity-50"></i>
            <h6>ยังไม่มีประวัติการส่งข้อเสนอแนะ</h6>
            <small>ท่านสามารถคลิกปุ่ม <b>"เขียนข้อเสนอแนะใหม่"</b> ด้านบนเพื่อส่งความคิดเห็นแรกได้เลยครับ</small>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category Cards Selector
    document.querySelectorAll('.cat-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.cat-card').forEach(c => {
                c.classList.remove('selected', 'border-primary', 'bg-primary-subtle');
                c.classList.add('bg-light');
            });
            this.classList.add('selected', 'border-primary', 'bg-primary-subtle');
            this.classList.remove('bg-light');
            const radio = this.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
        });
    });
});
</script>
