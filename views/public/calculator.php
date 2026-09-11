<?php
$loanProducts = $loanProducts ?? [];
?>
<div class="py-5 bg-navy text-white">
    <div class="container">
        <span class="badge bg-gold text-white mb-2 px-3 py-1">เครื่องมือคำนวณทางการเงิน</span>
        <h1 class="text-white fw-bold display-6 mb-2">โปรแกรมคำนวณเงินกู้ออนไลน์</h1>
        <p class="text-light-blue lead mb-0">คำนวณค่างวดรายเดือนและตารางการผ่อนชำระหนี้แบบลดต้นลดดอก (Amortization Schedule) มาตรฐานสถาบันการเงิน</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4 mb-5">
        <!-- Calculator Inputs -->
        <div class="col-lg-6">
            <div class="coop-card p-4 p-md-5 h-100">
                <h4 class="fw-bold text-navy mb-4"><i class="bi bi-sliders me-2 text-primary"></i> กำหนดเงื่อนไขสินเชื่อ</h4>

                <div class="mb-3">
                    <label class="form-label fw-bold">เลือกประเภทสินเชื่อ</label>
                    <select class="form-select form-select-lg" id="calcProduct">
                        <?php foreach ($loanProducts as $lp): ?>
                            <option value="<?= e($lp['id']) ?>" data-rate="<?= e($lp['interest_rate']) ?>" data-max-term="<?= e($lp['max_term_months']) ?>" data-method="<?= e($lp['calculation_type']) ?>">
                                <?= e($lp['name']) ?> (ดอกเบี้ย <?= number_format((float)$lp['interest_rate'], 2) ?>% ต่อปี)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label fw-bold">วงเงินที่ต้องการกู้ (บาท)</label>
                        <span class="text-primary fw-bold" id="labelPrincipal">500,000 บาท</span>
                    </div>
                    <input type="number" class="form-control form-control-lg font-monospace mb-2" id="calcPrincipal" value="500000" min="10000" step="10000">
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label fw-bold">ระยะเวลาการผ่อนชำระ (งวด/เดือน)</label>
                        <span class="text-primary fw-bold" id="labelTerm">60 งวด (5 ปี)</span>
                    </div>
                    <input type="number" class="form-control form-control-lg font-monospace mb-2" id="calcTerm" value="60" min="1" max="360">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">อัตราดอกเบี้ย (% ต่อปี)</label>
                        <input type="number" class="form-control form-control-lg font-monospace" id="calcRate" value="5.50" step="0.01">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">วิธีคิดอัตราดอกเบี้ย</label>
                        <select class="form-select form-select-lg" id="calcMethod">
                            <option value="effective" selected>ลดต้นลดดอก (Effective)</option>
                            <option value="flat">อัตราคงที่ (Flat Rate)</option>
                        </select>
                    </div>
                </div>

                <div class="alert alert-info border-0 rounded-3 small mt-4 mb-0">
                    <i class="bi bi-info-circle-fill me-1"></i> <b>หมายเหตุ:</b> การคำนวณนี้เป็นการประมาณการเบื้องต้น ตัวเลขจริงอาจมีการเปลี่ยนแปลงตามวันที่ทำสัญญาและการตัดรอบบัญชีของสหกรณ์
                </div>
            </div>
        </div>

        <!-- Calculator Results -->
        <div class="col-lg-6">
            <div class="coop-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                <div>
                    <h4 class="fw-bold text-navy mb-4"><i class="bi bi-pie-chart me-2 text-primary"></i> สรุปผลการประมาณการ</h4>

                    <div class="calc-result-box mb-4 shadow">
                        <small class="text-light-blue text-uppercase fw-semibold">ประมาณการค่างวดรายเดือนที่ต้องชำระ</small>
                        <div class="calc-result-figure my-2" id="calcResultMonthly">0.00 บาท</div>
                        <small class="text-light-subtle opacity-75">* ค่างวดเฉลี่ยต่องวดตลอดอายุสัญญา</small>
                    </div>

                    <div class="list-group list-group-flush rounded-3 border">
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-cash me-2"></i> วงเงินต้นทั้งหมด</span>
                            <span class="fw-bold fs-6" id="calcResultPrincipal">0.00 บาท</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-percent me-2 text-warning"></i> ดอกเบี้ยรวมตลอดสัญญา</span>
                            <span class="fw-bold fs-6 text-danger" id="calcResultInterest">0.00 บาท</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3 bg-light">
                            <span class="fw-bold text-navy"><i class="bi bi-wallet-fill me-2 text-primary"></i> ยอดเงินรวมที่ต้องชำระทั้งหมด</span>
                            <span class="fw-bold fs-5 text-primary" id="calcResultTotal">0.00 บาท</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary flex-grow-1" onclick="window.print()">
                        <i class="bi bi-printer me-1"></i> พิมพ์ผลการคำนวณ
                    </button>
                    <a href="<?= url('documents?cat=loan-forms') ?>" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> ดาวน์โหลดแบบฟอร์มกู้
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Amortization Schedule Table -->
    <div class="coop-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-navy mb-0">
                <i class="bi bi-table me-2 text-primary"></i> ตารางการผ่อนชำระหนี้รายงวด (Amortization Schedule)
            </h4>
            <span class="badge bg-light text-muted border">แสดงทุกงวด</span>
        </div>

        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
            <table class="table rate-table table-bordered table-striped mb-0" id="calcScheduleTable">
                <thead class="sticky-top">
                    <tr>
                        <th class="text-center" style="width: 80px;">งวดที่</th>
                        <th class="text-end">ยอดผ่อนชำระ (บาท)</th>
                        <th class="text-end">เงินต้น (บาท)</th>
                        <th class="text-end">ดอกเบี้ย (บาท)</th>
                        <th class="text-end">เงินต้นคงเหลือ (บาท)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Injected dynamically via loan-calculator.js -->
                </tbody>
            </table>
        </div>
    </div>
</div>
