<!-- Header -->
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">ข้อเสนอแนะสมาชิก</li>
            </ol>
        </nav>
        <h1 class="h3 fw-bold text-navy mb-1">
            <i class="bi bi-chat-heart-fill text-primary me-2"></i>จัดการข้อเสนอแนะสมาชิก (Member Voice & Innovation)
        </h1>
        <p class="text-muted small mb-0">รวบรวมความคิดเห็น ข้อเสนอแนะนวัตกรรม และไอเดียโครงการสวัสดิการจากสมาชิกสหกรณ์</p>
    </div>
</div>

<!-- Metric KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-2">
        <a href="<?= url('admin/suggestions') ?>" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none h-100 border-start border-4 border-primary">
            <div class="text-muted small">ทั้งหมด</div>
            <h3 class="fw-bold text-navy mb-0 font-monospace"><?= number_format($stats['total'] ?? 0) ?></h3>
        </a>
    </div>
    <div class="col-6 col-md-2">
        <a href="<?= url('admin/suggestions?status=submitted') ?>" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none h-100 border-start border-4 border-secondary">
            <div class="text-muted small">รอตรวจสอบ</div>
            <h3 class="fw-bold text-secondary mb-0 font-monospace"><?= number_format($stats['submitted'] ?? 0) ?></h3>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="<?= url('admin/suggestions?status=under_review') ?>" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none h-100 border-start border-4 border-warning">
            <div class="text-muted small">อยู่ระหว่างพิจารณา</div>
            <h3 class="fw-bold text-warning mb-0 font-monospace"><?= number_format($stats['under_review'] ?? 0) ?></h3>
        </a>
    </div>
    <div class="col-6 col-md-2">
        <a href="<?= url('admin/suggestions?status=approved') ?>" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none h-100 border-start border-4 border-info">
            <div class="text-muted small">รับหลักการ</div>
            <h3 class="fw-bold text-info mb-0 font-monospace"><?= number_format($stats['approved'] ?? 0) ?></h3>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="<?= url('admin/suggestions?status=implemented') ?>" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none h-100 border-start border-4 border-success">
            <div class="text-muted small">นำไปปฏิบัติจริงแล้ว</div>
            <h3 class="fw-bold text-success mb-0 font-monospace"><?= number_format($stats['implemented'] ?? 0) ?></h3>
        </a>
    </div>
</div>

