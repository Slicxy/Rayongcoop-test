<?php
$surveys = $surveys ?? [];
?>
<div class="row g-4">
    <!-- Header -->
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 bg-white p-4 rounded-4 shadow-sm border">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">แบบสำรวจและโพลล์</li>
                    </ol>
                </nav>
                <h4 class="fw-bold text-navy mb-1"><i class="bi bi-ui-checks-grid me-2 text-primary"></i> ระบบสำรวจความพึงพอใจและโพลล์สมาชิก</h4>
                <p class="text-muted small mb-0">สร้างแบบประเมินความพึงพอใจ สำรวจความคิดเห็น และวิเคราะห์ผลตอบรับแบบ Real-time Dashboard</p>
            </div>
            <div>
                <a href="<?= url('admin/surveys/create') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> สร้างแบบสำรวจใหม่
                </a>
            </div>
        </div>
    </div>

    <!-- Surveys Table -->
    <div class="col-12">
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="fw-bold text-navy">
                    <i class="bi bi-list-check me-2 text-primary"></i> รายการแบบสำรวจทั้งหมด
                </div>
                <span class="badge bg-light text-primary border rounded-pill px-3 py-1">
                    ทั้งหมด <?= count($surveys) ?> รายการ
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">ชื่อแบบสำรวจ</th>
                                <th>กลุ่มเป้าหมาย</th>
                                <th>จำนวนข้อ</th>
                                <th>ผู้ตอบแบบสำรวจ</th>
                                <th>ระยะเวลา</th>
                                <th>สถานะ</th>
                                <th class="text-end pe-4">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($surveys)): ?>
                                <?php foreach ($surveys as $s): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-navy"><?= e($s['title']) ?></div>
                                            <small class="text-muted">Slug: <code><?= e($s['slug']) ?></code></small>
                                        </td>
                                        <td>
                                            <?php if ($s['target_audience'] === 'members_only'): ?>
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">เฉพาะสมาชิก</span>
                                            <?php elseif ($s['target_audience'] === 'public'): ?>
                                                <span class="badge bg-info-subtle text-info border border-info-subtle">บุคคลทั่วไป</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">ทั้งหมด</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border"><?= $s['question_count'] ?> ข้อ</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-1 font-monospace fw-bold text-success fs-6">
                                                <i class="bi bi-people-fill small"></i> <?= number_format((int)$s['response_count']) ?> คน
                                            </div>
                                        </td>
                                        <td>
                                            <small class="text-muted d-block">
                                                <?= date('d/m/Y', strtotime($s['start_date'])) ?> 
                                                <?= !empty($s['end_date']) ? ' - ' . date('d/m/Y', strtotime($s['end_date'])) : '(ไม่มีกำหนดสิ้นสุด)' ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?php if ($s['status'] === 'active'): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">กำลังเปิดรับ</span>
                                            <?php elseif ($s['status'] === 'closed'): ?>
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-1 rounded-pill">ปิดรับแล้ว</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 rounded-pill">แบบร่าง</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <a href="<?= url('admin/surveys/' . $s['id'] . '/results') ?>" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                                    <i class="bi bi-bar-chart-line me-1"></i> ดูผลสำรวจ
                                                </a>
                                                <a href="<?= url('surveys/' . $s['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-2" title="เปิดหน้าฟอร์ม">
                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                </a>
                                                <form action="<?= url('admin/surveys/' . $s['id'] . '/delete') ?>" method="POST" class="d-inline" onsubmit="return confirm('ท่านแน่ใจหรือไม่ว่าต้องการลบแบบสำรวจนี้?');">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2" title="ลบ">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        ยังไม่มีแบบสำรวจในระบบ คลิก "สร้างแบบสำรวจใหม่" เพื่อเริ่มต้น
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
