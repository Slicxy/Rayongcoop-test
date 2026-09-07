<!-- Online Services Menu Grid -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <a href="<?= url('member/loan-apply') ?>" class="card border-0 shadow-sm rounded-4 p-3 text-center h-100 text-decoration-none bg-white d-flex flex-column align-items-center justify-content-center">
            <div class="bg-primary-subtle text-primary rounded-circle p-3 mb-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-cash-stack fs-4"></i>
            </div>
            <span class="fw-bold text-navy small">ยื่นกู้เงินออนไลน์</span>
        </a>
    </div>

    <div class="col-md-3 col-6">
        <a href="<?= url('member/shares') ?>" class="card border-0 shadow-sm rounded-4 p-3 text-center h-100 text-decoration-none bg-white d-flex flex-column align-items-center justify-content-center">
            <div class="bg-warning-subtle text-warning rounded-circle p-3 mb-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-sliders fs-4"></i>
            </div>
            <span class="fw-bold text-navy small">ขอเปลี่ยนค่าหุ้น</span>
        </a>
    </div>

    <div class="col-md-3 col-6">
        <a href="<?= url('member/welfare') ?>" class="card border-0 shadow-sm rounded-4 p-3 text-center h-100 text-decoration-none bg-white d-flex flex-column align-items-center justify-content-center">
            <div class="bg-info-subtle text-info rounded-circle p-3 mb-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-heart-pulse fs-4"></i>
            </div>
            <span class="fw-bold text-navy small">ยื่นขอสวัสดิการ</span>
        </a>
    </div>

    <div class="col-md-3 col-6">
        <button type="button" class="card border-0 shadow-sm rounded-4 p-3 text-center h-100 text-decoration-none bg-white d-flex flex-column align-items-center justify-content-center w-100" onclick="requestDoc('ขอหนังสือรับรองยอดหนี้/การเป็นสมาชิก')">
            <div class="bg-success-subtle text-success rounded-circle p-3 mb-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-file-earmark-check fs-4"></i>
            </div>
            <span class="fw-bold text-navy small">ขอหนังสือรับรอง</span>
        </button>
    </div>
</div>

<!-- Request Tracking Table -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 p-4 pb-0">
        <h5 class="fw-bold text-navy mb-0"><i class="bi bi-send-check-fill text-primary me-2"></i>ติดตามสถานะคำขอออนไลน์ (Request Tracking)</h5>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>เลขที่คำขอ (Request ID)</th>
                        <th>ประเภทคำขอ</th>
                        <th>หัวข้อ / รายละเอียด</th>
                        <th>สถานะ</th>
                        <th>วันที่ส่งคำขอ</th>
                        <th class="text-center">Timeline</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($requests)): ?>
                        <?php foreach ($requests as $r): ?>
                            <tr>
                                <td class="font-monospace small fw-bold text-primary"><?= e($r['request_no']) ?></td>
                                <td>
                                    <span class="badge bg-light text-navy border small"><?= e($r['request_type']) ?></span>
                                </td>
                                <td>
                                    <div class="fw-bold small text-navy"><?= e($r['title']) ?></div>
                                    <small class="text-muted"><?= e($r['details']) ?></small>
                                </td>
                                <td>
                                    <?php if ($r['status'] === 'completed' || $r['status'] === 'approved'): ?>
                                        <span class="badge bg-success-subtle text-success">เสร็จสมบูรณ์</span>
                                    <?php elseif ($r['status'] === 'in_progress'): ?>
                                        <span class="badge bg-info-subtle text-info">กำลังดำเนินการ</span>
                                    <?php elseif ($r['status'] === 'rejected'): ?>
                                        <span class="badge bg-danger-subtle text-danger">ไม่อนุมัติ</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning-subtle text-warning">ส่งคำขอแล้ว</span>
                                    <?php endif; ?>
                                </td>
                                <td class="small text-muted font-monospace"><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="showTimeline('<?= e($r['request_no']) ?>', <?= htmlspecialchars($r['timeline_json'] ?? '[]') ?>)">
                                        <i class="bi bi-clock-history me-1"></i> ดูไทม์ไลน์
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted small">
                                <i class="bi bi-info-circle me-1"></i> ยังไม่มีประวัติคำขอออนไลน์
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Timeline Modal -->
<div class="modal fade" id="timelineModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-navy"><i class="bi bi-clock-history text-primary me-2"></i>ไทม์ไลน์คำขอ <span id="timelineReqNo" class="font-monospace"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="timelineContent"></div>
            </div>
        </div>
    </div>
</div>

<script>
function showTimeline(reqNo, timeline) {
    document.getElementById('timelineReqNo').textContent = reqNo;
    const container = document.getElementById('timelineContent');
    container.innerHTML = '';

    if (!timeline || timeline.length === 0) {
        container.innerHTML = '<p class="text-muted small text-center mb-0">อยู่ระหว่างรอเจ้าหน้าที่รับเรื่อง</p>';
    } else {
        let html = '<ul class="list-group list-group-flush small">';
        timeline.forEach(t => {
            html += `<li class="list-group-item px-0 py-2 border-0 d-flex gap-3">
                <div class="text-primary font-monospace fw-bold" style="min-width: 100px;">${t.time || ''}</div>
                <div><div class="fw-bold text-navy">${t.status}</div><div class="text-muted">${t.desc}</div></div>
            </li>`;
        });
        html += '</ul>';
        container.innerHTML = html;
    }

    new bootstrap.Modal(document.getElementById('timelineModal')).show();
}

function requestDoc(title) {
    Swal.fire({
        title: title,
        text: 'ระบบจะสร้างคำขอและส่งต่อไปยังเจ้าหน้าที่ธุรการสหกรณ์เพื่อออกเอกสาร',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'ยืนยันส่งคำขอ',
        cancelButtonText: 'ยกเลิก',
        confirmButtonColor: '#0066CC'
    }).then(res => {
        if (res.isConfirmed) {
            Swal.fire('สำเร็จ', 'ส่งคำขอออกหนังสือรับรองเรียบร้อยแล้ว เจ้าหน้าที่จะดำเนินการภายใน 1-2 วันทำการ', 'success');
        }
    });
}
</script>
