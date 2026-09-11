<?php
$slides = $slides ?? [];
?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-images me-2 text-primary"></i> จัดการ Hero Slideshow</h3>
        <p class="text-muted small mb-0">แบนเนอร์ภาพสไลด์ขนาดใหญ่บนหน้าแรกของเว็บไซต์ พร้อมระบบปรับแต่งข้อความ รูปภาพ และความโปร่งแสง</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= url('/') ?>" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-box-arrow-up-right me-1"></i> ดูหน้าแรก
        </a>
        <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createSlideModal">
            <i class="bi bi-plus-lg me-1"></i> เพิ่มสไลด์ใหม่
        </button>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th style="width: 140px;">ภาพพื้นหลัง</th>
                        <th>หัวข้อสไลด์ (Title)</th>
                        <th>ปุ่ม CTA</th>
                        <th>Overlay</th>
                        <th>Priority</th>
                        <th>สถานะ</th>
                        <th class="text-end" style="width: 120px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($slides)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-images fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                ยังไม่มีข้อมูลสไลด์ในระบบ
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($slides as $i => $s): ?>
                            <?php
                                $img = $s['desktop_image'] ?? 'hero_bg_default.jpg';
                                if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                                    $thumbUrl = $img;
                                } elseif (str_starts_with($img, 'storage/') || str_starts_with($img, '/storage/')) {
                                    $thumbUrl = url(ltrim($img, '/'));
                                } else {
                                    $thumbUrl = asset('img/' . $img);
                                }
                            ?>
                            <tr>
                                <td class="text-muted small"><?= $i + 1 ?></td>
                                <td>
                                    <div class="rounded-3 overflow-hidden shadow-sm border position-relative" style="width: 120px; height: 65px; background: #07284f;">
                                        <img src="<?= $thumbUrl ?>" alt="<?= e($s['title']) ?>" class="w-100 h-100 object-fit-cover">
                                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 text-white px-1 py-0 text-center" style="font-size: 10px;">
                                            <?= round(((float)($s['overlay_opacity'] ?? 0.80)) * 100) ?>% Dark
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-navy"><?= e($s['title']) ?></div>
                                    <?php if (!empty($s['subtitle'])): ?>
                                        <div class="badge bg-gold text-dark small mt-1"><i class="bi bi-shield-check me-1"></i> <?= e($s['subtitle']) ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($s['description'])): ?>
                                        <div class="text-muted small text-truncate mt-1" style="max-width: 350px;"><?= e($s['description']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($s['button_text'])): ?>
                                        <a href="<?= url($s['button_url'] ?? '#') ?>" target="_blank" class="badge bg-primary text-white text-decoration-none">
                                            <?= e($s['button_text']) ?> <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 9px;"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border"><?= round(((float)$s['overlay_opacity']) * 100) ?>%</span>
                                </td>
                                <td><span class="badge bg-secondary"><?= e($s['priority']) ?></span></td>
                                <td>
                                    <span class="badge <?= $s['status'] === 'active' ? 'bg-success' : ($s['status'] === 'draft' ? 'bg-warning text-dark' : 'bg-secondary') ?>">
                                        <?= e(strtoupper($s['status'])) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary me-1" title="แก้ไขสไลด์" onclick='openEditModal(<?= json_encode($s, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="ลบสไลด์" onclick="deleteSlide(<?= $s['id'] ?>)">
                                        <i class="bi bi-trash"></i>
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

<!-- Create Slide Modal -->
<div class="modal fade" id="createSlideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy"><i class="bi bi-plus-circle me-2 text-primary"></i> เพิ่ม Hero Slide ใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/hero-slides/store') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">หัวข้อใหญ่ (Main Title) <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required placeholder="เช่น มั่นคง โปร่งใส ทันสมัย เพื่อคุณภาพชีวิตที่ดีของสมาชิก">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">หัวข้อย่อย / Badge (Subtitle)</label>
                        <input type="text" name="subtitle" class="form-control" placeholder="เช่น สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">คำอธิบาย (Description)</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="รายละเอียดข้อความที่จะแสดงใต้หัวข้อใหญ่"></textarea>
                    </div>

                    <div class="card bg-light border-0 p-3 mb-3 rounded-3">
                        <label class="form-label fw-bold small mb-2"><i class="bi bi-image me-1 text-primary"></i> รูปภาพพื้นหลัง (Background Image)</label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">อัปโหลดไฟล์ภาพใหม่ (JPG, PNG, WebP)</label>
                                <input type="file" name="desktop_image_file" class="form-control" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted">หรือเลือกรูปภาพพรีเซ็ตที่มีในระบบ</label>
                                <select name="preset_image" class="form-select">
                                    <option value="">-- กำหนดเอง / ใช้ไฟล์อัปโหลด --</option>
                                    <option value="hero_bg_coop.jpg" selected>🏛️ ภาพอาคารสำนักงานใหญ่สหกรณ์ (hero_bg_coop.jpg)</option>
                                    <option value="hero_bg_health.jpg">🏥 ภาพบุคลากรการแพทย์และสาธารณสุข (hero_bg_health.jpg)</option>
                                    <option value="hero_bg_default.jpg">💼 ภาพการเงินและบริการสมาชิก (hero_bg_default.jpg)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">ข้อความบนปุ่ม CTA</label>
                            <input type="text" name="button_text" class="form-control" placeholder="เช่น สมัครสมาชิก / คำนวณเงินกู้">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">ลิงก์ปลายทางปุ่ม (URL)</label>
                            <input type="text" name="button_url" class="form-control" placeholder="เช่น eservice หรือ loans">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">จัดตำแหน่งข้อความ</label>
                            <select name="text_alignment" class="form-select">
                                <option value="left">ชิดซ้าย (Left)</option>
                                <option value="center">กึ่งกลาง (Center)</option>
                                <option value="right">ชิดขวา (Right)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">ความมืด Overlay (0 - 1)</label>
                            <input type="number" name="overlay_opacity" class="form-control" value="0.80" step="0.05" min="0" max="1">
                            <small class="text-muted" style="font-size: 11px;">แนะนำ 0.75 - 0.85</small>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">ลำดับ Priority</label>
                            <input type="number" name="priority" class="form-control" value="10">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">สถานะการแสดงผล</label>
                            <select name="status" class="form-select">
                                <option value="active">เปิดใช้งาน (Active)</option>
                                <option value="draft">ร่าง (Draft)</option>
                                <option value="inactive">ปิดใช้งาน (Inactive)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">บันทึกสไลด์</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Slide Modal -->
