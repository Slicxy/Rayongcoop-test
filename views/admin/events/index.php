<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-navy mb-1"><i class="bi bi-calendar-event-fill text-info me-2"></i> จัดการปฏิทินกิจกรรม & กำหนดการ</h4>
        <p class="text-muted small mb-0">กำหนดการประชุมใหญ่ รอบยื่นกู้เงิน จ่ายเงินปันผล และวันหยุดทำการ</p>
    </div>
    <a href="<?= url('admin/events/create') ?>" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus-lg me-1"></i> เพิ่มกิจกรรมใหม่
    </a>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form action="<?= url('admin/events') ?>" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <select name="cat" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- ทุกหมวดหมู่กิจกรรม --</option>
                    <option value="meeting" <?= ($category === 'meeting') ? 'selected' : '' ?>>ประชุมใหญ่ / สรรหา</option>
                    <option value="loan_window" <?= ($category === 'loan_window') ? 'selected' : '' ?>>รอบยื่นกู้เงิน</option>
                    <option value="dividend" <?= ($category === 'dividend') ? 'selected' : '' ?>>จ่ายเงินปันผล</option>
                    <option value="holiday" <?= ($category === 'holiday') ? 'selected' : '' ?>>วันหยุดทำการ</option>
                    <option value="activity" <?= ($category === 'activity') ? 'selected' : '' ?>>กิจกรรมทั่วไป</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- ทุกสถานะ --</option>
                    <option value="upcoming" <?= ($status === 'upcoming') ? 'selected' : '' ?>>กำลังจะมาถึง (Upcoming)</option>
                    <option value="completed" <?= ($status === 'completed') ? 'selected' : '' ?>>เสร็จสิ้น (Completed)</option>
                    <option value="cancelled" <?= ($status === 'cancelled') ? 'selected' : '' ?>>ยกเลิก (Cancelled)</option>
                </select>
            </div>
            <div class="col-md-4 text-md-end">
                <?php if (!empty($category) || !empty($status)): ?>
                    <a href="<?= url('admin/events') ?>" class="btn btn-sm btn-outline-secondary rounded-pill">
                        <i class="bi bi-x-circle me-1"></i> ล้างตัวกรอง
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" style="width: 50px;">#</th>
                        <th>กิจกรรม / กำหนดการ</th>
                        <th>หมวดหมู่</th>
                        <th>วันที่จัดกิจกรรม</th>
                        <th>สถานที่</th>
                        <th>สถานะ</th>
                        <th class="text-end pe-4" style="width: 150px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($events)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x fs-1 d-block mb-2 text-secondary"></i>
                                ไม่พบกิจกรรมในปฏิทิน
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($events as $i => $item): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $i + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if ($item['is_featured']): ?>
                                            <span class="badge bg-gold text-white"><i class="bi bi-pin-angle-fill"></i></span>
                                        <?php endif; ?>
                                        <div class="fw-bold text-navy"><?= e($item['title']) ?></div>
                                    </div>
                                    <?php if (!empty($item['description'])): ?>
                                        <small class="text-muted text-truncate d-block" style="max-width: 320px;"><?= e($item['description']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        $catLabel = match($item['category']) {
                                            'meeting' => 'ประชุมใหญ่/สรรหา',
                                            'loan_window' => 'รอบยื่นกู้เงิน',
                                            'dividend' => 'จ่ายเงินปันผล',
                                            'holiday' => 'วันหยุดทำการ',
                                            default => 'กิจกรรมทั่วไป'
                                        };
                                    ?>
                                    <span class="badge bg-light text-navy border"><?= $catLabel ?></span>
                                </td>
                                <td>
                                    <div class="small fw-semibold"><?= thai_date($item['start_date']) ?></div>
                                    <?php if (!empty($item['end_date']) && $item['end_date'] !== $item['start_date']): ?>
                                        <small class="text-muted">ถึง <?= thai_date($item['end_date']) ?></small>
                                    <?php endif; ?>
                                    <?php if (!empty($item['start_time'])): ?>
                                        <div class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-clock me-1"></i> <?= date('H:i', strtotime($item['start_time'])) ?> น.</div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="small text-muted"><?= e($item['location'] ?? '-') ?></span>
                                </td>
                                <td>
                                    <?php if ($item['status'] === 'upcoming'): ?>
                                        <span class="badge bg-success">เร็วๆ นี้</span>
                                    <?php elseif ($item['status'] === 'completed'): ?>
                                        <span class="badge bg-secondary">เสร็จสิ้น</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">ยกเลิก</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= url("admin/events/{$item['id']}/edit") ?>" class="btn btn-outline-primary" title="แก้ไข">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?= url("admin/events/{$item['id']}/delete") ?>" method="POST" onsubmit="return confirm('คุณต้องการลบกิจกรรมนี้ใช่หรือไม่?');" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-outline-danger" title="ลบ">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
