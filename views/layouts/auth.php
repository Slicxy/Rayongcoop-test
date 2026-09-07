<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'เข้าสู่ระบบ') ?> — สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</title>
    
    <!-- Google Fonts: Prompt -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>?v=1.0.1">

    <style>
        :root {
            --coop-primary: #0066CC;
            --coop-navy: #073B74;
            --coop-navy-dark: #052A54;
            --coop-accent: #28A745;
            --coop-bg-gradient: linear-gradient(135deg, #073B74 0%, #0B5ED7 50%, #0066CC 100%);
        }

        body.auth-body {
            font-family: 'Prompt', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--coop-bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            margin: 0;
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle Geometric Background Shapes */
        .auth-bg-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            pointer-events: none;
        }
        .shape-1 { width: 500px; height: 500px; top: -150px; right: -100px; }
        .shape-2 { width: 400px; height: 400px; bottom: -120px; left: -100px; }

        .auth-card {
            background: #FFFFFF;
            border-radius: 18px;
            box-shadow: 0 20px 45px rgba(5, 42, 84, 0.25), 0 0 1px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 460px;
            overflow: hidden;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeInCard 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeInCard {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .auth-header {
            background: #FFFFFF;
            padding: 36px 32px 20px 32px;
            text-align: center;
        }

        .coop-logo-badge {
            width: 68px;
            height: 68px;
            margin: 0 auto 16px auto;
            border-radius: 16px;
            background: linear-gradient(135deg, #073B74 0%, #0066CC 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-size: 32px;
            box-shadow: 0 8px 20px rgba(0, 102, 204, 0.3);
            transition: transform 0.3s ease;
        }

        .coop-logo-badge:hover {
            transform: scale(1.05) rotate(2deg);
        }

        .auth-title {
            font-size: 24px;
            font-weight: 700;
            color: #073B74;
            margin-bottom: 4px;
            letter-spacing: -0.01em;
        }

        .auth-subtitle {
            font-size: 14px;
            color: #64748B;
            font-weight: 400;
            margin-bottom: 0;
        }

        .auth-body-content {
            padding: 10px 32px 36px 32px;
        }

        /* Form Controls */
        .form-label-custom {
            font-size: 14px;
            font-weight: 600;
            color: #1E293B;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: stretch;
            width: 100%;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .input-group-custom .input-icon-addon {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-right: none;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            color: #64748B;
            font-size: 17px;
            padding: 0 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .form-control-custom {
            border: 1px solid #E2E8F0;
            border-left: none;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            padding: 12px 16px;
            font-size: 15px;
            color: #0F172A;
            background: #F8FAFC;
            height: 48px;
            transition: all 0.2s ease;
            width: 100%;
        }

        .form-control-custom:focus {
            background: #FFFFFF;
            border-color: #0066CC;
            box-shadow: none;
            outline: none;
        }

        .input-group-custom:focus-within .input-icon-addon {
            background: #FFFFFF;
            border-color: #0066CC;
            color: #0066CC;
        }

        .input-group-custom:focus-within {
            box-shadow: 0 0 0 3.5px rgba(0, 102, 204, 0.12);
        }

        /* Toggle Password Button */
        .btn-toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #94A3B8;
            font-size: 18px;
            cursor: pointer;
            padding: 4px 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
            transition: color 0.2s ease;
        }

        .btn-toggle-password:hover {
            color: #0066CC;
        }

        /* Submit Button */
        .btn-auth-submit {
            background: linear-gradient(135deg, #073B74 0%, #0066CC 100%);
            color: #FFFFFF;
            border: none;
            border-radius: 10px;
            height: 50px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(0, 102, 204, 0.3);
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .btn-auth-submit:hover:not(:disabled) {
            background: linear-gradient(135deg, #052A54 0%, #0052A3 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
            color: #FFFFFF;
        }

        .btn-auth-submit:disabled {
            opacity: 0.75;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Test Accounts Card */
        .demo-account-box {
            background: #F1F5F9;
            border: 1px dashed #CBD5E1;
            border-radius: 10px;
            padding: 12px 14px;
            margin-top: 20px;
            font-size: 13px;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-autofill {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            background: #0066CC;
            color: #FFFFFF;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-autofill:hover {
            background: #073B74;
        }

        /* Alert Box */
        .auth-alert-box {
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            display: none;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            animation: shakeAlert 0.35s ease;
        }

        .auth-alert-box.show {
            display: flex;
        }

        .auth-alert-danger {
            background-color: #FEF2F2;
            border: 1px solid #F87171;
            color: #991B1B;
        }

        .auth-alert-success {
            background-color: #F0FDF4;
            border: 1px solid #86EFAC;
            color: #166534;
        }

        @keyframes shakeAlert {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }

        .auth-footer-link {
            text-align: center;
            margin-top: 24px;
            font-size: 13.5px;
        }

        .auth-footer-link a {
            color: #64748B;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .auth-footer-link a:hover {
            color: #0066CC;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .auth-header { padding: 28px 20px 16px 20px; }
            .auth-body-content { padding: 8px 20px 28px 20px; }
            .auth-title { font-size: 21px; }
            .coop-logo-badge { width: 58px; height: 58px; font-size: 26px; }
        }
    </style>
</head>
<body class="auth-body">

    <!-- Background Shapes -->
    <div class="auth-bg-shape shape-1"></div>
    <div class="auth-bg-shape shape-2"></div>

    <div class="auth-card">
        <!-- 1. Cooperative Branding Header -->
        <div class="auth-header">
            <div class="coop-logo-badge">
                <i class="bi bi-bank2"></i>
            </div>
            <h1 class="auth-title">เข้าสู่ระบบ</h1>
            <p class="auth-subtitle">ระบบบริหารจัดการสหกรณ์ออมทรัพย์</p>
        </div>

        <!-- 2. Login Form Body -->
        <div class="auth-body-content">
            <?= $content ?? '' ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
    <script src="<?= asset('js/swal-config.js') ?>?v=1.0.0"></script>

    <?php if (!empty($flashSuccess)): ?>
        <script>document.addEventListener('DOMContentLoaded', () => showToast('success', <?= json_encode($flashSuccess) ?>));</script>
    <?php endif; ?>
</body>
</html>
