<div class="row g-4">
    <!-- Header -->
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 bg-white p-4 rounded-4 shadow-sm border">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= url('admin/surveys') ?>" class="text-decoration-none">แบบสำรวจ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">ผลการสำรวจ</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                    <h4 class="fw-bold text-navy mb-0"><?= e($survey['title']) ?></h4>
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Real-time Analytics</span>
                </div>
                <p class="text-muted small mb-0"><?= e($survey['description'] ?? 'สรุปผลตอบรับและความคิดเห็นจากสมาชิกสหกรณ์') ?></p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= url('surveys/' . $survey['slug']) ?>" target="_blank" class="btn btn-outline-primary rounded-pill px-3">
                    <i class="bi bi-box-arrow-up-right me-1"></i> ดูหน้าฟอร์ม
                </a>
                <a href="<?= url('admin/surveys') ?>" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> ย้อนกลับ
                </a>
            </div>
        </div>
    </div>

    <!-- Overview Stats Cards -->
    <div class="col-md-4">
        <div class="card border-0 rounded-4 shadow-sm p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-bold text-uppercase">ผู้ตอบแบบสำรวจทั้งหมด</span>
                <div class="bg-primary-subtle text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-people-fill fs-5"></i>
                </div>
            </div>
            <div class="display-5 fw-bold text-navy font-monospace"><?= number_format($totalResponses) ?></div>
            <div class="small text-muted mt-2">
                <i class="bi bi-check-circle text-success me-1"></i> บันทึกข้อมูลเข้าระบบเรียบร้อย
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 rounded-4 shadow-sm p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-bold text-uppercase">ดัชนีความพึงพอใจ (CSAT)</span>
                <div class="bg-success-subtle text-success rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-patch-check-fill fs-5"></i>
                </div>
            </div>
            <div class="display-5 fw-bold text-success font-monospace"><?= number_format($csatScore, 1) ?>%</div>
            <div class="small text-muted mt-2">
                <i class="bi bi-graph-up-arrow text-success me-1"></i> เกณฑ์มาตรฐานการบริการระดับดีเด่น
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 rounded-4 shadow-sm p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-bold text-uppercase">คะแนนเฉลี่ยรวม (เต็ม 5.0)</span>
                <div class="bg-warning-subtle text-warning rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-star-fill fs-5"></i>
                </div>
            </div>
            <div class="display-5 fw-bold text-warning font-monospace"><?= number_format($averageRating, 2) ?> <span class="fs-4 text-muted">/ 5.0</span></div>
            <div class="small text-muted mt-2">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="bi bi-star-fill <?= $i <= round($averageRating) ? 'text-warning' : 'text-muted opacity-25' ?>"></i>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <!-- Questions Results Breakdown -->
    <div class="col-12">
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h6 class="fw-bold text-navy mb-0"><i class="bi bi-pie-chart me-2 text-primary"></i> สรุปผลตอบรับแยกตามข้อคำถาม</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <?php foreach ($questionStats as $idx => $st): ?>
                        <div class="col-lg-6">
                            <div class="p-4 rounded-4 border bg-light-subtle h-100">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="pe-2">
                                        <span class="badge bg-primary rounded-pill px-3 py-1 mb-1">ข้อที่ <?= $idx + 1 ?></span>
                                        <h6 class="fw-bold text-navy mb-0"><?= e($st['question']['question_text']) ?></h6>
                                    </div>
                                    <?php if ($st['question']['question_type'] === 'rating_1_5'): ?>
                                        <div class="text-end flex-shrink-0">
                                            <div class="fw-bold fs-4 text-warning font-monospace"><?= number_format((float)$st['avg_score'], 2) ?></div>
                                            <small class="text-muted" style="font-size: 11px;">คะแนนเฉลี่ย</small>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if ($st['question']['question_type'] === 'rating_1_5'): ?>
                                    <!-- Rating Distribution Bars -->
                                    <div class="d-flex flex-column gap-2 mt-3">
                                        <?php 
                                        $labels = [5 => '5 ดาว (มากที่สุด)', 4 => '4 ดาว (มาก)', 3 => '3 ดาว (ปานกลาง)', 2 => '2 ดาว (น้อย)', 1 => '1 ดาว (น้อยที่สุด)'];
                                        $totalQResponses = array_sum($st['distribution']) ?: 1;
                                        foreach ([5, 4, 3, 2, 1] as $star):
                                            $cnt = $st['distribution'][$star] ?? 0;
                                            $pct = round(($cnt / $totalQResponses) * 100);
                                        ?>
                                            <div class="d-flex align-items-center gap-2 small">
                                                <span style="width: 110px;" class="text-muted"><?= $labels[$star] ?></span>
                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $pct ?>%;" aria-valuenow="<?= $pct ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="text-muted font-monospace" style="width: 50px; text-align: right;"><?= $cnt ?> (<?= $pct ?>%)</span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                <?php elseif ($st['question']['question_type'] === 'text'): ?>
                                    <!-- Qualitative Feedback List -->
                                    <div class="mt-3">
                                        <div class="small fw-bold text-muted mb-2">ข้อเสนอแนะล่าสุด (<?= count($st['text_answers']) ?> รายการ):</div>
                                        <?php if (!empty($st['text_answers'])): ?>
                                            <div class="d-flex flex-column gap-2" style="max-height: 220px; overflow-y: auto;">
                                                <?php foreach ($st['text_answers'] as $t): ?>
                                                    <div class="p-2 bg-white rounded-3 border small">
                                                        <div class="text-dark"><?= e($t['answer_text']) ?></div>
                                                        <small class="text-muted" style="font-size: 10px;"><?= date('d/m/Y H:i', strtotime($t['submitted_at'])) ?></small>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <small class="text-muted">ยังไม่มีข้อเสนอแนะ</small>
                                        <?php endif; ?>
                                    </div>

                                <?php else: ?>
                                    <!-- Options Breakdown -->
                                    <div class="d-flex flex-column gap-2 mt-3">
                                        <?php if (!empty($st['option_counts'])): ?>
                                            <?php 
                                            $totalOpts = array_sum($st['option_counts']) ?: 1;
                                            foreach ($st['option_counts'] as $optName => $optCount): 
                                                $pct = round(($optCount / $totalOpts) * 100);
                                            ?>
                                                <div class="d-flex align-items-center gap-2 small">
                                                    <span class="text-truncate" style="width: 140px;" title="<?= e($optName) ?>"><?= e($optName) ?></span>
                                                    <div class="progress flex-grow-1" style="height: 8px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $pct ?>%;"></div>
                                                    </div>
                                                    <span class="text-muted font-monospace" style="width: 50px; text-align: right;"><?= $optCount ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <small class="text-muted">ยังไม่มีข้อมูลคำตอบ</small>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
