<?php
$newsList = $newsList ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="bi bi-newspaper me-2 text-primary"></i> จัดการข่าวสารและกิจกรรม</h3>
        <p class="text-muted small mb-0">รายการข่าวสาร ประกาศ และบทความประชาสัมพันธ์ทั้งหมด</p>
    </div>
    <a href="<?= url('admin/news/create') ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> เพิ่มข่าวสารใหม่
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive p-3">
            <table class="table table-hover coop-datatable align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>หัวข้อข่าว</th>
                        <th>หมวดหมู่</th>
                        <th>สถานะ Workflow</th>
                        <th>ผู้เขียน</th>
                        <th>วันที่เผยแพร่</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newsList as $i => $item): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <div class="fw-bold text-navy"><?= e($item['title']) ?></div>
                                <div class="small text-muted">
                                    <?php if ($item['is_pinned']): ?>
                                        <span class="badge bg-warning text-dark me-1"><i class="bi bi-pin-fill"></i> ปักหมุด</span>
                                    <?php endif; ?>
                                    <?php if ($item['is_featured']): ?>
                                        <span class="badge bg-primary me-1">ข่าวเด่น</span>
                                    <?php endif; ?>
                                    <span><i class="bi bi-eye"></i> <?= number_format($item['views_count']) ?> วิว</span>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-navy border"><?= e($item['category_name']) ?></span></td>
                            <td>
                                <span class="badge badge-workflow-<?= e($item['workflow_status']) ?>">
                                    <?= e(strtoupper($item['workflow_status'])) ?>
                                </span>
                            </td>
                            <td class="small"><?= e($item['author_name'] ?? 'Admin') ?></td>
                            <td class="small text-muted"><?= thai_date($item['publish_at']) ?></td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= url('news/' . $item['slug']) ?>" target="_blank" class="btn btn-outline-secondary" title="ดูหน้าเว็บ">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= url('admin/news/' . $item['id'] . '/edit') ?>" class="btn btn-outline-primary" title="แก้ไข">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" title="ลบ" onclick="deleteNews(<?= $item['id'] ?>)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function deleteNews(id) {
    showDeleteConfirm(() => {
        fetch(window.APP_URL + '/admin/news/' + id + '/delete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'ลบข่าวสารเรียบร้อยแล้ว');
                setTimeout(() => location.reload(), 800);
            } else {
                showError('เกิดข้อผิดพลาด', data.message);
            }
        });
    });
}
</script>
