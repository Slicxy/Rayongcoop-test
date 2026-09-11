<?php
$faqs = $faqs ?? [];
?>
<div class="py-5 bg-navy text-white">
    <div class="container">
        <span class="badge bg-gold text-white mb-2 px-3 py-1">ศูนย์ช่วยเหลือ</span>
        <h1 class="text-white fw-bold display-6 mb-2">คำถามที่พบบ่อย (FAQ)</h1>
        <p class="text-light-blue lead mb-0">รวบรวมข้อสงสัยและคำถามที่พบบ่อยเกี่ยวกับการเป็นสมาชิก เงินฝาก เงินกู้ และสวัสดิการ</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="accordion" id="faqAccordion">
                <?php foreach ($faqs as $i => $faq): ?>
                    <div class="accordion-item coop-card mb-3 border">
                        <h2 class="accordion-header" id="heading<?= $i ?>">
                            <button class="accordion-button <?= $i === 0 ? '' : 'collapsed' ?> fw-bold text-navy py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $i ?>">
                                <i class="bi bi-question-circle-fill text-primary me-2"></i> <?= e($faq['question']) ?>
                            </button>
                        </h2>
                        <div id="collapse<?= $i ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $i ?>" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary lh-lg pt-0 pb-4 px-4">
                                <?= nl2br(e($faq['answer'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
