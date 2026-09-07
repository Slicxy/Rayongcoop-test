<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="<?= url('staff/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= url('staff/members') ?>">สมาชิก</a></li>
                    <li class="breadcrumb-item active">นำเข้าข้อมูลจาก Excel/CSV</li>
                </ol>
            </nav>
            <h1 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-file-earmark-spreadsheet-fill text-success me-2"></i>ระบบนำเข้าข้อมูลสมาชิกจาก Excel / CSV
            </h1>
            <p class="text-muted small mb-0">อัปโหลดไฟล์รายชื่อสมาชิก ทุนเรือนหุ้น และเงินฝากเริ่มต้นเข้าสู่ระบบแบบกลุ่ม (Bulk Import)</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= url('staff/import/template') ?>" class="btn btn-outline-success btn-sm rounded-pill px-3 shadow-sm">
                <i class="bi bi-download me-1"></i>ดาวน์โหลด Template ตัวอย่าง (.csv)
            </a>
            <a href="<?= url('staff/members') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-people me-1"></i>ดูรายชื่อสมาชิกทั้งหมด
            </a>
        </div>
    </div>

    <!-- Step 1: Upload Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" id="uploadStepCard">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <h5 class="fw-bold text-navy mb-2"><i class="bi bi-cloud-arrow-up-fill text-primary me-2"></i>อัปโหลดไฟล์ข้อมูลสมาชิก</h5>
                <p class="text-muted small mb-3">รองรับไฟล์รูปแบบ <strong>.CSV (UTF-8)</strong> จาก Microsoft Excel หรือระบบ Core Banking เดิม โดยต้องมีโครงสร้างคอลัมน์ตาม Template มาตรฐานของสหกรณ์</p>
                
                <form id="uploadForm" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="p-4 border-2 border-dashed rounded-4 text-center bg-light mb-3" id="dropZone" style="border-style: dashed; border-color: #CBD5E1; cursor: pointer;">
                        <input type="file" id="fileInput" name="import_file" accept=".csv, .txt" class="d-none">
                        <div id="dropZonePrompt">
                            <i class="bi bi-file-earmark-arrow-up fs-1 text-primary d-block mb-2"></i>
                            <div class="fw-bold text-dark mb-1">ลากไฟล์มาวางที่นี่ หรือคลิกเพื่อเลือกไฟล์</div>
                            <small class="text-muted">ไฟล์นามสกุล .csv ขนาดไม่เกิน 10MB</small>
                        </div>
                        <div id="fileSelectedInfo" class="d-none">
                            <i class="bi bi-file-earmark-check-fill fs-1 text-success d-block mb-2"></i>
                            <div class="fw-bold text-dark fs-6" id="selectedFileName">filename.csv</div>
                            <small class="text-muted" id="selectedFileSize">0 KB</small>
                            <div class="mt-2">
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="resetFileSelection()">
                                    <i class="bi bi-x me-1"></i>เปลี่ยนไฟล์
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold" id="btnPreview" disabled>
                        <span class="spinner-border spinner-border-sm d-none" id="previewSpinner" role="status"></span>
                        <span id="previewBtnText"><i class="bi bi-search me-1"></i> ตรวจสอบและพรีวิวข้อมูล</span>
                    </button>
                </form>
            </div>

            <!-- Guidelines Sidebar -->
            <div class="col-lg-5 border-start-lg">
                <div class="p-3 bg-light rounded-4">
                    <h6 class="fw-bold text-navy mb-2"><i class="bi bi-info-circle-fill text-primary me-2"></i>ข้อกำหนดของข้อมูลที่นำเข้า</h6>
                    <ul class="text-muted small mb-0 ps-3" style="line-height: 1.8;">
                        <li><strong>เลขที่สมาชิก (จำเป็น):</strong> ต้องไม่เว้นว่าง เช่น `MEM-2024-0015`</li>
                        <li><strong>ชื่อ - นามสกุล (จำเป็น):</strong> ต้องมีข้อมูลทั้งชื่อและนามสกุล</li>
                        <li><strong>สังกัด/หน่วยงาน (จำเป็น):</strong> เช่น `โรงพยาบาลระยอง`, `สสจ.ระยอง`</li>
                        <li><strong>ทุนเรือนหุ้นเริ่มต้น:</strong> ระบบจะคำนวณมูลค่ารวมอัตโนมัติ (หุ้นละ 10 บาท)</li>
                        <li><strong>รหัสผ่านเข้าใช้งาน:</strong> ระบบจะตั้งค่าเริ่มต้นเป็น <code>coop123</code> และให้สมาชิกเปลี่ยนเองได้</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 2: Data Validation & Preview Section -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white d-none mb-4" id="previewSection">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h5 class="fw-bold text-navy mb-1"><i class="bi bi-clipboard2-check-fill text-primary me-2"></i>ผลการตรวจสอบความถูกต้องของข้อมูล</h5>
                <p class="text-muted small mb-0">ตรวจสอบความถูกต้องก่อนกดบันทึกลงฐานข้อมูลจริง</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="resetAll()">
                    <i class="bi bi-arrow-left me-1"></i>เลือกไฟล์ใหม่
                </button>
                <button type="button" class="btn btn-success btn-sm rounded-pill px-4 fw-bold shadow-sm" id="btnConfirmImport" onclick="executeBatchImport()">
                    <span class="spinner-border spinner-border-sm d-none" id="importSpinner" role="status"></span>
                    <span id="importBtnText"><i class="bi bi-check2-circle me-1"></i> ยืนยันการนำเข้าข้อมูล</span>
                </button>
            </div>
        </div>

        <!-- Metric KPI Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="p-3 bg-light rounded-4 border">
                    <div class="text-muted small">จำนวนแถวทั้งหมด</div>
                    <h3 class="fw-bold text-dark mb-0 font-monospace" id="statTotal">0</h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 bg-success-subtle rounded-4 border border-success-subtle">
                    <div class="text-success small fw-bold">ข้อมูลถูกต้อง (พร้อมเพิ่มใหม่)</div>
                    <h3 class="fw-bold text-success mb-0 font-monospace" id="statValid">0</h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 bg-warning-subtle rounded-4 border border-warning-subtle">
                    <div class="text-warning small fw-bold">ข้อมูลซ้ำในระบบ (จะอัปเดต)</div>
                    <h3 class="fw-bold text-warning mb-0 font-monospace" id="statDuplicate">0</h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 bg-danger-subtle rounded-4 border border-danger-subtle">
                    <div class="text-danger small fw-bold">ข้อมูลไม่สมบูรณ์ (จะข้าม)</div>
                    <h3 class="fw-bold text-danger mb-0 font-monospace" id="statError">0</h3>
                </div>
            </div>
        </div>

        <!-- Options Switches -->
        <div class="p-3 bg-light rounded-4 border mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="chkUpdateDuplicates" checked>
                        <label class="form-check-label fw-semibold small" for="chkUpdateDuplicates">
                            อัปเดตข้อมูลสมาชิกเดิมหากพบเลขที่สมาชิกซ้ำในระบบ (Upsert)
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="chkCreateAccounts" checked>
                        <label class="form-check-label fw-semibold small" for="chkCreateAccounts">
                            สร้างบัญชีผู้ใช้งานสำหรับ Login เข้าสู่ระบบสมาชิกอัตโนมัติ (Default: coop123)
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Data Table -->
        <div class="table-responsive" style="max-height: 480px; overflow-y: auto;">
            <table class="table table-hover align-middle mb-0" id="previewTable">
                <thead class="table-light sticky-top">
                    <tr>
                        <th style="width: 60px;">แถว</th>
                        <th>สถานะ</th>
                        <th>เลขสมาชิก</th>
                        <th>ชื่อ - นามสกุล</th>
                        <th>สังกัด / หน่วยงาน</th>
                        <th>เบอร์โทร</th>
                        <th>ค่าหุ้นรายเดือน</th>
                        <th>จำนวนหุ้น</th>
                        <th>เงินฝากเริ่มต้น</th>
                    </tr>
                </thead>
                <tbody id="previewTableBody">
                    <!-- Populated via Javascript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
