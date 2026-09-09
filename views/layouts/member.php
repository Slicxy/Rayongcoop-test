<?php $request = $request ?? request(); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'พอร์ทัลสมาชิก') ?> — สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</title>
    
    <!-- Google Fonts: Prompt & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Prompt:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.min.css">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>?v=1.1.0">

    <style>
        :root {
            --member-primary: #0066CC;
            --member-navy: #073B74;
            --member-bg: #F4F7FB;
            --sidebar-width: 260px;
        }

        body.member-body {
            font-family: 'Prompt', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--member-bg);
            color: #1E293B;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .member-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: #FFFFFF;
            border-right: 1px solid #E2E8F0;
            z-index: 1030;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
        }

        .member-sidebar-brand {
            padding: 20px;
            background: linear-gradient(135deg, #073B74 0%, #0066CC 100%);
            color: #FFFFFF;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .member-sidebar-nav {
            list-style: none;
            margin: 0;
            padding: 12px 8px;
            flex: 1;
        }

        .member-nav-header {
            font-size: 11px;
            font-weight: 700;
            color: #94A3B8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 12px 14px 4px 14px;
        }

        .member-nav-item {
            margin-bottom: 2px;
        }

        .member-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            font-size: 14px;
            font-weight: 500;
            color: #475569;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .member-nav-link i {
            font-size: 18px;
            color: #64748B;
            transition: color 0.2s ease;
        }

        .member-nav-link:hover {
            color: #0066CC;
            background: #F0F5FF;
        }

        .member-nav-link:hover i {
            color: #0066CC;
        }

        .member-nav-link.active {
            color: #0066CC;
            background: #E8F1FF;
            font-weight: 600;
        }

        .member-nav-link.active i {
            color: #0066CC;
        }

        /* Main Content Wrapper */
        .member-main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        /* Topbar Header */
        .member-topbar {
            height: 68px;
            background: #FFFFFF;
            border-bottom: 1px solid #E2E8F0;
            padding: 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .member-content {
            padding: 28px;
            flex: 1;
        }

        /* Cards & Components */
        .coop-summary-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .coop-summary-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        }

        /* Mobile Bottom Nav */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: #FFFFFF;
            border-top: 1px solid #E2E8F0;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.06);
            z-index: 1040;
            justify-content: space-around;
            align-items: center;
        }

        .mobile-bottom-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #64748B;
            text-decoration: none;
            font-size: 11px;
            gap: 2px;
        }

        .mobile-bottom-item.active,
        .mobile-bottom-item:hover {
            color: #0066CC;
        }

        .mobile-bottom-item i {
            font-size: 20px;
        }

        /* Responsive Breakpoints */
        @media (max-width: 991px) {
            .member-sidebar {
                transform: translateX(-100%);
            }

            .member-sidebar.show {
                transform: translateX(0);
            }

            .member-main-wrapper {
                margin-left: 0;
                padding-bottom: 60px;
            }

            .member-topbar {
                padding: 0 16px;
            }

            .member-content {
                padding: 16px;
            }

            .mobile-bottom-nav {
                display: flex;
            }
        }
    </style>
