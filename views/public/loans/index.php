<?php
$products = $products ?? [];
$schedules = $schedules ?? [];
?>
<div class="py-5 bg-navy text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-gold text-white mb-2 px-3 py-1">บริการสินเชื่อ</span>
                <h1 class="text-white fw-bold display-6 mb-2">สินเชื่อและเงินกู้สหกรณ์</h1>
                <p class="text-light-blue lead mb-0">อัตราดอกเบี้ยต่ำแบบลดต้นลดดอก อนุมัติไว วงเงินกู้สูง เพื่อเสริมสภาพคล่องและพัฒนาคุณภาพชีวิตของสมาชิก</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <a href="<?= url('calculator') ?>" class="btn btn-gold btn-lg shadow">
                    <i class="bi bi-calculator me-1"></i> คำนวณเงินกู้ออนไลน์
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Loan Products Grid -->
    <div class="row g-4 mb-5">
        <?php foreach ($products as $p): ?>
            <div class="col-lg-4 col-md-6">
                <div class="coop-card h-100 d-flex flex-column p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="rate-badge">
                            <?= number_format((float)$p['interest_rate'], 2) ?>% <small class="fs-6 fw-normal ms-1">/ปี</small>
                        </span>
                        <span class="badge bg-light text-navy border">ผ่อนนานสูงสุด <?= e($p['max_term_months']) ?> งวด</span>
                    </div>

                    <h4 class="fw-bold text-navy mb-2"><?= e($p['name']) ?></h4>
                    <p class="text-muted small flex-grow-1 mb-4"><?= e($p['short_description']) ?></p>

                    <div class="bg-light p-3 rounded-3 mb-4 small">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">วงเงินกู้สูงสุด:</span>
                            <span class="fw-bold text-navy"><?= format_money($p['max_loan_limit']) ?> บาท</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">รูปแบบดอกเบี้ย:</span>
                            <span class="fw-bold text-success"><?= $p['calculation_type'] === 'effective' ? 'ลดต้นลดดอก' : 'คงที่' ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">คุณสมบัติ:</span>
                            <span class="text-truncate ms-2" style="max-width: 160px;"><?= e($p['eligibility']) ?></span>
                        </div>
                    </div>

                    <div class="pt-3 border-top mt-auto d-flex gap-2">
                        <a href="<?= url('documents?cat=loan-forms') ?>" class="btn btn-outline-primary btn-sm flex-grow-1">
                            <i class="bi bi-file-earmark-arrow-down me-1"></i> แบบฟอร์มคำขอ
                        </a>
                        <a href="<?= url('calculator') ?>" class="btn btn-primary btn-sm px-3">
                            <i class="bi bi-calculator"></i> คำนวณ
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Loan Schedules Timeline -->
    <?php if (!empty($schedules)): ?>
    <div class="coop-card p-4 mb-5">
        <h4 class="fw-bold text-navy mb-3"><i class="bi bi-calendar-event me-2 text-primary"></i> ปฏิทินกำหนดยื่นกู้และจ่ายเงินกู้</h4>
        <div class="table-responsive">
            <table class="table rate-table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>รอบประจำเดือน</th>
                        <th>วันสุดท้ายของการยื่นเอกสาร</th>
                        <th>วันที่ประชุมพิจารณาอนุมัติ</th>
                        <th>วันโอนเงินเข้าบัญชี</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schedules as $s): ?>
                        <tr>
                            <td class="fw-bold text-navy"><?= e($s['title']) ?></td>
                            <td class="text-danger fw-semibold"><?= thai_date($s['submission_deadline']) ?></td>
                            <td><?= thai_date($s['approval_date']) ?></td>
                            <td class="text-success fw-bold"><?= thai_date($s['disbursement_date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>
