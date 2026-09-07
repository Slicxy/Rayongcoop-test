<!-- Header & Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold">ยอดรวมชำระปี <?= ($selectedYear ?? date('Y')) + 543 ?></span>
                <span class="badge bg-primary-subtle text-primary rounded-pill p-2"><i class="bi bi-wallet2 fs-6"></i></span>
            </div>
            <h3 class="fw-bold text-navy mb-0">฿<?= number_format($stats['total_paid'] ?? 0, 2) ?></h3>
            <small class="text-muted">รวมค่าหุ้นและเงินกู้ประจำปี</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold">ส่งค่าหุ้นสะสมปีนี้</span>
                <span class="badge bg-success-subtle text-success rounded-pill p-2"><i class="bi bi-piggy-bank fs-6"></i></span>
            </div>
            <h3 class="fw-bold text-success mb-0">฿<?= number_format($stats['share_paid'] ?? 0, 2) ?></h3>
            <small class="text-muted">เพิ่มมูลค่าทุนเรือนหุ้น</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold">ชำระเงินกู้สะสมปีนี้</span>
                <span class="badge bg-warning-subtle text-warning rounded-pill p-2"><i class="bi bi-cash-coin fs-6"></i></span>
            </div>
            <h3 class="fw-bold text-warning mb-0">฿<?= number_format($stats['loan_paid'] ?? 0, 2) ?></h3>
            <small class="text-muted">เงินต้นและดอกเบี้ยตามสัญญา</small>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white">
    <!-- Card Header with Filter -->
    <div class="card-header bg-white border-0 p-4 pb-2">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
            <div>
                <h5 class="fw-bold text-navy mb-1"><i class="bi bi-receipt-cutoff text-primary me-2"></i>ใบเสร็จรับเงินประจำเดือน (Electronic Receipts)</h5>
                <p class="text-muted small mb-0">ประวัติการชำระเงินและใบเสร็จอิเล็กทรอนิกส์พร้อม QR Code ตรวจสอบความถูกต้องตามกฎหมาย</p>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="<?= url('member/receipts') ?>" class="row g-2 align-items-center bg-light p-3 rounded-3">
            <div class="col-auto">
                <span class="small fw-bold text-muted"><i class="bi bi-funnel me-1"></i> ตัวกรอง:</span>
            </div>
            <div class="col-sm-3 col-6">
                <select name="year" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                    <option value="">-- ทุกปี --</option>
                    <?php 
                        $curY = (int)date('Y');
                        for ($y = $curY; $y >= $curY - 3; $y--): 
                    ?>
                        <option value="<?= $y ?>" <?= ($selectedYear == $y) ? 'selected' : '' ?>><?= $y + 543 ?> (<?= $y ?>)</option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-sm-3 col-6">
                <select name="month" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                    <option value="">-- ทุกเดือน --</option>
                    <?php 
                        $thaiMonths = [1=>'มกราคม', 2=>'กุมภาพันธ์', 3=>'มีนาคม', 4=>'เมษายน', 5=>'พฤษภาคม', 6=>'มิถุนายน', 7=>'กรกฎาคม', 8=>'สิงหาคม', 9=>'กันยายน', 10=>'ตุลาคม', 11=>'พฤศจิกายน', 12=>'ธันวาคม'];
                        foreach ($thaiMonths as $mNum => $mName): 
                    ?>
                        <option value="<?= $mNum ?>" <?= ($selectedMonth == $mNum) ? 'selected' : '' ?>><?= $mNum ?> - <?= $mName ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if (!empty($selectedYear) || !empty($selectedMonth)): ?>
                <div class="col-auto">
                    <a href="<?= url('member/receipts') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="bi bi-x-circle me-1"></i> ล้างตัวกรอง
                    </a>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>งวดประจำเดือน</th>
                        <th>เลขที่ใบเสร็จ</th>
                        <th>วันที่ออกเอกสาร</th>
                        <th class="text-end">ค่าหุ้น (บ.)</th>
                        <th class="text-end">เงินกู้ (บ.)</th>
                        <th class="text-end">เงินฝาก (บ.)</th>
                        <th class="text-end">ยอดรวมทั้งสิ้น (บาท)</th>
                        <th class="text-center">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($receipts)): ?>
                        <?php foreach ($receipts as $r): ?>
                            <tr>
                                <td class="fw-bold small text-navy">
                                    <i class="bi bi-calendar-check me-1 text-primary"></i> <?= $r['billing_month'] ?>/<?= (int)$r['billing_year'] + 543 ?>
                                </td>
                                <td>
                                    <span class="font-monospace small fw-bold text-primary"><?= e($r['receipt_no']) ?></span>
                                </td>
                                <td class="small text-muted font-monospace"><?= date('d/m/Y', strtotime($r['issue_date'])) ?></td>
                                <td class="text-end font-monospace small"><?= number_format((float)$r['share_amount'], 2) ?></td>
                                <td class="text-end font-monospace small"><?= number_format((float)$r['loan_principal'] + (float)$r['loan_interest'], 2) ?></td>
                                <td class="text-end font-monospace small"><?= number_format((float)$r['deposit_amount'], 2) ?></td>
                                <td class="text-end font-monospace fw-bold text-success fs-6">
                                    ฿<?= number_format((float)$r['total_amount'], 2) ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?= url('member/receipts/print/' . $r['receipt_no']) ?>" target="_blank" class="btn btn-primary btn-sm rounded-pill px-3" title="เปิดดูเอกสารทางการ">
                                            <i class="bi bi-eye-fill me-1"></i> ดูใบเสร็จ
                                        </a>
                                        <a href="<?= url('member/receipts/print/' . $r['receipt_no'] . '?download=pdf') ?>" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3" title="ดาวน์โหลดไฟล์ PDF ทันที">
                                            <i class="bi bi-file-earmark-pdf-fill me-1"></i> PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted small">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                                <div>ไม่พบประวัติใบเสร็จรับเงินตามเงื่อนไขที่เลือก</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Receipt Quick View Modal -->
