<div class="py-5 bg-navy text-white">
    <div class="container-xl">
        <span class="badge bg-gold text-white mb-2 px-3 py-1"><i class="bi bi-megaphone-fill me-1"></i> ข่าวสารสำคัญ</span>
        <h1 class="text-white fw-bold display-6 mb-2">ประกาศสำคัญสหกรณ์</h1>
        <p class="text-light-blue lead mb-0">ประกาศ มติคณะกรรมการ และข้อมูลสำคัญที่มีผลบังคับใช้สำหรับสมาชิกสหกรณ์</p>
    </div>
</div>

<div class="container-xl py-5">
    <?php if ($error = flash('error')): ?>
        <div class="alert alert-warning alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= e($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Filter & Search Bar -->
    <div class="coop-card p-4 mb-4">
        <form action="<?= url('announcements') ?>" method="GET" class="row g-3">
            <div class="col-md-6">
                <label for="search_q" class="form-label fw-bold small">ค้นหาประกาศ / มติเลขที่</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" id="search_q" name="q" class="form-control" placeholder="พิมพ์หัวข้อประกาศ หรือเลขที่มติ..." value="<?= e($keyword ?? '') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <label for="filter_priority" class="form-label fw-bold small">ระดับความสำคัญ</label>
                <select id="filter_priority" name="priority" class="form-select">
                    <option value="">-- ทั้งหมดทุกระดับความสำคัญ --</option>
                    <option value="urgent" <?= ($selectedPriority === 'urgent') ? 'selected' : '' ?>>ด่วนที่สุด (Urgent)</option>
                    <option value="important" <?= ($selectedPriority === 'important') ? 'selected' : '' ?>>สำคัญ (Important)</option>
                    <option value="general" <?= ($selectedPriority === 'general') ? 'selected' : '' ?>>ทั่วไป (General)</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter me-1"></i> ค้นหา
                </button>
                <?php if (!empty($keyword) || !empty($selectedPriority)): ?>
                    <a href="<?= url('announcements') ?>" class="btn btn-outline-secondary">รีเซ็ต</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Announcements List -->
    <div class="row g-4">
        <?php if (empty($announcements)): ?>
            <div class="col-12">
                <div class="coop-card p-5 text-center text-muted">
                    <i class="bi bi-megaphone fs-1 d-block mb-3 text-secondary"></i>
                    <h5>ไม่พบประกาศสำคัญตามเงื่อนไขที่เลือก</h5>
                    <p class="small mb-0">ท่านสามารถติดตามข่าวสารประชาสัมพันธ์ทั่วไปได้ที่หน้าข่าวสาร</p>
                    <a href="<?= url('news') ?>" class="btn btn-sm btn-outline-primary mt-3">ดูข่าวประชาสัมพันธ์</a>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($announcements as $item): ?>
                <div class="col-12">
                    <div class="coop-card p-4 transition-all hover-shadow <?= $item['is_pinned'] ? 'border-primary border-2' : '' ?>">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                            <div class="flex-grow-1">
                                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                    <?php if ($item['is_pinned']): ?>
                                        <span class="badge bg-primary"><i class="bi bi-pin-angle-fill me-1"></i> ปักหมุด</span>
                                    <?php endif; ?>

                                    <?php if ($item['priority'] === 'urgent'): ?>
                                        <span class="badge bg-danger"><i class="bi bi-exclamation-octagon-fill me-1"></i> ด่วนที่สุด</span>
                                    <?php elseif ($item['priority'] === 'important'): ?>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i> ประกาศสำคัญ</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">ทั่วไป</span>
                                    <?php endif; ?>

                                    <?php if (!empty($item['resolution_no'])): ?>
                                        <span class="badge bg-light text-navy border">
                                            <i class="bi bi-file-earmark-check me-1"></i> <?= e($item['resolution_no']) ?>
                                        </span>
                                    <?php endif; ?>

                                    <span class="text-muted small">
                                        <i class="bi bi-calendar3 me-1"></i> เผยแพร่เมื่อ <?= thai_date($item['publication_date']) ?>
                                    </span>

                                    <?php if (!empty($item['expiry_date'])): ?>
                                        <span class="text-muted small">
                                            • <i class="bi bi-clock-history me-1"></i> มีผลถึง <?= thai_date($item['expiry_date']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <h4 class="fw-bold text-navy mb-2">
                                    <a href="<?= url('announcements/' . $item['slug']) ?>" class="text-navy text-decoration-none hover-primary">
                                        <?= e($item['title']) ?>
                                    </a>
                                </h4>

                                <p class="text-muted small mb-3 line-clamp-2">
                                    <?= e($item['summary'] ?? strip_tags($item['content'])) ?>
                                </p>

                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <a href="<?= url('announcements/' . $item['slug']) ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                        อ่านประกาศฉบับเต็ม <i class="bi bi-arrow-right ms-1"></i>
                                    </a>

                                    <?php if (!empty($item['attachment_path'])): ?>
                                        <a href="<?= asset('storage/' . $item['attachment_path']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                            <i class="bi bi-paperclip me-1"></i> เอกสารแนบ (PDF)
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
