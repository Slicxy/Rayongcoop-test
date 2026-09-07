<!-- Beneficiaries Total Allocation Alert -->
<div class="alert <?= $isValid ? 'alert-success' : 'alert-warning' ?> d-flex align-items-center justify-content-between rounded-4 p-3 mb-4 shadow-sm" role="alert">
    <div class="d-flex align-items-center gap-2">
        <i class="bi <?= $isValid ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?> fs-4"></i>
        <div>
            <strong>สัดส่วนผลประโยชน์รวม: <?= number_format((float)$totalPercentage, 2) ?>%</strong>
            <div class="small"><?= $isValid ? 'สัดส่วนผลประโยชน์ถูกต้องครบถ้วน 100%' : 'คำเตือน: ผลรวมสัดส่วนของผู้รับผลประโยชน์ต้องเท่ากับ 100%' ?></div>
        </div>
    </div>
    <button type="button" class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addBeneficiaryModal">
        <i class="bi bi-person-plus-fill me-1"></i> เพิ่มผู้รับผลประโยชน์
    </button>
</div>

<!-- Beneficiaries List -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 p-4 pb-0">
        <h5 class="fw-bold text-navy mb-0"><i class="bi bi-people-fill text-primary me-2"></i>รายชื่อผู้รับผลประโยชน์ของสมาชิก</h5>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อ - นามสกุล</th>
                        <th>ความสัมพันธ์</th>
                        <th>เลขบัตรประชาชน (Masked)</th>
                        <th>เบอร์โทรศัพท์</th>
                        <th class="text-end">สัดส่วน (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($beneficiaries)): ?>
                        <?php foreach ($beneficiaries as $idx => $b): ?>
                            <tr>
                                <td class="font-monospace fw-bold text-muted"><?= $idx + 1 ?></td>
                                <td class="fw-bold text-navy"><?= e($b['first_name'] . ' ' . $b['last_name']) ?></td>
                                <td><span class="badge bg-light text-navy border"><?= e($b['relationship']) ?></span></td>
                                <td class="font-monospace text-muted small"><?= e($b['id_card_masked']) ?></td>
                                <td class="small text-muted"><?= e($b['phone']) ?></td>
                                <td class="text-end font-monospace fw-bold text-primary fs-6"><?= number_format((float)$b['percentage'], 2) ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted small">
                                <i class="bi bi-info-circle me-1"></i> ยังไม่มีข้อมูลผู้รับผลประโยชน์
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add Beneficiary -->
<div class="modal fade" id="addBeneficiaryModal" tabindex="-1" aria-labelledby="addBeneficiaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-navy" id="addBeneficiaryModalLabel"><i class="bi bi-person-plus text-primary me-2"></i>เพิ่มผู้รับผลประโยชน์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= url('member/beneficiaries') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">ชื่อ <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" placeholder="ชื่อจริง" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">นามสกุล <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" placeholder="นามสกุล" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">ความสัมพันธ์ <span class="text-danger">*</span></label>
                            <select name="relationship" class="form-select" required>
                                <option value="คู่สมรส">คู่สมรส</option>
                                <option value="บุตร">บุตร</option>
                                <option value="บิดา">บิดา</option>
                                <option value="มารดา">มารดา</option>
                                <option value="พี่น้อง">พี่น้อง</option>
                                <option value="ผู้อยู่ในอุปการะ">ผู้อยู่ในอุปการะ</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">สัดส่วน (%) <span class="text-danger">*</span></label>
                            <input type="number" name="percentage" class="form-control" placeholder="เช่น 50" min="1" max="100" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">เลขบัตรประชาชน</label>
                            <input type="text" name="id_card_masked" class="form-control" placeholder="1-XXXX-XXXXX-XX-X" value="1-2199-XXXXX-99-9">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" placeholder="08X-XXX-XXXX" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4 fw-medium shadow-sm">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>
