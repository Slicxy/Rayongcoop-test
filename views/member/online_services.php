<!-- Header & Overview Hero Banner -->
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-white overflow-hidden position-relative" style="background: linear-gradient(135deg, #072C59 0%, #0066CC 60%, #0284C7 100%);">
    <div class="position-absolute end-0 top-0 bottom-0 d-none d-lg-block opacity-10 pe-5 pt-3 pointer-events-none" style="font-size: 140px;">
        <i class="bi bi-grid-3x3-gap-fill"></i>
    </div>
    <div class="row align-items-center position-relative z-1">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-white text-navy fw-bold px-3 py-1 rounded-pill">
                    <i class="bi bi-patch-check-fill text-primary me-1"></i> บริการสมาชิกเฉพาะกิจ 24 ชม.
                </span>
                <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill">
                    <i class="bi bi-lightning-charge-fill me-1"></i> ดิจิทัลครบวงจร
                </span>
            </div>
            <h3 class="fw-bold text-white mb-2">ศูนย์บริการดิจิทัลและคำขอออนไลน์ (Digital & Specialized Services Hub)</h3>
            <p class="text-white-70 mb-0 small" style="max-width: 650px;">
                เข้าถึงบริการทางการเงิน สวัสดิการเฉพาะกิจ ขอหนังสือรับรอง ประเมินเงินปันผล และติดตามสถานะคำขอแบบเรียลไทม์ได้ในที่เดียว
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            <div class="d-flex flex-column flex-sm-row justify-content-lg-end gap-2">
                <a href="<?= url('member/loan-apply') ?>" class="btn btn-warning text-navy fw-bold rounded-pill px-4 py-2 shadow-sm">
                    <i class="bi bi-pencil-square me-1"></i> ยื่นกู้เงินด่วน
                </a>
                <a href="<?= url('member/tax-certificates') ?>" class="btn btn-light text-navy fw-bold rounded-pill px-3 py-2 shadow-sm">
                    <i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i> ใบรับรองภาษี
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Search & Category Filters -->
<div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-4">
    <div class="row g-3 align-items-center justify-content-between">
        <div class="col-lg-7 col-md-12">
            <div class="nav-pills-modern flex-wrap" role="tablist">
                <button type="button" class="nav-link active" onclick="filterCategory('all', this)">
                    <i class="bi bi-grid-fill me-1"></i> บริการทั้งหมด
                </button>
                <button type="button" class="nav-link" onclick="filterCategory('loan', this)">
                    <i class="bi bi-cash-coin me-1"></i> สินเชื่อและการเงิน
                </button>
                <button type="button" class="nav-link" onclick="filterCategory('welfare', this)">
                    <i class="bi bi-heart-pulse-fill me-1"></i> สวัสดิการเฉพาะกิจ
                </button>
                <button type="button" class="nav-link" onclick="filterCategory('doc', this)">
                    <i class="bi bi-file-earmark-text-fill me-1"></i> เอกสารและภาษี
                </button>
                <button type="button" class="nav-link" onclick="filterCategory('innovation', this)">
                    <i class="bi bi-lightbulb-fill me-1"></i> เสียงสมาชิก
                </button>
            </div>
        </div>
        <div class="col-lg-5 col-md-12">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3 text-muted">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="serviceSearchInput" class="form-control bg-light border-start-0 rounded-end-pill" placeholder="ค้นหาบริการ เช่น เงินกู้, ภาษี, สวัสดิการ, ปันผล..." onkeyup="searchServices(this.value)">
            </div>
        </div>
    </div>
</div>

<!-- Specialized Services Catalog Grid -->
<div class="row g-3 mb-5" id="servicesGrid">
    <!-- 1. Loan Application Wizard -->
    <div class="col-lg-4 col-md-6 service-card-item" data-category="loan" data-keywords="กู้เงิน ยื่นกู้ สินเชื่อ ฉุกเฉิน สามัญ พิเศษ loan apply">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white hover-lift position-relative overflow-hidden">
            <span class="position-absolute top-0 end-0 badge bg-danger text-white rounded-bottom-start-pill px-3 py-1 font-monospace" style="font-size: 11px;">
                <i class="bi bi-fire me-1"></i> ยอดนิยม
            </span>
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-primary-subtle text-primary rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; font-size: 24px;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-navy mb-1">ยื่นคำขอกู้เงินออนไลน์ (Loan Wizard)</h6>
                    <span class="badge bg-light text-primary border font-monospace" style="font-size: 11px;">ระบบดิจิทัล 6 ขั้นตอน</span>
                </div>
            </div>
            <p class="text-muted small mb-4 flex-grow-1">
                คำนวณวงเงินตามเงินเดือน อัปโหลดเอกสารแนบ และติดตามผลการอนุมัติแบบเรียลไทม์
            </p>
            <a href="<?= url('member/loan-apply') ?>" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold w-100">
                <i class="bi bi-send-fill me-1"></i> เข้าสู่ระบบยื่นกู้เงิน
            </a>
        </div>
    </div>

    <!-- 2. Tax Certificate -->
    <div class="col-lg-4 col-md-6 service-card-item" data-category="doc" data-keywords="ภาษี ดอกเบี้ย ลดหย่อนภาษี หนังสือรับรอง tax certificate">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white hover-lift position-relative overflow-hidden">
            <span class="position-absolute top-0 end-0 badge bg-success text-white rounded-bottom-start-pill px-3 py-1 font-monospace" style="font-size: 11px;">
                <i class="bi bi-check2-circle me-1"></i> ออกเอกสารทันที
            </span>
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-success-subtle text-success rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; font-size: 24px;">
                    <i class="bi bi-file-earmark-medical-fill"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-navy mb-1">หนังสือรับรองดอกเบี้ยเงินกู้ (Tax Cert)</h6>
                    <span class="badge bg-light text-success border font-monospace" style="font-size: 11px;">ลดหย่อนภาษีเงินได้</span>
                </div>
            </div>
            <p class="text-muted small mb-4 flex-grow-1">
                ดาวน์โหลดและพิมพ์หนังสือรับรองดอกเบี้ยเงินกู้เพื่อที่อยู่อาศัย พร้อม QR Code ตรวจสอบ
            </p>
            <a href="<?= url('member/tax-certificates') ?>" class="btn btn-outline-success btn-sm rounded-pill fw-semibold w-100">
                <i class="bi bi-printer-fill me-1"></i> ดูและพิมพ์หนังสือรับรอง
            </a>
        </div>
    </div>

    <!-- 3. Smart Dividend Estimator -->
    <div class="col-lg-4 col-md-6 service-card-item" data-category="loan" data-keywords="ปันผล เฉลี่ยคืน ประมาณการ คำนวณ dividend estimator">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white hover-lift position-relative overflow-hidden">
            <span class="position-absolute top-0 end-0 badge bg-warning text-dark rounded-bottom-start-pill px-3 py-1 font-monospace" style="font-size: 11px;">
                <i class="bi bi-cpu-fill me-1"></i> ระบบอัจฉริยะ
            </span>
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-warning-subtle text-warning rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; font-size: 24px;">
                    <i class="bi bi-pie-chart-fill"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-navy mb-1">ประมาณการเงินปันผล & เฉลี่ยคืน</h6>
                    <span class="badge bg-light text-warning border font-monospace" style="font-size: 11px;">คำนวณอัตโนมัติ</span>
                </div>
            </div>
            <p class="text-muted small mb-4 flex-grow-1">
                จำลองเงินปันผลค่าหุ้นและเงินเฉลี่ยคืนดอกเบี้ยเงินกู้ประจำปีตามยอดสะสมของสมาชิก
            </p>
            <a href="<?= url('member/dividend-estimator') ?>" class="btn btn-outline-warning text-dark btn-sm rounded-pill fw-semibold w-100">
                <i class="bi bi-calculator-fill me-1"></i> เปิดเครื่องคำนวณปันผล
            </a>
        </div>
    </div>

    <!-- 4. Specialized Welfare Claims -->
    <div class="col-lg-4 col-md-6 service-card-item" data-category="welfare" data-keywords="สวัสดิการ คลอดบุตร เจ็บป่วย เสียชีวิต ทุนการศึกษา welfare claim">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white hover-lift position-relative overflow-hidden">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-info-subtle text-info rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; font-size: 24px;">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-navy mb-1">ยื่นคำขอรับสวัสดิการสมาชิกเฉพาะกิจ</h6>
                    <span class="badge bg-light text-info border font-monospace" style="font-size: 11px;">กองทุนสวัสดิการ</span>
                </div>
            </div>
            <p class="text-muted small mb-4 flex-grow-1">
                ยื่นขอรับเงินสงเคราะห์รักษาพยาบาล คลอดบุตร ทุนการศึกษาบุตร และเงินช่วยเหลือกรณีภัยพิบัติ
            </p>
            <a href="<?= url('member/welfare') ?>" class="btn btn-outline-info text-dark btn-sm rounded-pill fw-semibold w-100">
                <i class="bi bi-hand-thumbs-up-fill me-1"></i> ยื่นขอสวัสดิการ
            </a>
        </div>
    </div>

    <!-- 5. Member Voice & Innovation Suggestion Box -->
    <div class="col-lg-4 col-md-6 service-card-item" data-category="innovation" data-keywords="ข้อเสนอแนะ ข้อคิดเห็น ร้องเรียน กล่องรับฟัง นวัตกรรม suggestion">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white hover-lift position-relative overflow-hidden">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-purple-subtle text-purple rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; font-size: 24px; background-color: #EDE9FE; color: #7C3AED;">
                    <i class="bi bi-chat-square-quote-fill"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-navy mb-1">กล่องรับฟังเสียงและนวัตกรรมสมาชิก</h6>
                    <span class="badge bg-light text-purple border font-monospace" style="font-size: 11px; color: #7C3AED;">Member Voice</span>
                </div>
            </div>
            <p class="text-muted small mb-4 flex-grow-1">
                ร่วมเสนอแนะไอเดียพัฒนาสหกรณ์ เสนอโครงการใหม่ พร้อมติดตามสถานะการผลักดันสู่การปฏิบัติ
            </p>
            <a href="<?= url('member/suggestions') ?>" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold w-100">
                <i class="bi bi-lightbulb-fill text-warning me-1"></i> ส่งข้อเสนอแนะ / ดูสถานะ
            </a>
        </div>
    </div>

    <!-- 6. Satisfaction Survey & Polls -->
    <div class="col-lg-4 col-md-6 service-card-item" data-category="innovation" data-keywords="แบบสำรวจ ความพึงพอใจ ประเมิน survey">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white hover-lift position-relative overflow-hidden">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-primary-subtle text-primary rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; font-size: 24px;">
                    <i class="bi bi-card-checklist"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-navy mb-1">แบบสำรวจความพึงพอใจ & วิจัย</h6>
                    <span class="badge bg-light text-primary border font-monospace" style="font-size: 11px;">Online Poll</span>
                </div>
            </div>
            <p class="text-muted small mb-4 flex-grow-1">
                ตอบแบบสำรวจความคิดเห็นเพื่อยกระดับการให้บริการของสหกรณ์ให้ตรงตามความต้องการของสมาชิก
            </p>
            <a href="<?= url('member/surveys') ?>" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold w-100">
                <i class="bi bi-pencil-fill me-1"></i> ทำแบบสำรวจออนไลน์
            </a>
        </div>
    </div>

    <!-- 7. Monthly Share Change Request -->
    <div class="col-lg-4 col-md-6 service-card-item" data-category="loan" data-keywords="หุ้น เปลี่ยนค่าหุ้น เพิ่มหุ้น ลดหุ้น share change">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white hover-lift position-relative overflow-hidden">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-warning-subtle text-warning rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; font-size: 24px;">
                    <i class="bi bi-sliders"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-navy mb-1">ขอเปลี่ยนแปลงค่าหุ้นรายเดือน</h6>
                    <span class="badge bg-light text-warning border font-monospace" style="font-size: 11px;">ทุนเรือนหุ้น</span>
                </div>
            </div>
            <p class="text-muted small mb-4 flex-grow-1">
                ส่งคำขอเพิ่มหรือลดอัตราการส่งเงินค่าหุ้นรายเดือนตามความสะดวกทางการเงิน
            </p>
            <a href="<?= url('member/shares') ?>" class="btn btn-outline-warning text-dark btn-sm rounded-pill fw-semibold w-100">
                <i class="bi bi-arrow-left-right me-1"></i> ขอปรับเปลี่ยนค่าหุ้น
            </a>
        </div>
    </div>

    <!-- 8. Request Official Certificates -->
    <div class="col-lg-4 col-md-6 service-card-item" data-category="doc" data-keywords="หนังสือรับรอง ยอดหนี้ สมาชิกภาพ certificate">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white hover-lift position-relative overflow-hidden">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-info-subtle text-info rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; font-size: 24px;">
                    <i class="bi bi-patch-check"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-navy mb-1">ขอหนังสือรับรองทางการ</h6>
                    <span class="badge bg-light text-info border font-monospace" style="font-size: 11px;">สมาชิกภาพ / ภาระหนี้</span>
                </div>
            </div>
            <p class="text-muted small mb-4 flex-grow-1">
                ขอหนังสือรับรองการเป็นสมาชิกสหกรณ์ หรือหนังสือรับรองยอดหนี้คงเหลือเพื่อยื่นกู้สถาบันการเงิน
            </p>
            <button type="button" class="btn btn-outline-info text-dark btn-sm rounded-pill fw-semibold w-100" onclick="openCertRequestModal()">
                <i class="bi bi-send-plus-fill me-1"></i> ยื่นคำขอเอกสารทันที
            </button>
        </div>
    </div>

    <!-- 9. Electronic Receipts with QR -->
    <div class="col-lg-4 col-md-6 service-card-item" data-category="doc" data-keywords="ใบเสร็จ สลิป ประจำเดือน receipt">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white hover-lift position-relative overflow-hidden">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-primary-subtle text-primary rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; font-size: 24px;">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-navy mb-1">ใบเสร็จรับเงินอิเล็กทรอนิกส์ (E-Receipts)</h6>
                    <span class="badge bg-light text-primary border font-monospace" style="font-size: 11px;">พร้อม QR Verification</span>
                </div>
            </div>
            <p class="text-muted small mb-4 flex-grow-1">
                ตรวจดูและดาวน์โหลดใบเสร็จรับเงินประจำเดือนพร้อมลายมือชื่อดิจิทัลและ QR Code ตามระเบียบ
            </p>
            <a href="<?= url('member/receipts') ?>" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold w-100">
                <i class="bi bi-qr-code me-1"></i> ดูประวัติใบเสร็จรับเงิน
            </a>
        </div>
    </div>
</div>

<!-- Request Tracking Table Section -->
<div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
    <div class="card-header bg-white border-0 p-4 pb-2">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h5 class="fw-bold text-navy mb-1"><i class="bi bi-send-check-fill text-primary me-2"></i>ติดตามสถานะคำขอออนไลน์ทั้งหมด (Request Tracking)</h5>
                <p class="text-muted small mb-0">ตรวจสอบความคืบหน้าของคำขอกู้เงิน, สวัสดิการ, หนังสือรับรอง และคำขอเปลี่ยนแปลงค่าหุ้น</p>
            </div>
            <div>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="location.reload()">
                    <i class="bi bi-arrow-clockwise me-1"></i> รีเฟรชสถานะ
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-4 pt-2">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>เลขที่คำขอ (Request ID)</th>
                        <th>ประเภทคำขอ</th>
                        <th>หัวข้อ / รายละเอียด</th>
                        <th>สถานะดำเนินงาน</th>
                        <th>วันที่ยื่นคำขอ</th>
                        <th class="text-center">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($requests)): ?>
                        <?php foreach ($requests as $r): ?>
                            <tr>
                                <td class="font-monospace small fw-bold text-primary">
                                    <i class="bi bi-hash"></i><?= e($r['request_no']) ?>
                                </td>
                                <td>
                                    <span class="badge bg-light text-navy border small fw-semibold">
                                        <?= match($r['request_type']) {
                                            'loan' => 'คำขอกู้เงิน',
                                            'share_change' => 'เปลี่ยนค่าหุ้น',
                                            'welfare' => 'สวัสดิการ',
                                            'certificate' => 'หนังสือรับรอง',
                                            'debt_cert' => 'รับรองหนี้',
                                            default => e($r['request_type'])
                                        } ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold small text-navy mb-0"><?= e($r['title']) ?></div>
                                    <small class="text-muted d-block text-truncate" style="max-width: 320px;"><?= e($r['details']) ?></small>
                                </td>
                                <td>
                                    <?php if ($r['status'] === 'completed' || $r['status'] === 'approved'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                            <i class="bi bi-check-circle-fill me-1"></i>เสร็จสมบูรณ์
                                        </span>
                                    <?php elseif ($r['status'] === 'in_progress' || $r['status'] === 'document_review'): ?>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3 py-1">
                                            <i class="bi bi-hourglass-split me-1"></i>กำลังดำเนินการ
                                        </span>
                                    <?php elseif ($r['status'] === 'rejected'): ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1">
                                            <i class="bi bi-x-circle-fill me-1"></i>ไม่อนุมัติ
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-1">
                                            <i class="bi bi-send-fill me-1"></i>ส่งคำขอแล้ว
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="small text-muted font-monospace"><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="showTimeline('<?= e($r['request_no']) ?>', <?= htmlspecialchars($r['timeline_json'] ?? '[]') ?>)">
                                        <i class="bi bi-clock-history me-1"></i> ไทม์ไลน์
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted small">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                                <div>ยังไม่มีประวัติคำขอออนไลน์ในขณะนี้</div>
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
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom p-4 pb-3">
                <h5 class="modal-title fw-bold text-navy">
                    <i class="bi bi-clock-history text-primary me-2"></i>ไทม์ไลน์การดำเนินการ: <span id="timelineReqNo" class="font-monospace text-primary"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="timelineContent"></div>
            </div>
            <div class="modal-footer bg-light border-top-0 p-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<!-- Request Certificate Modal -->
<div class="modal fade" id="certRequestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom p-4 pb-3">
                <h5 class="modal-title fw-bold text-navy">
                    <i class="bi bi-file-earmark-check-fill text-primary me-2"></i>ยื่นคำขอหนังสือรับรองทางการ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="certReqForm" onsubmit="submitCertRequest(event)">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy">ประเภทหนังสือรับรองที่ต้องการ <span class="text-danger">*</span></label>
                        <select id="certTypeSelect" class="form-select rounded-3" required>
                            <option value="ขอหนังสือรับรองการเป็นสมาชิกสหกรณ์">หนังสือรับรองการเป็นสมาชิกสหกรณ์</option>
                            <option value="ขอหนังสือรับรองภาระหนี้สินและเงินกู้คงเหลือ">หนังสือรับรองภาระหนี้สินและเงินกู้คงเหลือ</option>
                            <option value="ขอหนังสือรับรองยอดเงินฝากสะสมรวม">หนังสือรับรองยอดเงินฝากสะสมรวม</option>
                            <option value="ขอหนังสือรับรองการส่งเงินค่าหุ้นสะสม">หนังสือรับรองการส่งเงินค่าหุ้นสะสม</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy">วัตถุประสงค์ในการนำไปใช้ <span class="text-danger">*</span></label>
                        <input type="text" id="certPurposeInput" class="form-control rounded-3" placeholder="เช่น เพื่อยื่นกู้ซื้อบ้านสถาบันการเงินอื่น, ใช้ประกอบการศึกษา" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy">หมายเหตุ / ช่องทางรับเอกสาร</label>
                        <select id="certDeliverySelect" class="form-select rounded-3">
                            <option value="รับเป็นไฟล์ PDF ผ่านระบบออนไลน์">รับเป็นไฟล์ PDF ทางการผ่านระบบสมาชิกออนไลน์</option>
                            <option value="ขอรับฉบับจริง ณ สำนักงานสหกรณ์">ขอรับเอกสารฉบับจริง ณ สำนักงานสหกรณ์ออมทรัพย์สาธารณสุขระยอง</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">
                            <i class="bi bi-send-fill me-1"></i> ยืนยันส่งคำขอ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function filterCategory(cat, btn) {
    document.querySelectorAll('.nav-pills-modern .nav-link').forEach(el => el.classList.remove('active'));
    btn.classList.add('active');

    const items = document.querySelectorAll('.service-card-item');
    items.forEach(item => {
        if (cat === 'all' || item.getAttribute('data-category') === cat) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

function searchServices(query) {
    const q = query.trim().toLowerCase();
    const items = document.querySelectorAll('.service-card-item');
    
    items.forEach(item => {
        const text = (item.textContent + ' ' + (item.getAttribute('data-keywords') || '')).toLowerCase();
        if (q === '' || text.includes(q)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

function showTimeline(reqNo, timeline) {
    document.getElementById('timelineReqNo').textContent = reqNo;
    const container = document.getElementById('timelineContent');
    container.innerHTML = '';

    if (!timeline || timeline.length === 0) {
        container.innerHTML = '<p class="text-muted small text-center mb-0 py-3"><i class="bi bi-hourglass-split me-1"></i> อยู่ระหว่างรอเจ้าหน้าที่รับเรื่องและตรวจสอบเอกสาร</p>';
    } else {
        let html = '<div class="position-relative ps-3 border-start border-2 border-primary ms-2">';
        timeline.forEach(t => {
            html += `<div class="mb-3 position-relative">
                <div class="position-absolute rounded-circle bg-primary" style="width: 10px; height: 10px; left: -21px; top: 5px;"></div>
                <div class="small font-monospace text-primary fw-bold">${t.time || ''}</div>
                <div class="fw-bold text-navy small">${t.status}</div>
                <div class="text-muted small">${t.desc}</div>
            </div>`;
        });
        html += '</div>';
        container.innerHTML = html;
    }

    new bootstrap.Modal(document.getElementById('timelineModal')).show();
}

function openCertRequestModal() {
    new bootstrap.Modal(document.getElementById('certRequestModal')).show();
}

function submitCertRequest(e) {
    e.preventDefault();
    const type = document.getElementById('certTypeSelect').value;
    const purpose = document.getElementById('certPurposeInput').value;
    const delivery = document.getElementById('certDeliverySelect').value;

    Swal.fire({
        title: 'ยืนยันการส่งคำขอ?',
        text: `${type} (${purpose})`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'ยืนยันส่งคำขอ',
        cancelButtonText: 'ยกเลิก',
        confirmButtonColor: '#0066CC'
    }).then(res => {
        if (res.isConfirmed) {
            bootstrap.Modal.getInstance(document.getElementById('certRequestModal')).hide();
            Swal.fire({
                title: 'ส่งคำขอสำเร็จ',
                text: 'เจ้าหน้าที่ธุรการได้รับคำขอแล้ว และจะจัดทำเอกสารให้ภายใน 1-2 วันทำการ',
                icon: 'success',
                confirmButtonColor: '#0066CC'
            });
        }
    });
}
</script>
