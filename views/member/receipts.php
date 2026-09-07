<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 p-4 pb-2 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold text-navy mb-1"><i class="bi bi-receipt text-primary me-2"></i>ใบเสร็จรับเงินประจำเดือน (Electronic Receipts)</h5>
            <p class="text-muted small mb-0">ประวัติการชำระเงินและใบเสร็จอิเล็กทรอนิกส์พร้อม QR Code ตรวจสอบความถูกต้อง</p>
        </div>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>งวดประจำเดือน</th>
                        <th>เลขที่ใบเสร็จ</th>
                        <th>วันที่ออกใบเสร็จ</th>
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
                                    <i class="bi bi-calendar-event me-1 text-primary"></i> <?= $r['billing_month'] ?>/<?= $r['billing_year'] ?>
                                </td>
                                <td class="font-monospace small fw-bold text-primary"><?= e($r['receipt_no']) ?></td>
                                <td class="small text-muted font-monospace"><?= date('d/m/Y', strtotime($r['issue_date'])) ?></td>
                                <td class="text-end font-monospace small"><?= number_format((float)$r['share_amount'], 2) ?></td>
                                <td class="text-end font-monospace small"><?= number_format((float)$r['loan_principal'] + (float)$r['loan_interest'], 2) ?></td>
                                <td class="text-end font-monospace small"><?= number_format((float)$r['deposit_amount'], 2) ?></td>
                                <td class="text-end font-monospace fw-bold text-success fs-6"><?= number_format((float)$r['total_amount'], 2) ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="viewReceipt('<?= e($r['receipt_no']) ?>', '<?= $r['billing_month'] ?>/<?= $r['billing_year'] ?>', '<?= number_format((float)$r['total_amount'], 2) ?>', '<?= number_format((float)$r['share_amount'], 2) ?>', '<?= number_format((float)$r['loan_principal'], 2) ?>', '<?= number_format((float)$r['loan_interest'], 2) ?>', '<?= number_format((float)$r['deposit_amount'], 2) ?>')">
                                        <i class="bi bi-eye me-1"></i> ดูใบเสร็จ
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted small">
                                <i class="bi bi-info-circle me-1"></i> ไม่พบประวัติใบเสร็จรับเงิน
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-body p-4" id="receiptPrintArea">
                <div class="text-center pb-3 border-bottom mb-3">
                    <div class="bg-primary text-white rounded-circle p-2 d-inline-flex mb-2" style="width: 44px; height: 44px;"><i class="bi bi-bank2 fs-4"></i></div>
                    <h6 class="fw-bold text-navy mb-0">สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</h6>
                    <small class="text-muted">ใบเสร็จรับเงินอิเล็กทรอนิกส์ (Electronic Receipt)</small>
                </div>

                <div class="row g-2 small mb-3">
                    <div class="col-6"><span class="text-muted">เลขที่:</span> <b id="rcpNo" class="font-monospace"></b></div>
                    <div class="col-6 text-end"><span class="text-muted">งวด:</span> <b id="rcpPeriod"></b></div>
                    <div class="col-12"><span class="text-muted">สมาชิก:</span> <b><?= e(($member['prefix'] ?? '') . ($member['first_name'] ?? '') . ' ' . ($member['last_name'] ?? '')) ?> (<?= e($member['member_no']) ?>)</b></div>
                </div>

                <table class="table table-sm small mb-3 border-top border-bottom">
                    <tbody>
                        <tr><td>1. ค่าหุ้นรายเดือน</td><td class="text-end font-monospace" id="rcpShare"></td></tr>
                        <tr><td>2. ชำระเงินต้นเงินกู้</td><td class="text-end font-monospace" id="rcpLoanP"></td></tr>
                        <tr><td>3. ดอกเบี้ยเงินกู้</td><td class="text-end font-monospace" id="rcpLoanI"></td></tr>
                        <tr><td>4. เงินฝากสะสม</td><td class="text-end font-monospace" id="rcpDep"></td></tr>
                        <tr class="fw-bold bg-light"><td>ยอดรวมทั้งสิ้น</td><td class="text-end font-monospace text-primary fs-6" id="rcpTotal"></td></tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center pt-2">
                    <div class="text-start">
                        <small class="text-muted d-block" style="font-size: 10px;">ออกโดยระบบบริการดิจิทัล</small>
                        <small class="text-muted" style="font-size: 10px;">มีผลสมบูรณ์ตามกฎหมาย</small>
                    </div>
                    <div class="bg-light border p-1 rounded text-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-qr-code fs-3 text-dark"></i>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="window.print()"><i class="bi bi-printer me-1"></i> พิมพ์ / ดาวน์โหลด PDF</button>
            </div>
        </div>
    </div>
</div>

<script>
function viewReceipt(no, period, total, share, lp, li, dep) {
    document.getElementById('rcpNo').textContent = no;
    document.getElementById('rcpPeriod').textContent = period;
    document.getElementById('rcpShare').textContent = share + ' บ.';
    document.getElementById('rcpLoanP').textContent = lp + ' บ.';
    document.getElementById('rcpLoanI').textContent = li + ' บ.';
    document.getElementById('rcpDep').textContent = dep + ' บ.';
    document.getElementById('rcpTotal').textContent = total + ' บาท';

    new bootstrap.Modal(document.getElementById('receiptViewModal')).show();
}
</script>
