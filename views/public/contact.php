<div class="py-5 bg-navy text-white">
    <div class="container-xl">
        <span class="badge bg-gold text-white mb-2 px-3 py-1">ช่องทางการติดต่อ</span>
        <h1 class="text-white fw-bold display-6 mb-2">ติดต่อสหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</h1>
        <p class="text-light-blue lead mb-0">พร้อมให้บริการและคำปรึกษาทางการเงินแก่สมาชิกทุกท่าน</p>
    </div>
</div>

<div class="container-xl py-5">
    <?php if ($success = flash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> <?= e($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($error = flash('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= e($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-5">
        <!-- Contact Info & Google Maps -->
        <div class="col-lg-5">
            <div class="coop-card p-4 p-md-5 mb-4">
                <h4 class="fw-bold text-navy mb-4"><i class="bi bi-geo-alt-fill text-danger me-2"></i> สำนักงานใหญ่</h4>
                
                <div class="d-flex mb-3">
                    <i class="bi bi-pin-map text-primary fs-5 me-3 flex-shrink-0 mt-1"></i>
                    <div>
                        <b class="d-block text-navy">ที่อยู่:</b>
                        <span class="text-muted small"><?= e(config('app.coop.address')) ?></span>
                        <div class="mt-2">
                            <a href="https://maps.google.com/?q=<?= urlencode(config('app.coop.name') . ' ' . config('app.coop.address')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-primary" aria-label="เปิดแผนที่นำทางใน Google Maps">
                                <i class="bi bi-compass me-1"></i> เปิดแผนที่นำทาง (Google Maps)
                            </a>
                        </div>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <i class="bi bi-telephone text-primary fs-5 me-3 flex-shrink-0 mt-1"></i>
                    <div>
                        <b class="d-block text-navy">หมายเลขโทรศัพท์:</b>
                        <a href="tel:<?= preg_replace('/[^0-9]/', '', (string)config('app.coop.phone')) ?>" class="text-decoration-none text-navy fw-semibold" aria-label="โทรติดต่อ <?= e(config('app.coop.phone')) ?>">
                            <?= e(config('app.coop.phone')) ?>
                        </a>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <i class="bi bi-envelope text-primary fs-5 me-3 flex-shrink-0 mt-1"></i>
                    <div>
                        <b class="d-block text-navy">อีเมล:</b>
                        <a href="mailto:<?= e(config('app.coop.email')) ?>" class="text-decoration-none text-navy fw-semibold" aria-label="ส่งอีเมลถึง <?= e(config('app.coop.email')) ?>">
                            <?= e(config('app.coop.email')) ?>
                        </a>
                    </div>
                </div>

                <div class="d-flex">
                    <i class="bi bi-clock text-primary fs-5 me-3 flex-shrink-0 mt-1"></i>
                    <div>
                        <b class="d-block text-navy">เวลาทำการ:</b>
                        <span class="text-muted small"><?= e(config('app.coop.office_hours')) ?></span>
                    </div>
                </div>
            </div>

            <!-- Map Embed -->
            <div class="coop-card overflow-hidden" style="height: 260px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.7525381831825!2d101.24838647579148!3d12.678128587609279!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3102f835b3c38fbb%3A0x6fb708bf93c68ea7!2sRayong%20Provincial%20Public%20Health%20Office!5e0!3m2!1sen!2sth!4v1700000000000!5m2!1sen!2sth" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" title="แผนที่ที่ตั้งสำนักงานสหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด"></iframe>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-7">
            <div class="coop-card p-4 p-md-5">
                <h4 class="fw-bold text-navy mb-2"><i class="bi bi-send text-primary me-2"></i> ส่งข้อความถึงเรา</h4>
                <p class="text-muted small mb-4">กรอกข้อมูลด้านล่างเพื่อส่งข้อความสอบถามหรือข้อเสนอแนะ</p>

                <form id="publicContactForm" action="<?= url('contact/submit') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contact_name" class="form-label fw-bold small">ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                            <input type="text" id="contact_name" name="name" class="form-control" placeholder="ระบุชื่อและนามสกุล" required>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_phone" class="form-label fw-bold small">เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                            <input type="tel" id="contact_phone" name="phone" class="form-control" placeholder="เช่น 0812345678" required>
                        </div>
                        <div class="col-md-12">
                            <label for="contact_email" class="form-label fw-bold small">อีเมล <span class="text-danger">*</span></label>
                            <input type="email" id="contact_email" name="email" class="form-control" placeholder="example@domain.com" required>
                        </div>
                        <div class="col-md-12">
                            <label for="contact_subject" class="form-label fw-bold small">เรื่องที่ต้องการติดต่อ <span class="text-danger">*</span></label>
                            <input type="text" id="contact_subject" name="subject" class="form-control" placeholder="เช่น สอบถามข้อมูลเงินฝาก / สินเชื่อ" required>
                        </div>
                        <div class="col-md-12">
                            <label for="contact_message" class="form-label fw-bold small">ข้อความ <span class="text-danger">*</span></label>
                            <textarea id="contact_message" name="message" rows="5" class="form-control" placeholder="ระบุรายละเอียดที่ต้องการสอบถาม..." required></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold">
                                <i class="bi bi-send-fill me-2"></i> ส่งข้อความ
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
