<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 p-4 pb-2 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold text-navy mb-1"><i class="bi bi-bell-fill text-primary me-2"></i>ศูนย์การแจ้งเตือน (Notification Center)</h5>
            <p class="text-muted small mb-0">แจ้งเตือนสถานะคำขอกู้เงิน ใบเสร็จรับเงิน และข่าวสารสหกรณ์</p>
        </div>
        <form action="<?= url('member/notifications/read-all') ?>" method="POST">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="bi bi-check2-all me-1"></i> ทำเครื่องหมายว่าอ่านแล้วทั้งหมด
            </button>
        </form>
    </div>

    <div class="card-body p-4">
        <div class="list-group list-group-flush">
            <?php if (!empty($list)): ?>
                <?php foreach ($list as $n): ?>
                    <div class="list-group-item p-3 rounded-3 mb-2 border <?= $n['is_read'] ? 'bg-light' : 'bg-white border-primary' ?>">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div class="d-flex align-items-start gap-3">
                                <div class="p-2 rounded-circle <?= $n['is_read'] ? 'bg-secondary-subtle text-secondary' : 'bg-primary-subtle text-primary' ?>" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                    <?php if ($n['type'] === 'receipt'): ?>
                                        <i class="bi bi-receipt"></i>
                                    <?php elseif ($n['type'] === 'loan_approval'): ?>
                                        <i class="bi bi-cash-coin"></i>
                                    <?php else: ?>
                                        <i class="bi bi-bell"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <div class="fw-bold <?= $n['is_read'] ? 'text-dark' : 'text-primary' ?> small mb-1">
                                        <?= e($n['title']) ?>
                                        <?php if (!$n['is_read']): ?>
                                            <span class="badge bg-danger rounded-pill ms-2" style="font-size: 9px;">ใหม่</span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="small text-muted mb-1"><?= e($n['message']) ?></p>
                                    <small class="text-muted font-monospace" style="font-size: 11px;"><i class="bi bi-clock me-1"></i> <?= date('d/m/Y H:i', strtotime($n['created_at'])) ?></small>
                                </div>
                            </div>
                            <?php if (!empty($n['link_url'])): ?>
                                <a href="<?= url($n['link_url']) ?>" class="btn btn-sm btn-light border flex-shrink-0">
                                    ดูรายละเอียด &rarr;
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-bell-slash fs-1 text-muted d-block mb-2"></i>
                    <p class="mb-0">ไม่มีการแจ้งเตือนใหม่ในขณะนี้</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
