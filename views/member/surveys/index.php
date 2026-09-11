<?php
$surveys = $surveys ?? [];
?>
<div class="row g-4">
    <!-- Header -->
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 bg-white p-4 rounded-4 shadow-sm border">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item"><a href="<?= url('member/dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">แบบสำรวจสมาชิก</li>
                    </ol>
                </nav>
                <h4 class="fw-bold text-navy mb-1"><i class="bi bi-card-checklist me-2 text-primary"></i> แบบสำรวจความพึงพอใจและโพลล์สมาชิก</h4>
                <p class="text-muted small mb-0">ร่วมแสดงความคิดเห็นเพื่อร่วมเป็นส่วนหนึ่งในการพัฒนาบริการและสวัสดิการของสหกรณ์</p>
            </div>
            <div>
                <a href="<?= url('member/dashboard') ?>" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> กลับสู่ Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Surveys List -->
    <div class="col-12">
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h6 class="fw-bold text-navy mb-0"><i class="bi bi-ui-checks me-2 text-primary"></i> แบบสำรวจที่เปิดรับความคิดเห็นในขณะนี้</h6>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($surveys)): ?>
                    <div class="row g-3">
                        <?php foreach ($surveys as $s): ?>
                            <div class="col-lg-6">
                                <div class="card h-100 border rounded-4 p-4 shadow-sm hover-shadow transition-all" style="background-color: #FAFCFF;">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1">
                                            เปิดรับถึง: <?= !empty($s['end_date']) ? date('d/m/Y', strtotime($s['end_date'])) : 'ต่อเนื่อง' ?>
                                        </span>
                                        <?php if (!empty($s['has_responded'])): ?>
                                            <span class="badge bg-success rounded-pill px-3 py-1"><i class="bi bi-check-circle-fill me-1"></i> ตอบแล้ว</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1"><i class="bi bi-clock-history me-1"></i> รอการตอบ</span>
                                        <?php endif; ?>
                                    </div>

                                    <h5 class="fw-bold text-navy mb-2"><?= e($s['title']) ?></h5>
                                    <p class="text-muted small mb-3 flex-grow-1 line-clamp-2">
                                        <?= e($s['description'] ?? 'ขอความร่วมมือสมาชิกร่วมประเมินความพึงพอใจการให้บริการ') ?>
                                    </p>

                                    <div class="d-flex gap-2 mt-auto">
                                        <?php if (empty($s['has_responded']) || !empty($s['allow_multiple_responses'])): ?>
                                            <a href="<?= url('member/surveys/' . $s['id']) ?>" class="btn btn-primary rounded-pill w-100 fw-semibold py-2">
                                                <i class="bi bi-pencil-square me-1"></i> เริ่มทำแบบสำรวจ
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-outline-success rounded-pill w-100 py-2" disabled>
                                                <i class="bi bi-check2-all me-1"></i> บันทึกความคิดเห็นแล้ว
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="text-muted mb-3"><i class="bi bi-clipboard-check fs-1"></i></div>
                        <h6 class="fw-bold text-secondary">ไม่มีแบบสำรวจที่เปิดรับในขณะนี้</h6>
                        <p class="text-muted small">เมื่อสหกรณ์มีแบบประเมินหรือโพลล์ใหม่ จะปรากฏในหน้านี้ทันที</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
