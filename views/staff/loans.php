<div class="container-fluid py-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-cash-stack text-primary me-2"></i>ตรวจสอบและอนุมัติคำขอกู้เงิน
            </h1>
            <p class="text-muted small mb-0">ระบบพิจารณาคำขอกู้เงินออนไลน์ ตรวจสอบเอกสาร และบันทึกผลการอนุมัติ</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= url('staff/loans') ?>" class="btn btn-<?= empty($currentStatus) ? 'primary' : 'outline-secondary' ?> btn-sm rounded-pill px-3">
                ทั้งหมด
            </a>
            <a href="<?= url('staff/loans?status=submitted') ?>" class="btn btn-<?= $currentStatus === 'submitted' ? 'warning' : 'outline-warning' ?> btn-sm rounded-pill px-3">
                <i class="bi bi-clock me-1"></i>รอพิจารณา
            </a>
            <a href="<?= url('staff/loans?status=approved') ?>" class="btn btn-<?= $currentStatus === 'approved' ? 'success' : 'outline-success' ?> btn-sm rounded-pill px-3">
                <i class="bi bi-check-circle me-1"></i>อนุมัติแล้ว
            </a>
        </div>
    </div>

    <!-- Loan Applications Table Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle coop-datatable" data-order='[[0, "desc"]]'>
                <thead class="table-light">
                    <tr>
                        <th>เลขที่คำขอ</th>
                        <th>ผู้ขอกู้ (สมาชิก)</th>
                        <th>ประเภทเงินกู้</th>
                        <th>วงเงินที่ยื่นกู้</th>
                        <th>ระยะเวลา</th>
                        <th>เอกสารแนบ</th>
                        <th>สถานะ</th>
                        <th class="text-end">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($applications)): ?>
                        <?php foreach ($applications as $app): ?>
                            <?php 
                                $appAmount = (float)($app['request_amount'] ?? $app['requested_amount'] ?? 0);
                                $appTerm = (int)($app['request_term'] ?? $app['term_months'] ?? 0);
                                $appIncome = (float)($app['salary'] ?? $app['monthly_income'] ?? 0);
                                $docs = !empty($app['documents_json']) ? json_decode($app['documents_json'], true) : [];
                                if (!is_array($docs)) $docs = [];
                            ?>
                            <tr>
                                <td data-order="<?= (int)$app['id'] ?>">
                                    <span class="fw-bold text-primary font-monospace"><?= e($app['application_no']) ?></span>
                                    <div class="text-muted" style="font-size: 0.72rem;"><?= date('d/m/Y H:i', strtotime($app['created_at'])) ?></div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= e($app['member_name']) ?></div>
                                    <div class="text-muted small"><?= e($app['member_no']) ?> • <?= e($app['department'] ?? '-') ?></div>
                                    <div class="text-muted" style="font-size: 0.72rem;"><i class="bi bi-telephone me-1"></i><?= e($app['phone'] ?? '-') ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border"><?= e($app['loan_type']) ?></span>
                                    <div class="text-muted small mt-1">วัตถุประสงค์: <?= e($app['purpose'] ?? '-') ?></div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-6">฿<?= number_format($appAmount, 2) ?></div>
                                    <?php if ($appIncome > 0): ?>
                                        <div class="text-muted small">เงินเดือน: ฿<?= number_format($appIncome, 2) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary"><?= $appTerm ?> งวด</span>
                                </td>
                                <td>
                                    <?php if (!empty($docs)): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2.5 py-1 fw-bold">
                                            <i class="bi bi-paperclip me-1"></i> <?= count($docs) ?> ไฟล์
                                        </span>
                                        <div class="mt-1" style="max-width: 150px;">
                                            <?php foreach ($docs as $d): ?>
                                                <div class="text-truncate text-muted" style="font-size: 0.70rem;" title="<?= e($d['original_name'] ?? $d['name'] ?? '') ?>">
                                                    <i class="bi bi-file-earmark me-0.5"></i> <?= e($d['original_name'] ?? $d['name'] ?? '') ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge bg-light text-muted border rounded-pill px-2 py-1">
                                            ไม่มีไฟล์
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $statusBadge = match($app['status']) {
                                        'submitted' => 'bg-warning-subtle text-warning border-warning-subtle',
                                        'approved' => 'bg-success-subtle text-success border-success-subtle',
                                        'rejected' => 'bg-danger-subtle text-danger border-danger-subtle',
                                        'document_review' => 'bg-info-subtle text-info border-info-subtle',
                                        default => 'bg-light text-dark'
                                    };
                                    $statusLabel = match($app['status']) {
                                        'submitted' => 'รอตรวจสอบ',
                                        'approved' => 'อนุมัติแล้ว',
                                        'rejected' => 'ไม่อนุมัติ',
                                        'document_review' => 'ขอเอกสารเพิ่ม',
                                        default => $app['status']
                                    };
                                    ?>
                                    <span class="badge <?= $statusBadge ?> border rounded-pill px-3 py-1"><?= $statusLabel ?></span>
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#reviewModal<?= $app['id'] ?>">
                                        <i class="bi bi-pencil-square me-1"></i>พิจารณา
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modals rendered outside Table for DataTables Compliance -->
<?php if (!empty($applications)): ?>
    <?php foreach ($applications as $app): ?>
        <?php 
            $appAmount = (float)($app['request_amount'] ?? $app['requested_amount'] ?? 0);
            $appTerm = (int)($app['request_term'] ?? $app['term_months'] ?? 0);
            $docs = !empty($app['documents_json']) ? json_decode($app['documents_json'], true) : [];
            if (!is_array($docs)) $docs = [];
        ?>
        <div class="modal fade" id="reviewModal<?= $app['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header bg-light border-0 py-3 px-4">
                        <h5 class="modal-title fw-bold text-navy">
                            <i class="bi bi-file-earmark-check text-primary me-2"></i>พิจารณาคำขอกู้เงิน: <?= e($app['application_no']) ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= url('staff/loans/review') ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                        <div class="modal-body p-4">
                            <!-- Loan Details Overview -->
                            <div class="p-3 bg-light rounded-4 mb-4 border">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="text-muted small">ผู้ขอกู้ (สมาชิก)</div>
                                        <div class="fw-bold text-dark"><?= e($app['member_name'] ?? ($app['first_name'] . ' ' . $app['last_name'])) ?> (<?= e($app['member_no']) ?>)</div>
                                        <div class="text-muted small"><?= e($app['department'] ?? '-') ?> • โทร: <?= e($app['phone'] ?? '-') ?></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-muted small">ประเภทสินเชื่อ</div>
                                        <div class="fw-bold text-primary fs-6"><?= e($app['loan_type']) ?></div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="text-muted small">วงเงินที่ยื่นขอ</div>
                                        <div class="fw-bold fs-5 text-dark">฿<?= number_format($appAmount, 2) ?></div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="text-muted small">ระยะเวลาผ่อนชำระ</div>
                                        <div class="fw-bold text-dark"><?= $appTerm ?> งวด <?php if (!empty($app['estimated_monthly'])): ?>(ประมาณการ ฿<?= number_format((float)$app['estimated_monthly'], 2) ?>/งวด)<?php endif; ?></div>
                                    </div>
                                    <?php if (!empty($app['purpose'])): ?>
                                        <div class="col-12 mt-2 pt-2 border-top">
                                            <div class="text-muted small">วัตถุประสงค์การขอกู้:</div>
                                            <div class="fw-medium small text-dark"><?= e($app['purpose']) ?></div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($app['guarantor_member_no'])): ?>
                                        <div class="col-12">
                                            <div class="text-muted small">เลขที่สมาชิกผู้ค้ำประกัน:</div>
                                            <div class="fw-bold font-monospace text-navy small"><?= e($app['guarantor_member_no']) ?></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Attached Documents Showcase Section -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label fw-bold text-navy mb-0">
                                        <i class="bi bi-paperclip text-primary me-1"></i> เอกสารหลักฐานประกอบคำขอกู้ (Attached Documents)
                                    </label>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 small">
                                        <?= count($docs) ?> รายการ
                                    </span>
                                </div>

                                <?php if (!empty($docs)): ?>
                                    <div class="row g-2">
                                        <?php foreach ($docs as $doc): ?>
                                            <?php
                                                $docName = $doc['name'] ?? 'เอกสารแนบ';
                                                $filePath = $doc['file'] ?? '';
                                                $origName = $doc['original_name'] ?? $doc['filename'] ?? basename($filePath);
                                                $docSize = $doc['size'] ?? '1.2 MB';
                                                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION) ?: pathinfo($origName, PATHINFO_EXTENSION) ?: 'pdf');
                                                $fileName = basename($filePath);

                                                if (str_starts_with($filePath, 'http://') || str_starts_with($filePath, 'https://')) {
                                                    $streamUrl = $filePath;
                                                    $downloadUrl = $filePath;
                                                } else {
                                                    $streamUrl = url('staff/loans/document?file=' . urlencode($fileName) . '&name=' . urlencode($origName));
                                                    $downloadUrl = url('staff/loans/document?file=' . urlencode($fileName) . '&name=' . urlencode($origName) . '&download=1');
                                                }

                                                $iconClass = match($ext) {
                                                    'pdf' => 'bi-file-earmark-pdf-fill text-danger',
                                                    'jpg', 'jpeg', 'png' => 'bi-file-earmark-image-fill text-primary',
                                                    'doc', 'docx' => 'bi-file-earmark-word-fill text-info',
                                                    default => 'bi-file-earmark-text-fill text-secondary'
                                                };
                                            ?>
                                            <div class="col-md-6">
                                                <div class="p-3 bg-white border rounded-3 h-100 d-flex flex-column justify-content-between shadow-xs">
                                                    <div class="d-flex align-items-start gap-2 mb-2">
                                                        <div class="rounded-3 p-2 bg-light border d-flex align-items-center justify-content-center flex-shrink-0 mt-0.5" style="width: 44px; height: 44px;">
                                                            <i class="bi <?= $iconClass ?> fs-4"></i>
                                                        </div>
                                                        <div class="overflow-hidden flex-grow-1">
                                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-0.5 rounded-pill mb-1" style="font-size: 0.70rem;">
                                                                <?= e($docName) ?>
                                                            </span>
                                                            <div class="fw-bold text-dark small text-truncate" title="<?= e($origName) ?>">
                                                                <?= e($origName) ?>
                                                            </div>
                                                            <div class="text-muted d-flex align-items-center gap-1 mt-0.5" style="font-size: 0.70rem;">
                                                                <span class="badge bg-light text-dark border"><?= strtoupper($ext) ?></span>
                                                                <span class="font-monospace"><?= e($docSize) ?></span>
                                                                <span class="text-success ms-auto"><i class="bi bi-check-circle-fill"></i> แนบสำเร็จ</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-2 mt-auto pt-2 border-top">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-primary rounded-pill w-100 fw-medium"
                                                                onclick="openLoanDocPreview('<?= e($streamUrl) ?>', '<?= e(addslashes($origName)) ?> (<?= e(addslashes($docName)) ?>)', '<?= e($ext) ?>', '<?= e($downloadUrl) ?>')">
                                                            <i class="bi bi-eye me-1"></i> ดูเอกสาร
                                                        </button>
                                                        <a href="<?= $streamUrl ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5" title="เปิดในแท็บใหม่">
                                                            <i class="bi bi-box-arrow-up-right"></i>
                                                        </a>
                                                        <a href="<?= $downloadUrl ?>" class="btn btn-sm btn-light border rounded-pill px-2.5 text-secondary" title="ดาวน์โหลดไฟล์">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="p-3 bg-light rounded-3 text-center text-muted small border">
                                        <i class="bi bi-file-earmark-x fs-4 d-block mb-1 text-secondary opacity-50"></i>
                                        ไม่มีรายการเอกสารแนบสำหรับคำขอนี้
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Review Action -->
                            <div class="mb-3">
                                <label class="form-label fw-bold text-navy">ผลการพิจารณา <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="action" id="act_approve<?= $app['id'] ?>" value="approved" checked>
                                        <label class="form-check-label text-success fw-bold" for="act_approve<?= $app['id'] ?>">
                                            <i class="bi bi-check-circle me-1"></i>อนุมัติเงินกู้
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="action" id="act_doc<?= $app['id'] ?>" value="document_review">
                                        <label class="form-check-label text-info fw-bold" for="act_doc<?= $app['id'] ?>">
                                            <i class="bi bi-file-earmark-arrow-up me-1"></i>ขอเอกสารเพิ่มเติม
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="action" id="act_reject<?= $app['id'] ?>" value="rejected">
                                        <label class="form-check-label text-danger fw-bold" for="act_reject<?= $app['id'] ?>">
                                            <i class="bi bi-x-circle me-1"></i>ไม่อนุมัติ
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-navy">ความเห็นเจ้าหน้าที่ / ข้อความแจ้งสมาชิก</label>
                                <textarea name="comment" class="form-control" rows="3" placeholder="ระบุเหตุผลในการอนุมัติ หรือเอกสารที่ต้องการให้สมาชิกแนบเพิ่มเติม..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-0 py-3 px-4">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                                <i class="bi bi-check2-circle me-1"></i> บันทึกผลการพิจารณา
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Document Previewer Modal -->
<div class="modal fade" id="loanDocPreviewModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header bg-dark text-white py-2.5 px-4 border-0">
                <div class="d-flex align-items-center gap-2 overflow-hidden me-auto">
                    <i class="bi bi-file-earmark-text text-warning fs-5"></i>
                    <h6 class="modal-title fw-bold text-truncate mb-0" id="previewModalTitle">ดูตัวอย่างเอกสาร</h6>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="#" id="previewOpenTabBtn" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1">
                        <i class="bi bi-box-arrow-up-right me-1"></i> เปิดในแท็บใหม่
                    </a>
                    <a href="#" id="previewDownloadBtn" class="btn btn-sm btn-warning text-dark fw-bold rounded-pill px-3 py-1">
                        <i class="bi bi-download me-1"></i> ดาวน์โหลด
                    </a>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-0 bg-secondary-subtle d-flex align-items-center justify-content-center" style="min-height: 520px; max-height: 82vh;" id="previewModalBody">
                <div class="p-5 text-center text-muted">
                    <div class="spinner-border text-primary mb-2" role="status"></div>
                    <div>กำลังโหลดตัวอย่างเอกสาร...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openLoanDocPreview(url, title, ext, downloadUrl) {
    const modalEl = document.getElementById('loanDocPreviewModal');
    const titleEl = document.getElementById('previewModalTitle');
    const bodyEl = document.getElementById('previewModalBody');
    const openTabBtn = document.getElementById('previewOpenTabBtn');
    const downloadBtn = document.getElementById('previewDownloadBtn');

    titleEl.textContent = title || 'ดูตัวอย่างเอกสาร';
    openTabBtn.href = url;
    downloadBtn.href = downloadUrl || url;

    ext = (ext || 'pdf').toLowerCase();

    if (ext === 'pdf') {
        bodyEl.innerHTML = `
            <iframe src="${url}#toolbar=1&navpanes=0" 
                    style="width: 100%; height: 75vh; border: none; background: #fff;" 
                    title="${title}">
            </iframe>
        `;
    } else if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
        bodyEl.innerHTML = `
            <div class="p-3 text-center w-100 overflow-auto" style="max-height: 75vh;">
                <img src="${url}" alt="${title}" class="img-fluid rounded-3 shadow-sm" style="max-height: 70vh; object-fit: contain;">
            </div>
        `;
    } else {
        bodyEl.innerHTML = `
            <div class="p-5 text-center bg-white rounded-4 shadow-sm m-4">
                <i class="bi bi-file-earmark-word text-primary display-3 mb-3 d-block"></i>
                <h5 class="fw-bold text-dark mb-2">${title}</h5>
                <p class="text-muted small mb-4">ไฟล์นามสกุล .${ext.toUpperCase()} ไม่สามารถแสดงผลตัวอย่างผ่านเบราว์เซอร์ได้โดยตรง</p>
                <a href="${downloadUrl || url}" class="btn btn-primary rounded-pill px-4 fw-bold">
                    <i class="bi bi-download me-1"></i> ดาวน์โหลดไฟล์เพื่อเปิดดูบนเครื่อง
                </a>
            </div>
        `;
    }

    const modal = new bootstrap.Modal(modalEl);
    modal.show();
}
</script>
