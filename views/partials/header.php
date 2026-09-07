<?php
use App\Core\Auth;

$isLoggedIn = Auth::check();
$authUser = Auth::user();
$authRole = $authUser['role_slug'] ?? 'member';

$portalUrl = match($authRole) {
    'staff' => url('staff/dashboard'),
    'super_admin', 'admin' => url('admin/dashboard'),
    default => url('member/dashboard')
};

$portalName = match($authRole) {
    'staff' => 'Staff Dashboard',
    'super_admin', 'admin' => 'Admin Dashboard',
    default => 'พอร์ทัลสมาชิก'
};
?>

<header class="main-header border-bottom sticky-top bg-white shadow-sm" style="z-index: 1020;">
    <div class="container-xl position-relative">
        <nav class="navbar navbar-expand-xl navbar-light py-2">
            <!-- Brand Logo & Name (Member Portal Style) -->
            <a class="navbar-brand d-flex align-items-center py-0 me-3" href="<?= url('/') ?>">
                <div class="brand-icon me-2 d-flex align-items-center justify-content-center text-white rounded-3 shadow-sm" style="width: 44px; height: 44px; background: linear-gradient(135deg, #073B74 0%, #0066CC 100%);">
                    <i class="bi bi-bank2 fs-4"></i>
                </div>
                <div>
                    <div class="brand-text-main fw-bold text-navy" style="font-size: 1.15rem; line-height: 1.2; letter-spacing: -0.01em;"><?= config('app.coop.short_name') ?></div>
                    <div class="brand-text-sub text-muted small d-none d-sm-block" style="font-size: 0.72rem;"><?= config('app.coop.full_name_th') ?></div>
                </div>
            </a>

            <!-- Mobile Controls -->
            <div class="d-flex align-items-center d-xl-none ms-auto gap-2">
                <?php if ($isLoggedIn): ?>
                    <a href="<?= $portalUrl ?>" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?= url('login') ?>" class="btn btn-navy btn-sm rounded-pill px-3 shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบ
                    </a>
                <?php endif; ?>
                <button class="navbar-toggler border-0 shadow-none p-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuOffcanvas" aria-controls="mobileMenuOffcanvas" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <!-- Desktop Menu (All Categories as Rich Mega Menus) -->
            <div class="collapse navbar-collapse" id="desktopNavbar">
                <ul class="navbar-nav mx-auto align-items-center mb-2 mb-xl-0 gap-1">
                    <!-- 1. หน้าแรก -->
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill fw-medium <?= $request->uri() === '/' ? 'active text-primary fw-bold bg-light' : 'text-dark' ?>" href="<?= url('/') ?>">
                            <i class="bi bi-house-door me-1"></i> หน้าแรก
                        </a>
                    </li>

                    <!-- 2. Mega Menu: เกี่ยวกับสหกรณ์ -->
                    <li class="nav-item dropdown has-megamenu">
                        <a class="nav-link dropdown-toggle px-3 rounded-pill fw-medium <?= in_array($request->uri(), ['/about', '/board', '/statistics', '/complaints']) ? 'active text-primary fw-bold bg-light' : 'text-dark' ?>" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-building me-1"></i> เกี่ยวกับสหกรณ์
                        </a>
                        <div class="dropdown-menu megamenu-dropdown shadow-lg border-0 rounded-4 p-4">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <h6 class="fw-bold text-navy mb-3 pb-2 border-bottom"><i class="bi bi-building me-1 text-primary"></i> ข้อมูลองค์กร</h6>
                                    <a class="megamenu-item-link" href="<?= url('about') ?>">
                                        <div class="megamenu-icon"><i class="bi bi-shield-check"></i></div>
                                        <div>
                                            <div class="fw-semibold">ประวัติและวิสัยทัศน์</div>
                                            <small class="text-muted">ความเป็นมา ค่านิยม พันธกิจ</small>
                                        </div>
                                    </a>
                                    <a class="megamenu-item-link" href="<?= url('board') ?>">
                                        <div class="megamenu-icon"><i class="bi bi-people"></i></div>
                                        <div>
                                            <div class="fw-semibold">คณะกรรมการดำเนินการ</div>
                                            <small class="text-muted">โครงสร้างการบริหารและฝ่ายจัดการ</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold text-navy mb-3 pb-2 border-bottom"><i class="bi bi-graph-up-arrow me-1 text-primary"></i> ผลการดำเนินงาน</h6>
                                    <a class="megamenu-item-link" href="<?= url('statistics') ?>">
                                        <div class="megamenu-icon"><i class="bi bi-pie-chart"></i></div>
                                        <div>
                                            <div class="fw-semibold">ฐานะการเงินและสถิติ</div>
                                            <small class="text-muted">ทุนเรือนหุ้น เงินฝาก สินเชื่อ</small>
                                        </div>
                                    </a>
                                    <a class="megamenu-item-link" href="<?= url('documents?cat=annual-reports') ?>">
                                        <div class="megamenu-icon"><i class="bi bi-file-earmark-bar-graph"></i></div>
                                        <div>
                                            <div class="fw-semibold">รายงานประจำปี</div>
                                            <small class="text-muted">งบแสดงฐานะการเงินรายปี</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-light-blue rounded-4 border h-100 d-flex flex-column justify-content-between">
                                        <div>
                                            <h6 class="fw-bold text-navy mb-2"><i class="bi bi-shield-lock me-1 text-primary"></i> ธรรมาภิบาลและความโปร่งใส</h6>
                                            <p class="small text-muted mb-3">ยึดมั่นการดำเนินงานตามหลักธรรมาภิบาล มั่นคง โปร่งใส และตรวจสอบได้ในทุกขั้นตอน</p>
                                        </div>
                                        <a href="<?= url('complaints') ?>" class="btn btn-sm btn-primary w-100 fw-medium rounded-pill">
                                            <i class="bi bi-chat-left-dots me-1"></i> ศูนย์รับเรื่องร้องเรียน
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- 3. Mega Menu: บริการทางการเงิน (เงินฝาก, สินเชื่อ, คำนวณเงินกู้) -->
                    <li class="nav-item dropdown has-megamenu">
                        <a class="nav-link dropdown-toggle px-3 rounded-pill fw-medium <?= in_array($request->uri(), ['/deposits', '/loans', '/calculator', '/rates']) ? 'active text-primary fw-bold bg-light' : 'text-dark' ?>" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-wallet2 me-1"></i> บริการทางการเงิน
                        </a>
                        <div class="dropdown-menu megamenu-dropdown shadow-lg border-0 rounded-4 p-4">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <h6 class="fw-bold text-navy mb-3 pb-2 border-bottom"><i class="bi bi-piggy-bank me-1 text-success"></i> ผลิตภัณฑ์เงินฝาก</h6>
                                    <a class="megamenu-item-link" href="<?= url('deposits') ?>">
                                        <div class="megamenu-icon text-success" style="background-color: #E8F5E9;"><i class="bi bi-wallet2"></i></div>
                                        <div>
                                            <div class="fw-semibold">เงินฝากออมทรัพย์</div>
                                            <small class="text-muted">คล่องตัว ดอกเบี้ยสูง ปลอดภาษี</small>
                                        </div>
                                    </a>
                                    <a class="megamenu-item-link" href="<?= url('deposits') ?>">
                                        <div class="megamenu-icon text-success" style="background-color: #E8F5E9;"><i class="bi bi-safe2"></i></div>
                                        <div>
                                            <div class="fw-semibold">เงินฝากออมทรัพย์พิเศษ</div>
                                            <small class="text-muted">ผลตอบแทนคุ้มค่าเพื่อความมั่นคง</small>
                                        </div>
                                    </a>
                                    <a class="megamenu-item-link" href="<?= url('rates') ?>">
                                        <div class="megamenu-icon text-success" style="background-color: #E8F5E9;"><i class="bi bi-percent"></i></div>
                                        <div>
                                            <div class="fw-semibold">ประกาศอัตราดอกเบี้ย</div>
                                            <small class="text-muted">ดอกเบี้ยเงินฝากและเงินกู้ล่าสุด</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold text-navy mb-3 pb-2 border-bottom"><i class="bi bi-cash-stack me-1 text-primary"></i> สินเชื่อและเงินกู้</h6>
                                    <a class="megamenu-item-link" href="<?= url('loans') ?>">
                                        <div class="megamenu-icon"><i class="bi bi-lightning-charge"></i></div>
                                        <div>
                                            <div class="fw-semibold">เงินกู้เพื่อเหตุฉุกเฉิน</div>
                                            <small class="text-muted">อนุมัติไว เพื่อเหตุจำเป็นเร่งด่วน</small>
                                        </div>
                                    </a>
                                    <a class="megamenu-item-link" href="<?= url('loans') ?>">
                                        <div class="megamenu-icon"><i class="bi bi-cash-coin"></i></div>
                                        <div>
                                            <div class="fw-semibold">เงินกู้สามัญ</div>
                                            <small class="text-muted">วงเงินกู้สูง ผ่อนชำระระยะยาว</small>
                                        </div>
                                    </a>
                                    <a class="megamenu-item-link" href="<?= url('loans') ?>">
                                        <div class="megamenu-icon"><i class="bi bi-house-door"></i></div>
                                        <div>
                                            <div class="fw-semibold">เงินกู้พิเศษเพื่อการเคหะ</div>
                                            <small class="text-muted">เพื่อที่อยู่อาศัยและคุณภาพชีวิต</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-light-blue rounded-4 border h-100 d-flex flex-column justify-content-between">
                                        <div>
                                            <h6 class="fw-bold text-navy mb-2"><i class="bi bi-calculator me-1 text-warning"></i> คำนวณเงินกู้ออนไลน์</h6>
                                            <p class="small text-muted mb-3">จำลองการผ่อนชำระรายเดือน คำนวณดอกเบี้ยแบบลดต้นลดดอก วางแผนการเงินได้อย่างแม่นยำ</p>
                                        </div>
                                        <a href="<?= url('calculator') ?>" class="btn btn-sm btn-warning text-navy fw-bold w-100 rounded-pill shadow-sm">
                                            <i class="bi bi-calculator me-1"></i> คำนวณเงินกู้ทันที
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- 4. Mega Menu: สวัสดิการและเอกสาร (สวัสดิการ, ดาวน์โหลด, E-Service) -->
                    <li class="nav-item dropdown has-megamenu">
                        <a class="nav-link dropdown-toggle px-3 rounded-pill fw-medium <?= in_array($request->uri(), ['/welfare', '/documents', '/eservice']) ? 'active text-primary fw-bold bg-light' : 'text-dark' ?>" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-heart-pulse me-1"></i> สวัสดิการและเอกสาร
                        </a>
                        <div class="dropdown-menu megamenu-dropdown shadow-lg border-0 rounded-4 p-4">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <h6 class="fw-bold text-navy mb-3 pb-2 border-bottom"><i class="bi bi-heart-fill me-1 text-danger"></i> กองทุนสวัสดิการ</h6>
                                    <a class="megamenu-item-link" href="<?= url('welfare') ?>">
                                        <div class="megamenu-icon text-danger" style="background-color: #FFEBEE;"><i class="bi bi-gift"></i></div>
                                        <div>
                                            <div class="fw-semibold">เงินสงเคราะห์สมาชิก</div>
                                            <small class="text-muted">ช่วยเหลือครอบครัว คลอดบุตร เจ็บป่วย</small>
                                        </div>
                                    </a>
                                    <a class="megamenu-item-link" href="<?= url('welfare') ?>">
                                        <div class="megamenu-icon text-danger" style="background-color: #FFEBEE;"><i class="bi bi-mortarboard"></i></div>
                                        <div>
                                            <div class="fw-semibold">ทุนการศึกษาบุตร</div>
                                            <small class="text-muted">มอบทุนการศึกษาประจำปีทุกระดับ</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold text-navy mb-3 pb-2 border-bottom"><i class="bi bi-file-earmark-arrow-down me-1 text-info"></i> ศูนย์ดาวน์โหลด</h6>
                                    <a class="megamenu-item-link" href="<?= url('documents?cat=forms') ?>">
                                        <div class="megamenu-icon text-info" style="background-color: #E0F7FA;"><i class="bi bi-file-text"></i></div>
                                        <div>
                                            <div class="fw-semibold">แบบฟอร์มคำขอต่าง ๆ</div>
                                            <small class="text-muted">แบบฟอร์มขอกู้ เปลี่ยนค่าหุ้น สวัสดิการ</small>
                                        </div>
                                    </a>
                                    <a class="megamenu-item-link" href="<?= url('documents?cat=regulations') ?>">
                                        <div class="megamenu-icon text-info" style="background-color: #E0F7FA;"><i class="bi bi-journal-bookmark"></i></div>
                                        <div>
                                            <div class="fw-semibold">ระเบียบและข้อบังคับ</div>
                                            <small class="text-muted">ข้อบังคับสหกรณ์ฉบับปรับปรุง</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-light-blue rounded-4 border h-100 d-flex flex-column justify-content-between">
                                        <div>
                                            <h6 class="fw-bold text-navy mb-2"><i class="bi bi-grid-3x3-gap-fill me-1 text-primary"></i> บริการออนไลน์ E-Service</h6>
                                            <p class="small text-muted mb-3">ยื่นกู้ออนไลน์ ขอเปลี่ยนแปลงค่าหุ้น ยื่นสวัสดิการ และตรวจสอบข้อมูลธุรกรรมได้ตลอด 24 ชั่วโมง</p>
                                        </div>
                                        <a href="<?= url('eservice') ?>" class="btn btn-sm btn-primary w-100 fw-medium rounded-pill shadow-sm">
                                            <i class="bi bi-box-arrow-in-right me-1"></i> เข้าใช้งาน E-Service
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- 5. Mega Menu: ข่าวสารและติดต่อ (ข่าวสาร, ติดต่อเรา, FAQs) -->
                    <li class="nav-item dropdown has-megamenu">
                        <a class="nav-link dropdown-toggle px-3 rounded-pill fw-medium <?= in_array($request->uri(), ['/news', '/contact', '/faqs']) ? 'active text-primary fw-bold bg-light' : 'text-dark' ?>" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-newspaper me-1"></i> ข่าวสารและติดต่อ
                        </a>
                        <div class="dropdown-menu megamenu-dropdown shadow-lg border-0 rounded-4 p-4">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <h6 class="fw-bold text-navy mb-3 pb-2 border-bottom"><i class="bi bi-megaphone me-1 text-primary"></i> ข่าวสารและกิจกรรม</h6>
                                    <a class="megamenu-item-link" href="<?= url('news') ?>">
                                        <div class="megamenu-icon"><i class="bi bi-newspaper"></i></div>
                                        <div>
                                            <div class="fw-semibold">ข่าวประชาสัมพันธ์</div>
                                            <small class="text-muted">ข่าวสารความเคลื่อนไหวสหกรณ์</small>
                                        </div>
                                    </a>
                                    <a class="megamenu-item-link" href="<?= url('news') ?>">
                                        <div class="megamenu-icon"><i class="bi bi-calendar-event"></i></div>
                                        <div>
                                            <div class="fw-semibold">ปฏิทินกิจกรรม</div>
                                            <small class="text-muted">สัมมนา กิจกรรมสมาชิก วันหยุดทำการ</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold text-navy mb-3 pb-2 border-bottom"><i class="bi bi-geo-alt me-1 text-secondary"></i> ช่องทางติดต่อ</h6>
                                    <a class="megamenu-item-link" href="<?= url('contact') ?>">
                                        <div class="megamenu-icon text-secondary" style="background-color: #F1F5F9;"><i class="bi bi-pin-map"></i></div>
                                        <div>
                                            <div class="fw-semibold">สถานที่ตั้งและแผนที่</div>
                                            <small class="text-muted">สำนักงานสหกรณ์ จ.ระยอง</small>
                                        </div>
                                    </a>
                                    <a class="megamenu-item-link" href="<?= url('contact') ?>">
                                        <div class="megamenu-icon text-secondary" style="background-color: #F1F5F9;"><i class="bi bi-telephone"></i></div>
                                        <div>
                                            <div class="fw-semibold">เบอร์โทรศัพท์ & อีเมล</div>
                                            <small class="text-muted">ติดต่อเจ้าหน้าที่ในวันเวลาทำการ</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-light-blue rounded-4 border h-100 d-flex flex-column justify-content-between">
                                        <div>
                                            <h6 class="fw-bold text-navy mb-2"><i class="bi bi-question-circle-fill me-1 text-warning"></i> คำถามที่พบบ่อย (FAQs)</h6>
                                            <p class="small text-muted mb-3">รวบรวมคำถามและข้อสงสัยเกี่ยวกับการสมัครสมาชิก การกู้เงิน และการฝากเงิน</p>
                                        </div>
                                        <a href="<?= url('faqs') ?>" class="btn btn-sm btn-outline-primary w-100 fw-medium rounded-pill">
                                            <i class="bi bi-search me-1"></i> ดูคำถามที่พบบ่อย
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

                <!-- Account / Member Portal Section (Account Detail Style) -->
                <div class="d-flex align-items-center gap-2 ms-xl-2">
                    <?php if ($isLoggedIn): ?>
                        <!-- Notification Icon -->
                        <a href="<?= url('member/notifications') ?>" class="btn btn-light rounded-circle position-relative p-2" aria-label="การแจ้งเตือน">
                            <i class="bi bi-bell fs-5 text-dark"></i>
                        </a>

                        <!-- User Profile Chip Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 p-1 pe-3 rounded-pill border shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 34px; height: 34px;">
                                    <?= mb_substr($authUser['name'] ?? $authUser['username'] ?? 'ส', 0, 1, 'UTF-8') ?>
                                </div>
                                <div class="text-start d-none d-sm-block" style="line-height: 1.2;">
                                    <div class="fw-bold small text-navy"><?= e($authUser['name'] ?? $authUser['username'] ?? 'สมาชิก') ?></div>
                                    <small class="text-muted" style="font-size: 0.72rem;"><?= e($portalName) ?></small>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 py-2">
                                <li class="px-3 py-2 border-bottom">
                                    <div class="fw-bold text-navy small"><?= e($authUser['name'] ?? $authUser['username'] ?? 'สมาชิก') ?></div>
                                    <small class="text-muted">บทบาท: <?= e($authUser['role_name'] ?? $authRole) ?></small>
                                </li>
                                <li><a class="dropdown-item py-2 small" href="<?= $portalUrl ?>"><i class="bi bi-speedometer2 me-2 text-primary"></i> ไปที่ Dashboard</a></li>
                                <li><a class="dropdown-item py-2 small" href="<?= url('member/profile') ?>"><i class="bi bi-person me-2 text-primary"></i> ข้อมูลสมาชิก</a></li>
                                <li><a class="dropdown-item py-2 small" href="<?= url('member/deposits') ?>"><i class="bi bi-wallet2 me-2 text-success"></i> บัญชีเงินฝาก</a></li>
                                <li><a class="dropdown-item py-2 small" href="<?= url('member/loans') ?>"><i class="bi bi-cash-stack me-2 text-warning"></i> สัญญาเงินกู้</a></li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item py-2 small text-danger fw-medium" href="<?= url('logout') ?>">
                                        <i class="bi bi-power me-2"></i> ออกจากระบบ (Logout)
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Login / Member Portal CTA Button -->
                        <a href="<?= url('login') ?>" class="btn text-white rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-sm fw-semibold" style="background: linear-gradient(135deg, #073B74 0%, #0066CC 100%); font-size: 14px; gap: 6px;">
                            <i class="bi bi-box-arrow-in-right fs-5"></i>
                            <span>เข้าสู่ระบบสมาชิก</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- Mobile Offcanvas Menu (Categorized Cleanly) -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenuOffcanvas" aria-labelledby="mobileMenuOffcanvasLabel">
    <div class="offcanvas-header bg-navy text-white">
        <h5 class="offcanvas-title d-flex align-items-center" id="mobileMenuOffcanvasLabel">
            <i class="bi bi-bank2 me-2"></i> สอ.สธ.ระยอง
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="p-3 bg-light border-bottom">
            <?php if ($isLoggedIn): ?>
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                        <?= mb_substr($authUser['name'] ?? $authUser['username'] ?? 'ส', 0, 1, 'UTF-8') ?>
                    </div>
                    <div>
                        <div class="fw-bold text-navy small"><?= e($authUser['name'] ?? $authUser['username'] ?? 'สมาชิก') ?></div>
                        <small class="text-muted" style="font-size: 0.75rem;"><?= e($portalName) ?></small>
                    </div>
                </div>
                <a href="<?= $portalUrl ?>" class="btn btn-primary w-100 py-2 fw-bold rounded-pill mb-2">
                    <i class="bi bi-speedometer2 me-1"></i> ไปที่ <?= e($portalName) ?>
                </a>
                <a href="<?= url('logout') ?>" class="btn btn-outline-danger w-100 py-1 btn-sm rounded-pill">
                    <i class="bi bi-power me-1"></i> ออกจากระบบ
                </a>
            <?php else: ?>
                <a href="<?= url('login') ?>" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">
                    <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบสมาชิก
                </a>
            <?php endif; ?>
        </div>
        <div class="list-group list-group-flush">
            <!-- หน้าแรก -->
            <a href="<?= url('/') ?>" class="list-group-item list-group-item-action py-3 fw-semibold"><i class="bi bi-house-door me-2 text-primary"></i> หน้าแรก</a>
            
            <!-- เกี่ยวกับสหกรณ์ -->
            <div class="list-group-item bg-light text-muted small fw-bold text-uppercase py-2 px-3">เกี่ยวกับสหกรณ์</div>
            <a href="<?= url('about') ?>" class="list-group-item list-group-item-action py-2 ps-4 small"><i class="bi bi-info-circle me-2 text-primary"></i> ประวัติและวิสัยทัศน์</a>
            <a href="<?= url('board') ?>" class="list-group-item list-group-item-action py-2 ps-4 small"><i class="bi bi-people me-2 text-primary"></i> คณะกรรมการดำเนินการ</a>
            <a href="<?= url('statistics') ?>" class="list-group-item list-group-item-action py-2 ps-4 small"><i class="bi bi-pie-chart me-2 text-primary"></i> ฐานะการเงินและสถิติ</a>
            <a href="<?= url('complaints') ?>" class="list-group-item list-group-item-action py-2 ps-4 small"><i class="bi bi-shield-lock me-2 text-primary"></i> ศูนย์รับเรื่องร้องเรียน</a>

            <!-- บริการทางการเงิน -->
            <div class="list-group-item bg-light text-muted small fw-bold text-uppercase py-2 px-3">บริการทางการเงิน</div>
            <a href="<?= url('deposits') ?>" class="list-group-item list-group-item-action py-2 ps-4 small"><i class="bi bi-piggy-bank me-2 text-success"></i> เงินฝากสหกรณ์</a>
            <a href="<?= url('loans') ?>" class="list-group-item list-group-item-action py-2 ps-4 small"><i class="bi bi-cash-stack me-2 text-primary"></i> สินเชื่อและเงินกู้</a>
            <a href="<?= url('calculator') ?>" class="list-group-item list-group-item-action py-2 ps-4 small"><i class="bi bi-calculator me-2 text-warning"></i> คำนวณเงินกู้ออนไลน์</a>

            <!-- สวัสดิการและเอกสาร -->
            <div class="list-group-item bg-light text-muted small fw-bold text-uppercase py-2 px-3">สวัสดิการและเอกสาร</div>
            <a href="<?= url('welfare') ?>" class="list-group-item list-group-item-action py-2 ps-4 small"><i class="bi bi-heart-pulse me-2 text-danger"></i> สวัสดิการสมาชิก</a>
            <a href="<?= url('documents') ?>" class="list-group-item list-group-item-action py-2 ps-4 small"><i class="bi bi-file-earmark-arrow-down me-2 text-info"></i> ศูนย์ดาวน์โหลดเอกสาร</a>
            <a href="<?= url('eservice') ?>" class="list-group-item list-group-item-action py-2 ps-4 small"><i class="bi bi-grid-3x3-gap me-2 text-primary"></i> บริการออนไลน์ (E-Service)</a>

            <!-- ข่าวสารและติดต่อ -->
            <div class="list-group-item bg-light text-muted small fw-bold text-uppercase py-2 px-3">ข่าวสารและติดต่อ</div>
            <a href="<?= url('news') ?>" class="list-group-item list-group-item-action py-2 ps-4 small"><i class="bi bi-newspaper me-2 text-primary"></i> ข่าวสารและกิจกรรม</a>
            <a href="<?= url('contact') ?>" class="list-group-item list-group-item-action py-2 ps-4 small"><i class="bi bi-geo-alt me-2 text-secondary"></i> ติดต่อสหกรณ์</a>
            <a href="<?= url('faqs') ?>" class="list-group-item list-group-item-action py-2 ps-4 small"><i class="bi bi-question-circle me-2 text-warning"></i> คำถามที่พบบ่อย (FAQs)</a>
        </div>
    </div>
</div>
