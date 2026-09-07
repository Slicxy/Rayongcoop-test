<div class="py-5 bg-navy text-white">
    <div class="container-xl">
        <span class="badge bg-gold text-white mb-2 px-3 py-1"><i class="bi bi-calendar-event me-1"></i> ปฏิทินและกำหนดการ</span>
        <h1 class="text-white fw-bold display-6 mb-2">ปฏิทินกิจกรรมสหกรณ์</h1>
        <p class="text-light-blue lead mb-0">กำหนดการประชุมใหญ่ รอบการยื่นกู้ การจ่ายเงินปันผล และวันหยุดทำการของสหกรณ์</p>
    </div>
</div>

<div class="container-xl py-5">
    <!-- Filter Tabs -->
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="<?= url('calendar') ?>" class="btn btn-sm rounded-pill <?= empty($selectedCategory) ? 'btn-primary' : 'btn-outline-secondary' ?>">
            ทั้งหมด
        </a>
        <a href="<?= url('calendar?cat=meeting') ?>" class="btn btn-sm rounded-pill <?= ($selectedCategory === 'meeting') ? 'btn-primary' : 'btn-outline-secondary' ?>">
            <i class="bi bi-people me-1"></i> ประชุมใหญ่ / สรรหา
        </a>
        <a href="<?= url('calendar?cat=loan_window') ?>" class="btn btn-sm rounded-pill <?= ($selectedCategory === 'loan_window') ? 'btn-primary' : 'btn-outline-secondary' ?>">
            <i class="bi bi-cash-stack me-1"></i> รอบยื่นกู้เงิน
        </a>
        <a href="<?= url('calendar?cat=dividend') ?>" class="btn btn-sm rounded-pill <?= ($selectedCategory === 'dividend') ? 'btn-primary' : 'btn-outline-secondary' ?>">
            <i class="bi bi-award me-1"></i> จ่ายเงินปันผล
        </a>
        <a href="<?= url('calendar?cat=holiday') ?>" class="btn btn-sm rounded-pill <?= ($selectedCategory === 'holiday') ? 'btn-primary' : 'btn-outline-secondary' ?>">
            <i class="bi bi-door-closed me-1"></i> วันหยุดทำการ
        </a>
        <a href="<?= url('calendar?cat=activity') ?>" class="btn btn-sm rounded-pill <?= ($selectedCategory === 'activity') ? 'btn-primary' : 'btn-outline-secondary' ?>">
            <i class="bi bi-stars me-1"></i> กิจกรรมทั่วไป
        </a>
    </div>

    <div class="row g-4">
        <!-- Events Timeline List -->
        <div class="col-lg-8">
            <?php if (empty($events)): ?>
                <div class="coop-card p-5 text-center text-muted">
                    <i class="bi bi-calendar-x fs-1 d-block mb-3 text-secondary"></i>
                    <h5>ไม่พบกิจกรรมหรือกำหนดการในช่วงเวลาที่เลือก</h5>
                    <p class="small mb-0">สามารถเลือกดูหมวดหมู่อื่น หรือติดตามข่าวสารประชาสัมพันธ์เพิ่มเติม</p>
                </div>
            <?php else: ?>
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($events as $ev): ?>
                        <?php
                            $catBadge = match($ev['category']) {
                                'meeting' => ['class' => 'bg-purple text-white', 'icon' => 'bi-people-fill', 'label' => 'ประชุมใหญ่/สรรหา'],
                                'loan_window' => ['class' => 'bg-success text-white', 'icon' => 'bi-cash-coin', 'label' => 'รอบยื่นกู้เงิน'],
                                'dividend' => ['class' => 'bg-warning text-dark', 'icon' => 'bi-award-fill', 'label' => 'จ่ายเงินปันผล'],
                                'holiday' => ['class' => 'bg-danger text-white', 'icon' => 'bi-door-closed-fill', 'label' => 'วันหยุดทำการ'],
                                default => ['class' => 'bg-primary text-white', 'icon' => 'bi-star-fill', 'label' => 'กิจกรรมสหกรณ์'],
                            };
                            $isPast = strtotime($ev['end_date'] ?: $ev['start_date']) < strtotime(date('Y-m-d'));
                        ?>
                        <div class="coop-card p-4 transition-all <?= $isPast ? 'opacity-75' : '' ?> <?= $ev['is_featured'] ? 'border-primary border-2' : '' ?>">
                            <div class="d-flex flex-column flex-md-row gap-4 align-items-start">
                                <!-- Date Badge Box -->
                                <div class="text-center p-3 rounded-4 bg-light border flex-shrink-0" style="min-width: 100px;">
                                    <div class="text-danger fw-bold fs-4 lh-1"><?= date('d', strtotime($ev['start_date'])) ?></div>
                                    <div class="small fw-semibold text-navy"><?= thai_month_short(date('m', strtotime($ev['start_date']))) ?></div>
                                    <div class="text-muted" style="font-size: 0.75rem;"><?= (int)date('Y', strtotime($ev['start_date'])) + 543 ?></div>
                                </div>

                                <!-- Event Details -->
                                <div class="flex-grow-1">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <span class="badge <?= $catBadge['class'] ?>">
                                            <i class="bi <?= $catBadge['icon'] ?> me-1"></i> <?= $catBadge['label'] ?>
                                        </span>

                                        <?php if ($ev['is_featured']): ?>
                                            <span class="badge bg-gold text-white"><i class="bi bi-pin-angle-fill me-1"></i> กิจกรรมสำคัญ</span>
                                        <?php endif; ?>

                                        <?php if ($isPast): ?>
                                            <span class="badge bg-secondary">เสร็จสิ้นแล้ว</span>
                                        <?php endif; ?>
                                    </div>

                                    <h4 class="fw-bold text-navy mb-2"><?= e($ev['title']) ?></h4>

                                    <?php if (!empty($ev['description'])): ?>
                                        <p class="text-muted small mb-3"><?= nl2br(e($ev['description'])) ?></p>
                                    <?php endif; ?>

                                    <div class="d-flex flex-wrap gap-3 text-muted small">
                                        <?php if (!empty($ev['start_time'])): ?>
                                            <div>
                                                <i class="bi bi-clock me-1 text-primary"></i> 
                                                <?= date('H:i', strtotime($ev['start_time'])) ?> <?= !empty($ev['end_time']) ? '- ' . date('H:i น.', strtotime($ev['end_time'])) : 'น.' ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($ev['location'])): ?>
                                            <div>
                                                <i class="bi bi-geo-alt me-1 text-danger"></i> <?= e($ev['location']) ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($ev['end_date']) && $ev['end_date'] !== $ev['start_date']): ?>
                                            <div>
                                                <i class="bi bi-calendar-range me-1 text-info"></i> ถึง <?= thai_date($ev['end_date']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (!empty($ev['related_link'])): ?>
                                        <div class="mt-3">
                                            <a href="<?= e($ev['related_link']) ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                                                ดูรายละเอียดเพิ่มเติม <i class="bi bi-box-arrow-up-right ms-1"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar Right Column -->
        <div class="col-lg-4">
            <!-- Upcoming Highlights -->
            <div class="coop-card p-4 mb-4">
                <h5 class="fw-bold text-navy mb-3"><i class="bi bi-bell-fill text-warning me-2"></i> กำหนดการเร็วๆ นี้</h5>
                <?php if (empty($upcoming)): ?>
                    <p class="text-muted small mb-0">ไม่มีกำหนดการที่กำลังจะมาถึง</p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($upcoming as $up): ?>
                            <div class="d-flex gap-3 align-items-start border-bottom pb-2">
                                <div class="badge bg-light text-navy border text-center p-2 rounded-3 flex-shrink-0" style="min-width: 55px;">
                                    <div class="fw-bold fs-6 lh-1"><?= date('d', strtotime($up['start_date'])) ?></div>
                                    <div style="font-size: 0.7rem;"><?= thai_month_short(date('m', strtotime($up['start_date']))) ?></div>
                                </div>
                                <div>
                                    <div class="fw-bold text-navy small mb-1"><?= e($up['title']) ?></div>
                                    <small class="text-muted d-block"><?= e($up['location'] ?? 'สำนักงานสหกรณ์') ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Operating Hours Box -->
            <div class="coop-card p-4 bg-light border-0">
                <h6 class="fw-bold text-navy mb-2"><i class="bi bi-clock-history text-primary me-2"></i> เวลาทำการสหกรณ์</h6>
                <p class="small text-muted mb-2"><?= e(config('app.coop.office_hours')) ?></p>
                <small class="text-danger d-block"><i class="bi bi-info-circle me-1"></i> ปิดทำการในวันเสาร์-อาทิตย์ และวันหยุดนักขัตฤกษ์</small>
            </div>
        </div>
    </div>
</div>
