<?php
$activeUser = \App\Core\Auth::user() ?? [
    'username' => 'rayongcoop1',
    'name' => 'เจ้าหน้าที่สหกรณ์ (rayongcoop1)',
    'role_name' => 'ผู้ดูแลระบบ',
    'role_slug' => 'super_admin'
];
?>
<header class="admin-topbar">
    <div class="d-flex align-items-center">
        <button class="btn btn-light d-lg-none me-2" id="btnToggleSidebar" aria-label="Toggle Sidebar">
            <i class="bi bi-list fs-5"></i>
        </button>
        <div class="d-flex align-items-center">
            <span class="fw-bold text-navy me-2 d-none d-md-inline" style="font-size: 0.95rem;">
                <i class="bi bi-bank2 me-1 text-primary"></i> ระบบบริหารจัดการสหกรณ์ออมทรัพย์
            </span>
            <span class="badge bg-success-subtle text-success border border-success-subtle small d-none d-sm-inline">
                <i class="bi bi-shield-check me-1"></i> ระบบออนไลน์
            </span>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2 gap-sm-3">
        <!-- View Public Website -->
        <a href="<?= url('/') ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 d-none d-sm-inline-flex align-items-center">
            <i class="bi bi-globe me-1"></i> หน้าเว็บไซต์
        </a>

        <!-- Notification Bell -->
        <div class="dropdown">
            <button class="btn btn-light rounded-circle position-relative p-2" type="button" data-bs-toggle="dropdown" aria-label="การแจ้งเตือน">
                <i class="bi bi-bell fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2" style="width: 280px;">
                <li class="px-3 py-2 border-bottom fw-bold text-navy small">การแจ้งเตือนระบบ</li>
                <li><a class="dropdown-item py-2 small" href="<?= url('admin/complaints') ?>"><i class="bi bi-chat-dots text-warning me-2"></i> เรื่องร้องเรียนใหม่รอตรวจสอบ</a></li>
                <li><a class="dropdown-item py-2 small" href="<?= url('admin/interest-rates') ?>"><i class="bi bi-percent text-success me-2"></i> อัตราดอกเบี้ยมีผลบังคับใช้</a></li>
            </ul>
        </div>

        <!-- User Profile Dropdown -->
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 p-1 pe-3 rounded-pill border" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="text-start d-none d-md-block" style="line-height: 1.2;">
                    <div class="fw-bold small text-navy"><?= e($activeUser['username'] ?? 'rayongcoop1') ?></div>
                    <small class="text-muted" style="font-size: 0.72rem;"><?= e($activeUser['name'] ?? 'เจ้าหน้าที่สหกรณ์') ?></small>
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                <li class="px-3 py-2 border-bottom">
                    <div class="fw-bold text-navy small"><?= e($activeUser['name'] ?? 'rayongcoop1') ?></div>
                    <small class="text-muted">Username: <?= e($activeUser['username'] ?? 'rayongcoop1') ?></small>
                </li>
                <li><a class="dropdown-item py-2" href="<?= url('dashboard') ?>"><i class="bi bi-speedometer2 me-2 text-primary"></i> Dashboard</a></li>
                <li><a class="dropdown-item py-2" href="<?= url('admin/users') ?>"><i class="bi bi-person-gear me-2 text-secondary"></i> จัดการผู้ใช้งาน</a></li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <a class="dropdown-item py-2 text-danger fw-medium" href="<?= url('logout') ?>">
                        <i class="bi bi-box-arrow-right me-2"></i> ออกจากระบบ (Logout)
                    </a>
                </li>
            </ul>
        </div>

        <!-- Quick Logout Direct Button -->
        <a href="<?= url('logout') ?>" class="btn btn-outline-danger btn-sm rounded-pill px-3 d-none d-md-inline-flex align-items-center gap-1" title="ออกจากระบบ">
            <i class="bi bi-power"></i>
            <span>ออกจากระบบ</span>
        </a>
    </div>
</header>
