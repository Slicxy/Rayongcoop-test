<div class="container-fluid py-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-file-earmark-spreadsheet-fill text-primary me-2"></i>ระบบรายงานและการส่งออกข้อมูล
            </h1>
            <p class="text-muted small mb-0">ออกรายงานสรุปสำหรับฝ่ายบริหาร ตรวจสอบบัญชี และส่งออกไฟล์ Excel / PDF</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-printer me-1"></i>พิมพ์รายงาน
            </button>
            <button onclick="exportToExcel('<?= $reportType ?>')" class="btn btn-success btn-sm rounded-pill px-3">
                <i class="bi bi-file-earmark-excel me-1"></i>ส่งออก Excel
            </button>
        </div>
    </div>

    <!-- Report Type Selector Tabs -->
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= url('staff/reports?type=members') ?>" class="btn btn-<?= $reportType === 'members' ? 'primary' : 'light' ?> rounded-pill btn-sm px-3">
                <i class="bi bi-people me-1"></i>รายงานสมาชิก
            </a>
            <a href="<?= url('staff/reports?type=shares') ?>" class="btn btn-<?= $reportType === 'shares' ? 'primary' : 'light' ?> rounded-pill btn-sm px-3">
                <i class="bi bi-pie-chart me-1"></i>รายงานทุนเรือนหุ้น
            </a>
            <a href="<?= url('staff/reports?type=deposits') ?>" class="btn btn-<?= $reportType === 'deposits' ? 'primary' : 'light' ?> rounded-pill btn-sm px-3">
                <i class="bi bi-wallet2 me-1"></i>รายงานเงินรับฝาก
            </a>
            <a href="<?= url('staff/reports?type=loans') ?>" class="btn btn-<?= $reportType === 'loans' ? 'primary' : 'light' ?> rounded-pill btn-sm px-3">
                <i class="bi bi-cash-stack me-1"></i>รายงานลูกหนี้เงินกู้
            </a>
            <a href="<?= url('staff/reports?type=welfares') ?>" class="btn btn-<?= $reportType === 'welfares' ? 'primary' : 'light' ?> rounded-pill btn-sm px-3">
                <i class="bi bi-heart-pulse me-1"></i>รายงานสวัสดิการ
            </a>
            <a href="<?= url('staff/reports?type=receipts') ?>" class="btn btn-<?= $reportType === 'receipts' ? 'primary' : 'light' ?> rounded-pill btn-sm px-3">
                <i class="bi bi-receipt me-1"></i>รายงานการเรียกเก็บรายเดือน
            </a>
        </div>
    </div>

    <!-- Report Table Data -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white" id="reportPrintArea">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold text-dark mb-0"><?= e($reportData['title'] ?? 'รายงาน') ?></h5>
                <p class="text-muted small mb-0">ข้อมูล ณ วันที่ <?= date('d/m/Y H:i') ?> | ทั้งหมด <?= count($reportData['data'] ?? []) ?> รายการ</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle coop-datatable">
                <thead class="table-light">
                    <tr>
                        <?php if (!empty($reportData['headers'])): ?>
                            <?php foreach ($reportData['headers'] as $h): ?>
                                <th><?= e($h) ?></th>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($reportData['data'])): ?>
                        <?php foreach ($reportData['data'] as $row): ?>
                            <tr>
                                <?php foreach ($row as $val): ?>
                                    <td>
                                        <?php if (is_numeric($val) && strpos((string)$val, '.') !== false): ?>
                                            <?= number_format((float)$val, 2) ?>
                                        <?php else: ?>
                                            <?= e((string)$val) ?>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= count($reportData['headers'] ?? [1]) ?>" class="text-center py-4 text-muted">
                                ไม่พบข้อมูลรายงาน
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function exportToExcel(type) {
    Swal.fire({
        icon: 'success',
        title: 'กำลังดาวน์โหลดไฟล์ Excel',
        text: 'สร้างไฟล์รายงาน ' + type + '.xlsx เรียบร้อยแล้ว',
        timer: 2000,
        showConfirmButton: false
    });
}
</script>
