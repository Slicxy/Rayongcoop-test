<?php
$welfares = $welfares ?? [];
?>
<div class="py-5 bg-navy text-white">
    <div class="container">
        <span class="badge bg-gold text-white mb-2 px-3 py-1">การเกื้อกูลสมาชิก</span>
        <h1 class="text-white fw-bold display-6 mb-2">สวัสดิการสมาชิกสหกรณ์</h1>
        <p class="text-light-blue lead mb-0">มอบความมั่นคงและเกื้อกูลแก่สมาชิกและครอบครัวในทุกช่วงจังหวะชีวิต</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <?php foreach ($welfares as $w): ?>
            <div class="col-lg-4 col-md-6">
                <div class="coop-card h-100 d-flex flex-column p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="quick-service-icon me-3 flex-shrink-0" style="background-color: var(--coop-light-blue); color: var(--coop-blue);">
                            <i class="bi bi-heart-pulse-fill"></i>
                        </div>
                        <div>
                            <span class="badge bg-light text-navy border small mb-1"><?= e($w['category']) ?></span>
                            <h5 class="fw-bold text-navy mb-0"><?= e($w['title']) ?></h5>
                        </div>
                    </div>

                    <p class="text-muted small flex-grow-1 mb-4"><?= e($w['short_description']) ?></p>

                    <div class="bg-light p-3 rounded-3 mb-4 small">
                        <div class="mb-2">
                            <span class="text-muted d-block">วงเงินสวัสดิการ:</span>
                            <b class="text-success fs-6"><?= e($w['benefit_amount']) ?></b>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted d-block">คุณสมบัติผู้มีสิทธิ์:</span>
                            <span><?= e($w['eligibility']) ?></span>
                        </div>
                        <div>
                            <span class="text-muted d-block">ติดต่อสอบถาม:</span>
                            <span class="text-primary"><?= e($w['contact_info'] ?? '-') ?></span>
                        </div>
                    </div>

                    <div class="pt-3 border-top mt-auto d-flex gap-2">
                        <a href="<?= url('documents?cat=welfare-forms') ?>" class="btn btn-outline-primary btn-sm flex-grow-1">
                            <i class="bi bi-file-earmark-arrow-down me-1"></i> ดาวน์โหลดแบบฟอร์ม
                        </a>
                        <a href="<?= url('contact') ?>" class="btn btn-primary btn-sm px-3">
                            ยื่นคำขอ
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