let parsedRows = [];

document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const uploadForm = document.getElementById('uploadForm');
    const btnPreview = document.getElementById('btnPreview');
    const dropZonePrompt = document.getElementById('dropZonePrompt');
    const fileSelectedInfo = document.getElementById('fileSelectedInfo');
    const selectedFileName = document.getElementById('selectedFileName');
    const selectedFileSize = document.getElementById('selectedFileSize');

    // Click dropzone to open file dialog
    dropZone.addEventListener('click', () => fileInput.click());

    // Drag & Drop Handlers
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.add('bg-white', 'border-primary');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.remove('bg-white', 'border-primary');
        }, false);
    });

    dropZone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect(files[0]);
        }
    });

    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            handleFileSelect(this.files[0]);
        }
    });

    function handleFileSelect(file) {
        selectedFileName.textContent = file.name;
        selectedFileSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
        dropZonePrompt.classList.add('d-none');
        fileSelectedInfo.classList.remove('d-none');
        btnPreview.disabled = false;
    }

    // Submit File for Preview
    uploadForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!fileInput.files.length) return;

        const csrfToken = document.querySelector('input[name="_csrf_token"]')?.value || window.CSRF_TOKEN || '';
        const formData = new FormData();
        formData.append('import_file', fileInput.files[0]);
        formData.append('_csrf_token', csrfToken);

        setPreviewLoading(true);

        fetch("<?= url('staff/import/preview') ?>", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(res => res.json())
        .then(data => {
            setPreviewLoading(false);
            if (data.success) {
                renderPreview(data);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ตรวจสอบไฟล์ไม่สำเร็จ',
                    text: data.message || 'โครงสร้างไฟล์ไม่ถูกต้อง',
                    confirmButtonColor: '#0066CC'
                });
            }
        })
        .catch(err => {
            setPreviewLoading(false);
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถประมวลผลไฟล์ได้ กรุณาลองใหม่อีกครั้ง',
                confirmButtonColor: '#0066CC'
            });
        });
    });

    function setPreviewLoading(isLoading) {
        const spinner = document.getElementById('previewSpinner');
        const text = document.getElementById('previewBtnText');
        if (isLoading) {
            btnPreview.disabled = true;
            spinner.classList.remove('d-none');
            text.textContent = ' กำลังตรวจสอบข้อมูล...';
        } else {
            btnPreview.disabled = false;
            spinner.classList.add('d-none');
            text.innerHTML = '<i class="bi bi-search me-1"></i> ตรวจสอบและพรีวิวข้อมูล';
        }
    }
});