<div class="modal fade" id="editSlideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-navy"><i class="bi bi-pencil-square me-2 text-primary"></i> แก้ไข Hero Slide</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSlideForm" action="" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">หัวข้อใหญ่ (Main Title) <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">หัวข้อย่อย / Badge (Subtitle)</label>
                        <input type="text" name="subtitle" id="edit_subtitle" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">คำอธิบาย (Description)</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="card bg-light border-0 p-3 mb-3 rounded-3">
                        <label class="form-label fw-bold small mb-2"><i class="bi bi-image me-1 text-primary"></i> เปลี่ยนรูปภาพพื้นหลัง</label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">อัปโหลดไฟล์ภาพใหม่ (หากต้องการเปลี่ยน)</label>
                                <input type="file" name="desktop_image_file" class="form-control" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted">หรือเลือกรูปภาพพรีเซ็ต</label>
                                <select name="preset_image" id="edit_preset_image" class="form-select">
                                    <option value="">-- คงรูปภาพเดิมไว้ --</option>
                                    <option value="hero_bg_coop.jpg">🏛️ ภาพอาคารสำนักงานใหญ่สหกรณ์</option>
                                    <option value="hero_bg_health.jpg">🏥 ภาพบุคลากรการแพทย์และสาธารณสุข</option>
                                    <option value="hero_bg_default.jpg">💼 ภาพการเงินและบริการสมาชิก</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <small class="text-muted">รูปภาพปัจจุบัน: <span id="edit_current_image_name" class="fw-bold text-navy"></span></small>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">ข้อความบนปุ่ม CTA</label>
                            <input type="text" name="button_text" id="edit_button_text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">ลิงก์ปลายทางปุ่ม (URL)</label>
                            <input type="text" name="button_url" id="edit_button_url" class="form-control">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">จัดตำแหน่งข้อความ</label>
                            <select name="text_alignment" id="edit_text_alignment" class="form-select">
                                <option value="left">ชิดซ้าย (Left)</option>
                                <option value="center">กึ่งกลาง (Center)</option>
                                <option value="right">ชิดขวา (Right)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">ความมืด Overlay (0 - 1)</label>
                            <input type="number" name="overlay_opacity" id="edit_overlay_opacity" class="form-control" step="0.05" min="0" max="1">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">ลำดับ Priority</label>
                            <input type="number" name="priority" id="edit_priority" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">สถานะการแสดงผล</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="active">เปิดใช้งาน (Active)</option>
                                <option value="draft">ร่าง (Draft)</option>
                                <option value="inactive">ปิดใช้งาน (Inactive)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">บันทึกการเปลี่ยนแปลง</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(slide) {
    document.getElementById('editSlideForm').action = window.APP_URL + '/admin/hero-slides/' + slide.id + '/update';
    document.getElementById('edit_title').value = slide.title || '';
    document.getElementById('edit_subtitle').value = slide.subtitle || '';
    document.getElementById('edit_description').value = slide.description || '';
    document.getElementById('edit_button_text').value = slide.button_text || '';
    document.getElementById('edit_button_url').value = slide.button_url || '';
    document.getElementById('edit_text_alignment').value = slide.text_alignment || 'left';
    document.getElementById('edit_overlay_opacity').value = slide.overlay_opacity || '0.80';
    document.getElementById('edit_priority').value = slide.priority || '10';
    document.getElementById('edit_status').value = slide.status || 'active';
    document.getElementById('edit_current_image_name').textContent = slide.desktop_image || 'hero_bg_default.jpg';
    
    const editModal = new bootstrap.Modal(document.getElementById('editSlideModal'));
    editModal.show();
}

function deleteSlide(id) {
    showDeleteConfirm(() => {
        fetch(window.APP_URL + '/admin/hero-slides/' + id + '/delete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'ลบสไลด์เรียบร้อยแล้ว');
                setTimeout(() => location.reload(), 800);
            } else {
                showError('เกิดข้อผิดพลาด', data.message);
            }
        });
    });
}
</script>

