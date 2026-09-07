<div class="row g-4">
    <!-- Header -->
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 bg-white p-4 rounded-4 shadow-sm border">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= url('admin/surveys') ?>" class="text-decoration-none">แบบสำรวจ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">สร้างใหม่</li>
                    </ol>
                </nav>
                <h4 class="fw-bold text-navy mb-1"><i class="bi bi-plus-circle me-2 text-primary"></i> สร้างแบบสำรวจ / โพลล์ใหม่</h4>
                <p class="text-muted small mb-0">กำหนดหัวข้อ กลุ่มเป้าหมาย และเพิ่มคำถามสำหรับสำรวจความคิดเห็นสมาชิก</p>
            </div>
            <div>
                <a href="<?= url('admin/surveys') ?>" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> ย้อนกลับ
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="col-12">
        <form action="<?= url('admin/surveys/store') ?>" method="POST" id="surveyForm">
            <?= csrf_field() ?>

            <div class="row g-4">
                <!-- Survey Settings -->
                <div class="col-lg-4">
                    <div class="card border-0 rounded-4 shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h6 class="fw-bold text-navy mb-0"><i class="bi bi-gear me-2 text-primary"></i> ตั้งค่าแบบสำรวจ</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold small">หมวดหมู่แบบสำรวจ</label>
                                <select name="category" class="form-select">
                                    <option value="satisfaction">ความพึงพอใจการให้บริการ (CSAT)</option>
                                    <option value="loan_service">บริการสินเชื่อและเงินกู้</option>
                                    <option value="welfare">กองทุนสวัสดิการสมาชิก</option>
                                    <option value="digital_portal">ระบบบริการดิจิทัล & E-Service</option>
                                    <option value="annual_meeting">การประชุมใหญ่สามัญประจำปี</option>
                                    <option value="general">ทั่วไป / รับฟังความคิดเห็น</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">กลุ่มเป้าหมายผู้ตอบ</label>
                                <select name="target_audience" class="form-select">
                                    <option value="all">ทุกคน (สมาชิกและบุคคลทั่วไป)</option>
                                    <option value="members_only" selected>เฉพาะสมาชิกที่เข้าสู่ระบบ</option>
                                    <option value="public">บุคคลทั่วไป</option>
                                </select>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-bold small">วันที่เริ่มเปิดรับ</label>
                                    <input type="date" name="start_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-bold small">วันที่สิ้นสุด</label>
                                    <input type="date" name="end_date" class="form-control" value="<?= date('Y-m-d', strtotime('+60 days')) ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">สถานะการเผยแพร่</label>
                                <select name="status" class="form-select">
                                    <option value="active" selected>เปิดรับคำตอบทันที (Active)</option>
                                    <option value="draft">บันทึกเป็นแบบร่าง (Draft)</option>
                                    <option value="closed">ปิดรับคำตอบ (Closed)</option>
                                </select>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="is_anonymous" id="chkAnon" value="1" checked>
                                <label class="form-check-label small" for="chkAnon">ไม่เปิดเผยตัวตนผู้ตอบ (Anonymous)</label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">ข้อความขอบคุณเมื่อตอบเสร็จ</label>
                                <textarea name="thank_you_message" class="form-control" rows="2">สหกรณ์ขอขอบพระคุณท่านสมาชิกที่ร่วมแสดงความคิดเห็นเพื่อนำไปพัฒนาคุณภาพการบริการ</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-bold shadow-sm">
                                <i class="bi bi-check2-circle me-1"></i> บันทึกและเผยแพร่แบบสำรวจ
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Questions Builder -->
                <div class="col-lg-8">
                    <div class="card border-0 rounded-4 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h6 class="fw-bold text-navy mb-0"><i class="bi bi-card-heading me-2 text-primary"></i> ข้อมูลหัวข้อแบบสำรวจ</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">ชื่อหัวข้อแบบสำรวจ <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control form-control-lg" placeholder="เช่น แบบสำรวจความพึงพอใจการให้บริการ ประจำปี 2569" required>
                            </div>
                            <div class="mb-0">
                                <label class="form-label fw-bold small">คำอธิบายหรือวัตถุประสงค์ของแบบสำรวจ</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="ระบุรายละเอียดชี้แจงแก่ผู้ตอบแบบสำรวจ..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Questions List Container -->
                    <div class="card border-0 rounded-4 shadow-sm">
                        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold text-navy mb-0"><i class="bi bi-question-square me-2 text-primary"></i> รายการคำถามในแบบสำรวจ</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" id="btnAddQuestion">
                                <i class="bi bi-plus-lg me-1"></i> เพิ่มข้อคำถาม
                            </button>
                        </div>
                        <div class="card-body p-4" id="questionsContainer">
                            <!-- Question 1 Default -->
                            <div class="question-card p-3 rounded-4 border mb-3 bg-light-subtle" data-index="0">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary rounded-pill px-3 q-badge">ข้อที่ 1</span>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0 btn-remove-q" title="ลบข้อนี้"><i class="bi bi-trash fs-6"></i></button>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold">ข้อความคำถาม <span class="text-danger">*</span></label>
                                    <input type="text" name="questions[0][text]" class="form-control" placeholder="เช่น ความสะดวกรวดเร็วในการให้บริการ" value="ความพึงพอใจต่อการให้บริการโดยรวมของเจ้าหน้าที่สหกรณ์" required>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">รูปแบบการตอบ</label>
                                        <select name="questions[0][type]" class="form-select form-select-sm q-type-select">
                                            <option value="rating_1_5" selected>ระดับคะแนน 1 - 5 ดาว (CSAT)</option>
                                            <option value="single_choice">ตัวเลือกเดียว (Single Choice)</option>
                                            <option value="multiple_choice">เลือกได้หลายข้อ (Multiple Choice)</option>
                                            <option value="text">กล่องข้อความอิสระ (Text feedback)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" name="questions[0][is_required]" value="1" id="qReq0" checked>
                                            <label class="form-check-label small" for="qReq0">จำเป็นต้องตอบ (*)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="options-container mt-2 d-none">
                                    <label class="form-label small text-muted">ตัวเลือก (1 บรรทัด ต่อ 1 ตัวเลือก)</label>
                                    <textarea name="questions[0][options]" class="form-control form-control-sm" rows="3" placeholder="ตัวเลือกที่ 1&#10;ตัวเลือกที่ 2&#10;ตัวเลือกที่ 3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let qIndex = 1;
    const container = document.getElementById('questionsContainer');
    const btnAdd = document.getElementById('btnAddQuestion');

    function bindEvents(card) {
        const select = card.querySelector('.q-type-select');
        const optContainer = card.querySelector('.options-container');
        const btnRemove = card.querySelector('.btn-remove-q');

        select.addEventListener('change', function() {
            if (this.value === 'single_choice' || this.value === 'multiple_choice') {
                optContainer.classList.remove('d-none');
            } else {
                optContainer.classList.add('d-none');
            }
        });

        btnRemove.addEventListener('click', function() {
            if (container.querySelectorAll('.question-card').length > 1) {
                card.remove();
                renumber();
            } else {
                alert('ต้องมีคำถามอย่างน้อย 1 ข้อ');
            }
        });
    }

    function renumber() {
        const cards = container.querySelectorAll('.question-card');
        cards.forEach((c, idx) => {
            c.querySelector('.q-badge').textContent = 'ข้อที่ ' + (idx + 1);
        });
    }

    bindEvents(container.querySelector('.question-card'));

    btnAdd.addEventListener('click', function() {
        const card = document.createElement('div');
        card.className = 'question-card p-3 rounded-4 border mb-3 bg-light-subtle';
        card.dataset.index = qIndex;
        card.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-primary rounded-pill px-3 q-badge">ข้อที่ ${container.querySelectorAll('.question-card').length + 1}</span>
                <button type="button" class="btn btn-sm btn-link text-danger p-0 btn-remove-q" title="ลบข้อนี้"><i class="bi bi-trash fs-6"></i></button>
            </div>
            <div class="mb-2">
                <label class="form-label small fw-bold">ข้อความคำถาม <span class="text-danger">*</span></label>
                <input type="text" name="questions[${qIndex}][text]" class="form-control" placeholder="ระบุข้อความคำถาม..." required>
            </div>
            <div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">รูปแบบการตอบ</label>
                    <select name="questions[${qIndex}][type]" class="form-select form-select-sm q-type-select">
                        <option value="rating_1_5" selected>ระดับคะแนน 1 - 5 ดาว (CSAT)</option>
                        <option value="single_choice">ตัวเลือกเดียว (Single Choice)</option>
                        <option value="multiple_choice">เลือกได้หลายข้อ (Multiple Choice)</option>
                        <option value="text">กล่องข้อความอิสระ (Text feedback)</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="questions[${qIndex}][is_required]" value="1" id="qReq${qIndex}" checked>
                        <label class="form-check-label small" for="qReq${qIndex}">จำเป็นต้องตอบ (*)</label>
                    </div>
                </div>
            </div>
            <div class="options-container mt-2 d-none">
                <label class="form-label small text-muted">ตัวเลือก (1 บรรทัด ต่อ 1 ตัวเลือก)</label>
                <textarea name="questions[${qIndex}][options]" class="form-control form-control-sm" rows="3" placeholder="ตัวเลือกที่ 1&#10;ตัวเลือกที่ 2&#10;ตัวเลือกที่ 3"></textarea>
            </div>
        `;

        container.appendChild(card);
        bindEvents(card);
        qIndex++;
    });
});
</script>
