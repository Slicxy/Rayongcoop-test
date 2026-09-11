<?php
$keyword = $keyword ?? '';
$departments = $departments ?? [];
$selectedDept = $selectedDept ?? '';
$members = $members ?? [];
?>
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-people-fill text-primary me-2"></i>จัดการและค้นหาข้อมูลสมาชิก
            </h1>
            <p class="text-muted small mb-0">ระบบสืบค้นข้อมูลสมาชิกสหกรณ์และตรวจสอบสถานะแบบ 360 องศา</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <form action="<?= url('staff/members') ?>" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label small fw-semibold text-muted">คำค้นหา (ชื่อ-สกุล, เลขสมาชิก, เบอร์โทร, เลขบัตร ปชช.)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" value="<?= e($keyword ?? '') ?>" class="form-control bg-light border-start-0" placeholder="ระบุคำค้นหา...">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold text-muted">หน่วยงาน / สังกัด</label>
                <select name="dept" class="form-select bg-light">
                    <option value="">-- ทุกหน่วยงาน --</option>
                    <?php if (!empty($departments)): ?>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= e($dept) ?>" <?= ($selectedDept ?? '') === $dept ? 'selected' : '' ?>><?= e($dept) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary rounded-pill w-100">
                    <i class="bi bi-filter me-1"></i>ค้นหา
                </button>
                <a href="<?= url('staff/members') ?>" class="btn btn-outline-secondary rounded-pill px-3">
                    ล้าง
                </a>
            </div>
        </form>
    </div>

    <!-- Members Table -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0">รายชื่อสมาชิก (พบ <?= count($members) ?> รายการ)</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle coop-datatable">
                <thead class="table-light">
                    <tr>
                        <th>เลขสมาชิก</th>
                        <th>ชื่อ - นามสกุล</th>
                        <th>สังกัด / ตำแหน่ง</th>
                        <th>เบอร์โทรศัพท์</th>
                        <th>วันที่เป็นสมาชิก</th>
                        <th>สถานะ</th>
                        <th class="text-end">360° Profile</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($members)): ?>
                        <?php foreach ($members as $m): ?>
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary font-monospace"><?= e($m['member_no']) ?></span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= e($m['prefix'] . $m['first_name'] . ' ' . $m['last_name']) ?></div>
                                    <div class="text-muted" style="font-size: 0.72rem;"><?= e($m['email'] ?? '-') ?></div>
                                </td>
                                <td>
                                    <div><?= e($m['department'] ?? 'สำนักงานใหญ่') ?></div>
                                    <div class="text-muted small"><?= e($m['position'] ?? '-') ?></div>
                                </td>
                                <td><?= e($m['phone'] ?? '-') ?></td>
                                <td><?= !empty($m['join_date']) ? date('d/m/Y', strtotime($m['join_date'])) : '-' ?></td>
                                <td>
                                    <?php if ($m['status'] === 'active'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">ปกติ</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill"><?= e($m['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= url('staff/members/detail?id=' . $m['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="bi bi-person-lines-fill me-1"></i>ดูข้อมูล 360°
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
