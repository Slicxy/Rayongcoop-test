<?php
$member = $member ?? [];
?>
<div class="row g-4">
    <!-- Left Column: Member Card Summary -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 text-center p-4">
            <div class="position-relative d-inline-block mx-auto mb-3">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 100px; height: 100px; font-size: 42px;">
                    <?= mb_substr($member['first_name'] ?? 'ส', 0, 1, 'UTF-8') ?>
                </div>
                <span class="position-absolute bottom-0 end-0 bg-success text-white p-2 rounded-circle border border-white" title="สถานะปกติ">
                    <i class="bi bi-check-lg" style="font-size: 12px;"></i>
                </span>
            </div>

            <h5 class="fw-bold text-navy mb-1"><?= e(($member['prefix'] ?? '') . ($member['first_name'] ?? '') . ' ' . ($member['last_name'] ?? '')) ?></h5>
            <p class="text-muted small mb-2"><?= e($member['position'] ?? 'พยาบาลวิชาชีพ') ?></p>
            <div class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill font-monospace mb-3">
                <?= e($member['member_no'] ?? 'MEM-2024-0001') ?>
            </div>

            <ul class="list-group list-group-flush text-start small border-top pt-3">
                <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                    <span class="text-muted">หน่วยงานต้นสังกัด</span>
                    <span class="fw-medium text-end" style="max-width: 180px;"><?= e($member['department'] ?? '-') ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                    <span class="text-muted">วันที่เป็นสมาชิก</span>
                    <span class="fw-medium"><?= !empty($member['join_date']) ? date('d/m/Y', strtotime($member['join_date'])) : '-' ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                    <span class="text-muted">สถานะสมาชิกภาพ</span>
                    <span class="badge bg-success-subtle text-success">ปกติ (Active)</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Right Column: Profile Edit Form -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-navy mb-1"><i class="bi bi-person-lines-fill text-primary me-2"></i>รายละเอียดข้อมูลสมาชิก</h5>
                    <p class="text-muted small mb-0">สามารถแก้ไขเบอร์โทรศัพท์ อีเมล และที่อยู่ปัจจุบันได้ด้วยตนเอง</p>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="<?= url('member/profile') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="row g-3 mb-4">
                        <!-- Readonly Info -->
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">รหัสสมาชิก (Member ID)</label>
                            <input type="text" class="form-control bg-light" value="<?= e($member['member_no'] ?? '') ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">เลขบัตรประจำตัวประชาชน</label>
                            <input type="text" class="form-control bg-light font-monospace" value="1-2199-XXXXX-12-1 (Masked)" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">ชื่อ - นามสกุล</label>
                            <input type="text" class="form-control bg-light" value="<?= e(($member['prefix'] ?? '') . ($member['first_name'] ?? '') . ' ' . ($member['last_name'] ?? '')) ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">ตำแหน่ง</label>
                            <input type="text" class="form-control bg-light" value="<?= e($member['position'] ?? '') ?>" readonly>
                        </div>
                    </div>

                    <h6 class="fw-bold text-navy border-bottom pb-2 mb-3"><i class="bi bi-pencil-square text-primary me-2"></i>ข้อมูลติดต่อที่สามารถแก้ไขได้</h6>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">หมายเลขโทรศัพท์มือถือ <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="phone" class="form-control" value="<?= e($member['phone'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">อีเมล (Email) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" value="<?= e($member['email'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold">ที่อยู่ปัจจุบันที่ติดต่อได้ <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control" rows="3" required><?= e($member['address'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-light px-4">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary px-4 fw-medium shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> บันทึกข้อมูล
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
