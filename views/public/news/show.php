<?php
$news = $news ?? ['title' => 'ข่าวสาร', 'category_name' => '', 'publish_at' => date('Y-m-d'), 'views_count' => 0, 'content' => ''];
$related = $related ?? [];
?>
<div class="py-4 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?= url('/') ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="<?= url('news') ?>">ข่าวสาร</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= e($news['title']) ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <!-- Article Content -->
        <div class="col-lg-8">
            <div class="coop-card p-4 p-md-5">
                <span class="badge bg-navy mb-3 px-3 py-1"><?= e($news['category_name']) ?></span>
                <h1 class="fw-bold text-navy mb-3 display-6" style="font-size: 1.8rem;"><?= e($news['title']) ?></h1>
                
                <div class="d-flex flex-wrap gap-3 text-muted small pb-4 mb-4 border-bottom">
                    <span><i class="bi bi-calendar3 me-1"></i> เผยแพร่เมื่อ: <?= thai_date($news['publish_at'], true) ?></span>
                    <span><i class="bi bi-person me-1"></i> ผู้เขียน: <?= e($news['author_name'] ?? 'ฝ่ายประชาสัมพันธ์') ?></span>
                    <span><i class="bi bi-eye me-1"></i> เข้าชม: <?= number_format($news['views_count']) ?> ครั้ง</span>
                </div>

                <div class="article-body lh-lg text-secondary" style="font-size: 1.05rem;">
                    <?= $news['content'] ?>
                </div>

                <?php if (!empty($news['tags'])): ?>
                    <div class="pt-4 mt-4 border-top">
                        <small class="fw-bold text-muted me-2"><i class="bi bi-tags me-1"></i> แท็ก:</small>
                        <?php foreach (explode(',', $news['tags']) as $tag): ?>
                            <span class="badge bg-light text-navy border me-1"><?= trim(e($tag)) ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar Related News -->
        <div class="col-lg-4">
            <div class="coop-card p-4 mb-4">
                <h5 class="fw-bold text-navy mb-3">ข่าวอื่นในหมวดเดียวกัน</h5>
                <div class="list-group list-group-flush">
                    <?php foreach ($related as $rel): ?>
                        <a href="<?= url('news/' . $rel['slug']) ?>" class="list-group-item list-group-item-action px-0 py-3">
                            <h6 class="fw-semibold text-navy mb-1 line-clamp-2"><?= e($rel['title']) ?></h6>
                            <small class="text-muted"><i class="bi bi-calendar3 me-1"></i> <?= thai_date($rel['publish_at']) ?></small>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="p-4 bg-light-blue rounded-3 text-center">
                <i class="bi bi-headset fs-1 text-primary mb-2 d-block"></i>
                <h6 class="fw-bold text-navy">มีข้อสงสัยหรือต้องการสอบถาม?</h6>
                <p class="text-muted small mb-3">ติดต่อเจ้าหน้าที่สหกรณ์เพื่อขอข้อมูลเพิ่มเติม</p>
                <a href="<?= url('contact') ?>" class="btn btn-primary btn-sm w-100">ติดต่อเรา</a>
            </div>
        </div>
    </div>
</div>
