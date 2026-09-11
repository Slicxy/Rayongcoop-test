<?php
$complaint = array_merge([
    'id' => 0,
    'ticket_no' => '',
    'category' => '',
    'subject' => '',
    'description' => '',
    'created_at' => date('Y-m-d H:i:s'),
    'status' => 'received',
    'priority' => 'normal',
    'assigned_to' => null,
    'response_message' => '',
    'complainant_name' => '-',
    'complainant_phone' => '-',
    'complainant_email' => '-'
], $complaint ?? []);
$logs = $logs ?? [];
$officers = $officers ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1">
            <i class="bi bi-file-text me-2 text-primary"></i> เรื่องร้องเรียน: <?= e($complaint['ticket_no']) ?>
        </h3>
        <p class="text-muted small mb-0">ประเภท: <?= e($complaint['category']) ?> | วันที่ส่ง: <?= thai_date($complaint['created_at'], true) ?></p>
    </div>
    <a href="<?= url('admin/complaints') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> กลับหน้ารายการ
    </a>
</div>

<div class="row g-4">
    <!-- Complaint Details -->
    <div class="col-lg-7">
        <div class="admin-card p-4 mb-4">
            <h5 class="admin-card-title mb-3">รายละเอียดเรื่องร้องเรียน</h5>
            
            <div class="mb-3">
                <label class="text-muted small d-block">หัวข้อเรื่อง:</label>
                <div class="fw-bold text-navy fs-5"><?= e($complaint['subject']) ?></div>
            </div>

            <div class="mb-4">
                <label class="text-muted small d-block">เนื้อหาข้อความ:</label>
                <div class="p-3 bg-light rounded-3 text-secondary lh-lg small">
                    <?= nl2br(e($complaint['description'])) ?>
                </div>
            </div>

            <h6 class="fw-bold text-navy mb-2">ข้อมูลผู้ร้องเรียน:</h6>
            <div class="row g-2 small mb-3">
                <div class="col-sm-6"><b>ชื่อผู้แจ้ง:</b> <?= e($complaint['complainant_name']) ?></div>
                <div class="col-sm-6"><b>เบอร์โทร:</b> <?= e($complaint['complainant_phone']) ?></div>
                <div class="col-sm-6"><b>อีเมล:</b> <?= e($complaint['complainant_email'] ?? '-') ?></div>
            </div>

            <?php if (!empty($complaint['attachment'])): ?>
                <div class="pt-3 border-top">
                    <label class="text-muted small d-block mb-1">ไฟล์แนบประกอบ:</label>
                    <a href="<?= storage_url($complaint['attachment']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-paperclip me-1"></i> เปิดดูไฟล์แนบ
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Timeline Logs -->
        <div class="admin-card p-4">
            <h5 class="admin-card-title mb-3"><i class="bi bi-clock-history me-2 text-primary"></i> ประวัติการดำเนินการ (Audit Logs)</h5>
            <div class="timeline border-start border-2 border-primary ps-3 ms-2">
                <?php foreach ($logs as $log): ?>
                    <div class="position-relative mb-3">
                        <div class="position-absolute rounded-circle bg-primary" style="width: 10px; height: 10px; left: -21px; top: 5px;"></div>
                        <div class="fw-bold small text-navy"><?= e($log['action']) ?></div>
                        <div class="text-muted small"><?= e($log['note']) ?></div>
                        <small class="text-muted opacity-75">
                            <?= thai_date($log['created_at'], true) ?> <?= !empty($log['officer_name']) ? "โดย " . e($log['officer_name']) : '' ?>
                        </small>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Actions & Status Updates -->
    <div class="col-lg-5">
        <div class="admin-card p-4">
            <h5 class="admin-card-title mb-3">การดำเนินการ / ปรับปรุงสถานะ</h5>

            <form action="<?= url('admin/complaints/' . $complaint['id'] . '/update-status') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label fw-bold small">สถานะเรื่อง (Status) <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="received" <?= $complaint['status'] === 'received' ? 'selected' : '' ?>>Received (รับเรื่องแล้ว)</option>
                        <option value="under_review" <?= $complaint['status'] === 'under_review' ? 'selected' : '' ?>>Under Review (อยู่ระหว่างตรวจสอบ)</option>
                        <option value="assigned" <?= $complaint['status'] === 'assigned' ? 'selected' : '' ?>>Assigned (มอบหมายเจ้าหน้าที่)</option>
                        <option value="in_progress" <?= $complaint['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress (กำลังดำเนินการ)</option>
                        <option value="answered" <?= $complaint['status'] === 'answered' ? 'selected' : '' ?>>Answered (ตอบกลับแล้ว)</option>
                        <option value="closed" <?= $complaint['status'] === 'closed' ? 'selected' : '' ?>>Closed (ยุติเรื่อง)</option>
                        <option value="rejected" <?= $complaint['status'] === 'rejected' ? 'selected' : '' ?>>Rejected (ปฏิเสธเรื่อง)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">ระดับความสำคัญ (Priority)</label>
                    <select name="priority" class="form-select">
                        <option value="low" <?= $complaint['priority'] === 'low' ? 'selected' : '' ?>>Low (ต่ำ)</option>
                        <option value="normal" <?= $complaint['priority'] === 'normal' ? 'selected' : '' ?>>Normal (ปกติ)</option>
                        <option value="high" <?= $complaint['priority'] === 'high' ? 'selected' : '' ?>>High (สูง)</option>
                        <option value="urgent" <?= $complaint['priority'] === 'urgent' ? 'selected' : '' ?>>Urgent (เร่งด่วนมาก)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">มอบหมายเจ้าหน้าที่ผู้รับผิดชอบ</label>
                    <select name="assigned_officer_id" class="form-select">
                        <option value="">-- ไม่ระบุ --</option>
                        <?php foreach ($officers as $off): ?>
                            <option value="<?= $off['id'] ?>" <?= $complaint['assigned_officer_id'] == $off['id'] ? 'selected' : '' ?>>
                                <?= e($off['name']) ?> (<?= e($off['email']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">ข้อความตอบกลับสมาชิก (แสดงบนหน้าระบบติดตาม)</label>
                    <textarea name="response_message" class="form-control" rows="4" placeholder="พิมพ์ข้อความตอบกลับหรือผลการดำเนินการให้สมาชิกทราบ..."><?= e($complaint['response_message'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">บันทึกช่วยจำภายใน (Internal Note)</label>
                    <input type="text" name="action_note" class="form-control" placeholder="เช่น ส่งต่อฝ่ายสินเชื่อตรวจสอบ">
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                    <i class="bi bi-check2-circle me-1"></i> บันทึกการดำเนินการ
                </button>
            </form>
        </div>
    </div>
</div>