<!-- Filter Bar -->
<div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
    <form action="<?= url('admin/suggestions') ?>" method="GET" class="row g-2 align-items-center">
        <div class="col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control border-start-0" placeholder="ค้นหาเลขที่ / หัวข้อ / ชื่อสมาชิก..." value="<?= e($search ?? '') ?>">
            </div>
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select form-select-sm">
                <option value="">-- ทุกหมวดหมู่ --</option>
                <?php foreach ($categories as $catKey => $cat): ?>
                    <option value="<?= $catKey ?>" <?= ($selectedCategory === $catKey) ? 'selected' : '' ?>><?= e($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">-- ทุกสถานะ --</option>
                <?php foreach ($statuses as $stKey => $st): ?>
                    <option value="<?= $stKey ?>" <?= ($selectedStatus === $stKey) ? 'selected' : '' ?>><?= e($st['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-1">
            <button type="submit" class="btn btn-primary btn-sm rounded-pill w-100">
                <i class="bi bi-filter me-1"></i> กรอง
            </button>
            <a href="<?= url('admin/suggestions') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3" title="รีเซ็ต">
                <i class="bi bi-arrow-counterclockwise"></i>
            </a>
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="card border-0 shadow-sm rounded-4 bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                <thead class="table-light">
                    <tr>
                        <th style="width: 130px;">เลขที่</th>
                        <th style="width: 140px;">หมวดหมู่</th>
                        <th style="width: 180px;">ผู้เสนอ</th>
                        <th>หัวข้อ & รายละเอียด</th>
                        <th style="width: 130px;">วันที่ส่ง</th>
                        <th style="width: 140px;">สถานะ</th>
                        <th class="text-end" style="width: 120px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($suggestions)): ?>
                        <?php foreach ($suggestions as $item): ?>
                            <?php 
                                $catMeta = $categories[$item['category']] ?? ['name' => $item['category'], 'color' => 'secondary', 'icon' => 'bi-tag'];
                                $stMeta = $statuses[$item['status']] ?? ['name' => $item['status'], 'badge' => 'bg-secondary', 'icon' => 'bi-info-circle'];
                            ?>
                            <tr>
                                <td class="fw-bold font-monospace text-navy"><?= e($item['suggestion_no']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $catMeta['color'] ?>-subtle text-<?= $catMeta['color'] ?> border border-<?= $catMeta['color'] ?>-subtle rounded-pill">
                                        <i class="bi <?= $catMeta['icon'] ?> me-1"></i> <?= e($catMeta['name']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($item['is_anonymous']): ?>
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill"><i class="bi bi-incognito me-1"></i>ไม่เปิดเผยชื่อ</span>
                                    <?php else: ?>
                                        <div class="fw-semibold text-dark"><?= e($item['member_name']) ?></div>
                                        <small class="text-muted font-monospace"><?= e($item['member_no']) ?> &bull; <?= e($item['department']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="fw-bold text-navy mb-1"><?= e($item['title']) ?></div>
                                    <p class="text-muted small mb-0 text-truncate" style="max-width: 380px;"><?= e($item['content']) ?></p>
                                    <?php if (!empty($item['admin_response'])): ?>
                                        <div class="small text-success mt-1">
                                            <i class="bi bi-reply-fill me-1"></i> ตอบกลับแล้ว: <?= e(mb_substr($item['admin_response'], 0, 40, 'UTF-8')) ?>...
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="small text-muted font-monospace"><?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></td>
                                <td>
                                    <span class="badge <?= $stMeta['badge'] ?> px-2 py-1 rounded-pill small">
                                        <i class="bi <?= $stMeta['icon'] ?> me-1"></i> <?= e($stMeta['name']) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary" title="พิจารณาและตอบกลับ" onclick="openReviewModal(<?= htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') ?>)">
                                            <i class="bi bi-chat-left-dots"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" title="ลบ" onclick="deleteSuggestion(<?= $item['id'] ?>)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-chat-heart fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                <h6>ไม่พบข้อเสนอแนะตามเงื่อนไขที่ค้นหา</h6>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Review & Respond Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy" id="modalTitle">
                    <i class="bi bi-chat-dots-fill text-primary me-2"></i>พิจารณาข้อเสนอแนะและตอบกลับสมาชิก
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="reviewForm" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-3">
                    <!-- Proposal Detail Box -->
                    <div class="p-3 bg-light rounded-4 border mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-primary font-monospace" id="modalSugNo">SG-2026-00000</span>
                            <span class="text-muted small" id="modalDate">-</span>
                        </div>
                        <h6 class="fw-bold text-navy mb-2" id="modalSugTitle">-</h6>
                        <p class="text-dark small mb-2" id="modalSugContent" style="white-space: pre-line;">-</p>
                        <div class="d-flex justify-content-between align-items-center small text-muted border-top pt-2 mt-2">
                            <span id="modalMemberInfo">ผู้เสนอ: -</span>
                            <span id="modalAttachment"></span>
                        </div>
                    </div>

                    <!-- Update Status -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy">สถานะการพิจารณา <span class="text-danger">*</span></label>
                        <select name="status" id="modalStatusSelect" class="form-select" required>
                            <option value="submitted">ได้รับเรื่องแล้ว (Submitted)</option>
                            <option value="under_review">อยู่ระหว่างพิจารณา (Under Review)</option>
                            <option value="approved">รับหลักการ / เตรียมผลักดันโครงการ (Approved)</option>
                            <option value="implemented">นำไปปฏิบัติจริงแล้ว (Implemented)</option>
                            <option value="declined">ยุติเรื่อง / ชี้แจงเหตุผล (Declined)</option>
                        </select>
                    </div>

                    <!-- Admin Response Comment -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy">ข้อความตอบกลับ / คำชี้แจงไปยังสมาชิก <span class="text-danger">*</span></label>
                        <textarea name="admin_response" id="modalResponseText" class="form-control" rows="4" placeholder="พิมพ์ข้อความตอบกลับ ชี้แจงผลการพิจารณา หรือแผนการดำเนินงานของสหกรณ์..." required></textarea>
                        <small class="text-muted">ข้อความนี้จะแสดงในหน้าพอร์ทัลของสมาชิก และระบบจะส่งการแจ้งเตือนถึงสมาชิกอัตโนมัติ</small>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                        <i class="bi bi-check-circle me-1"></i> บันทึกการพิจารณา
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Form Hidden -->
<form id="deleteForm" method="POST" style="display: none;">
    <?= csrf_field() ?>
</form>

<script>
let reviewModalInstance = null;

document.addEventListener('DOMContentLoaded', function() {
    reviewModalInstance = new bootstrap.Modal(document.getElementById('reviewModal'));
});

function openReviewModal(item) {
    document.getElementById('modalSugNo').textContent = item.suggestion_no;
    document.getElementById('modalDate').textContent = item.created_at;
    document.getElementById('modalSugTitle').textContent = item.title;
    document.getElementById('modalSugContent').textContent = item.content;

    if (item.is_anonymous == 1) {
        document.getElementById('modalMemberInfo').innerHTML = '<span class="badge bg-secondary-subtle text-secondary"><i class="bi bi-incognito me-1"></i>ผู้เสนอ: ไม่เปิดเผยตัวตน</span>';
    } else {
        document.getElementById('modalMemberInfo').textContent = `ผู้เสนอ: ${item.member_name} (${item.member_no}) - ${item.department || ''}`;
    }

    if (item.attachment_path) {
        document.getElementById('modalAttachment').innerHTML = `<a href="${window.APP_URL}/${item.attachment_path}" target="_blank" class="btn btn-xs btn-outline-primary py-0 px-2 small"><i class="bi bi-paperclip me-1"></i>ดูเอกสารแนบ</a>`;
    } else {
        document.getElementById('modalAttachment').innerHTML = '';
    }

    document.getElementById('modalStatusSelect').value = item.status;
    document.getElementById('modalResponseText').value = item.admin_response || '';

    const form = document.getElementById('reviewForm');
    form.action = `<?= url('admin/suggestions') ?>/${item.id}/update-status`;

    reviewModalInstance.show();
}

function deleteSuggestion(id) {
    Swal.fire({
        title: 'ยืนยันลบข้อเสนอแนะ?',
        text: 'การลบข้อเสนอแนะนี้จะไม่สามารถกู้คืนได้',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DC3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'ใช่, ลบรายการ',
        cancelButtonText: 'ยกเลิก'
    }).then((res) => {
        if (res.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `<?= url('admin/suggestions') ?>/${id}/delete`;
            form.submit();
        }
    });
}
</script>
