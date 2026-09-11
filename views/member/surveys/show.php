<?php
$survey = array_merge(['id' => 0, 'title' => 'แบบสำรวจความคิดเห็น', 'slug' => '', 'description' => ''], $survey ?? []);
$questions = $questions ?? [];
?>
<div class="row g-4 justify-content-center">
    <!-- Header -->
    <div class="col-lg-10">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 bg-white p-4 rounded-4 shadow-sm border">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item"><a href="<?= url('member/dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= url('member/surveys') ?>" class="text-decoration-none">แบบสำรวจ</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= e($survey['title']) ?></li>
                    </ol>
                </nav>
                <h4 class="fw-bold text-navy mb-1"><?= e($survey['title']) ?></h4>
                <p class="text-muted small mb-0"><?= e($survey['description'] ?? 'กรุณาตอบคำถามตามความเป็นจริงเพื่อประโยชน์ในการพัฒนาสหกรณ์') ?></p>
            </div>
            <div>
                <a href="<?= url('member/surveys') ?>" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> ย้อนกลับ
                </a>
            </div>
        </div>
    </div>

    <!-- Questions Form -->
    <div class="col-lg-10">
        <form action="<?= url('member/surveys/' . $survey['id'] . '/submit') ?>" method="POST" id="memberSurveyForm">
            <?= csrf_field() ?>

            <div class="d-flex flex-column gap-4">
                <?php foreach ($questions as $idx => $q): ?>
                    <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
                        <div class="d-flex align-items-start gap-2 mb-3">
                            <span class="badge bg-primary rounded-pill px-3 py-1 flex-shrink-0">ข้อที่ <?= $idx + 1 ?></span>
                            <div>
                                <h6 class="fw-bold text-navy mb-0">
                                    <?= e($q['question_text']) ?>
                                    <?php if (!empty($q['is_required'])): ?>
                                        <span class="text-danger">*</span>
                                    <?php endif; ?>
                                </h6>
                                <?php if (!empty($q['description'])): ?>
                                    <small class="text-muted"><?= e($q['description']) ?></small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if ($q['question_type'] === 'rating_1_5'): ?>
                            <!-- Star / Score Rating (1 to 5) -->
                            <div class="p-3 bg-light rounded-4 text-center">
                                <div class="d-flex justify-content-center gap-3 gap-md-4 my-2">
                                    <?php for ($r = 5; $r >= 1; $r--): ?>
                                        <div class="form-check form-check-inline d-flex flex-column align-items-center m-0">
                                            <input class="form-check-input" type="radio" name="answers[<?= $q['id'] ?>]" id="q_<?= $q['id'] ?>_<?= $r ?>" value="<?= $r ?>" <?= $r === 5 ? 'checked' : '' ?> style="transform: scale(1.3); cursor: pointer;">
                                            <label class="form-check-label mt-2 small fw-bold cursor-pointer" for="q_<?= $q['id'] ?>_<?= $r ?>" style="cursor: pointer;">
                                                <div class="text-warning fs-5"><i class="bi bi-star-fill"></i></div>
                                                <div><?= $r ?> คะแนน</div>
                                                <small class="text-muted d-block" style="font-size: 10px;">
                                                    <?= $r === 5 ? 'มากที่สุด' : ($r === 4 ? 'มาก' : ($r === 3 ? 'ปานกลาง' : ($r === 2 ? 'น้อย' : 'น้อยที่สุด'))) ?>
                                                </small>
                                            </label>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>

                        <?php elseif ($q['question_type'] === 'single_choice'): ?>
                            <!-- Single Choice Options -->
                            <div class="d-flex flex-column gap-2 ps-2">
                                <?php foreach ($q['options'] as $oIdx => $opt): ?>
                                    <div class="form-check p-3 rounded-3 border bg-light-subtle">
                                        <input class="form-check-input ms-0 me-2" type="radio" name="answers[<?= $q['id'] ?>]" id="q_<?= $q['id'] ?>_opt_<?= $oIdx ?>" value="<?= e($opt) ?>" <?= $oIdx === 0 ? 'checked' : '' ?>>
                                        <label class="form-check-label w-100" for="q_<?= $q['id'] ?>_opt_<?= $oIdx ?>" style="cursor: pointer;">
                                            <?= e($opt) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        <?php elseif ($q['question_type'] === 'multiple_choice'): ?>
                            <!-- Multiple Choice Options -->
                            <div class="d-flex flex-column gap-2 ps-2">
                                <?php foreach ($q['options'] as $oIdx => $opt): ?>
                                    <div class="form-check p-3 rounded-3 border bg-light-subtle">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" name="answers[<?= $q['id'] ?>][]" id="q_<?= $q['id'] ?>_opt_<?= $oIdx ?>" value="<?= e($opt) ?>">
                                        <label class="form-check-label w-100" for="q_<?= $q['id'] ?>_opt_<?= $oIdx ?>" style="cursor: pointer;">
                                            <?= e($opt) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        <?php else: ?>
                            <!-- Text Input -->
                            <textarea name="answers[<?= $q['id'] ?>]" class="form-control rounded-3" rows="3" placeholder="พิมพ์ข้อความตอบกลับของท่านที่นี่..."></textarea>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <div class="text-center my-3">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow fw-bold">
                        <i class="bi bi-send-fill me-2"></i> ส่งแบบสำรวจความคิดเห็น
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
