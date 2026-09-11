<?php
$directors = $directors ?? [];
?>
<div class="py-5 bg-navy text-white">
    <div class="container">
        <span class="badge bg-gold text-white mb-2 px-3 py-1">โครงสร้างองค์กร</span>
        <h1 class="text-white fw-bold display-6 mb-2">คณะกรรมการดำเนินการและฝ่ายจัดการ</h1>
        <p class="text-light-blue lead mb-0">ผู้นำและบุคลากรผู้ขับเคลื่อนสหกรณ์ด้วยหลักธรรมาภิบาลและความซื่อสัตย์สุจริต</p>
    </div>
</div>

<div class="container py-5">
    <!-- Directors -->
    <div class="mb-5">
        <div class="text-center mb-5">
            <h3 class="fw-bold text-navy">คณะกรรมการดำเนินการ</h3>
            <p class="text-muted small">ประจำปีบัญชี 2568 - 2569</p>
        </div>

        <div class="row g-4 justify-content-center">
            <?php foreach ($directors as $b): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 text-center">
                    <div class="coop-card p-4 h-100">
                        <div class="mb-3 mx-auto rounded-circle overflow-hidden bg-light shadow-sm" style="width: 140px; height: 140px;">
                            <img src="<?= asset('img/board_placeholder.jpg') ?>" class="w-100 h-100 object-fit-cover" alt="<?= e($b['name']) ?>">
                        </div>
                        <h6 class="fw-bold text-navy mb-1"><?= e($b['name']) ?></h6>
                        <div class="text-primary small fw-semibold mb-1"><?= e($b['position']) ?></div>
                        <small class="text-muted d-block">วาระ พ.ศ. <?= e($b['term_years']) ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
