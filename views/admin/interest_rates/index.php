<?php
$depositRates = $depositRates ?? [];
$loanRates = $loanRates ?? [];
$history = $history ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-percent me-2 text-primary"></i> จัดการอัตราดอกเบี้ยและประวัติ</h3>
        <p class="text-muted small mb-0">อัตราดอกเบี้ยเงินฝาก-เงินกู้ พร้อมระบบเก็บบันทึกประวัติการเปลี่ยนแปลงแบบไม่ลบข้อมูลเก่า</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Deposit Rates -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h5 class="admin-card-title"><i class="bi bi-piggy-bank text-primary me-2"></i> อัตราดอกเบี้ยเงินฝาก</h5>
            </div>
            <div class="admin-card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ประเภทเงินฝาก</th>
                                <th>อัตราปัจจุบัน</th>
                                <th>วันที่มีผล</th>
                                <th class="text-end">ปรับอัตรา</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($depositRates as $dr): ?>
                                <tr>
                                    <td class="fw-bold text-navy small"><?= e($dr['product_name']) ?></td>
                                    <td><span class="badge bg-gold text-white fs-6"><?= number_format((float)$dr['rate'], 2) ?>%</span></td>
                                    <td class="small text-muted"><?= thai_date($dr['effective_date']) ?></td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="openRateModal(<?= $dr['id'] ?>, '<?= e($dr['product_name']) ?>', <?= $dr['rate'] ?>)">
                                            <i class="bi bi-pencil-square"></i> แก้ไข
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Loan Rates -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h5 class="admin-card-title"><i class="bi bi-cash-coin text-primary me-2"></i> อัตราดอกเบี้ยเงินกู้</h5>
            </div>
            <div class="admin-card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ประเภทสินเชื่อ</th>
                                <th>อัตราปัจจุบัน</th>
                                <th>วันที่มีผล</th>
                                <th class="text-end">ปรับอัตรา</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($loanRates as $lr): ?>
                                <tr>
                                    <td class="fw-bold text-navy small"><?= e($lr['product_name']) ?></td>
                                    <td><span class="badge bg-primary text-white fs-6"><?= number_format((float)$lr['rate'], 2) ?>%</span></td>
                                    <td class="small text-muted"><?= thai_date($lr['effective_date']) ?></td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="openRateModal(<?= $lr['id'] ?>, '<?= e($lr['product_name']) ?>', <?= $lr['rate'] ?>)">
                                            <i class="bi bi-pencil-square"></i> แก้ไข
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Interest Rate Audit History Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="admin-card-title"><i class="bi bi-clock-history me-2 text-primary"></i> ประวัติการเปลี่ยนแปลงอัตราดอกเบี้ย (Historical Audit Log)</h5>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle coop-datatable mb-0">
                <thead class="table-light">
                    <tr>
                        <th>วันที่มีผล</th>
                        <th>ประเภทผลิตภัณฑ์</th>
                        <th>อัตราเดิม</th>
                        <th>อัตราใหม่</th>
                        <th>ผู้ปรับปรุง</th>
                        <th>เหตุผล / หมายเหตุ</th>
                        <th>บันทึกเมื่อ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history as $h): ?>
                        <tr>
                            <td class="fw-semibold text-navy"><?= thai_date($h['effective_date']) ?></td>
                            <td><?= e($h['product_name']) ?></td>
                            <td class="font-monospace text-muted"><?= number_format((float)$h['old_rate'], 2) ?>%</td>
                            <td class="font-monospace fw-bold text-primary"><?= number_format((float)$h['new_rate'], 2) ?>%</td>
                            <td class="small"><?= e($h['changer_name'] ?? 'Admin') ?></td>
                            <td class="small text-secondary"><?= e($h['note'] ?? '-') ?></td>
                            <td class="small text-muted"><?= date('d/m/Y H:i', strtotime($h['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Update Rate Modal -->
<div class="modal fade" id="updateRateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy" id="rateModalTitle">ปรับอัตราดอกเบี้ย</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rateUpdateForm" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">อัตราดอกเบี้ยใหม่ (% ต่อปี) <span class="text-danger">*</span></label>
                        <input type="number" name="new_rate" id="modalNewRate" class="form-control form-control-lg font-monospace" step="0.001" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">วันที่มีผลบังคับใช้ (Effective Date) <span class="text-danger">*</span></label>
                        <input type="date" name="effective_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">เหตุผล / มติที่ประชุม / หมายเหตุ <span class="text-danger">*</span></label>
                        <textarea name="note" class="form-control" rows="3" placeholder="ระบุมติที่ประชุมคณะกรรมการดำเนินการ ครั้งที่..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">บันทึกอัตราดอกเบี้ย</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRateModal(id, name, currentRate) {
    document.getElementById('rateModalTitle').textContent = 'ปรับอัตราดอกเบี้ย: ' + name;
    document.getElementById('modalNewRate').value = currentRate;
    document.getElementById('rateUpdateForm').action = window.APP_URL + '/admin/interest-rates/' + id + '/update';
    new bootstrap.Modal(document.getElementById('updateRateModal')).show();
}
</script>
