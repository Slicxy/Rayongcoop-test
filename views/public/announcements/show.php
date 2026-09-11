<?php
$announcement = $announcement ?? ['title' => 'ประกาศสำคัญ', 'priority' => 'general', 'publish_at' => date('Y-m-d'), 'publication_date' => date('Y-m-d'), 'views_count' => 0, 'view_count' => 0, 'content' => ''];
$related = $related ?? [];
?>
<div class="py-4 bg-navy text-white">
    <div class="container-xl">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="<?= url('/') ?>" class="text-light-blue text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="<?= url('announcements') ?>" class="text-light-blue text-decoration-none">ประกาศสำคัญ</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">รายละเอียดประกาศ</li>
            </ol>
        </nav>
        <h1 class="h3 fw-bold text-white mb-0"><?= e($announcement['title'] ?? '') ?></h1>
    </div>
</div>

<div class="container-xl py-5">
    <div class="row g-5">
        <!-- Main Content Left Column -->
        <div class="col-lg-8">
            <div class="coop-card p-4 p-md-5 mb-4">
                <!-- Meta Tags -->
                <div class="d-flex flex-wrap align-items-center gap-2 mb-4 pb-3 border-bottom">
                    <?php if (($announcement['priority'] ?? '') === 'urgent'): ?>
                        <span class="badge bg-danger"><i class="bi bi-exclamation-octagon-fill me-1"></i> ด่วนที่สุด</span>
                    <?php elseif (($announcement['priority'] ?? '') === 'important'): ?>
                        <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i> ประกาศสำคัญ</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">ทั่วไป</span>
                    <?php endif; ?>

                    <?php if (!empty($announcement['resolution_no'])): ?>
                        <span class="badge bg-light text-navy border">
                            <i class="bi bi-file-earmark-check me-1"></i> <?= e($announcement['resolution_no']) ?>
                        </span>
                    <?php endif; ?>

                    <span class="text-muted small">
                        <i class="bi bi-calendar3 me-1"></i> วันที่ประกาศ: <?= thai_date($announcement['publication_date'] ?? $announcement['publish_at'] ?? date('Y-m-d')) ?>
                    </span>

                    <?php if (!empty($announcement['expiry_date'])): ?>
                        <span class="text-muted small">
                            • <i class="bi bi-clock-history me-1"></i> มีผลบังคับถึง: <?= thai_date($announcement['expiry_date']) ?>
                        </span>
                    <?php endif; ?>

                    <span class="text-muted small ms-auto">
                        <i class="bi bi-eye me-1"></i> เข้าชม <?= number_format((float)($announcement['view_count'] ?? $announcement['views_count'] ?? 0)) ?> ครั้ง
                    </span>
                </div>

                <!-- Announcement Body -->
                <div class="announcement-content mb-5" style="line-height: 1.8; font-size: 1.05rem;">
                    <?= $announcement['content'] ?>
                </div>

                <!-- Attachment Box -->
                <?php if (!empty($announcement['attachment_path'])): ?>
                    <div class="p-4 bg-light rounded-4 border border-primary border-opacity-25 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary text-white rounded-3 p-3 fs-3">
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-navy"><?= e($announcement['attachment_name'] ?? 'เอกสารแนบประกาศ (PDF)') ?></div>
                                <small class="text-muted">เอกสารฉบับทางการจากสหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</small>
                            </div>
                        </div>
                        <a href="<?= asset('storage/' . $announcement['attachment_path']) ?>" target="_blank" class="btn btn-primary rounded-pill px-4 fw-bold">
                            <i class="bi bi-download me-1"></i> เปิดดู / ดาวน์โหลด
                        </a>
                    </div>
                <?php endif; ?>

                <?php if (!empty($announcement['related_link'])): ?>
                    <div class="mt-4">
                        <a href="<?= e($announcement['related_link']) ?>" target="_blank" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="bi bi-link-45deg me-1"></i> เอกสารหรือระบบที่เกี่ยวข้อง <i class="bi bi-box-arrow-up-right ms-1"></i>
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Share & Back Buttons -->
                <div class="d-flex justify-content-between align-items-center pt-4 border-top mt-5">
                    <a href="<?= url('announcements') ?>" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i> กลับไปหน้ารวมประกาศ
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar Right Column -->
        <div class="col-lg-4">
            <!-- Other Active Announcements -->
            <div class="coop-card p-4 mb-4">
                <h5 class="fw-bold text-navy mb-3"><i class="bi bi-megaphone-fill text-warning me-2"></i> ประกาศสำคัญอื่นๆ</h5>
                <?php if (empty($related)): ?>
                    <p class="text-muted small mb-0">ไม่มีประกาศสำคัญเพิ่มเติมในขณะนี้</p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($related as $rel): ?>
                            <div class="border-bottom pb-2">
                                <small class="text-muted d-block"><?= thai_date($rel['publication_date']) ?></small>
                                <a href="<?= url('announcements/' . $rel['slug']) ?>" class="text-navy fw-semibold text-decoration-none hover-primary small">
                                    <?= e($rel['title']) ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- E-Service Quick Banner -->
            <div class="coop-card p-4 text-white" style="background: linear-gradient(135deg, #073B74 0%, #0B5ED7 100%);">
                <h5 class="fw-bold text-white mb-2"><i class="bi bi-shield-lock-fill text-warning me-2"></i> สมาชิกสหกรณ์</h5>
                <p class="small text-white-80 mb-3">เข้าสู่ระบบเพื่อตรวจสอบข้อมูลหุ้น เงินฝาก สินเชื่อ และพิมพ์ใบเสร็จ e-Receipt ออนไลน์ตลอด 24 ชม.</p>
                <a href="<?= url('eservice') ?>" class="btn btn-gold text-navy fw-bold w-100 rounded-pill">
                    เข้าสู่ระบบ E-Service <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