</head>
<body class="member-body">

    <!-- 1. Sidebar Navigation (Desktop & Mobile Offcanvas) -->
    <aside class="member-sidebar" id="memberSidebar">
        <div class="member-sidebar-brand">
            <div class="bg-white text-primary rounded-3 p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                <i class="bi bi-bank2 fs-5"></i>
            </div>
            <div>
                <div class="fw-bold" style="font-size: 15px; line-height: 1.2;">พอร์ทัลสมาชิก</div>
                <div style="font-size: 11px; opacity: 0.85;">สอ.สธ.ระยอง จำกัด</div>
            </div>
        </div>

        <ul class="member-sidebar-nav">
            <li class="member-nav-header">ภาพรวม & สมาชิก</li>
            <li class="member-nav-item">
                <a href="<?= url('member/dashboard') ?>" class="member-nav-link <?= $request->uri() === '/member/dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> <span>Dashboard สมาชิก</span>
                </a>
            </li>
            <li class="member-nav-item">
                <a href="<?= url('member/profile') ?>" class="member-nav-link <?= $request->uri() === '/member/profile' ? 'active' : '' ?>">
                    <i class="bi bi-person-badge"></i> <span>ข้อมูลสมาชิก</span>
                </a>
            </li>
            <li class="member-nav-item">
                <a href="<?= url('member/financial-summary') ?>" class="member-nav-link <?= $request->uri() === '/member/financial-summary' ? 'active' : '' ?>">
                    <i class="bi bi-pie-chart"></i> <span>ภาพรวมการเงิน</span>
                </a>
            </li>

            <li class="member-nav-header">บัญชี & ธุรกรรม</li>
            <li class="member-nav-item">
                <a href="<?= url('member/shares') ?>" class="member-nav-link <?= $request->uri() === '/member/shares' ? 'active' : '' ?>">
                    <i class="bi bi-graph-up-arrow"></i> <span>หุ้นของสมาชิก</span>
                </a>
            </li>
            <li class="member-nav-item">
                <a href="<?= url('member/deposits') ?>" class="member-nav-link <?= $request->uri() === '/member/deposits' ? 'active' : '' ?>">
                    <i class="bi bi-piggy-bank"></i> <span>บัญชีเงินฝาก</span>
                </a>
            </li>
            <li class="member-nav-item">
                <a href="<?= url('member/loans') ?>" class="member-nav-link <?= $request->uri() === '/member/loans' ? 'active' : '' ?>">
                    <i class="bi bi-credit-card-2-front"></i> <span>สัญญาเงินกู้</span>
                </a>
            </li>
            <li class="member-nav-item">
                <a href="<?= url('member/receipts') ?>" class="member-nav-link <?= $request->uri() === '/member/receipts' ? 'active' : '' ?>">
                    <i class="bi bi-receipt"></i> <span>ใบเสร็จรับเงิน</span>
                </a>
            </li>
            <li class="member-nav-item">
                <a href="<?= url('member/tax-certificates') ?>" class="member-nav-link <?= str_starts_with($request->uri(), '/member/tax-certificates') ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-text text-primary"></i> <span>หนังสือรับรองภาษี</span>
                </a>
            </li>

            <li class="member-nav-header">บริการออนไลน์ & สิทธิประโยชน์</li>
            <li class="member-nav-item">
                <a href="<?= url('member/dividend-estimator') ?>" class="member-nav-link <?= $request->uri() === '/member/dividend-estimator' ? 'active' : '' ?>">
                    <i class="bi bi-calculator text-warning"></i> <span>ประมาณการเงินปันผล</span>
                </a>
            </li>
            <li class="member-nav-item">
                <a href="<?= url('member/surveys') ?>" class="member-nav-link <?= str_starts_with($request->uri(), '/member/surveys') ? 'active' : '' ?>">
                    <i class="bi bi-card-checklist text-info"></i> <span>แบบสำรวจสมาชิก</span>
                </a>
            </li>
            <li class="member-nav-item">
                <a href="<?= url('member/loan-apply') ?>" class="member-nav-link <?= $request->uri() === '/member/loan-apply' ? 'active' : '' ?>">
                    <i class="bi bi-cash-stack text-success"></i> <span>ยื่นกู้ออนไลน์</span>
                </a>
            </li>
            <li class="member-nav-item">
                <a href="<?= url('member/welfare') ?>" class="member-nav-link <?= $request->uri() === '/member/welfare' ? 'active' : '' ?>">
                    <i class="bi bi-heart-pulse"></i> <span>สวัสดิการสมาชิก</span>
                </a>
            </li>
            <li class="member-nav-item">
                <a href="<?= url('member/beneficiaries') ?>" class="member-nav-link <?= $request->uri() === '/member/beneficiaries' ? 'active' : '' ?>">
                    <i class="bi bi-people"></i> <span>ผู้รับผลประโยชน์</span>
                </a>
            </li>
            <li class="member-nav-item">
                <a href="<?= url('member/suggestions') ?>" class="member-nav-link <?= str_starts_with($request->uri(), '/member/suggestions') ? 'active' : '' ?>">
                    <i class="bi bi-chat-heart text-danger"></i> <span>กล่องข้อเสนอแนะ</span>
                </a>
            </li>
            <li class="member-nav-item">
                <a href="<?= url('member/online-services') ?>" class="member-nav-link <?= $request->uri() === '/member/online-services' ? 'active' : '' ?>">
                    <i class="bi bi-send-check"></i> <span>ติดตามคำขอออนไลน์</span>
                </a>
            </li>

            <li class="member-nav-header">การตั้งค่า</li>
            <li class="member-nav-item">
                <a href="<?= url('member/settings') ?>" class="member-nav-link <?= $request->uri() === '/member/settings' ? 'active' : '' ?>">
                    <i class="bi bi-gear"></i> <span>ตั้งค่าบัญชี & PDPA</span>
                </a>
            </li>
            <li class="member-nav-item">
                <a href="<?= url('logout') ?>" class="member-nav-link text-danger">
                    <i class="bi bi-power text-danger"></i> <span>ออกจากระบบ</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- 2. Main Content Wrapper -->
    <div class="member-main-wrapper">
        <!-- Topbar -->
        <header class="member-topbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-light d-lg-none me-2" id="btnToggleMemberSidebar" aria-label="Toggle Navigation">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="d-none d-sm-block">
                    <span class="fw-bold text-navy"><i class="bi bi-shield-check text-primary me-1"></i> ระบบบริหารจัดการสหกรณ์ออมทรัพย์</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 gap-sm-3">
                <!-- Public Website Link -->
                <a href="<?= url('/') ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 d-none d-md-inline-flex align-items-center gap-1">
                    <i class="bi bi-globe"></i> หน้าเว็บหลัก
                </a>

                <!-- Notification Bell -->
                <div class="dropdown">
                    <a href="<?= url('member/notifications') ?>" class="btn btn-light rounded-circle position-relative p-2" aria-label="การแจ้งเตือน">
                        <i class="bi bi-bell fs-5 text-dark"></i>
                        <?php if (!empty($unreadCount) && $unreadCount > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                                <?= $unreadCount ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </div>

                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 p-1 pe-3 rounded-pill border" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 34px; height: 34px;">
                            <?= mb_substr($member['first_name'] ?? 'ส', 0, 1, 'UTF-8') ?>
                        </div>
                        <div class="text-start d-none d-sm-block" style="line-height: 1.2;">
                            <div class="fw-bold small text-navy"><?= e(($member['prefix'] ?? '') . ($member['first_name'] ?? 'สมาชิก') . ' ' . ($member['last_name'] ?? '')) ?></div>
                            <small class="text-muted" style="font-size: 0.72rem;"><?= e($member['member_no'] ?? 'MEM-2024-0001') ?></small>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-bold text-navy small"><?= e(($member['prefix'] ?? '') . ($member['first_name'] ?? '') . ' ' . ($member['last_name'] ?? '')) ?></div>
                            <small class="text-muted">รหัสสมาชิก: <?= e($member['member_no'] ?? 'MEM-2024-0001') ?></small>
                        </li>
                        <li><a class="dropdown-item py-2 small" href="<?= url('member/profile') ?>"><i class="bi bi-person me-2 text-primary"></i> ข้อมูลสมาชิก</a></li>
                        <li><a class="dropdown-item py-2 small" href="<?= url('member/settings') ?>"><i class="bi bi-shield-lock me-2 text-secondary"></i> ความปลอดภัย & รหัสผ่าน</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item py-2 small text-danger fw-medium" href="<?= url('logout') ?>">
                                <i class="bi bi-power me-2"></i> ออกจากระบบ (Logout)
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main Dynamic View Content -->
        <main class="member-content">
            <?= $content ?? '' ?>
        </main>
    </div>

    <!-- 3. Mobile Bottom Navigation -->
    <nav class="mobile-bottom-nav">
        <a href="<?= url('member/dashboard') ?>" class="mobile-bottom-item <?= $request->uri() === '/member/dashboard' ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i>
            <span>หน้าหลัก</span>
        </a>
        <a href="<?= url('member/deposits') ?>" class="mobile-bottom-item <?= $request->uri() === '/member/deposits' ? 'active' : '' ?>">
            <i class="bi bi-piggy-bank"></i>
            <span>เงินฝาก</span>
        </a>
        <a href="<?= url('member/loans') ?>" class="mobile-bottom-item <?= $request->uri() === '/member/loans' ? 'active' : '' ?>">
            <i class="bi bi-credit-card-2-front"></i>
            <span>เงินกู้</span>
        </a>
        <a href="<?= url('member/receipts') ?>" class="mobile-bottom-item <?= $request->uri() === '/member/receipts' ? 'active' : '' ?>">
            <i class="bi bi-receipt"></i>
            <span>ใบเสร็จ</span>
        </a>
        <a href="<?= url('member/profile') ?>" class="mobile-bottom-item <?= $request->uri() === '/member/profile' ? 'active' : '' ?>">
            <i class="bi bi-person"></i>
            <span>โปรไฟล์</span>
        </a>
    </nav>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script src="<?= asset('js/swal-config.js') ?>?v=1.0.0"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('memberSidebar');
            const toggleBtn = document.getElementById('btnToggleMemberSidebar');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('#memberSidebar') && !e.target.closest('#btnToggleMemberSidebar')) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>

    <?php if (!empty($flashSuccess)): ?>
        <script>document.addEventListener('DOMContentLoaded', () => showToast('success', <?= json_encode($flashSuccess) ?>));</script>
    <?php endif; ?>
    <?php if (!empty($flashError)): ?>
        <script>document.addEventListener('DOMContentLoaded', () => showError('แจ้งเตือน', <?= json_encode($flashError) ?>));</script>
    <?php endif; ?>
</body>
</html>
