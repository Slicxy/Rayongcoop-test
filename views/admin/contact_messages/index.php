<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-navy mb-1"><i class="bi bi-chat-left-text-fill text-primary me-2"></i> ข้อความติดต่อจากผู้ใช้งาน</h4>
        <p class="text-muted small mb-0">รายการข้อความสอบถามและข้อเสนอแนะที่ส่งผ่านหน้าเว็บไซต์</p>
    </div>
</div>

<!-- Status Filter Tabs -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex flex-wrap gap-2">
                <a href="<?= url('admin/contact-messages') ?>" class="btn btn-sm <?= empty($status) ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-3">
                    ทั้งหมด <span class="badge bg-white text-dark ms-1"><?= $counts['all'] ?></span>
                </a>
                <a href="<?= url('admin/contact-messages?status=new') ?>" class="btn btn-sm <?= $status === 'new' ? 'btn-danger' : 'btn-outline-danger' ?> rounded-pill px-3">
                    <i class="bi bi-envelope-fill me-1"></i> มาใหม่ <span class="badge bg-white text-danger ms-1"><?= $counts['new'] ?></span>
                </a>
                <a href="<?= url('admin/contact-messages?status=in_progress') ?>" class="btn btn-sm <?= $status === 'in_progress' ? 'btn-warning' : 'btn-outline-warning' ?> rounded-pill px-3">
                    <i class="bi bi-hourglass-split me-1"></i> กำลังดำเนินการ <span class="badge bg-white text-dark ms-1"><?= $counts['in_progress'] ?></span>
                </a>
                <a href="<?= url('admin/contact-messages?status=answered') ?>" class="btn btn-sm <?= $status === 'answered' ? 'btn-success' : 'btn-outline-success' ?> rounded-pill px-3">
                    <i class="bi bi-check-circle-fill me-1"></i> ตอบกลับแล้ว <span class="badge bg-white text-success ms-1"><?= $counts['answered'] ?></span>
                </a>
                <a href="<?= url('admin/contact-messages?status=closed') ?>" class="btn btn-sm <?= $status === 'closed' ? 'btn-secondary' : 'btn-outline-secondary' ?> rounded-pill px-3">
                    <i class="bi bi-archive-fill me-1"></i> ปิดงาน <span class="badge bg-white text-dark ms-1"><?= $counts['closed'] ?></span>
                </a>
            </div>

            <!-- Search Form -->
            <form action="<?= url('admin/contact-messages') ?>" method="GET" class="d-flex gap-2">
                <?php if (!empty($status)): ?>
                    <input type="hidden" name="status" value="<?= e($status) ?>">
                <?php endif; ?>
                <div class="input-group input-group-sm">
                    <input type="text" name="q" class="form-control" placeholder="ค้นหาชื่อ, เบอร์โทร, เรื่อง..." value="<?= e($search ?? '') ?>">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    <?php if (!empty($search)): ?>
                        <a href="<?= url('admin/contact-messages' . (!empty($status) ? '?status=' . $status : '')) ?>" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Messages Table -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" style="width: 60px;">#</th>
                        <th>ผู้ติดต่อ</th>
                        <th>เรื่องที่ติดต่อ</th>
                        <th>สถานะ</th>
                        <th>วันที่ส่งข้อความ</th>
                        <th>ผู้รับผิดชอบ</th>
                        <th class="text-end pe-4" style="width: 120px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($messages)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                ไม่พบข้อความติดต่อตามเงื่อนไขที่เลือก
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($messages as $i => $m): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $i + 1 ?></td>
                                <td>
                                    <div class="fw-bold text-navy"><?= e($m['name']) ?></div>
                                    <div class="small text-muted">
                                        <i class="bi bi-telephone me-1"></i> <?= e($m['phone']) ?> 
                                        <?php if (!empty($m['email'])): ?>
                                            • <i class="bi bi-envelope me-1"></i> <?= e($m['email']) ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark text-truncate" style="max-width: 320px;">
                                        <?= e($m['subject']) ?>
                                    </div>
                                    <div class="small text-muted text-truncate" style="max-width: 320px;">
                                        <?= e(mb_substr($m['message'], 0, 60)) ?>...
                                    </div>
                                </td>
                                <td>
                                    <?php if ($m['status'] === 'new'): ?>
                                        <span class="badge bg-danger"><i class="bi bi-envelope me-1"></i> ข้อความใหม่</span>
                                    <?php elseif ($m['status'] === 'in_progress'): ?>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> กำลังดำเนินการ</span>
                                    <?php elseif ($m['status'] === 'answered'): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> ตอบกลับแล้ว</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><i class="bi bi-archive me-1"></i> ปิดงาน</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="small fw-semibold"><?= thai_date($m['created_at']) ?></div>
                                    <div class="text-muted" style="font-size: 0.75rem;"><?= date('H:i น.', strtotime($m['created_at'])) ?></div>
                                </td>
                                <td>
                                    <span class="small text-muted"><?= e($m['responder_name'] ?? '-') ?></span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="<?= url("admin/contact-messages/{$m['id']}") ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        ดูรายละเอียด <i class="bi bi-chevron-right ms-1"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
