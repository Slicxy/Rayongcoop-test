<div class="py-5" style="background: linear-gradient(135deg, #073B74 0%, #0052A3 100%); color: #ffffff;">
    <div class="container-xl text-center">
        <span class="badge bg-gold text-white px-3 py-1 rounded-pill mb-2 fw-semibold">
            <i class="bi bi-ui-checks me-1"></i> แบบสำรวจความคิดเห็น
        </span>
        <h1 class="fw-bold mb-2"><?= e($survey['title']) ?></h1>
        <p class="text-light-blue small mb-0" style="max-width: 650px; margin: 0 auto;">
            <?= e($survey['description'] ?? 'สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด ขอขอบพระคุณทุกความคิดเห็นอันมีค่ายิ่ง') ?>
        </p>
    </div>
</div>

<div class="py-5 bg-light">
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="<?= url('surveys/' . $survey['slug'] . '/submit') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="d-flex flex-column gap-4">
                        <?php foreach ($questions as $idx => $q): ?>
                            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
                                <div class="d-flex align-items-start gap-2 mb-3">
                                    <span class="badge bg-primary rounded-pill px-3 py-1 flex-shrink-0">ข้อที่ <?= $idx + 1 ?></span>
                                    <div>
                                        <h5 class="fw-bold text-navy mb-0">
                                            <?= e($q['question_text']) ?>
                                            <?php if (!empty($q['is_required'])): ?>
                                                <span class="text-danger">*</span>
                                            <?php endif; ?>
                                        </h5>
                                    </div>
                                </div>

                                <?php if ($q['question_type'] === 'rating_1_5'): ?>
                                    <div class="p-3 bg-light rounded-4 text-center">
                                        <div class="d-flex justify-content-center gap-3 gap-md-4 my-2">
                                            <?php for ($r = 5; $r >= 1; $r--): ?>
                                                <div class="form-check form-check-inline d-flex flex-column align-items-center m-0">
                                                    <input class="form-check-input" type="radio" name="answers[<?= $q['id'] ?>]" id="pub_q_<?= $q['id'] ?>_<?= $r ?>" value="<?= $r ?>" <?= $r === 5 ? 'checked' : '' ?> style="transform: scale(1.3); cursor: pointer;">
                                                    <label class="form-check-label mt-2 small fw-bold cursor-pointer" for="pub_q_<?= $q['id'] ?>_<?= $r ?>" style="cursor: pointer;">
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
                                    <div class="d-flex flex-column gap-2 ps-2">
                                        <?php foreach ($q['options'] as $oIdx => $opt): ?>
                                            <div class="form-check p-3 rounded-3 border bg-light-subtle">
                                                <input class="form-check-input ms-0 me-2" type="radio" name="answers[<?= $q['id'] ?>]" id="pub_q_<?= $q['id'] ?>_opt_<?= $oIdx ?>" value="<?= e($opt) ?>" <?= $oIdx === 0 ? 'checked' : '' ?>>
                                                <label class="form-check-label w-100" for="pub_q_<?= $q['id'] ?>_opt_<?= $oIdx ?>" style="cursor: pointer;">
                                                    <?= e($opt) ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                <?php elseif ($q['question_type'] === 'multiple_choice'): ?>
                                    <div class="d-flex flex-column gap-2 ps-2">
                                        <?php foreach ($q['options'] as $oIdx => $opt): ?>
                                            <div class="form-check p-3 rounded-3 border bg-light-subtle">
                                                <input class="form-check-input ms-0 me-2" type="checkbox" name="answers[<?= $q['id'] ?>][]" id="pub_q_<?= $q['id'] ?>_opt_<?= $oIdx ?>" value="<?= e($opt) ?>">
                                                <label class="form-check-label w-100" for="pub_q_<?= $q['id'] ?>_opt_<?= $oIdx ?>" style="cursor: pointer;">
                                                    <?= e($opt) ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                <?php else: ?>
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
    </div>
</div>
