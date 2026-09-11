<?php
use App\Core\Auth;

$eservices = $eservices ?? [];
$isLoggedIn = Auth::check();
$portalUrl = $isLoggedIn ? url('member/dashboard') : url('login');
?>

<!-- Header Banner -->
<div class="py-5 bg-navy text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #072C59 0%, #0066CC 60%, #0284C7 100%);">
    <div class="position-absolute end-0 top-0 bottom-0 d-none d-lg-block opacity-10 pe-5 pt-3 pointer-events-none" style="font-size: 160px;">
        <i class="bi bi-grid-3x3-gap-fill"></i>
    </div>
    <div class="container-xl position-relative z-1">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-gold text-white px-3 py-1 rounded-pill fw-bold">
                        <i class="bi bi-shield-check me-1"></i> ปลอดภัย มาตรฐานสากล 24 ชม.
                    </span>
                    <span class="badge bg-white text-navy px-3 py-1 rounded-pill fw-bold">
                        <i class="bi bi-stars text-warning me-1"></i> Digital E-Services
                    </span>
                </div>
                <h1 class="text-white fw-bold display-6 mb-2">ศูนย์บริการออนไลน์และบริการเฉพาะกิจ (E-Service Gateway)</h1>
                <p class="text-white-70 lead mb-0" style="font-size: 1.05rem; max-width: 700px;">
                    ประตูสู่บริการดิจิทัลครบวงจรสำหรับสมาชิกสหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด — ตรวจสอบหุ้น เงินฝาก สินเชื่อ สวัสดิการ ยื่นกู้ออนไลน์ และสมาคมฌาปนกิจ
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?= $portalUrl ?>" class="btn btn-light text-navy fw-bold px-4 py-3 rounded-pill shadow-sm d-inline-flex align-items-center gap-2 hover-lift">
                    <i class="bi bi-person-circle fs-5 text-primary"></i>
                    <span><?= $isLoggedIn ? 'ไปที่ Member Portal' : 'เข้าสู่ระบบสมาชิกดิจิทัล' ?></span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container-xl py-5">
    <!-- Featured Quick Access Tools Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-5 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #072C59 0%, #0F6292 50%, #0066CC 100%);">
        <div class="row align-items-center g-4">
            <div class="col-auto">
                <div class="bg-white text-primary rounded-4 p-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 68px; height: 68px; font-size: 32px;">
                    <i class="bi bi-laptop-fill"></i>
                </div>
            </div>
            <div class="col">
                <div class="badge bg-white text-navy fw-bold mb-1 px-3 py-1 rounded-pill">ระบบบริหารจัดการหลัก</div>
                <h4 class="fw-bold mb-1 text-white">ระบบสมาชิกสหกรณ์ดิจิทัล (RayongCoop Member Portal)</h4>
                <p class="text-white-70 mb-0 small" style="max-width: 750px;">
                    เข้าถึงข้อมูลหุ้นสะสม สมุดเงินฝากอิเล็กทรอนิกส์ (E-Passbook) ยื่นคำขอกู้เงินออนไลน์ (Loan Wizard) ใบเสร็จดิจิทัลพร้อม QR Code และยื่นขอสวัสดิการเฉพาะกิจ
                </p>
            </div>
            <div class="col-lg-auto">
                <a href="<?= $portalUrl ?>" class="btn btn-warning text-navy fw-bold px-4 py-2 rounded-pill shadow-sm hover-lift">
                    <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบทันที
                </a>
            </div>
        </div>
    </div>

    <!-- Specialized Self-Service Quick Tools -->
    <div class="mb-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
            <div>
                <h4 class="fw-bold text-navy mb-1">
                    <i class="bi bi-lightning-charge-fill text-warning me-2"></i>เครื่องมือและบริการเฉพาะกิจ (Specialized Tools)
                </h4>
                <p class="text-muted small mb-0">เครื่องมือคำนวณและบริการสาธารณะที่สามารถเข้าใช้งานได้ทันทีโดยไม่ต้องล็อกอิน</p>
            </div>
        </div>
        <div class="row g-3">
            <!-- Tool 1: Dividend Estimator -->
            <div class="col-lg-4 col-md-6">
                <a href="<?= url('dividend-estimator') ?>" class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white text-decoration-none hover-lift d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-4 p-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 22px;">
                                <i class="bi bi-pie-chart-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-navy mb-1">ประมาณการเงินปันผล & เฉลี่ยคืน</h6>
                                <span class="badge bg-light text-warning border font-monospace" style="font-size: 11px;">จำลองผลตอบแทน</span>
                            </div>
                        </div>
                        <p class="text-muted small mb-3">
                            คำนวณเงินปันผลค่าหุ้นและเงินเฉลี่ยคืนดอกเบี้ยเงินกู้ประจำปีตามยอดสะสมของท่าน
                        </p>
                    </div>
                    <span class="text-primary fw-semibold small d-inline-flex align-items-center">
                        เปิดเครื่องมือคำนวณ <i class="bi bi-arrow-right ms-1"></i>
                    </span>
                </a>
            </div>

            <!-- Tool 2: Loan Readiness Checklist -->
            <div class="col-lg-4 col-md-6">
                <a href="<?= url('loans/checklist') ?>" class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white text-decoration-none hover-lift d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-4 p-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 22px;">
                                <i class="bi bi-check2-square"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-navy mb-1">ตรวจสอบความพร้อมยื่นกู้เงิน</h6>
                                <span class="badge bg-light text-primary border font-monospace" style="font-size: 11px;">Loan Readiness</span>
                            </div>
                        </div>
                        <p class="text-muted small mb-3">
                            เช็คลิสต์ตรวจสอบคุณสมบัติและเอกสารประกอบการขอกู้เงินฉุกเฉิน สามัญ และพิเศษ
                        </p>
                    </div>
                    <span class="text-primary fw-semibold small d-inline-flex align-items-center">
                        เริ่มตรวจสอบความพร้อม <i class="bi bi-arrow-right ms-1"></i>
                    </span>
                </a>
            </div>

            <!-- Tool 3: Loan Installment Calculator -->
            <div class="col-lg-4 col-md-6">
                <a href="<?= url('calculator') ?>" class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white text-decoration-none hover-lift d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-4 p-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 22px;">
                                <i class="bi bi-calculator-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-navy mb-1">คำนวณค่างวดเงินกู้รายเดือน</h6>
                                <span class="badge bg-light text-success border font-monospace" style="font-size: 11px;">Loan Calculator</span>
                            </div>
                        </div>
                        <p class="text-muted small mb-3">
                            คำนวณยอดผ่อนชำระเงินต้นและดอกเบี้ยรายเดือนตามวงเงินและระยะเวลาที่เลือก
                        </p>
                    </div>
                    <span class="text-primary fw-semibold small d-inline-flex align-items-center">
                        คำนวณค่างวดทันที <i class="bi bi-arrow-right ms-1"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>

    <!-- Category Filter Tabs & Connected Systems -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-2 border-bottom">
        <div>
            <h4 class="fw-bold text-navy mb-1">
                <i class="bi bi-grid-3x3-gap-fill text-primary me-2"></i>บริการและระบบที่เชื่อมต่อทั้งหมด
            </h4>
            <p class="text-muted small mb-0">เลือกระบบที่ต้องการเข้าใช้งาน ทั้งระบบภายในและหน่วยงานภายนอกที่เกี่ยวข้อง</p>
        </div>
        <div class="btn-group rounded-pill p-1 bg-light border" role="group" id="eserviceFilterGroup">
            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 active" onclick="filterServices('all', this)">ทั้งหมด</button>
            <button type="button" class="btn btn-sm btn-light rounded-pill px-3" onclick="filterServices('internal', this)">ระบบสหกรณ์</button>
            <button type="button" class="btn btn-sm btn-light rounded-pill px-3" onclick="filterServices('external', this)">หน่วยงานภายนอก</button>
        </div>
    </div>

    <!-- Service Cards Grid -->
    <div class="row g-4" id="serviceCardsContainer">
        <?php foreach ($eservices as $es): ?>
            <?php
            $isExternal = in_array($es['category'] ?? '', ['external', 'association']) || !empty($es['confirm_before_redirect']);
            $targetUrl = match($es['id']) {
                1 => url('member/dashboard'),
                2 => url('member/deposits'),
                3 => url('member/loan-apply'),
                default => e($es['url'])
            };
            $cardCategory = $isExternal ? 'external' : 'internal';
            ?>
            <div class="col-lg-6 service-item" data-category="<?= $cardCategory ?>">
                <div class="coop-card p-4 h-100 d-flex flex-column justify-content-between border rounded-4 shadow-sm bg-white hover-lift">
                    <div>
                        <div class="d-flex align-items-start mb-3">
                            <div class="quick-service-icon me-3 flex-shrink-0 rounded-4 d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; background: linear-gradient(135deg, #072C59 0%, #0066CC 100%); color: #fff; font-size: 24px;">
                                <i class="bi <?= e($es['icon']) ?>"></i>
                            </div>
                            <div>
                                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                    <h5 class="fw-bold text-navy mb-0"><?= e($es['name']) ?></h5>
                                    <?php if (!empty($es['is_maintenance'])): ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill font-monospace" style="font-size: 11px;">ปิดปรับปรุงชั่วคราว</span>
                                    <?php else: ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill font-monospace" style="font-size: 11px;">เปิดให้บริการปกติ</span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-muted small mb-0 mt-2" style="line-height: 1.5;"><?= e($es['description']) ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
                        <small class="text-muted d-flex align-items-center">
                            <i class="bi bi-shield-check text-success fs-6 me-1"></i> 
                            <?= $isExternal ? 'ลิงก์ภายนอก • มีระบบยืนยันความปลอดภัย' : 'ระบบเชื่อมต่อภายในสหกรณ์' ?>
                        </small>
                        <?php if (!empty($es['is_maintenance'])): ?>
                            <button class="btn btn-secondary btn-sm rounded-pill px-4" disabled>อยู่ระหว่างปิดปรับปรุง</button>
                        <?php else: ?>
                            <a href="<?= $targetUrl ?>" 
                               class="btn btn-primary btn-sm rounded-pill px-4 fw-semibold" 
                               data-confirm-external="<?= $isExternal ? '1' : '0' ?>" 
                               data-service-name="<?= e($es['name']) ?>"
                               <?= $isExternal ? 'target="_blank"' : '' ?>>
                                เข้าใช้งานระบบ <i class="bi <?= $isExternal ? 'bi-box-arrow-up-right' : 'bi-arrow-right' ?> ms-1"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Security & Assistance Box -->
    <div class="row g-4 mt-4">
        <div class="col-md-6">
            <div class="p-4 bg-light rounded-4 border h-100">
                <h6 class="fw-bold text-navy mb-2"><i class="bi bi-shield-lock-fill text-primary me-2"></i>คำแนะนำความปลอดภัยในการใช้งาน</h6>
                <ul class="text-muted small mb-0 ps-3">
                    <li class="mb-1">ห้ามเปิดเผย Username และ Password ของท่านแก่บุคคลอื่น</li>
                    <li class="mb-1">สหกรณ์ไม่มีนโยบายสอบถามรหัสผ่านหรือรหัส OTP ผ่านทางโทรศัพท์หรือข้อความ SMS</li>
                    <li>ควรออกจากระบบ (Logout) ทุกครั้งหลังเสร็จสิ้นการใช้งานบนอุปกรณ์สาธารณะ</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-4 bg-light rounded-4 border h-100">
                <h6 class="fw-bold text-navy mb-2"><i class="bi bi-headset text-primary me-2"></i>ต้องการความช่วยเหลือในการเข้าใช้งาน?</h6>
                <p class="text-muted small mb-2">หากท่านพบปัญหาในการเข้าสู่ระบบ ลืมรหัสผ่าน หรือต้องการความช่วยเหลือด้านธุรกรรม</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="<?= url('contact') ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-telephone me-1"></i> ติดต่อเจ้าหน้าที่
                    </a>
                    <a href="<?= url('faqs') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="bi bi-question-circle me-1"></i> คำถามที่พบบ่อย (FAQs)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterServices(category, btn) {
    document.querySelectorAll('#eserviceFilterGroup button').forEach(b => {
        b.classList.remove('btn-primary', 'active');
        b.classList.add('btn-light');
    });
    btn.classList.remove('btn-light');
    btn.classList.add('btn-primary', 'active');

    const items = document.querySelectorAll('.service-item');
    items.forEach(item => {
        if (category === 'all' || item.getAttribute('data-category') === category) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
