<?php
$categories = $categories ?? [];
$selectedCategory = $selectedCategory ?? '';
$newsList = $newsList ?? [];
?>
<div class="py-5 bg-navy text-white">
    <div class="container">
        <span class="badge bg-gold text-white mb-2 px-3 py-1">ศูนย์ข่าวสาร</span>
        <h1 class="text-white fw-bold display-6 mb-2">ข่าวสารและกิจกรรมประชาสัมพันธ์</h1>
        <p class="text-light-blue lead mb-0">ติดตามข่าวสารความเคลื่อนไหว ประกาศ และกิจกรรมล่าสุดของสหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</p>
    </div>
</div>

<div class="container py-5">
    <!-- Category Filter Tabs -->
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="<?= url('news') ?>" class="btn btn-sm rounded-pill <?= empty($selectedCategory) ? 'btn-primary' : 'btn-outline-secondary' ?>">
            ข่าวทั้งหมด
        </a>
        <?php foreach ($categories as $cat): ?>
            <a href="<?= url('news?cat=' . $cat['slug']) ?>" class="btn btn-sm rounded-pill <?= ($selectedCategory === $cat['slug']) ? 'btn-primary' : 'btn-outline-secondary' ?>">
                <?= e($cat['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- News Grid -->
    <div class="row g-4">
        <?php if (!empty($newsList)): ?>
            <?php foreach ($newsList as $news): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="coop-card h-100 d-flex flex-column">
                        <div class="position-relative bg-light" style="height: 200px; overflow: hidden;">
                            <?php 
                                $newsThumb = !empty($news['thumbnail']) ? storage_url($news['thumbnail']) : (!empty($news['featured_image']) ? storage_url($news['featured_image']) : asset('img/news_placeholder.jpg')); 
                            ?>
                            <img src="<?= $newsThumb ?>" onerror="this.onerror=null; this.src='<?= asset('img/news_placeholder.jpg') ?>';" class="w-100 h-100 object-fit-cover" alt="<?= e($news['title']) ?>">
                            <span class="position-absolute top-0 start-0 m-3 badge bg-navy">
                                <?= e($news['category_name']) ?>
                            </span>
                            <?php if ($news['is_pinned']): ?>
                                <span class="position-absolute top-0 end-0 m-3 badge bg-warning text-dark"><i class="bi bi-pin-angle-fill me-1"></i> ปักหมุด</span>
                            <?php endif; ?>
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="bi bi-calendar3 me-1"></i> <?= thai_date($news['publish_at']) ?></span>
                                <span><i class="bi bi-eye me-1"></i> <?= number_format($news['views_count']) ?></span>
                            </div>
                            <h5 class="fw-bold text-navy mb-2 line-clamp-2">
                                <a href="<?= url('news/' . $news['slug']) ?>" class="text-navy text-decoration-none">
                                    <?= e($news['title']) ?>
                                </a>
                            </h5>
                            <p class="text-muted small flex-grow-1 line-clamp-3">
                                <?= e($news['summary'] ?? strip_tags($news['content'] ?? '')) ?>
                            </p>
                            <div class="pt-3 border-top mt-auto">
                                <a href="<?= url('news/' . $news['slug']) ?>" class="btn btn-sm btn-link p-0 text-primary fw-semibold">
                                    อ่านรายละเอียด <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="coop-card p-5 text-center text-muted">
                    <i class="bi bi-newspaper fs-1 text-secondary mb-3 d-block"></i>
                    <h5>ไม่พบข่าวสารในหมวดหมู่นี้</h5>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
