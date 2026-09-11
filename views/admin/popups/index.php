<?php
$popups = $popups ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-window-stack me-2 text-primary"></i> จัดการ Popup Campaign</h3>
        <p class="text-muted small mb-0">ระบบหน้าต่างแจ้งเตือนและแคมเปญประชาสัมพันธ์ พร้อมระบบจัดคิวและความถี่</p>
    </div>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createPopupModal">
        <i class="bi bi-plus-lg me-1"></i> สร้าง Popup ใหม่
    </button>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>ชื่อแคมเปญ</th>
                        <th>ประเภท</th>
                        <th>เงื่อนไขแสดงผล</th>
                        <th>ความถี่ (Frequency)</th>
                        <th>Priority</th>
                        <th>สถิติ Impression/Clicks</th>
                        <th>สถานะ</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($popups as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <div class="fw-bold text-navy"><?= e($p['title']) ?></div>
                                <small class="text-muted"><?= e(strip_tags($p['content'])) ?></small>
                            </td>
                            <td><span class="badge bg-light text-navy border"><?= e($p['type']) ?></span></td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    <?= e($p['display_mode']) ?> (<?= $p['delay_seconds'] ?>s)
                                </span>
                            </td>
                            <td><small><?= e($p['frequency']) ?></small></td>
                            <td>
                                <?php
                                $prioColors = ['critical' => 'bg-danger', 'high' => 'bg-warning text-dark', 'normal' => 'bg-primary', 'low' => 'bg-secondary'];
                                ?>
                                <span class="badge <?= $prioColors[$p['priority']] ?? 'bg-secondary' ?>"><?= e(strtoupper($p['priority'])) ?></span>
                            </td>
                            <td class="small font-monospace">
                                <div><i class="bi bi-eye text-primary"></i> <?= number_format($p['impressions_count']) ?></div>
                                <div><i class="bi bi-cursor text-success"></i> <?= number_format($p['clicks_count']) ?></div>
                            </td>
                            <td>
                                <span class="badge <?= $p['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= e(strtoupper($p['status'])) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletePopup(<?= $p['id'] ?>)">
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

<!-- Create Popup Modal -->
<div class="modal fade" id="createPopupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy">สร้าง Popup Campaign ใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/popups/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">ชื่อหัวข้อ Popup <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required placeholder="เช่น แจ้งกำหนดการจ่ายเงินปันผล...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">เนื้อหาข้อความ (Content HTML) <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">ข้อความบนปุ่ม (CTA Text)</label>
                            <input type="text" name="button_text" class="form-control" placeholder="ตรวจสอบสิทธิ์">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">ลิงก์ปุ่ม (CTA URL)</label>
                            <input type="text" name="button_url" class="form-control" placeholder="/eservice">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">เงื่อนไขการแสดง</label>
                            <select name="display_mode" class="form-select">
                                <option value="load">ทันทีเมื่อเข้าเว็บ (Load)</option>
                                <option value="delay">หน่วงเวลา X วินาที (Delay)</option>
                                <option value="scroll">เมื่อ Scroll 50%</option>
                                <option value="exit">เมื่อจะออกจากหน้า (Exit Intent)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">ความถี่ (Frequency)</label>
                            <select name="frequency" class="form-select">
                                <option value="session">ครั้งเดียวต่อ Session</option>
                                <option value="daily">ครั้งเดียวต่อวัน (Daily)</option>
                                <option value="always">ทุกครั้งที่เข้าเว็บ</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">ลำดับความสำคัญ (Priority)</label>
                            <select name="priority" class="form-select">
                                <option value="critical">Critical (ฉุกเฉิน)</option>
                                <option value="high">High (ด่วนมาก)</option>
                                <option value="normal" selected>Normal (ปกติ)</option>
                                <option value="low">Low (ทั่วไป)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">สถานะ</label>
                            <select name="status" class="form-select">
                                <option value="active">Active (เปิดใช้งาน)</option>
                                <option value="draft">Draft (ฉบับร่าง)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">สร้าง Popup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deletePopup(id) {
    showDeleteConfirm(() => {
        fetch(window.APP_URL + '/admin/popups/' + id + '/delete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'ลบ Popup เรียบร้อยแล้ว');
                setTimeout(() => location.reload(), 800);
            } else {
                showError('เกิดข้อผิดพลาด', data.message);
            }
        });
    });
}
</script>
