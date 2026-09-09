<footer class="main-footer">
    <div class="container-xl pb-5">
        <div class="row g-4">
            <!-- Col 1: Coop Info -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <img src="<?= asset('img/logo.webp') ?>" alt="<?= e(config('app.coop.short_name')) ?>" class="me-2 rounded-3 bg-white p-1" style="height: 48px; width: auto; object-fit: contain;">
                    <div>
                        <h5 class="text-white fw-bold mb-0"><?= config('app.coop.short_name') ?></h5>
                        <small class="text-light-blue"><?= config('app.coop.full_name_en') ?></small>
                    </div>
                </div>
                <p class="small text-muted-coop mb-3">
                    <?= config('app.coop.address') ?>
                </p>
                <div class="d-flex flex-column gap-2 small text-light mb-3">
                    <div><i class="bi bi-telephone text-primary me-2"></i> โทรศัพท์: <?= config('app.coop.phone') ?></div>
                    <div><i class="bi bi-printer text-primary me-2"></i> โทรสาร: <?= config('app.coop.fax') ?></div>
                    <div><i class="bi bi-envelope text-primary me-2"></i> อีเมล: <?= config('app.coop.email') ?></div>
                    <div><i class="bi bi-clock text-primary me-2"></i> เวลาทำการ: <?= config('app.coop.office_hours') ?></div>
                </div>
            </div>

            <!-- Col 2: Services -->
            <div class="col-lg-2 col-md-6 col-6">
                <h6 class="footer-title">บริการทางการเงิน</h6>
                <ul class="footer-links">
                    <li><a href="<?= url('deposits') ?>"><i class="bi bi-chevron-right me-1 small"></i> เงินฝากออมทรัพย์</a></li>
                    <li><a href="<?= url('deposits') ?>"><i class="bi bi-chevron-right me-1 small"></i> เงินฝากประจำ</a></li>
                    <li><a href="<?= url('loans') ?>"><i class="bi bi-chevron-right me-1 small"></i> เงินกู้สามัญ</a></li>
                    <li><a href="<?= url('loans') ?>"><i class="bi bi-chevron-right me-1 small"></i> เงินกู้เพื่อเคหะฯ</a></li>
                    <li><a href="<?= url('calculator') ?>"><i class="bi bi-chevron-right me-1 small"></i> คำนวณเงินกู้</a></li>
                    <li><a href="<?= url('dividend-estimator') ?>"><i class="bi bi-chevron-right me-1 small"></i> ประมาณการเงินปันผล</a></li>
                    <li><a href="<?= url('rates') ?>"><i class="bi bi-chevron-right me-1 small"></i> ตารางอัตราดอกเบี้ย</a></li>
                </ul>
            </div>

            <!-- Col 3: Member Services -->
            <div class="col-lg-3 col-md-6 col-6">
                <h6 class="footer-title">บริการสมาชิก</h6>
                <ul class="footer-links">
                    <li><a href="<?= url('eservice') ?>"><i class="bi bi-chevron-right me-1 small"></i> ระบบ E-Service สมาชิก</a></li>
                    <li><a href="<?= url('welfare') ?>"><i class="bi bi-chevron-right me-1 small"></i> สวัสดิการสงเคราะห์</a></li>
                    <li><a href="<?= url('surveys/member-satisfaction-2569') ?>"><i class="bi bi-chevron-right me-1 small text-primary"></i> แบบสำรวจความพึงพอใจ</a></li>
                    <li><a href="<?= url('documents') ?>"><i class="bi bi-chevron-right me-1 small"></i> ดาวน์โหลดแบบฟอร์ม</a></li>
                    <li><a href="<?= url('documents?cat=regulations') ?>"><i class="bi bi-chevron-right me-1 small"></i> ระเบียบและข้อบังคับ</a></li>
                    <li><a href="<?= url('complaints') ?>"><i class="bi bi-chevron-right me-1 small"></i> ศูนย์รับเรื่องร้องเรียน</a></li>
                    <li><a href="<?= url('faqs') ?>"><i class="bi bi-chevron-right me-1 small"></i> คำถามที่พบบ่อย (FAQ)</a></li>
                </ul>
            </div>

            <!-- Col 4: Privacy & Legal -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-title">นโยบายและความปลอดภัย</h6>
                <ul class="footer-links mb-3">
                    <li><a href="<?= url('privacy/policy') ?>"><i class="bi bi-shield-check me-1"></i> นโยบายคุ้มครองข้อมูลส่วนบุคคล (PDPA)</a></li>
                    <li><a href="<?= url('privacy/cookies') ?>"><i class="bi bi-cookie me-1"></i> นโยบายการใช้คุกกี้ (Cookie Policy)</a></li>
                    <li><a href="<?= url('terms') ?>"><i class="bi bi-file-earmark-text me-1"></i> ข้อกำหนดและเงื่อนไขการใช้งาน</a></li>
                    <li><a href="javascript:void(0)" class="btn-open-cookie-settings text-primary"><i class="bi bi-sliders me-1"></i> การตั้งค่าคุกกี้ (Cookie Settings)</a></li>
                </ul>
                <div class="p-3 bg-dark rounded-3 border border-secondary border-opacity-25">
                    <small class="d-block text-muted mb-1"><i class="bi bi-lock-fill text-success me-1"></i> ช่องทางเจ้าหน้าที่</small>
                    <a href="<?= url('login') ?>" class="btn btn-sm btn-outline-light w-100" style="font-size: 0.8rem;">
                        <i class="bi bi-person-lock me-1"></i> เข้าสู่ระบบเจ้าหน้าที่ (Admin CMS)
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container-xl d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <div>
                © <?= date('Y') + 543 ?> <?= config('app.coop.full_name_th') ?>. All Rights Reserved.
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-secondary bg-opacity-25 text-light">v<?= config('app.version') ?></span>
                <a href="#top" class="text-secondary text-decoration-none small"><i class="bi bi-arrow-up-circle fs-5"></i> กลับสู่ด้านบน</a>
            </div>
        </div>
    </div>
</footer>
