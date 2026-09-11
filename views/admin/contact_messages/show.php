<?php
$message = array_merge([
    'id' => 0,
    'subject' => '',
    'message' => '',
    'name' => '-',
    'phone' => '-',
    'email' => '-',
    'sender_name' => '-',
    'sender_email' => '-',
    'sender_phone' => '-',
    'status' => 'new',
    'admin_response' => '',
    'created_at' => date('Y-m-d H:i:s'),
    'ip_address' => '-'
], $message ?? []);
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="<?= url('admin/contact-messages') ?>" class="btn btn-sm btn-outline-secondary rounded-pill mb-2">
            <i class="bi bi-arrow-left me-1"></i> กลับไปหน้ารายการ
        </a>
        <h4 class="fw-bold text-navy mb-1"><?= e($message['subject']) ?></h4>
        <p class="text-muted small mb-0">รหัสข้อความ #<?= $message['id'] ?> • ส่งเมื่อ <?= thai_date($message['created_at']) ?> <?= date('H:i น.', strtotime($message['created_at'])) ?></p>
    </div>
    <div>
        <form action="<?= url("admin/contact-messages/{$message['id']}/delete") ?>" method="POST" onsubmit="return confirm('คุณต้องการลบข้อความนี้ใช่หรือไม่?');" class="d-inline">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                <i class="bi bi-trash-fill me-1"></i> ลบข้อความ
            </button>
        </form>
    </div>
</div>

<div class="row g-4">
    <!-- Message Content Left Column -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-bottom border-light">
                <h6 class="fw-bold text-navy mb-0"><i class="bi bi-chat-quote-fill text-primary me-2"></i> เนื้อหาข้อความ</h6>
            </div>
            <div class="card-body p-4">
                <div class="bg-light p-4 rounded-3 mb-4">
                    <p class="mb-0 text-dark" style="white-space: pre-line; line-height: 1.7;"><?= e($message['message']) ?></p>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 border rounded-3 bg-white">
                            <small class="text-muted d-block">ชื่อผู้ติดต่อ</small>
                            <b class="text-navy fs-6"><?= e($message['name']) ?></b>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 border rounded-3 bg-white">
                            <small class="text-muted d-block">เบอร์โทรศัพท์</small>
                            <a href="tel:<?= e($message['phone']) ?>" class="fw-bold text-decoration-none">
                                <i class="bi bi-telephone me-1"></i> <?= e($message['phone']) ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 border rounded-3 bg-white">
                            <small class="text-muted d-block">อีเมล</small>
                            <a href="mailto:<?= e($message['email']) ?>" class="fw-bold text-decoration-none">
                                <i class="bi bi-envelope me-1"></i> <?= e($message['email']) ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 border rounded-3 bg-white">
                            <small class="text-muted d-block">IP Address & Browser</small>
                            <span class="small text-muted"><?= e($message['ip_address'] ?? '-') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Response & Status Right Column -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-bottom border-light">
                <h6 class="fw-bold text-navy mb-0"><i class="bi bi-gear-fill text-warning me-2"></i> จัดการสถานะและการตอบกลับ</h6>
            </div>
            <div class="card-body p-4">
                <form action="<?= url("admin/contact-messages/{$message['id']}/update") ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">สถานะการดำเนินการ</label>
                        <select name="status" class="form-select">
                            <option value="new" <?= $message['status'] === 'new' ? 'selected' : '' ?>>มาใหม่ (New)</option>
                            <option value="in_progress" <?= $message['status'] === 'in_progress' ? 'selected' : '' ?>>กำลังดำเนินการ (In Progress)</option>
                            <option value="answered" <?= $message['status'] === 'answered' ? 'selected' : '' ?>>ตอบกลับเรียบร้อย (Answered)</option>
                            <option value="closed" <?= $message['status'] === 'closed' ? 'selected' : '' ?>>ปิดงาน / สิ้นสุดเรื่อง (Closed)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">บันทึกข้อความตอบกลับผู้ติดต่อ</label>
                        <textarea name="staff_reply" rows="4" class="form-control" placeholder="ระบุข้อความหรือสรุปผลการตอบกลับสมาชิก..."><?= e($message['staff_reply'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small">บันทึกภายในสำหรับเจ้าหน้าที่ (Internal Notes)</label>
                        <textarea name="staff_notes" rows="3" class="form-control" placeholder="บันทึกช่วยจำสำหรับเจ้าหน้าที่สหกรณ์ (ผู้ติดต่อจะไม่เห็น)..."><?= e($message['staff_notes'] ?? '') ?></textarea>
                    </div>

                    <?php if (!empty($message['responded_at'])): ?>
                        <div class="alert alert-light border small text-muted mb-3">
                            <i class="bi bi-info-circle me-1"></i> อัปเดตล่าสุดเมื่อ <?= thai_date($message['responded_at']) ?> โดย <?= e($message['responder_name'] ?? 'เจ้าหน้าที่') ?>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold rounded-pill">
                        <i class="bi bi-check-circle-fill me-2"></i> บันทึกการเปลี่ยนแปลง
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