function resetFileSelection() {
    document.getElementById('fileInput').value = '';
    document.getElementById('dropZonePrompt').classList.remove('d-none');
    document.getElementById('fileSelectedInfo').classList.add('d-none');
    document.getElementById('btnPreview').disabled = true;
}

function resetAll() {
    resetFileSelection();
    document.getElementById('previewSection').classList.add('d-none');
    document.getElementById('uploadStepCard').classList.remove('d-none');
    parsedRows = [];
}

function renderPreview(data) {
    parsedRows = data.rows || [];
    document.getElementById('statTotal').textContent = data.total_rows;
    document.getElementById('statValid').textContent = data.valid_count;
    document.getElementById('statDuplicate').textContent = data.duplicate_count;
    document.getElementById('statError').textContent = data.error_count;

    const tbody = document.getElementById('previewTableBody');
    tbody.innerHTML = '';

    parsedRows.forEach(r => {
        const tr = document.createElement('tr');
        
        let statusBadge = '';
        if (r.status === 'valid') {
            statusBadge = '<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">พร้อมเพิ่มใหม่</span>';
        } else if (r.status === 'duplicate') {
            statusBadge = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">มีในระบบแล้ว</span>';
        } else {
            statusBadge = `<span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill" title="${r.errors.join(', ')}">ผิดพลาด</span>`;
        }

        tr.innerHTML = `
            <td class="text-muted small">${r.row_number}</td>
            <td>${statusBadge}</td>
            <td class="fw-bold font-monospace text-primary">${escapeHtml(r.member_no)}</td>
            <td>
                <div class="fw-semibold text-dark">${escapeHtml(r.prefix + r.first_name + ' ' + r.last_name)}</div>
                <small class="text-muted">${escapeHtml(r.position || '-')}</small>
            </td>
            <td>${escapeHtml(r.department)}</td>
            <td>${escapeHtml(r.phone || '-')}</td>
            <td>฿${numberFormat(r.monthly_share)}</td>
            <td>${numberFormat(r.total_shares)} หุ้น</td>
            <td>฿${numberFormat(r.initial_deposit)}</td>
        `;

        if (r.status === 'error') {
            tr.classList.add('table-danger');
        }

        tbody.appendChild(tr);
    });

    document.getElementById('uploadStepCard').classList.add('d-none');
    document.getElementById('previewSection').classList.remove('d-none');
}

