<?php $request = $request ?? request(); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? config('app.name')) ?> — สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</title>
    <meta name="description" content="<?= e($metaDescription ?? 'สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด บริการเงินฝาก สินเชื่อ สวัสดิการ มั่นคง โปร่งใส ทันสมัย เพื่อสมาชิก') ?>">
    <link rel="canonical" href="<?= url($request->uri()) ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= e($title ?? config('app.name')) ?>">
    <meta property="og:description" content="<?= e($metaDescription ?? 'สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด บริการเงินฝาก สินเชื่อ สวัสดิการ มั่นคง โปร่งใส ทันสมัย เพื่อสมาชิก') ?>">
    <meta property="og:url" content="<?= url($request->uri()) ?>">
    <meta property="og:image" content="<?= asset('images/og-rayongcoop.png') ?>">
    <meta name="twitter:card" content="summary_large_image">

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FinancialService",
      "name": "สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด",
      "alternateName": "Rayong Public Health Cooperative",
      "url": "<?= url('/') ?>",
      "logo": "<?= asset('images/logo.png') ?>",
      "telephone": "+66-38-611-123",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "สำนักงานสาธารณสุขจังหวัดระยอง",
        "addressLocality": "เมืองระยอง",
        "addressRegion": "ระยอง",
        "postalCode": "21000",
        "addressCountry": "TH"
      },
      "openingHours": "Mo-Fr 08:30-16:30"
    }
    </script>

    <!-- Google Fonts: Prompt (Modern Thai Corporate) & Inter (Financial Numerics) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Prompt:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.min.css">
    
    <!-- Custom Theme CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>?v=1.1.0">

    <script>
        window.APP_URL = "<?= url('/') ?>";
        window.CSRF_TOKEN = "<?= csrf_token() ?>";
    </script>
</head>
<body>
    <!-- Skip to main content link for accessibility -->
    <a href="#mainContent" class="skip-link">ข้ามไปยังเนื้อหาหลัก (Skip to Content)</a>

    <!-- 1. Top Announcement Bar -->
    <?php include dirname(__DIR__) . '/partials/announcement_bar.php'; ?>

    <!-- 2. Main Header & Navigation -->
    <?php include dirname(__DIR__) . '/partials/header.php'; ?>

    <!-- 3. Main Dynamic Content -->
    <main id="mainContent">
        <?= $content ?? '' ?>
    </main>

    <!-- 4. Footer -->
    <?php include dirname(__DIR__) . '/partials/footer.php'; ?>

    <!-- 5. Cookie Consent Banner & Modal -->
    <?php include dirname(__DIR__) . '/partials/cookie_banner.php'; ?>
    <?php include dirname(__DIR__) . '/partials/cookie_modal.php'; ?>

    <!-- 6. Campaign Popup Modal -->
    <?php include dirname(__DIR__) . '/partials/popup_modal.php'; ?>

    <!-- Core Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    
    <!-- App Config & Standard Scripts -->
    <script src="<?= asset('js/swal-config.js') ?>?v=1.0.0"></script>
    <script src="<?= asset('js/cookie-consent.js') ?>?v=1.0.0"></script>
    <script src="<?= asset('js/popup-manager.js') ?>?v=1.0.0"></script>
    <script src="<?= asset('js/loan-calculator.js') ?>?v=1.0.0"></script>
    <script src="<?= asset('js/main.js') ?>?v=1.0.0"></script>

    <?php if (!empty($flashSuccess)): ?>
        <script>document.addEventListener('DOMContentLoaded', () => showToast('success', <?= json_encode($flashSuccess) ?>));</script>
    <?php endif; ?>
    <?php if (!empty($flashError)): ?>
        <script>document.addEventListener('DOMContentLoaded', () => showError('แจ้งเตือน', <?= json_encode($flashError) ?>));</script>
    <?php endif; ?>
</body>
</html>
