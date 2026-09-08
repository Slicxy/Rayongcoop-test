<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Admin CMS') ?> — RayongCoop CMS</title>
    
    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.min.css">

    <!-- Admin & Main Theme CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>?v=1.0.0">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>?v=1.0.0">

    <script>
        window.APP_URL = "<?= url('/') ?>";
        window.CSRF_TOKEN = "<?= csrf_token() ?>";
    </script>
</head>
<body class="admin-body">

    <!-- Admin Sidebar -->
    <?php include dirname(__DIR__) . '/partials/admin_sidebar.php'; ?>

    <!-- Main Wrapper -->
    <div class="admin-main-wrapper">
        <!-- Topbar -->
        <?php include dirname(__DIR__) . '/partials/admin_topbar.php'; ?>

        <!-- Content Area -->
        <main class="admin-content">
            <?= $content ?? '' ?>
        </main>
    </div>

    <!-- Core Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    
    <!-- SweetAlert Central & Admin Scripts -->
    <script src="<?= asset('js/swal-config.js') ?>?v=1.0.0"></script>
    
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable) {
                $('.coop-datatable').each(function() {
                    let orderConf = $(this).data('order') || [[0, 'desc']];
                    if (typeof orderConf === 'string') {
                        try { orderConf = JSON.parse(orderConf); } catch(e) { orderConf = [[0, 'desc']]; }
                    }
                    $(this).DataTable({
                        order: orderConf,
                        language: {
                            search: "ค้นหา:",
                            lengthMenu: "แสดง _MENU_ รายการ",
                            info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                            infoEmpty: "แสดง 0 ถึง 0 จาก 0 รายการ",
                            zeroRecords: "ไม่พบข้อมูลที่ตรงกัน",
                            emptyTable: "ไม่มีรายการข้อมูลที่จะแสดง",
                            paginate: {
                                first: "หน้าแรก",
                                last: "หน้าสุดท้าย",
                                next: "ถัดไป",
                                previous: "ก่อนหน้า"
                            }
                        }
                    });
                });
            }

            // Mobile Admin/Staff Sidebar Toggle
            const sidebar = document.getElementById('adminSidebar');
            const toggleBtn = document.getElementById('btnToggleSidebar');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sidebar.classList.toggle('show');
                });
                document.addEventListener('click', function(e) {
                    if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
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
