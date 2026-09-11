<?php
$products = $products ?? [];
$rates = $rates ?? [];
?>
<div class="py-5 bg-navy text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-gold text-white mb-2 px-3 py-1">บริการเงินฝาก</span>
                <h1 class="text-white fw-bold display-6 mb-2">ผลิตภัณฑ์เงินฝากสหกรณ์</h1>
                <p class="text-light-blue lead mb-0">ผลตอบแทนคุ้มค่า ดอกเบี้ยสูง ปลอดภาษี เพื่อสร้างความมั่นคงทางการเงินให้แก่สมาชิกและครอบครัว</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <a href="<?= url('eservice') ?>" class="btn btn-gold btn-lg">
                    <i class="bi bi-wallet2 me-1"></i> ตรวจสอบยอดเงินฝากออนไลน์
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Products Grid -->
    <div class="row g-4 mb-5">
        <?php foreach ($products as $p): ?>
            <div class="col-lg-4 col-md-6">
                <div class="coop-card h-100 d-flex flex-column p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="rate-badge rate-badge-gold">
                            <?= number_format((float)$p['interest_rate'], 2) ?>% <small class="fs-6 fw-normal ms-1">/ปี</small>
                        </span>
                        <?php if ($p['is_featured']): ?>
                            <span class="badge bg-primary">แนะนำ</span>
                        <?php endif; ?>
                    </div>
                    
                    <h4 class="fw-bold text-navy mb-2"><?= e($p['name']) ?></h4>
                    <p class="text-muted small flex-grow-1 mb-4"><?= e($p['short_description']) ?></p>

                    <ul class="list-unstyled small mb-4">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> เปิดบัญชีขั้นต่ำ: <b><?= format_money($p['min_deposit']) ?> บาท</b></li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> เงื่อนไขการถอน: <?= e($p['withdrawal_condition']) ?></li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> สิทธิประโยชน์: ดอกเบี้ยปลอดภาษี</li>
                    </ul>

                    <div class="pt-3 border-top mt-auto d-flex gap-2">
                        <a href="<?= url('documents?cat=deposit-forms') ?>" class="btn btn-outline-primary btn-sm flex-grow-1">
                            <i class="bi bi-download me-1"></i> ดาวน์โหลดแบบฟอร์ม
                        </a>
                        <a href="<?= url('contact') ?>" class="btn btn-primary btn-sm px-3">
                            เปิดบัญชี
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Interest Rate Table -->
    <div class="coop-card p-4">
        <h4 class="fw-bold text-navy mb-3"><i class="bi bi-table me-2"></i> ประกาศอัตราดอกเบี้ยเงินฝากสหกรณ์</h4>
        <div class="table-responsive">
            <table class="table rate-table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ประเภทบัญชีเงินฝาก</th>
                        <th>อัตราดอกเบี้ย (% ต่อปี)</th>
                        <th>วันที่มีผลบังคับใช้</th>
                        <th>หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rates as $i => $r): ?>
                        <tr>
                            <td class="text-center"><?= $i + 1 ?></td>
                            <td class="fw-bold text-navy"><?= e($r['product_name']) ?></td>
                            <td class="text-end fw-bold text-primary fs-5"><?= number_format((float)$r['rate'], 2) ?>%</td>
                            <td><?= thai_date($r['effective_date']) ?></td>
                            <td><?= e($r['condition_note'] ?? 'ตามประกาศสหกรณ์') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
