<?php
$ticket = $ticket ?? '';
$complaint = $complaint ?? null;
$logs = $logs ?? [];
?>
<div class="py-5 bg-navy text-white">
    <div class="container">
        <span class="badge bg-gold text-white mb-2 px-3 py-1">บริการติดตามเรื่อง</span>
        <h1 class="text-white fw-bold display-6 mb-2">ติดตามสถานะเรื่องร้องเรียน</h1>
        <p class="text-light-blue lead mb-0">ตรวจสอบความคืบหน้าและการดำเนินการตามเลขที่เรื่องร้องเรียน</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Search Box -->
            <div class="coop-card p-4 mb-4">
                <form action="<?= url('complaints/track') ?>" method="GET" class="row g-2 align-items-center">
                    <div class="col-sm-9">
                        <input type="text" name="ticket" class="form-control form-control-lg font-monospace" placeholder="กรอกเลขที่เรื่อง เช่น RC-COM-2569-00001" value="<?= e($ticket ?? '') ?>" required>
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-search me-1"></i> ค้นหา
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tracking Result -->
            <?php if (!empty($complaint)): ?>
                <div class="coop-card p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-4">
                        <div>
                            <span class="text-muted small d-block">เลขที่เรื่องร้องเรียน</span>
                            <h4 class="fw-bold text-primary font-monospace mb-0"><?= e($complaint['ticket_no']) ?></h4>
                        </div>
                        <div>
                            <?php
                            $statusMap = [
                                'received' => ['bg-secondary', 'รับเรื่องแล้ว'],
                                'under_review' => ['bg-info', 'อยู่ระหว่างตรวจสอบ'],
                                'assigned' => ['bg-warning text-dark', 'มอบหมายเจ้าหน้าที่แล้ว'],
                                'in_progress' => ['bg-primary', 'กำลังดำเนินการ'],
                                'answered' => ['bg-success', 'ตอบกลับแล้ว'],
                                'closed' => ['bg-dark', 'ยุติเรื่อง'],
                                'rejected' => ['bg-danger', 'ปฏิเสธเรื่อง'],
                            ];
                            $st = $statusMap[$complaint['status']] ?? ['bg-secondary', $complaint['status']];
                            ?>
                            <span class="badge <?= $st[0] ?> fs-6 px-3 py-2"><?= $st[1] ?></span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-navy mb-1">หัวข้อเรื่อง:</h6>
                        <p class="text-secondary"><?= e($complaint['subject']) ?></p>

                        <h6 class="fw-bold text-navy mb-1">รายละเอียด:</h6>
                        <div class="p-3 bg-light rounded-3 text-secondary small mb-3">
                            <?= nl2br(e($complaint['description'])) ?>
                        </div>

                        <?php if (!empty($complaint['response_message'])): ?>
                            <div class="alert alert-success rounded-3 p-3">
                                <h6 class="fw-bold text-success mb-1"><i class="bi bi-chat-check-fill me-1"></i> ข้อความตอบกลับจากเจ้าหน้าที่:</h6>
                                <p class="mb-0 small"><?= nl2br(e($complaint['response_message'])) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Timeline Logs -->
                    <h6 class="fw-bold text-navy mb-3"><i class="bi bi-clock-history me-1"></i> ลำดับเหตุการณ์ (Timeline)</h6>
                    <div class="timeline border-start border-2 border-primary ps-3 ms-2">
                        <?php foreach ($logs as $log): ?>
                            <div class="position-relative mb-3">
                                <div class="position-absolute rounded-circle bg-primary" style="width: 10px; height: 10px; left: -21px; top: 5px;"></div>
                                <div class="fw-bold small text-navy"><?= e($log['action']) ?></div>
                                <div class="text-muted small"><?= e($log['note']) ?></div>
                                <small class="text-muted opacity-75"><?= thai_date($log['created_at'], true) ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php elseif (isset($ticket) && $ticket !== ''): ?>
                <div class="coop-card p-5 text-center text-muted">
                    <i class="bi bi-search fs-1 text-secondary mb-3 d-block"></i>
                    <h5>ไม่พบข้อมูลเลขที่เรื่องร้องเรียน "<?= e($ticket) ?>"</h5>
                    <p class="small mb-0">กรุณาตรวจสอบความถูกต้องของเลขที่เรื่องร้องเรียนแล้วลองใหม่อีกครั้ง</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
