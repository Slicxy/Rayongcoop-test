<?php
$products = $products ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-piggy-bank me-2 text-primary"></i> จัดการผลิตภัณฑ์เงินฝาก</h3>
        <p class="text-muted small mb-0">รายการบัญชีเงินฝากออมทรัพย์ เงินฝากประจำ และเงื่อนไขการฝากถอน</p>
    </div>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createDepositModal">
        <i class="bi bi-plus-lg me-1"></i> เพิ่มผลิตภัณฑ์ใหม่
    </button>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>ชื่อผลิตภัณฑ์</th>
                        <th>ดอกเบี้ย (% ต่อปี)</th>
                        <th>เงินฝากขั้นต่ำ</th>
                        <th>เงื่อนไขการถอน</th>
                        <th>สถานะ</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <div class="fw-bold text-navy"><?= e($p['name']) ?></div>
                                <small class="text-muted"><?= e($p['short_description'] ?? '') ?></small>
                            </td>
                            <td><span class="badge bg-gold text-white fs-6"><?= number_format((float)$p['interest_rate'], 2) ?>%</span></td>
                            <td class="font-monospace"><?= format_money($p['min_deposit']) ?> บาท</td>
                            <td class="small text-muted text-truncate" style="max-width: 220px;"><?= e($p['withdrawal_condition'] ?? '-') ?></td>
                            <td>
                                <span class="badge <?= $p['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= e(strtoupper($p['status'])) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteDeposit(<?= $p['id'] ?>)">
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

<!-- Create Deposit Modal -->
<div class="modal fade" id="createDepositModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy">เพิ่มผลิตภัณฑ์เงินฝากใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/deposits/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">ชื่อผลิตภัณฑ์เงินฝาก <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="เช่น เงินฝากออมทรัพย์พิเศษ...">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">อัตราดอกเบี้ย (% ต่อปี) <span class="text-danger">*</span></label>
                            <input type="number" name="interest_rate" class="form-control" step="0.001" required placeholder="3.100">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">เงินฝากขั้นต่ำ (บาท)</label>
                            <input type="number" name="min_deposit" class="form-control" value="500">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">คำอธิบายย่อ (Short Description)</label>
                        <input type="text" name="short_description" class="form-control" placeholder="จุดเด่นสำคัญ เช่น ดอกเบี้ยสูง ปลอดภาษี...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">เงื่อนไขการถอน</label>
                        <input type="text" name="withdrawal_condition" class="form-control" placeholder="เช่น ถอนได้เดือนละ 1 ครั้งโดยไม่มีค่าธรรมเนียม">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">คุณสมบัติผู้เปิดบัญชี</label>
                        <input type="text" name="eligibility" class="form-control" placeholder="สมาชิกสามัญ และ สมาชิกสมทบ">
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="chkFeaturedDeposit">
                        <label class="form-check-label small" for="chkFeaturedDeposit">แสดงเป็นผลิตภัณฑ์แนะนำบนหน้าแรก</label>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">บันทึกผลิตภัณฑ์</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteDeposit(id) {
    showDeleteConfirm(() => {
        fetch(window.APP_URL + '/admin/deposits/' + id + '/delete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'ลบผลิตภัณฑ์เงินฝากเรียบร้อยแล้ว');
                setTimeout(() => location.reload(), 800);
            } else {
                showError('เกิดข้อผิดพลาด', data.message);
            }
        });
    });
}
</script>
