<!-- Loans Contract Cards -->
<div class="row g-3 mb-4">
    <?php foreach ($loans as $ln): ?>
        <?php 
            $isActive = ($activeLoan && $activeLoan['id'] === $ln['id']); 
            $pctPaid = round(($ln['paid_periods'] / max(1, $ln['total_periods'])) * 100);
        ?>
        <div class="col-md-6">
            <a href="<?= url('member/loans?contract=' . $ln['contract_no']) ?>" class="card border-0 shadow-sm rounded-4 p-4 text-decoration-none text-start h-100 <?= $isActive ? 'border border-2 border-danger bg-danger-subtle' : 'bg-white' ?>" style="transition: transform 0.2s ease;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge <?= $isActive ? 'bg-danger text-white' : 'bg-light text-navy border' ?> font-monospace">
                        <?= e($ln['contract_no']) ?>
                    </span>
                    <span class="text-danger small fw-bold"><i class="bi bi-percent"></i> ดอกเบี้ย <?= $ln['interest_rate'] ?>%</span>
                </div>
                <h5 class="fw-bold text-navy mb-1"><?= e($ln['loan_name']) ?></h5>
                <h3 class="fw-bold text-danger my-2 font-monospace"><?= number_format((float)$ln['principal_balance'], 2) ?> <span class="fs-6 fw-normal text-muted">บาท</span></h3>
                
                <!-- Progress Bar -->
                <div class="my-2">
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span>ชำระแล้ว <?= $ln['paid_periods'] ?>/<?= $ln['total_periods'] ?> งวด (<?= $pctPaid ?>%)</span>
                        <span class="fw-bold text-navy">คงเหลือ <?= $ln['remaining_periods'] ?> งวด</span>
                    </div>
                    <div class="progress" style="height: 7px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $pctPaid ?>%;" aria-valuenow="<?= $pctPaid ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <small class="text-muted mt-2">วงเงินกู้เดิม: <b><?= number_format((float)$ln['loan_amount']) ?> บาท</b> &bull; ผ่อนเดือนละ <b><?= number_format((float)$ln['monthly_installment']) ?> บาท</b></small>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<!-- Amortization Schedule Table -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 p-4 pb-2 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h5 class="fw-bold text-navy mb-1"><i class="bi bi-calendar3 text-danger me-2"></i>ตารางการผ่อนชำระหนี้ (Amortization Schedule)</h5>
            <p class="text-muted small mb-0">สัญญาเลขที่: <b class="font-monospace text-navy"><?= e($activeLoan['contract_no'] ?? '') ?></b> - <?= e($activeLoan['loan_name'] ?? '') ?></p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= url('member/loan-apply') ?>" class="btn btn-warning text-navy btn-sm fw-bold">
                <i class="bi bi-plus-circle me-1"></i> ยื่นกู้เงินเพิ่ม
            </a>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()"><i class="bi bi-printer me-1"></i> พิมพ์ / PDF</button>
        </div>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>งวดที่</th>
                        <th>วันครบกำหนด</th>
                        <th class="text-end">เงินต้น (บาท)</th>
                        <th class="text-end">ดอกเบี้ย (บาท)</th>
                        <th class="text-end">ค่างวดรวม (บาท)</th>
                        <th class="text-end">เงินต้นคงเหลือ</th>
                        <th class="text-center">สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($schedules)): ?>
                        <?php foreach ($schedules as $s): ?>
                            <tr>
                                <td class="font-monospace fw-bold small text-navy"><?= $s['period_no'] ?></td>
                                <td class="small text-muted font-monospace"><?= date('d/m/Y', strtotime($s['due_date'])) ?></td>
                                <td class="text-end font-monospace small"><?= number_format((float)$s['principal_payment'], 2) ?></td>
                                <td class="text-end font-monospace small"><?= number_format((float)$s['interest_payment'], 2) ?></td>
                                <td class="text-end font-monospace fw-bold text-navy small"><?= number_format((float)$s['total_payment'], 2) ?></td>
                                <td class="text-end font-monospace text-danger small"><?= number_format((float)$s['remaining_principal'], 2) ?></td>
                                <td class="text-center">
                                    <?php if ($s['paid_status'] === 'paid'): ?>
                                        <span class="badge bg-success-subtle text-success small">ชำระแล้ว</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-muted small">รอดำเนินการ</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted small">
                                <i class="bi bi-info-circle me-1"></i> ไม่มีตารางผ่อนชำระสำหรับสัญญานี้
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
