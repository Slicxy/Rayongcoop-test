<aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar-brand">
        <div class="bg-primary text-white rounded-3 p-2 me-2 d-flex align-items-center justify-content-center">
            <i class="bi bi-bank2 fs-5"></i>
        </div>
        <div>
            <div class="fw-bold text-white fs-6">RayongCoop CMS</div>
            <div class="text-muted" style="font-size: 0.72rem;">ระบบบริหารจัดการดิจิทัล</div>
        </div>
    </div>

    <ul class="admin-nav">
        <!-- Overview -->
        <li class="admin-nav-item">
            <a href="<?= url('admin/dashboard') ?>" class="admin-nav-link <?= $request->uri() === '/admin/dashboard' ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> <span>Dashboard ภาพรวม</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/executive') ?>" class="admin-nav-link <?= $request->uri() === '/admin/executive' ? 'active' : '' ?>">
                <i class="bi bi-pie-chart-fill text-warning"></i> <span>Executive Dashboard</span>
            </a>
        </li>

        <!-- Staff Operations -->
        <li class="admin-nav-header">ระบบงานเจ้าหน้าที่ (Staff Management)</li>
        <li class="admin-nav-item">
            <a href="<?= url('staff/dashboard') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/staff/dashboard') ? 'active' : '' ?>">
                <i class="bi bi-briefcase"></i> <span>Staff Dashboard</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('staff/members') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/staff/members') ? 'active' : '' ?>">
                <i class="bi bi-person-lines-fill"></i> <span>จัดการสมาชิก 360°</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('staff/loans') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/staff/loans') ? 'active' : '' ?>">
                <i class="bi bi-clipboard2-check"></i> <span>ตรวจคำขอกู้เงิน</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('staff/welfare') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/staff/welfare') ? 'active' : '' ?>">
                <i class="bi bi-heart-pulse"></i> <span>ตรวจคำขอสวัสดิการ</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('staff/reports') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/staff/reports') ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-spreadsheet"></i> <span>ศูนย์รายงานและส่งออก</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('staff/import') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/staff/import') ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-arrow-up-fill text-success"></i> <span>นำเข้าข้อมูล Excel/CSV</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('member/dashboard') ?>" target="_blank" class="admin-nav-link text-info">
                <i class="bi bi-box-arrow-up-right"></i> <span>ไปที่ Member Portal</span>
            </a>
        </li>

        <!-- Content & Marketing -->
        <li class="admin-nav-header">จัดการเนื้อหาและประชาสัมพันธ์</li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/news') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/news') ? 'active' : '' ?>">
                <i class="bi bi-newspaper"></i> <span>ข่าวสารและกิจกรรม</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/announcements') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/announcements') ? 'active' : '' ?>">
                <i class="bi bi-megaphone"></i> <span>แถบประกาศสำคัญ</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/hero-slides') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/hero-slides') ? 'active' : '' ?>">
                <i class="bi bi-images"></i> <span>Hero Slideshow</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/popups') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/popups') ? 'active' : '' ?>">
                <i class="bi bi-window-stack"></i> <span>Popup Campaign</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/media') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/media') ? 'active' : '' ?>">
                <i class="bi bi-folder2-open"></i> <span>Media Library</span>
            </a>
        </li>

        <!-- Financial & Products -->
        <li class="admin-nav-header">ผลิตภัณฑ์การเงินและสวัสดิการ</li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/interest-rates') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/interest-rates') ? 'active' : '' ?>">
                <i class="bi bi-percent"></i> <span>อัตราดอกเบี้ย & ประวัติ</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/deposits') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/deposits') ? 'active' : '' ?>">
                <i class="bi bi-piggy-bank"></i> <span>ผลิตภัณฑ์เงินฝาก</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/loans') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/loans') ? 'active' : '' ?>">
                <i class="bi bi-cash-stack"></i> <span>ผลิตภัณฑ์เงินกู้</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/welfare') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/welfare') ? 'active' : '' ?>">
                <i class="bi bi-heart-pulse"></i> <span>สวัสดิการสมาชิก</span>
            </a>
        </li>

        <!-- Operations & Documents -->
        <li class="admin-nav-header">งานเอกสารและบริการสมาชิก</li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/documents') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/documents') ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-text"></i> <span>ศูนย์เอกสารและระเบียบ</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/eservices') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/eservices') ? 'active' : '' ?>">
                <i class="bi bi-grid-3x3-gap"></i> <span>E-Service Gateway</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/complaints') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/complaints') ? 'active' : '' ?>">
                <i class="bi bi-chat-left-dots"></i> <span>ศูนย์เรื่องร้องเรียน</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/board-staff') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/board-staff') ? 'active' : '' ?>">
                <i class="bi bi-people"></i> <span>กรรมการและเจ้าหน้าที่</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/faqs') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/faqs') ? 'active' : '' ?>">
                <i class="bi bi-question-circle"></i> <span>คำถามที่พบบ่อย (FAQ)</span>
            </a>
        </li>

        <!-- Privacy & PDPA -->
        <li class="admin-nav-header">PDPA & Privacy Management</li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/privacy-cookies') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/privacy-cookies') ? 'active' : '' ?>">
                <i class="bi bi-shield-check"></i> <span>Privacy & Cookies</span>
            </a>
        </li>

        <!-- Governance & Security -->
        <li class="admin-nav-header">ความปลอดภัยและการตั้งค่า</li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/users') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/users') ? 'active' : '' ?>">
                <i class="bi bi-person-gear"></i> <span>ผู้ใช้งานและสิทธิ์ (RBAC)</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/audit-logs') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/audit-logs') ? 'active' : '' ?>">
                <i class="bi bi-journal-check"></i> <span>Audit Trail (บันทึกประวัติ)</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/backups') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/backups') ? 'active' : '' ?>">
                <i class="bi bi-database-check"></i> <span>สำรองข้อมูล (Backup)</span>
            </a>
        </li>
        <li class="admin-nav-item">
            <a href="<?= url('admin/settings') ?>" class="admin-nav-link <?= str_starts_with($request->uri(), '/admin/settings') ? 'active' : '' ?>">
                <i class="bi bi-gear"></i> <span>ตั้งค่าระบบ (Settings)</span>
            </a>
        </li>
    </ul>
</aside>