function executeBatchImport() {
    if (!parsedRows.length) return;

    const updateDuplicates = document.getElementById('chkUpdateDuplicates').checked;
    const createAccounts = document.getElementById('chkCreateAccounts').checked;

    Swal.fire({
        title: 'ยืนยันการนำเข้าข้อมูล?',
        text: `ระบบจะทำการบันทึกข้อมูลสมาชิกทั้งหมด ${parsedRows.length} รายการลงในฐานข้อมูล`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0066CC',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'ใช่, นำเข้าข้อมูลทันที',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            setImportLoading(true);

            const csrfToken = document.querySelector('input[name="_csrf_token"]')?.value || window.CSRF_TOKEN || '';
            fetch("<?= url('staff/import/process') ?>", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    _csrf_token: csrfToken,
                    rows: parsedRows,
                    update_duplicates: updateDuplicates ? 1 : 0,
                    create_accounts: createAccounts ? 1 : 0
                })
            })
            .then(res => res.json())
            .then(data => {
                setImportLoading(false);
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'นำเข้าข้อมูลสำเร็จ!',
                        html: `
                            <div class="text-start p-3 bg-light rounded-3 my-2 small">
                                <div class="mb-1 text-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i> เพิ่มสมาชิกใหม่: ${data.imported_count} ราย</div>
                                <div class="mb-1 text-warning fw-bold"><i class="bi bi-arrow-repeat me-1"></i> อัปเดตสมาชิกเดิม: ${data.updated_count} ราย</div>
                                <div class="mb-1 text-primary fw-bold"><i class="bi bi-person-lock me-1"></i> สร้างบัญชี Login: ${data.accounts_created} บัญชี</div>
                                <div class="text-muted"><i class="bi bi-skip-forward me-1"></i> ข้ามรายการที่ผิดพลาด: ${data.skipped_count} ราย</div>
                            </div>
                        `,
                        confirmButtonColor: '#0066CC',
                        confirmButtonText: 'ไปที่หน้ารายชื่อสมาชิก'
                    }).then(() => {
                        window.location.href = "<?= url('staff/members') ?>";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาดในการนำเข้า',
                        text: data.message || 'ไม่สามารถบันทึกข้อมูลได้',
                        confirmButtonColor: '#0066CC'
                    });
                }
            })
            .catch(err => {
                setImportLoading(false);
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาดของระบบ',
                    text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                    confirmButtonColor: '#0066CC'
                });
            });
        }
    });
}

function setImportLoading(isLoading) {
    const btn = document.getElementById('btnConfirmImport');
    const spinner = document.getElementById('importSpinner');
    const text = document.getElementById('importBtnText');
    if (isLoading) {
        btn.disabled = true;
        spinner.classList.remove('d-none');
        text.textContent = ' กำลังบันทึกข้อมูล...';
    } else {
        btn.disabled = false;
        spinner.classList.add('d-none');
        text.innerHTML = '<i class="bi bi-check2-circle me-1"></i> ยืนยันการนำเข้าข้อมูล';
    }
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function numberFormat(num) {
    return Number(num || 0).toLocaleString('th-TH');
}
</script>
