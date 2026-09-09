<!-- ================================================================= -->
<!-- HEADER BANNER: คณะกรรมการดำเนินการและฝ่ายจัดการ -->
<!-- ================================================================= -->
<div class="py-5 bg-navy text-white position-relative overflow-hidden">
    <div class="container position-relative z-1">
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-gold text-white px-3 py-1 rounded-pill">โครงสร้างองค์กร</span>
            <span class="badge bg-white text-navy px-3 py-1 rounded-pill d-none d-sm-inline-block">ธรรมาภิบาล</span>
        </div>
        <h1 class="text-white fw-bold display-6 mb-2">คณะกรรมการดำเนินการและฝ่ายจัดการ</h1>
        <p class="text-light-blue lead mb-0">ผู้นำและบุคลากรผู้ขับเคลื่อนสหกรณ์ด้วยหลักธรรมาภิบาล ความโปร่งใส และความซื่อสัตย์สุจริต</p>
    </div>
</div>

<div class="container py-5">
    <!-- Navigation Tabs / Category Filter -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
        <a href="#directors" class="btn btn-outline-primary rounded-pill px-4 active">
            <i class="bi bi-people-fill me-1"></i> คณะกรรมการดำเนินการ
        </a>
        <a href="#auditors" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-shield-check me-1"></i> ผู้ตรวจสอบกิจการ
        </a>
        <a href="#advisors" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-award me-1"></i> ที่ปรึกษาสหกรณ์
        </a>
        <a href="#staff" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-person-workspace me-1"></i> ฝ่ายจัดการและเจ้าหน้าที่
        </a>
    </div>

    <!-- ================================================================= -->
    <!-- 1. คณะกรรมการดำเนินการ (Board of Directors) -->
    <!-- ================================================================= -->
    <section id="directors" class="mb-5 pb-4 border-bottom">
        <div class="text-center mb-5">
            <span class="badge bg-light-blue text-primary px-3 py-1 rounded-pill fw-bold mb-2">คณะผู้บริหารสหกรณ์</span>
            <h2 class="fw-bold text-navy">คณะกรรมการดำเนินการ</h2>
            <p class="text-muted small">ประจำปีบัญชี 2568 - 2569</p>
        </div>

        <?php if (!empty($directors)): ?>
            <?php
            // Separate President from other directors for hierarchical display
            $president = null;
            $otherDirectors = [];
            foreach ($directors as $d) {
                if (($d['sort_order'] == 1 || str_contains($d['position'], 'ประธานกรรมการ')) && !str_contains($d['position'], 'รองประธาน') && $president === null) {
                    $president = $d;
                } else {
                    $otherDirectors[] = $d;
                }
            }
            ?>

            <!-- President (Top Highlight) -->
            <?php if ($president): ?>
                <?php
                $photo = !empty($president['photo']) ? (str_starts_with($president['photo'], 'http') ? $president['photo'] : asset('img/' . $president['photo'])) : asset('img/board_placeholder.jpg');
                ?>
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="coop-card p-4 p-md-5 h-100 bg-white border border-2 border-primary border-opacity-25 rounded-4 shadow-sm position-relative">
                            <span class="position-absolute top-0 start-50 translate-middle badge bg-gold text-white px-3 py-1 rounded-pill shadow-sm">
                                <i class="bi bi-star-fill me-1"></i> ประธานกรรมการ
                            </span>
                            <div class="mb-3 mx-auto rounded-circle overflow-hidden bg-light shadow border border-3 border-white mt-2" style="width: 150px; height: 150px;">
                                <img src="<?= $photo ?>" onerror="this.onerror=null; this.src='<?= asset('img/board_placeholder.jpg') ?>';" class="w-100 h-100 object-fit-cover" alt="<?= e($president['name']) ?>">
                            </div>
                            <h5 class="fw-bold text-navy mb-1"><?= e($president['name']) ?></h5>
                            <div class="text-primary fw-bold mb-2"><?= e($president['position']) ?></div>
                            <span class="badge bg-light text-navy border small">วาระ พ.ศ. <?= e($president['term_years'] ?? '2568 - 2569') ?></span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Other Directors Grid -->
            <div class="row g-4 justify-content-center">
                <?php foreach ($otherDirectors as $b): ?>
                    <?php
                    $photo = !empty($b['photo']) ? (str_starts_with($b['photo'], 'http') ? $b['photo'] : asset('img/' . $b['photo'])) : asset('img/board_placeholder.jpg');
                    $isVice = str_contains($b['position'], 'รองประธาน');
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 text-center">
                        <div class="coop-card p-4 h-100 bg-white border rounded-4 shadow-sm hover-lift">
                            <div class="mb-3 mx-auto rounded-circle overflow-hidden bg-light shadow-sm" style="width: 130px; height: 130px;">
                                <img src="<?= $photo ?>" onerror="this.onerror=null; this.src='<?= asset('img/board_placeholder.jpg') ?>';" class="w-100 h-100 object-fit-cover" alt="<?= e($b['name']) ?>">
                            </div>
                            <h6 class="fw-bold text-navy mb-1"><?= e($b['name']) ?></h6>
                            <div class="<?= $isVice ? 'text-primary fw-semibold' : 'text-secondary small fw-medium' ?> mb-2">
                                <?= e($b['position']) ?>
                            </div>
                            <small class="text-muted d-block">วาระ พ.ศ. <?= e($b['term_years'] ?? '2568 - 2569') ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="p-5 text-center bg-light rounded-4 border">
                <i class="bi bi-people text-muted fs-1 mb-2 d-block"></i>
                <h6 class="text-navy fw-bold mb-1">อยู่ระหว่างการปรับปรุงข้อมูลคณะกรรมการ</h6>
                <p class="text-muted small mb-0">โปรดติดตามประกาศรายนามคณะกรรมการชุดใหม่เร็วๆ นี้</p>
            </div>
        <?php endif; ?>
    </section>

    <!-- ================================================================= -->
    <!-- 2. ผู้ตรวจสอบกิจการ (Auditors) -->
    <!-- ================================================================= -->
    <section id="auditors" class="mb-5 pb-4 border-bottom">
        <div class="text-center mb-5">
            <span class="badge bg-light-blue text-primary px-3 py-1 rounded-pill fw-bold mb-2">การกำกับดูแล</span>
            <h2 class="fw-bold text-navy">คณะผู้ตรวจสอบกิจการ</h2>
            <p class="text-muted small">ตรวจสอบการดำเนินงานเพื่อความโปร่งใสและถูกต้องตามระเบียบสหกรณ์</p>
        </div>

        <?php if (!empty($auditors)): ?>
            <div class="row g-4 justify-content-center">
                <?php foreach ($auditors as $a): ?>
                    <?php
                    $photo = !empty($a['photo']) ? (str_starts_with($a['photo'], 'http') ? $a['photo'] : asset('img/' . $a['photo'])) : asset('img/board_placeholder.jpg');
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 text-center">
                        <div class="coop-card p-4 h-100 bg-white border rounded-4 shadow-sm hover-lift">
                            <div class="mb-3 mx-auto rounded-circle overflow-hidden bg-light shadow-sm" style="width: 130px; height: 130px;">
                                <img src="<?= $photo ?>" onerror="this.onerror=null; this.src='<?= asset('img/board_placeholder.jpg') ?>';" class="w-100 h-100 object-fit-cover" alt="<?= e($a['name']) ?>">
                            </div>
                            <h6 class="fw-bold text-navy mb-1"><?= e($a['name']) ?></h6>
                            <div class="text-primary small fw-semibold mb-1"><?= e($a['position']) ?></div>
                            <small class="text-muted d-block">วาระ พ.ศ. <?= e($a['term_years'] ?? '2568 - 2569') ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="coop-card p-4 text-center bg-white border rounded-4 max-w-700 mx-auto">
                <div class="p-3 bg-light-blue rounded-circle d-inline-block text-primary mb-3">
                    <i class="bi bi-shield-check fs-2"></i>
                </div>
                <h5 class="fw-bold text-navy mb-2">การตรวจสอบกิจการสหกรณ์</h5>
                <p class="text-muted small mb-0">
                    สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด มีการคัดเลือกผู้ตรวจสอบกิจการที่มีคุณวุฒิและผ่านการอบรมตามเกณฑ์กรมตรวจบัญชีสหกรณ์ เพื่อรายงานผลการตรวจสอบต่อที่ประชุมใหญ่สามัญประจำปี
                </p>
            </div>
        <?php endif; ?>
    </section>

    <!-- ================================================================= -->
    <!-- 3. ที่ปรึกษาสหกรณ์ (Advisors) -->
    <!-- ================================================================= -->
    <section id="advisors" class="mb-5 pb-4 border-bottom">
        <div class="text-center mb-5">
            <span class="badge bg-light-blue text-primary px-3 py-1 rounded-pill fw-bold mb-2">คำปรึกษาและข้อเสนอแนะ</span>
            <h2 class="fw-bold text-navy">ที่ปรึกษากิตติมศักดิ์และผู้ทรงคุณวุฒิ</h2>
            <p class="text-muted small">ผู้ทรงคุณวุฒิที่ให้คำปรึกษาเชิงยุทธศาสตร์และการดำเนินงานของสหกรณ์</p>
        </div>

        <?php if (!empty($advisors)): ?>
            <div class="row g-4 justify-content-center">
                <?php foreach ($advisors as $adv): ?>
                    <?php
                    $photo = !empty($adv['photo']) ? (str_starts_with($adv['photo'], 'http') ? $adv['photo'] : asset('img/' . $adv['photo'])) : asset('img/board_placeholder.jpg');
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 text-center">
                        <div class="coop-card p-4 h-100 bg-white border rounded-4 shadow-sm hover-lift">
                            <div class="mb-3 mx-auto rounded-circle overflow-hidden bg-light shadow-sm" style="width: 130px; height: 130px;">
                                <img src="<?= $photo ?>" onerror="this.onerror=null; this.src='<?= asset('img/board_placeholder.jpg') ?>';" class="w-100 h-100 object-fit-cover" alt="<?= e($adv['name']) ?>">
                            </div>
                            <h6 class="fw-bold text-navy mb-1"><?= e($adv['name']) ?></h6>
                            <div class="text-primary small fw-semibold mb-1"><?= e($adv['position']) ?></div>
                            <small class="text-muted d-block"><?= e($adv['term_years'] ?? '') ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="coop-card p-4 text-center bg-white border rounded-4 max-w-700 mx-auto">
                <div class="p-3 bg-light-blue rounded-circle d-inline-block text-primary mb-3">
                    <i class="bi bi-award fs-2"></i>
                </div>
                <h5 class="fw-bold text-navy mb-2">ที่ปรึกษากิตติมศักดิ์</h5>
                <p class="text-muted small mb-0">
                    สหกรณ์ได้รับเกียรติจากผู้ทรงคุณวุฒิด้านการเงิน การสาธารณสุข และกฎหมาย ร่วมเป็นที่ปรึกษาในการกำหนดทิศทางการบริหารเพื่อประโยชน์สูงสุดของสมาชิก
                </p>
            </div>
        <?php endif; ?>
    </section>

    <!-- ================================================================= -->
    <!-- 4. ฝ่ายจัดการและเจ้าหน้าที่ (Management & Staff) -->
    <!-- ================================================================= -->
    <section id="staff" class="mb-4">
        <div class="text-center mb-5">
            <span class="badge bg-light-blue text-primary px-3 py-1 rounded-pill fw-bold mb-2">การให้บริการสมาชิก</span>
            <h2 class="fw-bold text-navy">ฝ่ายจัดการและเจ้าหน้าที่สหกรณ์</h2>
            <p class="text-muted small">พร้อมให้บริการด้วยความสุภาพ รวดเร็ว และเป็นมืออาชีพ</p>
        </div>

        <?php if (!empty($staffList)): ?>
            <div class="row g-4 justify-content-center">
                <?php foreach ($staffList as $st): ?>
                    <?php
                    $photo = !empty($st['photo']) ? (str_starts_with($st['photo'], 'http') ? $st['photo'] : asset('img/' . $st['photo'])) : asset('img/board_placeholder.jpg');
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 text-center">
                        <div class="coop-card p-4 h-100 bg-white border rounded-4 shadow-sm hover-lift">
                            <div class="mb-3 mx-auto rounded-circle overflow-hidden bg-light shadow-sm" style="width: 120px; height: 120px;">
                                <img src="<?= $photo ?>" onerror="this.onerror=null; this.src='<?= asset('img/board_placeholder.jpg') ?>';" class="w-100 h-100 object-fit-cover" alt="<?= e($st['name']) ?>">
                            </div>
                            <h6 class="fw-bold text-navy mb-1"><?= e($st['name']) ?></h6>
                            <div class="text-primary small fw-semibold mb-1"><?= e($st['position']) ?></div>
                            <small class="text-muted d-block"><?= e($st['department'] ?? 'สำนักงานสหกรณ์') ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Staff Department Overview Cards -->
            <div class="row g-4 justify-content-center">
                <div class="col-md-3 col-sm-6">
                    <div class="coop-card p-4 text-center bg-white border rounded-4 h-100">
                        <div class="p-3 bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px;">
                            <i class="bi bi-cash-coin fs-4"></i>
                        </div>
                        <h6 class="fw-bold text-navy mb-1">ฝ่ายสินเชื่อและเงินกู้</h6>
                        <small class="text-muted d-block mb-3">บริการคำขอกู้สามัญ ฉุกเฉิน พิเศษ</small>
                        <a href="<?= url('contact') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">ติดต่อเจ้าหน้าที่</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="coop-card p-4 text-center bg-white border rounded-4 h-100">
                        <div class="p-3 bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px;">
                            <i class="bi bi-wallet2 fs-4"></i>
                        </div>
                        <h6 class="fw-bold text-navy mb-1">ฝ่ายเงินฝากและหุ้น</h6>
                        <small class="text-muted d-block mb-3">เปิดบัญชีเงินฝาก ค่าหุ้น ปันผล</small>
                        <a href="<?= url('contact') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">ติดต่อเจ้าหน้าที่</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="coop-card p-4 text-center bg-white border rounded-4 h-100">
                        <div class="p-3 bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px;">
                            <i class="bi bi-heart-pulse-fill fs-4"></i>
                        </div>
                        <h6 class="fw-bold text-navy mb-1">ฝ่ายสวัสดิการและสมาชิก</h6>
                        <small class="text-muted d-block mb-3">สวัสดิการ 6 ประเภท สสธท. กสธท.</small>
                        <a href="<?= url('contact') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">ติดต่อเจ้าหน้าที่</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="coop-card p-4 text-center bg-white border rounded-4 h-100">
                        <div class="p-3 bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px;">
                            <i class="bi bi-calculator fs-4"></i>
                        </div>
                        <h6 class="fw-bold text-navy mb-1">ฝ่ายการเงินและบัญชี</h6>
                        <small class="text-muted d-block mb-3">ใบเสร็จรับเงิน รายงานการเงิน</small>
                        <a href="<?= url('contact') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">ติดต่อเจ้าหน้าที่</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>
