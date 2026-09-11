<?php
$accounts = $accounts ?? [];
$activeAccount = $activeAccount ?? null;
$typeFilter = $typeFilter ?? 'all';
$transactions = $transactions ?? [];
?>
<!-- Account Selector Tabs -->
<div class="row g-3 mb-4">
    <?php foreach ($accounts as $acc): ?>
        <?php $isActive = ($activeAccount && $activeAccount['id'] === $acc['id']); ?>
        <div class="col-md-6">
            <a href="<?= url('member/deposits?account=' . $acc['account_no']) ?>" class="card border-0 shadow-sm rounded-4 p-4 text-decoration-none text-start h-100 <?= $isActive ? 'border border-2 border-primary bg-primary-subtle' : 'bg-white' ?>" style="transition: transform 0.2s ease;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge <?= $isActive ? 'bg-primary text-white' : 'bg-light text-navy border' ?> font-monospace">
                        <?= e($acc['account_no']) ?>
                    </span>
                    <span class="text-success small fw-bold"><i class="bi bi-percent"></i> ดอกเบี้ย <?= $acc['interest_rate'] ?>%</span>
                </div>
                <h5 class="fw-bold text-navy mb-1"><?= e($acc['account_name']) ?></h5>
                <h3 class="fw-bold text-success my-2 font-monospace"><?= number_format((float)$acc['balance'], 2) ?> <span class="fs-6 fw-normal text-muted">บาท</span></h3>
                <small class="text-muted">ดอกเบี้ยสะสมรอจ่าย: <b><?= number_format((float)$acc['accrued_interest'], 2) ?> บาท</b> &bull; เปิดเมื่อ <?= date('d/m/Y', strtotime($acc['open_date'])) ?></small>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<!-- Transaction History Ledger -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 p-4 pb-2 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h5 class="fw-bold text-navy mb-1"><i class="bi bi-receipt-cutoff text-primary me-2"></i>รายการเดินบัญชี (Transaction Ledger)</h5>
            <p class="text-muted small mb-0">บัญชี: <b class="font-monospace text-navy"><?= e($activeAccount['account_no'] ?? '') ?></b> - <?= e($activeAccount['account_name'] ?? '') ?></p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <div class="btn-group btn-group-sm">
                <a href="<?= url('member/deposits?account=' . ($activeAccount['account_no'] ?? '')) ?>" class="btn btn-<?= empty($typeFilter) ? 'primary' : 'outline-primary' ?>">ทั้งหมด</a>
                <a href="<?= url('member/deposits?account=' . ($activeAccount['account_no'] ?? '') . '&type=deposit') ?>" class="btn btn-<?= $typeFilter === 'deposit' ? 'primary' : 'outline-primary' ?>">เงินฝาก</a>
                <a href="<?= url('member/deposits?account=' . ($activeAccount['account_no'] ?? '') . '&type=withdraw') ?>" class="btn btn-<?= $typeFilter === 'withdraw' ? 'primary' : 'outline-primary' ?>">ถอนเงิน</a>
                <a href="<?= url('member/deposits?account=' . ($activeAccount['account_no'] ?? '') . '&type=interest') ?>" class="btn btn-<?= $typeFilter === 'interest' ? 'primary' : 'outline-primary' ?>">ดอกเบี้ย</a>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()"><i class="bi bi-printer me-1"></i> พิมพ์ / PDF</button>
        </div>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>วัน-เวลา</th>
                        <th>รายการธุรกรรม</th>
                        <th>ช่องทาง</th>
                        <th class="text-end">ฝาก (+)</th>
                        <th class="text-end">ถอน (-)</th>
                        <th class="text-end">ยอดคงเหลือ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php foreach ($transactions as $tx): ?>
                            <tr>
                                <td class="small text-muted font-monospace"><?= date('d/m/Y H:i', strtotime($tx['tx_date'])) ?></td>
                                <td>
                                    <?php if ($tx['tx_type'] === 'deposit'): ?>
                                        <span class="badge bg-success-subtle text-success me-1">เงินฝาก</span>
                                    <?php elseif ($tx['tx_type'] === 'withdraw'): ?>
                                        <span class="badge bg-danger-subtle text-danger me-1">ถอนเงิน</span>
                                    <?php else: ?>
                                        <span class="badge bg-info-subtle text-info me-1">ดอกเบี้ย</span>
                                    <?php endif; ?>
                                    <span class="small"><?= e($tx['description'] ?? '') ?></span>
                                </td>
                                <td class="small text-muted"><?= e($tx['channel'] ?? 'ระบบ') ?></td>
                                <td class="text-end font-monospace text-success fw-bold small">
                                    <?= in_array($tx['tx_type'], ['deposit', 'interest', 'transfer_in']) ? '+' . number_format((float)$tx['amount'], 2) : '-' ?>
                                </td>
                                <td class="text-end font-monospace text-danger fw-bold small">
                                    <?= in_array($tx['tx_type'], ['withdraw', 'transfer_out']) ? '-' . number_format((float)$tx['amount'], 2) : '-' ?>
                                </td>
                                <td class="text-end font-monospace fw-bold text-navy small">
                                    <?= number_format((float)$tx['balance'], 2) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted small">
                                <i class="bi bi-info-circle me-1"></i> ไม่มีรายการเคลื่อนไหวในหมวดที่เลือก
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
