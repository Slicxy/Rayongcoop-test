<?php
$products = $products ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-cash-stack me-2 text-primary"></i> จัดการผลิตภัณฑ์เงินกู้และสินเชื่อ</h3>
        <p class="text-muted small mb-0">รายการเงินกู้สามัญ ฉุกเฉิน พิเศษ และเงื่อนไขการคำนวณดอกเบี้ย</p>
    </div>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createLoanModal">
        <i class="bi bi-plus-lg me-1"></i> เพิ่มสินเชื่อใหม่
    </button>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>ชื่อประเภทสินเชื่อ</th>
                        <th>หมวดหมู่</th>
                        <th>ดอกเบี้ย (% ต่อปี)</th>
                        <th>วงเงินกู้สูงสุด</th>
                        <th>ผ่อนนานสุด</th>
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
                            <td><span class="badge bg-light text-navy border"><?= e($p['category']) ?></span></td>
                            <td><span class="badge bg-primary text-white fs-6"><?= number_format((float)$p['interest_rate'], 2) ?>%</span></td>
                            <td class="font-monospace fw-bold"><?= format_money($p['max_loan_limit']) ?> บาท</td>
                            <td><?= e($p['max_term_months']) ?> งวด</td>
                            <td>
                                <span class="badge <?= $p['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= e(strtoupper($p['status'])) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteLoan(<?= $p['id'] ?>)">
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

<!-- Create Loan Modal -->
<div class="modal fade" id="createLoanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy">เพิ่มผลิตภัณฑ์เงินกู้ใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/loans/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-3">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold small">ชื่อประเภทเงินกู้ <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="เช่น เงินกู้สามัญ...">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">หมวดหมู่ <span class="text-danger">*</span></label>
                            <select name="category" class="form-select">
                                <option value="general">เงินกู้สามัญ</option>
                                <option value="emergency">เงินกู้ฉุกเฉิน</option>
                                <option value="special">เงินกู้พิเศษ</option>
                                <option value="housing">เงินกู้เคหะ</option>
                                <option value="welfare">เงินกู้สวัสดิการ</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">อัตราดอกเบี้ย (% ต่อปี) <span class="text-danger">*</span></label>
                            <input type="number" name="interest_rate" class="form-control" step="0.001" required placeholder="5.500">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">วงเงินกู้สูงสุด (บาท)</label>
                            <input type="number" name="max_loan_limit" class="form-control" value="3000000">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">ผ่อนชำระสูงสุด (งวด/เดือน)</label>
                            <input type="number" name="max_term_months" class="form-control" value="240">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">คำอธิบายย่อ (Short Description)</label>
                        <input type="text" name="short_description" class="form-control" placeholder="จุดเด่น เช่น ดอกเบี้ยลดต้นลดดอก อนุมัติไว...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">คุณสมบัติผู้กู้</label>
                        <input type="text" name="eligibility" class="form-control" placeholder="เป็นสมาชิกมาแล้วไม่น้อยกว่า 1 ปี...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">หลักประกัน / ผู้ค้ำประกัน</label>
                        <input type="text" name="guarantor_requirement" class="form-control" placeholder="สมาชิกค้ำประกัน 1-3 คน...">
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="is_calculator_enabled" value="1" id="chkCalcEnabled" checked>
                        <label class="form-check-label small" for="chkCalcEnabled">เปิดให้ใช้งานในโปรแกรมคำนวณเงินกู้</label>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">บันทึกเงินกู้</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteLoan(id) {
    showDeleteConfirm(() => {
        fetch(window.APP_URL + '/admin/loans/' + id + '/delete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'ลบผลิตภัณฑ์เงินกู้เรียบร้อยแล้ว');
                setTimeout(() => location.reload(), 800);
            } else {
                showError('เกิดข้อผิดพลาด', data.message);
            }
        });
    });
}
</script>
