<div class="container-fluid py-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-heart-pulse-fill text-primary me-2"></i>ตรวจสอบและอนุมัติสวัสดิการสมาชิก
            </h1>
            <p class="text-muted small mb-0">ระบบพิจารณาคำขอรับเงินสวัสดิการสงเคราะห์และทุนการศึกษา</p>
        </div>
    </div>

    <!-- Welfare Applications Table -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle coop-datatable">
                <thead class="table-light">
                    <tr>
                        <th>เลขที่คำขอ</th>
                        <th>สมาชิก</th>
                        <th>ประเภทสวัสดิการ</th>
                        <th>ยอดขอรับ</th>
                        <th>วันที่ยื่น</th>
                        <th>สถานะ</th>
                        <th class="text-end">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($applications)): ?>
                        <?php foreach ($applications as $app): ?>
                            <tr>
                                <td>
                                    <span class="fw-bold font-monospace text-primary"><?= e($app['application_no']) ?></span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= e($app['member_name']) ?></div>
                                    <div class="text-muted small"><?= e($app['member_no']) ?> • <?= e($app['department'] ?? '-') ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border"><?= e($app['welfare_name']) ?></span>
                                    <div class="text-muted small mt-1"><?= e($app['description'] ?? '-') ?></div>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark fs-6">฿<?= number_format((float)$app['claim_amount'], 2) ?></span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($app['created_at'])) ?></td>
                                <td>
                                    <?php if ($app['status'] === 'approved'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">อนุมัติแล้ว</span>
                                    <?php elseif ($app['status'] === 'rejected'): ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">ไม่อนุมัติ</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3">รอพิจารณา</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#welfareModal<?= $app['id'] ?>">
                                        <i class="bi bi-pencil-square me-1"></i>พิจารณา
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modals rendered outside Table for DataTables Compliance -->
<?php if (!empty($applications)): ?>
    <?php foreach ($applications as $app): ?>
        <div class="modal fade" id="welfareModal<?= $app['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">พิจารณาคำขอสวัสดิการ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= url('staff/welfare/review') ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                        <div class="modal-body py-4">
                            <div class="p-3 bg-light rounded-3 mb-3">
                                <div class="text-muted small">ผู้ขอรับสวัสดิการ:</div>
                                <div class="fw-bold"><?= e($app['member_name']) ?> (<?= e($app['member_no']) ?>)</div>
                                <div class="text-muted small mt-2">สวัสดิการ:</div>
                                <div class="fw-bold text-primary"><?= e($app['welfare_name']) ?> — ฿<?= number_format((float)$app['claim_amount'], 2) ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">ผลการพิจารณา</label>
                                <select name="action" class="form-select">
                                    <option value="approved">อนุมัติการจ่ายสวัสดิการ</option>
                                    <option value="rejected">ไม่อนุมัติ</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">ความเห็น / หมายเหตุ</label>
                                <textarea name="comment" class="form-control" rows="2" placeholder="ระบุเหตุผลหรือข้อความแจ้งสมาชิก..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