<div class="modal fade" id="receiptViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-body p-4" id="receiptPrintArea">
                <div class="text-center pb-3 border-bottom mb-3">
                    <div class="bg-primary text-white rounded-circle p-2 d-inline-flex mb-2" style="width: 48px; height: 48px;">
                        <i class="bi bi-bank2 fs-4"></i>
                    </div>
                    <h6 class="fw-bold text-navy mb-0">สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</h6>
                    <small class="text-muted">ใบเสร็จรับเงินอิเล็กทรอนิกส์ (Electronic Receipt)</small>
                </div>

                <div class="row g-2 small mb-3">
                    <div class="col-6"><span class="text-muted">เลขที่ใบเสร็จ:</span> <b id="rcpNo" class="font-monospace text-primary"></b></div>
                    <div class="col-6 text-end"><span class="text-muted">ประจำงวด:</span> <b id="rcpPeriod"></b></div>
                    <div class="col-6"><span class="text-muted">วันที่ออก:</span> <span id="rcpDate" class="font-monospace"></span></div>
                    <div class="col-6 text-end"><span class="text-muted">สถานะ:</span> <span class="badge bg-success-subtle text-success">ชำระแล้ว</span></div>
                    <div class="col-12 mt-2 pt-2 border-top">
                        <span class="text-muted">สมาชิก:</span> <b><?= e(($member['prefix'] ?? '') . ($member['first_name'] ?? '') . ' ' . ($member['last_name'] ?? '')) ?> (<?= e($member['member_no']) ?>)</b>
                    </div>
                </div>

                <table class="table table-sm small mb-3 border-top border-bottom">
                    <tbody>
                        <tr><td>1. ค่าหุ้นรายเดือน</td><td class="text-end font-monospace" id="rcpShare"></td></tr>
                        <tr><td>2. ชำระเงินต้นเงินกู้</td><td class="text-end font-monospace" id="rcpLoanP"></td></tr>
                        <tr><td>3. ดอกเบี้ยเงินกู้</td><td class="text-end font-monospace" id="rcpLoanI"></td></tr>
                        <tr><td>4. เงินฝากสะสม</td><td class="text-end font-monospace" id="rcpDep"></td></tr>
                        <tr class="fw-bold bg-light">
                            <td class="text-dark">ยอดรวมทั้งสิ้น</td>
                            <td class="text-end font-monospace text-success fs-6" id="rcpTotal"></td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center pt-2">
                    <div class="text-start">
                        <small class="text-muted d-block" style="font-size: 11px;"><i class="bi bi-shield-check text-success me-1"></i>ออกโดยระบบดิจิทัล</small>
                        <small class="text-muted" style="font-size: 11px;">มีผลสมบูรณ์ตามกฎหมาย</small>
                    </div>
                    <div class="bg-light border p-1 rounded text-center">
                        <img id="rcpQrImg" src="" alt="QR Verification" style="width: 50px; height: 50px;">
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top-0 p-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">ปิด</button>
                <a id="rcpPdfBtn" href="#" target="_blank" class="btn btn-danger rounded-pill px-3 fw-semibold">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> ดาวน์โหลด PDF (.pdf)
                </a>
                <a id="rcpPrintBtn" href="#" target="_blank" class="btn btn-primary rounded-pill px-3 fw-semibold">
                    <i class="bi bi-printer-fill me-1"></i> พิมพ์เอกสาร A4
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function viewReceipt(no, period, date, total, share, lp, li, dep, printUrl, qrToken) {
    document.getElementById('rcpNo').textContent = no;
    document.getElementById('rcpPeriod').textContent = period;
    document.getElementById('rcpDate').textContent = date;
    document.getElementById('rcpShare').textContent = share + ' บาท';
    document.getElementById('rcpLoanP').textContent = lp + ' บาท';
    document.getElementById('rcpLoanI').textContent = li + ' บาท';
    document.getElementById('rcpDep').textContent = dep + ' บาท';
    document.getElementById('rcpTotal').textContent = '฿' + total;
    document.getElementById('rcpPrintBtn').href = printUrl;
    document.getElementById('rcpPdfBtn').href = printUrl + '?download=pdf';

    if (qrToken) {
        const verifyUrl = "<?= url('verify-receipt/') ?>" + qrToken;
        document.getElementById('rcpQrImg').src = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" + encodeURIComponent(verifyUrl);
    }

    new bootstrap.Modal(document.getElementById('receiptViewModal')).show();
}
</script>
