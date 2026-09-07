<!-- Welfare Benefits Catalog -->
<div class="row g-3 mb-4">
    <?php foreach ($types as $w): ?>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white d-flex flex-column justify-content-between">
                <div>
                    <div class="bg-info-subtle text-info rounded-circle p-2 d-inline-flex mb-3" style="width: 44px; height: 44px;">
                        <i class="bi <?= e($w['icon'] ?? 'bi-heart-pulse') ?> fs-5"></i>
                    </div>
                    <h6 class="fw-bold text-navy mb-1"><?= e($w['name']) ?></h6>
                    <small class="text-muted d-block mb-2"><?= e($w['category']) ?></small>
                    <p class="small text-muted" style="font-size: 12px; line-height: 1.4;"><?= e($w['conditions']) ?></p>
                </div>
                <div class="border-top pt-2 mt-2">
                    <span class="small text-muted">วงเงินสิทธิ์สูงสุด</span>
                    <div class="fw-bold text-primary font-monospace fs-5"><?= number_format((float)$w['coverage_amount']) ?> <span class="fs-6 fw-normal text-muted">บาท</span></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Welfare Claim Application & History -->
<div class="row g-4">
    <!-- Submit Claim Form -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0">
                <h5 class="fw-bold text-navy mb-1"><i class="bi bi-gift-fill text-info me-2"></i>ยื่นขอรับเงินสวัสดิการออนไลน์</h5>
                <p class="text-muted small mb-0">กรอกข้อมูลและแนบเอกสารเพื่อขอรับเงินสวัสดิการ</p>
            </div>
            <div class="card-body p-4">
                <form action="<?= url('member/welfare/apply') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">ประเภทสวัสดิการที่ต้องการขอรับ <span class="text-danger">*</span></label>
                        <select name="welfare_type_id" class="form-select" required>
                            <?php foreach ($types as $t): ?>
                                <option value="<?= $t['id'] ?>"><?= e($t['name']) ?> (สูงสุด <?= number_format((float)$t['coverage_amount']) ?> บ.)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">จำนวนเงินที่ขอรับ (บาท) <span class="text-danger">*</span></label>
                        <input type="number" name="claim_amount" class="form-control" placeholder="เช่น 3000" min="100" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">รายละเอียดคำขอ / เอกสารอ้างอิง <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" placeholder="ระบุรายละเอียด เช่น ขอรับสวัสดิการคลอดบุตร พร้อมแนบสูติบัตร" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">แนบเอกสารหลักฐาน (สูติบัตร/ใบเสร็จ/ใบรับรองแพทย์)</label>
                        <input type="file" name="doc_proof" class="form-control form-control-sm">
                    </div>

                    <button type="submit" class="btn btn-info text-white w-100 py-2 fw-medium shadow-sm">
                        <i class="bi bi-send me-1"></i> ยื่นคำขอรับสวัสดิการ
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Welfare History -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 p-4 pb-0">
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-clock-history text-primary me-2"></i>ประวัติการขอรับสวัสดิการ</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small">
                            <tr>
                                <th>เลขที่คำขอ</th>
                                <th>ประเภทสวัสดิการ</th>
                                <th class="text-end">ยอดเงิน</th>
                                <th>สถานะ</th>
                                <th>วันที่ยื่น</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($applications)): ?>
                                <?php foreach ($applications as $app): ?>
                                    <tr>
                                        <td class="font-monospace small fw-bold text-navy"><?= e($app['application_no']) ?></td>
                                        <td class="small fw-medium"><?= e($app['welfare_name']) ?></td>
                                        <td class="text-end font-monospace small fw-bold text-success"><?= number_format((float)$app['claim_amount'], 2) ?></td>
                                        <td>
                                            <?php if ($app['status'] === 'approved'): ?>
                                                <span class="badge bg-success-subtle text-success">อนุมัติแล้ว</span>
                                            <?php elseif ($app['status'] === 'rejected'): ?>
                                                <span class="badge bg-danger-subtle text-danger">ไม่อนุมัติ</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning-subtle text-warning">รอตรวจสอบ</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="small text-muted"><?= date('d/m/Y', strtotime($app['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted small">
                                        <i class="bi bi-info-circle me-1"></i> ยังไม่มีประวัติการขอรับสวัสดิการ
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
