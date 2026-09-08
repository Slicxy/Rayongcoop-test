<!-- Alert Container -->
<div id="loginAlertBox" class="auth-alert-box auth-alert-danger <?= !empty($flashError) ? 'show' : '' ?>" role="alert">
    <i class="bi bi-exclamation-circle-fill fs-5 flex-shrink-0"></i>
    <div id="loginAlertMessage"><?= e($flashError ?? 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง') ?></div>
</div>

<form action="<?= url('login') ?>" method="POST" id="coopLoginForm" novalidate>
    <?= csrf_field() ?>

    <!-- 1. Username Field -->
    <div class="mb-3">
        <label for="usernameInput" class="form-label-custom">
            <span>ชื่อผู้ใช้งาน / เลขที่สมาชิก (Username or Member No.)</span>
        </label>
        <div class="input-group-custom">
            <span class="input-icon-addon">
                <i class="bi bi-person"></i>
            </span>
            <input 
                type="text" 
                name="username" 
                id="usernameInput" 
                class="form-control form-control-custom" 
                placeholder="กรอกชื่อผู้ใช้ หรือเลขที่สมาชิก เช่น rayongcoop1 หรือ staff1" 
                value="<?= e(old('username', '')) ?>" 
                required 
                autofocus
                autocomplete="username"
            >
        </div>
    </div>

    <!-- 2. Password Field with Show/Hide Toggle -->
    <div class="mb-3">
        <label for="passwordInput" class="form-label-custom">
            <span>รหัสผ่าน (Password)</span>
        </label>
        <div class="input-group-custom">
            <span class="input-icon-addon">
                <i class="bi bi-lock"></i>
            </span>
            <input 
                type="password" 
                name="password" 
                id="passwordInput" 
                class="form-control form-control-custom pe-5" 
                placeholder="••••••" 
                required
                autocomplete="current-password"
            >
            <button type="button" class="btn-toggle-password" id="togglePasswordBtn" aria-label="แสดงหรือซ่อนรหัสผ่าน" tabindex="-1">
                <i class="bi bi-eye" id="passwordEyeIcon"></i>
            </button>
        </div>
    </div>

    <!-- 3. Remember Me & Forgot Password -->
    <div class="d-flex align-items-center justify-content-between mb-4 mt-2">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" value="1" id="rememberMe" style="cursor: pointer;">
            <label class="form-check-label small text-muted user-select-none" for="rememberMe" style="cursor: pointer;">
                จดจำการเข้าสู่ระบบ
            </label>
        </div>
        <a href="#" class="small text-decoration-none fw-medium text-primary" id="forgotPasswordLink">
            ลืมรหัสผ่าน?
        </a>
    </div>

    <!-- 4. Login Button with Loading State -->
    <button type="submit" class="btn-auth-submit" id="btnLogin">
        <span class="spinner-border spinner-border-sm d-none" id="loginSpinner" role="status" aria-hidden="true"></span>
        <span id="loginBtnText">
            <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบ
        </span>
    </button>

    <!-- 5. Test Account Helper Card (Local / Development Mode Only) -->
    <?php if (config('app.env') === 'local' || config('app.debug')): ?>
        <div class="demo-account-box">
            <div>
                <div class="fw-bold text-navy"><i class="bi bi-info-circle me-1 text-primary"></i> บัญชีทดสอบระบบ (Dev Mode):</div>
                <div class="font-monospace text-muted mt-1" style="font-size: 11px;">
                    สมาชิก: <span class="fw-bold text-dark">rayongcoop1</span> / <span class="fw-bold text-dark">coop1</span><br>
                    เจ้าหน้าที่: <span class="fw-bold text-dark">staff1</span> / <span class="fw-bold text-dark">staff123</span>
                </div>
            </div>
            <div class="d-flex flex-column gap-1">
                <button type="button" class="btn-autofill" id="btnAutofill" title="กรอกบัญชีสมาชิก">
                    สมาชิก
                </button>
                <button type="button" class="btn-autofill bg-secondary text-white" id="btnAutofillStaff" title="กรอกบัญชีเจ้าหน้าที่">
                    เจ้าหน้าที่
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- 6. Return Link -->
    <div class="auth-footer-link">
        <a href="<?= url('/') ?>">
            <i class="bi bi-arrow-left me-1"></i> กลับสู่หน้าหลักเว็บไซต์
        </a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('coopLoginForm');
    const usernameInput = document.getElementById('usernameInput');
    const passwordInput = document.getElementById('passwordInput');
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    const passwordEyeIcon = document.getElementById('passwordEyeIcon');
    const btnLogin = document.getElementById('btnLogin');
    const loginSpinner = document.getElementById('loginSpinner');
    const loginBtnText = document.getElementById('loginBtnText');
    const alertBox = document.getElementById('loginAlertBox');
    const alertMessage = document.getElementById('loginAlertMessage');
    const btnAutofill = document.getElementById('btnAutofill');
    const forgotPasswordLink = document.getElementById('forgotPasswordLink');

    // 1. Password Visibility Toggle
    if (togglePasswordBtn && passwordInput && passwordEyeIcon) {
        togglePasswordBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            passwordEyeIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    }

    // 2. Autofill Test Accounts
    if (btnAutofill) {
        btnAutofill.addEventListener('click', function() {
            usernameInput.value = 'rayongcoop1';
            passwordInput.value = 'coop1';
            hideAlert();
            passwordInput.focus();
        });
    }

    const btnAutofillStaff = document.getElementById('btnAutofillStaff');
    if (btnAutofillStaff) {
        btnAutofillStaff.addEventListener('click', function() {
            usernameInput.value = 'staff1';
            passwordInput.value = 'staff123';
            hideAlert();
            passwordInput.focus();
        });
    }

    // 3. Forgot password notification
    if (forgotPasswordLink) {
        forgotPasswordLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'info',
                    title: 'ลืมรหัสผ่าน',
                    text: 'กรุณาติดต่อผู้ดูแลระบบสหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด เพื่อขอรับการรีเซ็ตรหัสผ่าน',
                    confirmButtonText: 'ตกลง',
                    confirmButtonColor: '#0066CC'
                });
            } else {
                alert('กรุณาติดต่อผู้ดูแลระบบเพื่อขอรับการรีเซ็ตรหัสผ่าน');
            }
        });
    }

    function showAlert(msg, isSuccess = false) {
        alertMessage.textContent = msg;
        alertBox.className = 'auth-alert-box show ' + (isSuccess ? 'auth-alert-success' : 'auth-alert-danger');
    }

    function hideAlert() {
        alertBox.className = 'auth-alert-box';
    }

    function setLoading(isLoading) {
        if (isLoading) {
            btnLogin.disabled = true;
            loginSpinner.classList.remove('d-none');
            loginBtnText.innerHTML = 'กำลังเข้าสู่ระบบ...';
        } else {
            btnLogin.disabled = false;
            loginSpinner.classList.add('d-none');
            loginBtnText.innerHTML = '<i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบ';
        }
    }

    // 4. Form Submit Handler with AJAX + Validation
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const username = usernameInput.value.trim();
        const password = passwordInput.value;

        // Validation
        if (!username) {
            showAlert('กรุณากรอกชื่อผู้ใช้งาน');
            usernameInput.focus();
            return;
        }

        if (!password) {
            showAlert('กรุณากรอกรหัสผ่าน');
            passwordInput.focus();
            return;
        }

        hideAlert();
        setLoading(true);

        const formData = new FormData(loginForm);
        formData.append('ajax', '1');

        fetch(loginForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            let data = {};
            try {
                data = await response.json();
            } catch (err) {
                data = { success: false, message: 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง' };
            }
            return { ok: response.ok, status: response.status, data: data };
        })
        .then(({ ok, status, data }) => {
            if (ok && data && data.success) {
                showAlert('เข้าสู่ระบบสำเร็จ กำลังพาไปยัง Dashboard...', true);
                setTimeout(() => {
                    window.location.href = data.redirect || '<?= url('admin/dashboard') ?>';
                }, 400);
            } else {
                setLoading(false);
                const msg = (data && data.message) ? data.message : 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง';
                showAlert(msg, false);
                passwordInput.value = '';
                passwordInput.focus();
            }
        })
        .catch(error => {
            console.error('Login error:', error);
            setLoading(false);
            showAlert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง', false);
        });
    });

    // Support Enter on input fields
    [usernameInput, passwordInput].forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                loginForm.requestSubmit ? loginForm.requestSubmit() : loginForm.submit();
            }
        });
    });
});
</script>
