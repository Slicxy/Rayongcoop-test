<?php
$backups = $backups ?? [];
$totalSize = $totalSize ?? 0;
$lastBackupTime = $lastBackupTime ?? null;
$tableCount = $tableCount ?? 0;
$dbSize = $dbSize ?? 0;
?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-database-check me-2 text-primary"></i> ศูนย์สำรองและกู้คืนข้อมูล (Backup & Disaster Recovery)</h3>
        <p class="text-muted small mb-0">จัดการสำรองฐานข้อมูล ไฟล์เอกสาร และกู้คืนระบบแบบครบวงจรสำหรับผู้ดูแลระบบ</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <!-- 1. Database Backup -->
        <form action="<?= url('admin/backups/create') ?>" method="POST" id="createDbBackupForm" class="d-inline">
            <?= csrf_field() ?>
            <button type="button" class="btn btn-primary btn-sm shadow-sm" onclick="showConfirm('ยืนยันสำรองฐานข้อมูล?', 'ระบบจะทำการส่งออกโครงสร้างและข้อมูลทั้งหมดเป็นไฟล์ SQL', 'สำรองฐานข้อมูล', 'ยกเลิก', () => document.getElementById('createDbBackupForm').submit())">
                <i class="bi bi-database-add me-1"></i> สำรองฐานข้อมูล (SQL)
            </button>
        </form>

        <!-- 2. Storage Backup -->
        <form action="<?= url('admin/backups/create-storage') ?>" method="POST" id="createStorageBackupForm" class="d-inline">
            <?= csrf_field() ?>
            <button type="button" class="btn btn-info btn-sm text-dark shadow-sm" onclick="showConfirm('ยืนยันสำรองไฟล์เอกสาร & สื่อ?', 'ระบบจะทำการบีบอัดไฟล์ใน storage/uploads ทั้งหมดเป็น ZIP', 'สำรองไฟล์สื่อ', 'ยกเลิก', () => document.getElementById('createStorageBackupForm').submit())">
                <i class="bi bi-file-earmark-zip me-1"></i> สำรองไฟล์เอกสาร/สื่อ (Uploads)
            </button>
        </form>

        <!-- 3. Full System Backup -->
        <form action="<?= url('admin/backups/create-full') ?>" method="POST" id="createFullBackupForm" class="d-inline">
            <?= csrf_field() ?>
            <button type="button" class="btn btn-dark btn-sm shadow-sm" onclick="showConfirm('ยืนยันสำรองระบบแบบสมบูรณ์?', 'ระบบจะทำการสำรองทั้งฐานข้อมูลและไฟล์เอกสารทั้งหมดรวมเป็น ZIP ไฟล์เดียว', 'สำรองข้อมูลสมบูรณ์', 'ยกเลิก', () => document.getElementById('createFullBackupForm').submit())">
                <i class="bi bi-archive-fill me-1 text-warning"></i> สำรองทั้งระบบ (Full Backup)
            </button>
        </form>
    </div>
</div>

