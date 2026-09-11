<?php
$complaints = $complaints ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-chat-left-dots me-2 text-primary"></i> ศูนย์รับเรื่องร้องเรียนและข้อเสนอแนะ</h3>
        <p class="text-muted small mb-0">รายการเรื่องร้องเรียนและข้อเสนอแนะจากสมาชิกทั้งหมด</p>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle coop-datatable mb-0">
                <thead class="table-light">
                    <tr>
                        <th>เลขที่เรื่อง</th>
                        <th>ประเภท</th>
                        <th>หัวข้อเรื่อง</th>
                        <th>ผู้แจ้ง / เบอร์โทร</th>
                        <th>สถานะ</th>
                        <th>ความสำคัญ</th>
                        <th>ผู้รับผิดชอบ</th>
                        <th>วันที่ส่ง</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($complaints as $c): ?>
                        <tr>
                            <td class="font-monospace fw-bold small text-navy"><?= e($c['ticket_no']) ?></td>
                            <td><span class="badge bg-light text-navy border"><?= e($c['category']) ?></span></td>
                            <td class="small fw-semibold"><?= e($c['subject']) ?></td>
                            <td class="small">
                                <div><?= e($c['complainant_name']) ?></div>
                                <small class="text-muted"><?= e($c['complainant_phone']) ?></small>
                            </td>
                            <td>
                                <?php
                                $statusMap = [
                                    'received' => 'bg-secondary',
                                    'under_review' => 'bg-info',
                                    'assigned' => 'bg-warning text-dark',
                                    'in_progress' => 'bg-primary',
                                    'answered' => 'bg-success',
                                    'closed' => 'bg-dark',
                                    'rejected' => 'bg-danger',
                                ];
                                ?>
                                <span class="badge <?= $statusMap[$c['status']] ?? 'bg-secondary' ?>"><?= e(strtoupper($c['status'])) ?></span>
                            </td>
                            <td>
                                <span class="badge <?= $c['priority'] === 'urgent' ? 'bg-danger' : 'bg-secondary' ?>"><?= e(strtoupper($c['priority'])) ?></span>
                            </td>
                            <td class="small"><?= e($c['officer_name'] ?? '-') ?></td>
                            <td class="small text-muted"><?= date('d/m/Y H:i', strtotime($c['created_at'])) ?></td>
                            <td class="text-end">
                                <a href="<?= url('admin/complaints/' . $c['id']) ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-search"></i> ตรวจสอบ
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
