<?php
$welfares = $welfares ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-heart-pulse me-2 text-primary"></i> จัดการสวัสดิการสมาชิก</h3>
        <p class="text-muted small mb-0">รายการสวัสดิการสงเคราะห์ ทุนการศึกษา และเงินช่วยเหลือสมาชิก</p>
    </div>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createWelfareModal">
        <i class="bi bi-plus-lg me-1"></i> เพิ่มสวัสดิการใหม่
    </button>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>ชื่อสวัสดิการ</th>
                        <th>หมวดหมู่</th>
                        <th>วงเงินช่วยเหลือ</th>
                        <th>คุณสมบัติ</th>
                        <th>สถานะ</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($welfares as $i => $w): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <div class="fw-bold text-navy"><?= e($w['title']) ?></div>
                                <small class="text-muted"><?= e($w['short_description'] ?? '') ?></small>
                            </td>
                            <td><span class="badge bg-light text-navy border"><?= e($w['category']) ?></span></td>
                            <td class="fw-bold text-success"><?= e($w['benefit_amount']) ?></td>
                            <td class="small text-muted text-truncate" style="max-width: 220px;"><?= e($w['eligibility']) ?></td>
                            <td>
                                <span class="badge <?= $w['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= e(strtoupper($w['status'])) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteWelfare(<?= $w['id'] ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Welfare Modal -->
<div class="modal fade" id="createWelfareModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy">เพิ่มสวัสดิการสมาชิกใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/welfare/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-3">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold small">ชื่อสวัสดิการ <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required placeholder="เช่น สวัสดิการสมาชิกถึงแก่กรรม...">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">หมวดหมู่ <span class="text-danger">*</span></label>
                            <input type="text" name="category" class="form-control" required placeholder="เช่น สวัสดิการเกื้อกูล">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">วงเงินช่วยเหลือ / ประโยชน์ที่ได้รับ <span class="text-danger">*</span></label>
                            <input type="text" name="benefit_amount" class="form-control" required placeholder="เช่น สูงสุด 200,000 บาท">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">ติดต่อสอบถาม</label>
                            <input type="text" name="contact_info" class="form-control" placeholder="ฝ่ายสวัสดิการ โทร. 038-611178 ต่อ 105">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">คำอธิบายย่อ</label>
                        <textarea name="short_description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">คุณสมบัติผู้มีสิทธิ์</label>
                        <input type="text" name="eligibility" class="form-control" placeholder="สมาชิกสามัญที่ถึงแก่กรรม...">
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">บันทึกสวัสดิการ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteWelfare(id) {
    showDeleteConfirm(() => {
        fetch(window.APP_URL + '/admin/welfare/' + id + '/delete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'ลบสวัสดิการเรียบร้อยแล้ว');
                setTimeout(() => location.reload(), 800);
            } else {
                showError('เกิดข้อผิดพลาด', data.message);
            }
        });
    });
}
</script>