<!-- Overview Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card p-3 h-100 border-start border-4 border-primary">
            <div class="d-flex align-items-center">
                <div class="bg-light-blue text-primary rounded-3 p-3 me-3">
                    <i class="bi bi-folder-check fs-4"></i>
                </div>
                <div>
                    <small class="text-muted fw-bold text-uppercase d-block" style="font-size: 0.75rem;">จำนวนไฟล์สำรอง</small>
                    <div class="fs-4 fw-bold text-navy"><?= count($backups) ?> ไฟล์</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card p-3 h-100 border-start border-4 border-info">
            <div class="d-flex align-items-center">
                <div class="bg-light text-info rounded-3 p-3 me-3">
                    <i class="bi bi-hdd-network-fill fs-4"></i>
                </div>
                <div>
                    <small class="text-muted fw-bold text-uppercase d-block" style="font-size: 0.75rem;">พื้นที่จัดเก็บสำรองรวม</small>
                    <div class="fs-4 fw-bold text-navy">
                        <?= $totalSize > 1048576 ? number_format($totalSize / 1048576, 2) . ' MB' : number_format($totalSize / 1024, 2) . ' KB' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card p-3 h-100 border-start border-4 border-success">
            <div class="d-flex align-items-center">
                <div class="bg-light-green text-success rounded-3 p-3 me-3">
                    <i class="bi bi-clock-history fs-4"></i>
                </div>
                <div>
                    <small class="text-muted fw-bold text-uppercase d-block" style="font-size: 0.75rem;">สำรองข้อมูลล่าสุด</small>
                    <div class="fs-6 fw-bold text-navy">
                        <?= $lastBackupTime ? thai_date($lastBackupTime, true) : 'ยังไม่มีข้อมูล' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card p-3 h-100 border-start border-4 border-warning">
            <div class="d-flex align-items-center">
                <div class="bg-light text-warning rounded-3 p-3 me-3">
                    <i class="bi bi-database-gear fs-4"></i>
                </div>
                <div>
                    <small class="text-muted fw-bold text-uppercase d-block" style="font-size: 0.75rem;">ฐานข้อมูลหลักปัจจุบัน</small>
                    <div class="fs-6 fw-bold text-navy">
                        <?= $tableCount ?> ตาราง (~<?= number_format($dbSize / 1024 / 1024, 2) ?> MB)
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Backups File List Table -->
<div class="admin-card mb-4 shadow-sm">
    <div class="admin-card-header d-flex justify-content-between align-items-center py-3 px-4 border-bottom bg-white">
        <h5 class="fw-bold text-navy mb-0"><i class="bi bi-list-columns-reverse me-2 text-primary"></i> รายการไฟล์สำรองข้อมูล</h5>
        <span class="badge bg-light text-dark border"><?= count($backups) ?> รายการ</span>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;" class="ps-4">#</th>
                        <th>ประเภท</th>
                        <th>ชื่อไฟล์สำรอง</th>
                        <th>ขนาดไฟล์</th>
                        <th>วันที่สร้างไฟล์</th>
                        <th class="text-end pe-4">การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($backups)): ?>
                        <?php foreach ($backups as $i => $b): ?>
                            <tr>
                                <td class="ps-4 text-muted"><?= $i + 1 ?></td>
                                <td>
                                    <span class="badge <?= $b['badge'] ?> px-2 py-1">
                                        <i class="bi <?= $b['icon'] ?> me-1"></i> <?= $b['typeLabel'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi <?= $b['icon'] ?> fs-5 me-2 text-primary"></i>
                                        <span class="fw-bold font-monospace text-navy"><?= e($b['filename']) ?></span>
                                    </div>
                                </td>
                                <td class="font-monospace small">
                                    <?= $b['size'] > 1048576 ? number_format($b['size'] / 1048576, 2) . ' MB' : number_format($b['size'] / 1024, 2) . ' KB' ?>
                                </td>
                                <td class="small text-muted">
                                    <i class="bi bi-calendar3 me-1"></i> <?= thai_date($b['created_at'], true) ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <!-- Download -->
                                        <a href="<?= url('admin/backups/download?file=' . urlencode($b['filename'])) ?>" class="btn btn-outline-primary" title="ดาวน์โหลดไฟล์">
                                            <i class="bi bi-download me-1"></i> ดาวน์โหลด
                                        </a>

                                        <!-- Restore (For SQL only) -->
                                        <?php if ($b['type'] === 'database'): ?>
                                            <button type="button" class="btn btn-outline-warning" title="กู้คืนฐานข้อมูลจากไฟล์นี้" onclick="confirmRestore('<?= e($b['filename']) ?>')">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i> กู้คืน (Restore)
                                            </button>
                                        <?php endif; ?>

                                        <!-- Delete -->
                                        <button type="button" class="btn btn-outline-danger" title="ลบไฟล์สำรอง" onclick="confirmDelete('<?= e($b['filename']) ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-folder2-open fs-1 d-block mb-2 text-secondary"></i>
                                ยังไม่มีไฟล์สำรองข้อมูลในระบบ กรุณากดปุ่ม <b>"สำรองฐานข้อมูล (SQL)"</b> หรือ <b>"สำรองทั้งระบบ"</b> ด้านบน
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Hidden Action Forms for Restore & Delete -->
<form id="restoreBackupForm" action="<?= url('admin/backups/restore') ?>" method="POST" style="display: none;">
    <?= csrf_field() ?>
    <input type="hidden" name="filename" id="restoreFilename">
</form>

<form id="deleteBackupForm" action="<?= url('admin/backups/delete') ?>" method="POST" style="display: none;">
    <?= csrf_field() ?>
    <input type="hidden" name="filename" id="deleteFilename">
</form>

<!-- Automation & CLI Disaster Recovery Info Card -->
<div class="admin-card p-4 bg-light border">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <h6 class="fw-bold text-navy mb-2"><i class="bi bi-terminal-fill me-2 text-primary"></i> คำสั่งระบบอัตโนมัติ (CLI & Scheduled Backups)</h6>
            <p class="small text-muted mb-2">
                ผู้ดูแลระบบสามารถตั้งเวลาสำรองข้อมูลอัตโนมัติ (Cron Job) บน Server โดยใช้คำสั่ง Console ดังนี้:
            </p>
            <div class="bg-dark text-light p-3 rounded-3 font-monospace small mb-2 overflow-auto">
                <span class="text-success"># คำสั่งสำรองฐานข้อมูลผ่าน CLI:</span><br>
                php bin/console backup:run<br><br>
                <span class="text-success"># ตั้งค่า Cron Job ทุกวันเวลา 01:00 น.:</span><br>
                0 1 * * * php c:\xampp\htdocs\rayongcoop\bin\console backup:run >> storage\logs\backup.log 2>&1
            </div>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            <div class="p-3 bg-white rounded-3 border shadow-sm text-start">
                <div class="fw-bold text-navy small mb-1"><i class="bi bi-shield-lock-fill text-success me-1"></i> มาตรการความปลอดภัย</div>
                <ul class="extra-small text-muted ps-3 mb-0" style="font-size: 0.78rem;">
                    <li>จำกัดสิทธิ์เฉพาะ Super Admin เท่านั้น</li>
                    <li>บันทึก Audit Trail ทุกครั้งที่มีการดาวน์โหลด/กู้คืน</li>
                    <li>ไฟล์ถูกเก็บในโฟลเดอร์ที่มี .htaccess ป้องกัน Direct Access</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function confirmRestore(filename) {
    Swal.fire({
        title: 'ยืนยันการกู้คืนฐานข้อมูล?',
        html: `ท่านกำลังจะกู้คืนฐานข้อมูลจากไฟล์ <b>${filename}</b><br><span class="text-danger small">⚠️ ข้อมูลปัจจุบันจะถูกเขียนทับด้วยข้อมูลจากไฟล์สำรองนี้</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d97706',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'ยืนยันการกู้คืนข้อมูล',
        cancelButtonText: 'ยกเลิก',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('restoreFilename').value = filename;
            document.getElementById('restoreBackupForm').submit();
        }
    });
}

function confirmDelete(filename) {
    Swal.fire({
        title: 'ยืนยันการลบไฟล์สำรอง?',
        text: `ต้องการลบไฟล์ ${filename} ใช่หรือไม่?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'ลบไฟล์',
        cancelButtonText: 'ยกเลิก',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteFilename').value = filename;
            document.getElementById('deleteBackupForm').submit();
        }
    });
}
</script>
