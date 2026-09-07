<div class="container-fluid py-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-cash-stack text-primary me-2"></i>ตรวจสอบและอนุมัติคำขอกู้เงิน
            </h1>
            <p class="text-muted small mb-0">ระบบพิจารณาคำขอกู้เงินออนไลน์ ตรวจสอบเอกสาร และบันทึกผลการอนุมัติ</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= url('staff/loans') ?>" class="btn btn-<?= empty($currentStatus) ? 'primary' : 'outline-secondary' ?> btn-sm rounded-pill px-3">
                ทั้งหมด
            </a>
            <a href="<?= url('staff/loans?status=submitted') ?>" class="btn btn-<?= $currentStatus === 'submitted' ? 'warning' : 'outline-warning' ?> btn-sm rounded-pill px-3">
                <i class="bi bi-clock me-1"></i>รอพิจารณา
            </a>
            <a href="<?= url('staff/loans?status=approved') ?>" class="btn btn-<?= $currentStatus === 'approved' ? 'success' : 'outline-success' ?> btn-sm rounded-pill px-3">
                <i class="bi bi-check-circle me-1"></i>อนุมัติแล้ว
            </a>
        </div>
    </div>

    <!-- Loan Applications Table Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle coop-datatable">
                <thead class="table-light">
                    <tr>
                        <th>เลขที่คำขอ</th>
                        <th>ผู้ขอกู้ (สมาชิก)</th>
                        <th>ประเภทเงินกู้</th>
                        <th>วงเงินที่ยื่นกู้</th>
                        <th>ระยะเวลา</th>
                        <th>สถานะ</th>
                        <th class="text-end">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($applications)): ?>
                        <?php foreach ($applications as $app): ?>
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary font-monospace"><?= e($app['application_no']) ?></span>
                                    <div class="text-muted" style="font-size: 0.72rem;"><?= date('d/m/Y H:i', strtotime($app['created_at'])) ?></div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= e($app['member_name']) ?></div>
                                    <div class="text-muted small"><?= e($app['member_no']) ?> • <?= e($app['department'] ?? '-') ?></div>
                                    <div class="text-muted" style="font-size: 0.72rem;"><i class="bi bi-telephone me-1"></i><?= e($app['phone'] ?? '-') ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border"><?= e($app['loan_type']) ?></span>
                                    <div class="text-muted small mt-1">วัตถุประสงค์: <?= e($app['purpose'] ?? '-') ?></div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-6">฿<?= number_format((float)$app['requested_amount'], 2) ?></div>
                                    <div class="text-muted small">เงินเดือน: ฿<?= number_format((float)($app['monthly_income'] ?? 0), 2) ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary"><?= (int)$app['term_months'] ?> งวด</span>
                                </td>
                                <td>
                                    <?php
                                    $statusBadge = match($app['status']) {
                                        'submitted' => 'bg-warning-subtle text-warning border-warning-subtle',
                                        'approved' => 'bg-success-subtle text-success border-success-subtle',
                                        'rejected' => 'bg-danger-subtle text-danger border-danger-subtle',
                                        'document_review' => 'bg-info-subtle text-info border-info-subtle',
                                        default => 'bg-light text-dark'
                                    };
                                    $statusLabel = match($app['status']) {
                                        'submitted' => 'รอตรวจสอบ',
                                        'approved' => 'อนุมัติแล้ว',
                                        'rejected' => 'ไม่อนุมัติ',
                                        'document_review' => 'ขอเอกสารเพิ่ม',
                                        default => $app['status']
                                    };
                                    ?>
                                    <span class="badge <?= $statusBadge ?> border rounded-pill px-3 py-1"><?= $statusLabel ?></span>
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#reviewModal<?= $app['id'] ?>">
                                        <i class="bi bi-pencil-square me-1"></i>พิจารณา
                                    </button>
                                </td>
                            </tr>

                            <!-- Review Modal -->
                            <div class="modal fade" id="reviewModal<?= $app['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold">
                                                <i class="bi bi-file-earmark-check text-primary me-2"></i>พิจารณาคำขอกู้เงิน: <?= e($app['application_no']) ?>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="<?= url('staff/loans/review') ?>" method="POST">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                                            <div class="modal-body py-4">
                                                <div class="p-3 bg-light rounded-3 mb-3">
                                                    <div class="row g-2">
                                                        <div class="col-md-6">
                                                            <div class="text-muted small">ผู้ขอกู้</div>
                                                            <div class="fw-bold"><?= e($app['member_name']) ?> (<?= e($app['member_no']) ?>)</div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="text-muted small">ประเภทสินเชื่อ</div>
                                                            <div class="fw-bold text-primary"><?= e($app['loan_type']) ?></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="text-muted small">วงเงินที่ยื่นขอ</div>
                                                            <div class="fw-bold fs-5 text-dark">฿<?= number_format((float)$app['requested_amount'], 2) ?></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="text-muted small">จำนวนงวดที่ขอผ่อน</div>
                                                            <div class="fw-bold"><?= (int)$app['term_months'] ?> งวด</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">ผลการพิจารณา <span class="text-danger">*</span></label>
                                                    <div class="d-flex gap-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="action" id="act_approve<?= $app['id'] ?>" value="approved" checked>
                                                            <label class="form-check-label text-success fw-bold" for="act_approve<?= $app['id'] ?>">
                                                                <i class="bi bi-check-circle me-1"></i>อนุมัติเงินกู้
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="action" id="act_doc<?= $app['id'] ?>" value="document_review">
                                                            <label class="form-check-label text-info fw-bold" for="act_doc<?= $app['id'] ?>">
                                                                <i class="bi bi-file-earmark-arrow-up me-1"></i>ขอเอกสารเพิ่มเติม
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="action" id="act_reject<?= $app['id'] ?>" value="rejected">
                                                            <label class="form-check-label text-danger fw-bold" for="act_reject<?= $app['id'] ?>">
                                                                <i class="bi bi-x-circle me-1"></i>ไม่อนุมัติ
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">ความเห็นเจ้าหน้าที่ / หมายเหตุ</label>
                                                    <textarea name="comment" class="form-control" rows="3" placeholder="ระบุเหตุผลในการอนุมัติ หรือเอกสารที่ต้องการเพิ่มเติม..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4">บันทึกผลการพิจารณา</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-clipboard-check fs-1 d-block mb-2 text-secondary"></i>
                                ไม่พบคำขอกู้เงินในสถานะนี้
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
