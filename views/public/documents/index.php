<div class="py-5 bg-navy text-white">
    <div class="container">
        <span class="badge bg-gold text-white mb-2 px-3 py-1">ศูนย์บริการเอกสารดิจิทัล</span>
        <h1 class="text-white fw-bold display-6 mb-2">ศูนย์ดาวน์โหลดเอกสารและระเบียบ</h1>
        <p class="text-light-blue lead mb-0">ค้นหาและดาวน์โหลดแบบฟอร์มคำขอ ระเบียบ ข้อบังคับ และรายงานประจำปีของสหกรณ์</p>
    </div>
</div>

<div class="container-xl py-5">
    <?php if ($success = flash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> <?= e($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($error = flash('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= e($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Filter & Search Bar -->
    <div class="coop-card p-4 mb-4">
        <form action="<?= url('documents') ?>" method="GET" class="row g-3">
            <div class="col-md-5">
                <label class="form-label fw-bold small">ค้นหาชื่อเอกสาร / เลขที่เอกสาร</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control" placeholder="พิมพ์คำค้นหา..." value="<?= e($keyword ?? '') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold small">หมวดหมู่เอกสาร</label>
                <select name="cat" class="form-select">
                    <option value="">-- แสดงทุกหมวดหมู่ --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= e($cat['slug']) ?>" <?= ($selectedCategory === $cat['slug']) ? 'selected' : '' ?>>
                            <?= e($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter me-1"></i> กรองข้อมูล
                </button>
                <a href="<?= url('documents') ?>" class="btn btn-outline-secondary">
                    รีเซ็ต
                </a>
            </div>
        </form>
    </div>

    <!-- Category Tabs -->
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="<?= url('documents') ?>" class="btn btn-sm rounded-pill <?= empty($selectedCategory) ? 'btn-primary' : 'btn-outline-secondary' ?>">
            ทั้งหมด
        </a>
        <?php foreach ($categories as $cat): ?>
            <a href="<?= url('documents?cat=' . $cat['slug']) ?>" class="btn btn-sm rounded-pill <?= ($selectedCategory === $cat['slug']) ? 'btn-primary' : 'btn-outline-secondary' ?>">
                <?= e($cat['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Documents List -->
    <div class="row">
        <div class="col-12">
            <?php if (!empty($documents)): ?>
                <?php foreach ($documents as $doc): ?>
                    <div class="doc-row">
                        <div class="d-flex align-items-center me-3">
                            <i class="bi bi-file-earmark-pdf-fill doc-icon"></i>
                            <div>
                                <h6 class="fw-bold text-navy mb-1"><?= e($doc['title']) ?></h6>
                                <div class="d-flex flex-wrap gap-2 text-muted small">
                                    <span class="badge bg-light text-navy border"><?= e($doc['category_name']) ?></span>
                                    <?php if (!empty($doc['document_number'])): ?>
                                        <span><i class="bi bi-tag me-1"></i> <?= e($doc['document_number']) ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($doc['year'])): ?>
                                        <span><i class="bi bi-calendar me-1"></i> ประจำปี <?= e($doc['year']) ?></span>
                                    <?php endif; ?>
                                    <span><i class="bi bi-download me-1"></i> ดาวน์โหลดแล้ว <?= number_format($doc['download_count']) ?> ครั้ง</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 flex-shrink-0">
                            <a href="<?= url('documents/' . $doc['id'] . '/download') ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i> ดูตัวอย่าง
                            </a>
                            <a href="<?= url('documents/' . $doc['id'] . '/download') ?>" download class="btn btn-sm btn-primary">
                                <i class="bi bi-download me-1"></i> ดาวน์โหลด
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="coop-card p-5 text-center text-muted">
                    <i class="bi bi-folder-x fs-1 text-secondary mb-3 d-block"></i>
                    <h5>ไม่พบเอกสารตามเงื่อนไขที่ค้นหา</h5>
                    <p class="small mb-0">กรุณาลองเปลี่ยนคำค้นหา หรือเลือกหมวดหมู่อื่น</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
