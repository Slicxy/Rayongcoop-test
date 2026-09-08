<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="<?= url('staff/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">ระบบรายงานและส่งออกข้อมูล</li>
                </ol>
            </nav>
            <h1 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-file-earmark-spreadsheet-fill text-success me-2"></i>ระบบรายงานและการส่งออกข้อมูล (Reporting Engine)
            </h1>
            <p class="text-muted small mb-0">ออกรายงานสรุปสำหรับฝ่ายบริหาร ตรวจสอบบัญชี และส่งออกไฟล์ Excel / CSV มาตรฐาน UTF-8</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm">
                <i class="bi bi-printer me-1"></i> พิมพ์รายงาน
            </button>
            <?php 
                $exportQuery = http_build_query([
                    'type' => $reportType,
                    'export' => 'csv',
                    'q' => $search ?? '',
                    'dept' => $selectedDept ?? '',
                    'status' => $selectedStatus ?? ''
                ]);
            ?>
            <a href="<?= url('staff/reports?' . $exportQuery) ?>" class="btn btn-success btn-sm rounded-pill px-3 fw-semibold shadow-sm">
                <i class="bi bi-file-earmark-excel me-1"></i> ส่งออก Excel / CSV
            </a>
        </div>
    </div>

    <!-- Report Type Selector Tabs -->
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= url('staff/reports?type=members') ?>" class="btn btn-<?= $reportType === 'members' ? 'primary' : 'outline-secondary' ?> rounded-pill btn-sm px-3 fw-medium">
                <i class="bi bi-people me-1"></i> รายงานทะเบียนสมาชิก
            </a>
            <a href="<?= url('staff/reports?type=shares') ?>" class="btn btn-<?= $reportType === 'shares' ? 'primary' : 'outline-secondary' ?> rounded-pill btn-sm px-3 fw-medium">
                <i class="bi bi-pie-chart me-1"></i> รายงานทุนเรือนหุ้น
            </a>
            <a href="<?= url('staff/reports?type=deposits') ?>" class="btn btn-<?= $reportType === 'deposits' ? 'primary' : 'outline-secondary' ?> rounded-pill btn-sm px-3 fw-medium">
                <i class="bi bi-wallet2 me-1"></i> รายงานเงินรับฝาก
            </a>
            <a href="<?= url('staff/reports?type=loans') ?>" class="btn btn-<?= $reportType === 'loans' ? 'primary' : 'outline-secondary' ?> rounded-pill btn-sm px-3 fw-medium">
                <i class="bi bi-cash-stack me-1"></i> รายงานลูกหนี้เงินกู้
            </a>
            <a href="<?= url('staff/reports?type=welfares') ?>" class="btn btn-<?= $reportType === 'welfares' ? 'primary' : 'outline-secondary' ?> rounded-pill btn-sm px-3 fw-medium">
                <i class="bi bi-heart-pulse me-1"></i> รายงานสวัสดิการ
            </a>
            <a href="<?= url('staff/reports?type=receipts') ?>" class="btn btn-<?= $reportType === 'receipts' ? 'primary' : 'outline-secondary' ?> rounded-pill btn-sm px-3 fw-medium">
                <i class="bi bi-receipt me-1"></i> รายงานเรียกเก็บรายเดือน
            </a>
        </div>
    </div>

    <!-- Summary KPI Metrics Cards -->
    <?php $summary = $reportData['summary'] ?? []; ?>
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-primary">
                <div class="text-muted small">จำนวนรายการทั้งหมด</div>
                <h3 class="fw-bold text-navy mb-0 font-monospace"><?= number_format($summary['count'] ?? count($reportData['data'] ?? [])) ?> <span class="fs-6 fw-normal text-muted">รายการ</span></h3>
            </div>
        </div>

        <?php if ($reportType === 'members'): ?>
            <div class="col-6 col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-success">
                    <div class="text-muted small">มูลค่าทุนเรือนหุ้นสมาชิกรวม</div>
                    <h3 class="fw-bold text-success mb-0 font-monospace">฿<?= number_format((float)($summary['total_share'] ?? 0), 2) ?></h3>
                </div>
            </div>
        <?php elseif ($reportType === 'shares'): ?>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-info">
                    <div class="text-muted small">จำนวนหุ้นรวม</div>
                    <h3 class="fw-bold text-info mb-0 font-monospace"><?= number_format((float)($summary['total_shares'] ?? 0)) ?> <span class="fs-6 fw-normal text-muted">หุ้น</span></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-success">
                    <div class="text-muted small">มูลค่าทุนเรือนหุ้นรวม</div>
                    <h3 class="fw-bold text-success mb-0 font-monospace">฿<?= number_format((float)($summary['total_amount'] ?? 0), 2) ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-warning">
                    <div class="text-muted small">ยอดส่งค่าหุ้น/เดือนรวม</div>
                    <h3 class="fw-bold text-warning mb-0 font-monospace">฿<?= number_format((float)($summary['total_monthly'] ?? 0), 2) ?></h3>
                </div>
            </div>
        <?php elseif ($reportType === 'deposits'): ?>
            <div class="col-6 col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-success">
                    <div class="text-muted small">ยอดเงินรับฝากคงเหลือรวม</div>
                    <h3 class="fw-bold text-success mb-0 font-monospace">฿<?= number_format((float)($summary['total_balance'] ?? 0), 2) ?></h3>
                </div>
            </div>
        <?php elseif ($reportType === 'loans'): ?>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-primary">
                    <div class="text-muted small">วงเงินกู้อนุมัติรวม</div>
                    <h3 class="fw-bold text-primary mb-0 font-monospace">฿<?= number_format((float)($summary['total_loan_amount'] ?? 0), 2) ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-danger">
                    <div class="text-muted small">ยอดหนี้คงเหลือรวม</div>
                    <h3 class="fw-bold text-danger mb-0 font-monospace">฿<?= number_format((float)($summary['total_principal'] ?? 0), 2) ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-warning">
                    <div class="text-muted small">ค่างวดผ่อนชำระ/เดือนรวม</div>
                    <h3 class="fw-bold text-warning mb-0 font-monospace">฿<?= number_format((float)($summary['total_monthly'] ?? 0), 2) ?></h3>
                </div>
            </div>
        <?php elseif ($reportType === 'welfares'): ?>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-info">
                    <div class="text-muted small">วงเงินขอรับสวัสดิการรวม</div>
                    <h3 class="fw-bold text-info mb-0 font-monospace">฿<?= number_format((float)($summary['total_claim'] ?? 0), 2) ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-success">
                    <div class="text-muted small">จำนวนเงินที่อนุมัติแล้วรวม</div>
                    <h3 class="fw-bold text-success mb-0 font-monospace">฿<?= number_format((float)($summary['total_approved'] ?? 0), 2) ?></h3>
                </div>
            </div>
        <?php elseif ($reportType === 'receipts'): ?>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-info">
                    <div class="text-muted small">ค่าหุ้นที่เรียกเก็บ</div>
                    <h3 class="fw-bold text-info mb-0 font-monospace">฿<?= number_format((float)($summary['total_share'] ?? 0), 2) ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-danger">
                    <div class="text-muted small">เงินต้น/ดอกเบี้ยเงินกู้</div>
                    <h3 class="fw-bold text-danger mb-0 font-monospace">฿<?= number_format((float)(($summary['total_loan_principal'] ?? 0) + ($summary['total_loan_interest'] ?? 0)), 2) ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-success">
                    <div class="text-muted small">รวมยอดเรียกเก็บสุทธิ</div>
                    <h3 class="fw-bold text-success mb-0 font-monospace">฿<?= number_format((float)($summary['total_grand'] ?? 0), 2) ?></h3>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Filter Bar Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <form action="<?= url('staff/reports') ?>" method="GET" class="row g-3 align-items-end">
            <input type="hidden" name="type" value="<?= e($reportType) ?>">

            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">ค้นหาคำสำคัญ (เลขสมาชิก / ชื่อ / เลขที่)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control border-start-0" placeholder="พิมพ์เพื่อค้นหา..." value="<?= e($search ?? '') ?>">
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">สังกัด / หน่วยงาน</label>
                <select name="dept" class="form-select">
                    <option value="">-- แสดงทุกหน่วยงาน --</option>
                    <?php if (!empty($departments)): ?>
                        <?php foreach ($departments as $d): ?>
                            <option value="<?= e($d) ?>" <?= ($selectedDept === $d) ? 'selected' : '' ?>><?= e($d) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <?php if (in_array($reportType, ['loans', 'welfares', 'members'])): ?>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">สถานะ</label>
                    <select name="status" class="form-select">
                        <option value="">-- แสดงทุกสถานะ --</option>
                        <?php if ($reportType === 'loans'): ?>
                            <option value="active" <?= ($selectedStatus === 'active') ? 'selected' : '' ?>>ปกติ (Active)</option>
                            <option value="closed" <?= ($selectedStatus === 'closed') ? 'selected' : '' ?>>ปิดสัญญาแล้ว (Closed)</option>
                        <?php elseif ($reportType === 'welfares'): ?>
                            <option value="approved" <?= ($selectedStatus === 'approved') ? 'selected' : '' ?>>อนุมัติแล้ว</option>
                            <option value="pending" <?= ($selectedStatus === 'pending') ? 'selected' : '' ?>>รอตรวจสอบ</option>
                            <option value="rejected" <?= ($selectedStatus === 'rejected') ? 'selected' : '' ?>>ไม่อนุมัติ</option>
                        <?php elseif ($reportType === 'members'): ?>
                            <option value="active" <?= ($selectedStatus === 'active') ? 'selected' : '' ?>>ปกติ (Active)</option>
                            <option value="resigned" <?= ($selectedStatus === 'resigned') ? 'selected' : '' ?>>ลาออก (Resigned)</option>
                        <?php endif; ?>
                    </select>
                </div>
            <?php endif; ?>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold">
                    <i class="bi bi-filter me-1"></i> คัดกรอง
                </button>
                <a href="<?= url('staff/reports?type=' . $reportType) ?>" class="btn btn-outline-secondary rounded-pill px-3" title="ล้างการค้นหา">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Report Printable Card & Data Table -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white" id="reportPrintArea">
        <!-- Print Header (Visible when printed) -->
        <div class="d-none d-print-block text-center border-bottom pb-3 mb-4">
            <h4 class="fw-bold text-navy mb-1">สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</h4>
            <h5 class="fw-bold mb-1"><?= e($reportData['title'] ?? 'รายงานสรุปข้อมูล') ?></h5>
            <div class="text-muted small">ข้อมูล ณ วันที่ <?= date('d/m/Y H:i:s') ?> | ออกรายงานโดย: <?= e(App\Core\Auth::user()['name'] ?? 'เจ้าหน้าที่สหกรณ์') ?></div>
        </div>

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-table text-primary me-2"></i><?= e($reportData['title'] ?? 'ตารางรายงาน') ?></h5>
                <p class="text-muted small mb-0">ข้อมูล ณ วันที่ <?= date('d/m/Y H:i') ?> | พบข้อมูลทั้งหมด <b><?= count($reportData['data'] ?? []) ?></b> รายการ</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0" style="font-size: 0.9rem;">
                <thead class="table-light">
                    <tr>
                        <?php if (!empty($reportData['headers'])): ?>
                            <?php foreach ($reportData['headers'] as $h): ?>
                                <th class="text-nowrap fw-bold text-navy"><?= e($h) ?></th>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($reportData['data'])): ?>
                        <?php foreach ($reportData['data'] as $row): ?>
                            <tr>
                                <?php foreach ($row as $cellIndex => $val): ?>
                                    <td class="<?= ($cellIndex === 0) ? 'text-muted small' : '' ?>">
                                        <?= e((string)$val) ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= count($reportData['headers'] ?? [1]) ?>" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                <h6>ไม่พบข้อมูลรายงานตามเงื่อนไขที่เลือก</h6>
                                <small>กรุณาลองเปลี่ยนคำค้นหา หรือรีเซ็ตตัวกรอง</small>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Print Signatures (Visible when printed) -->
        <div class="d-none d-print-block mt-5 pt-4">
            <div class="row text-center">
                <div class="col-4">
                    <div class="mb-4">......................................................</div>
                    <div>( <?= e(App\Core\Auth::user()['name'] ?? 'เจ้าหน้าที่ผู้จัดทำ') ?> )</div>
                    <small class="text-muted">เจ้าหน้าที่ผู้จัดทำรายงาน</small>
                </div>
                <div class="col-4">
                    <div class="mb-4">......................................................</div>
                    <div>( ...................................................... )</div>
                    <small class="text-muted">หัวหน้าฝ่ายการเงิน/สินเชื่อ</small>
                </div>
                <div class="col-4">
                    <div class="mb-4">......................................................</div>
                    <div>( ...................................................... )</div>
                    <small class="text-muted">ผู้จัดการสหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</small>
                </div>
            </div>
        </div>
    </div>
</div>

