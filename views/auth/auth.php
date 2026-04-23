<?php
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Access - Cafeteria</title>
     <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
     <style>
        :root {
            --primary: #F59E0B;
            --hover: #D97706;
            --primary-glow: rgba(245, 158, 11, 0.4);
            --bg-dark: #070B14;
            --glass: rgba(255, 255, 255, 0.04);
            --glass-border: rgba(255, 255, 255, 0.08);
            --text: #F9FAFB;
            --text-muted: #9CA3AF;
            --shadow-premium: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            --ease: cubic-bezier(0.4, 0, 0.2, 1);
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--text);
            background: var(--bg-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, #111827 0%, #070B14 100%);
            animation: slowRotate 30s linear infinite;
            z-index: -1;
        }

        @keyframes slowRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .auth-container {
            width: 100%;
            max-width: 460px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .auth-card {
            width: 100%;
            background: var(--glass);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 36px;
            padding: 56px 48px;
            box-shadow: var(--shadow-premium);
            position: relative;
            overflow: hidden;
            transition: transform 0.4s var(--ease), box-shadow 0.4s var(--ease);
        }

        .auth-card:hover {
            transform: translateY(-5px) scale(1.005);
            box-shadow: 0 40px 60px -15px rgba(0, 0, 0, 0.7);
        }

        .forms-wrapper {
            display: flex;
            width: 200%;
            transition: transform 0.6s cubic-bezier(0.645, 0.045, 0.355, 1);
        }

        .auth-form {
            width: 50%;
            transition: opacity 0.4s var(--ease), transform 0.4s var(--ease);
        }

        .auth-card.register-active .forms-wrapper {
            transform: translateX(-50%);
        }

        .auth-card.register-active .login-form { opacity: 0; transform: scale(0.96); pointer-events: none; }
        .auth-card:not(.register-active) .register-form { opacity: 0; transform: scale(0.96); pointer-events: none; }

        .header-section h2 {
            font-size: 2.25rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: -1.5px;
            background: linear-gradient(to right, #fff, #9CA3AF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header-section p {
            font-size: 1rem;
            color: var(--text-muted);
            margin: 8px 0 40px;
        }

        .input-holder {
            position: relative;
            margin-bottom: 24px;
        }

        .icon-box {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.3);
            font-size: 1.1rem;
            transition: var(--ease) 0.3s;
            pointer-events: none;
            z-index: 5;
        }

        .premium-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 20px 20px 20px 54px;
            color: #fff;
            font-size: 1rem;
            font-weight: 500;
            transition: var(--ease) 0.4s;
            outline: none;
            box-sizing: border-box;
        }

        .premium-input::placeholder { color: transparent; }

        .premium-input:focus {
            background: rgba(255, 255, 255, 0.06);
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-glow), inset 0 2px 4px rgba(0,0,0,0.3);
        }

        .premium-input:focus ~ .icon-box {
            color: var(--primary);
            transform: translateY(-50%) scale(1.1);
        }

        .input-holder label {
            position: absolute;
            left: 54px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-weight: 500;
            pointer-events: none;
            transition: var(--ease) 0.3s;
            z-index: 1;
        }

        .premium-input:focus ~ label,
        .premium-input:not(:placeholder-shown) ~ label {
            top: 0;
            left: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary);
            background: var(--bg-dark);
            padding: 0 8px;
            border-radius: 4px;
        }

        .btn-premium {
            width: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--hover) 100%);
            color: white;
            border: none;
            padding: 20px;
            border-radius: 18px;
            font-weight: 700;
            font-size: 1.05rem;
            cursor: pointer;
            transition: var(--ease) 0.3s;
            box-shadow: 0 10px 20px -5px var(--primary-glow);
            margin-top: 10px;
        }

        .btn-premium:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 30px -10px var(--primary-glow);
            filter: brightness(1.1);
        }

        .btn-premium:active { transform: scale(0.98); }

        /* Premium Upload Box */
        .premium-upload-holder {
            margin-bottom: 24px;
        }

        .premium-upload-btn {
            width: 100%;
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.03);
            border: 1px dashed rgba(255, 255, 255, 0.15);
            border-radius: 18px;
            padding: 18px 24px;
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--ease) 0.4s;
            gap: 15px;
            box-sizing: border-box;
        }

        .premium-upload-btn:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.1);
        }

        .premium-upload-btn i {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.3);
            transition: 0.3s;
        }

        .premium-upload-btn:hover i {
            color: var(--primary);
            transform: scale(1.1);
        }

        #fileNameDisplay {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .switch-box {
            text-align: center;
            margin-top: 32px;
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        .link-switch {
            color: var(--primary);
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
        }

        .link-switch:hover {
            filter: brightness(1.2);
            text-decoration: underline;
        }

        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: rgba(255, 255, 255, 0.3);
            font-size: 1.25rem;
            transition: 0.3s;
            z-index: 10;
        }

        .password-toggle:hover { color: #fff; }

        .error-bubble {
            background: rgba(239, 68, 68, 0.08);
            border-left: 4px solid #EF4444;
            padding: 16px;
            border-radius: 12px;
            color: #F87171;
            font-size: 0.9rem;
            margin-bottom: 32px;
            animation: slideDown 0.4s var(--ease);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 480px) {
            .auth-card { padding: 40px 24px; }
        }
    </style>
</head>
<body>

    <div class="auth-container">
         <div class="auth-card <?= isset($_SESSION['show_register']) ? 'register-active' : '' ?>">
            
            <div class="forms-wrapper">
                
                 <div class="auth-form login-form">
                    <div class="header-section text-center">
                        <h2>Welcome</h2>
                        <p>Sign in to your account</p>
                    </div>

                    <?php if (isset($_SESSION['error']) && !isset($_SESSION['show_register'])): ?>
                        <div class="error-bubble">
                            <i class="bi bi-shield-lock-fill me-2"></i><?= htmlspecialchars($_SESSION['error']) ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <form action="index.php?page=login" method="POST" enctype="multipart/form-data">
                        <div class="input-holder">
                            <i class="bi bi-envelope icon-box"></i>
                            <input type="email" name="email" class="premium-input" placeholder=" " required>
                            <label>Email Address</label>
                        </div>

                        <div class="input-holder">
                            <i class="bi bi-shield-lock icon-box"></i>
                            <input type="password" name="password" class="premium-input" placeholder=" " required>
                            <label>Password</label>
                            <span class="password-toggle"><i class="bi bi-eye"></i></span>
                        </div>

                        <div class="text-end mb-4 px-2">
                            <a href="index.php?page=forget-password" class="small fw-bold opacity-75 text-decoration-none" style="color: var(--primary); transition: 0.3s;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Forgot Password?</a>
                        </div>

                        <button type="submit" class="btn-premium">Sign In</button>
                    </form>

                    <div class="switch-box">
                        Need an account? <span class="link-switch" data-target="register">Join Us</span>
                    </div>
                </div>

                 <div class="auth-form register-form">
                    <div class="header-section text-center">
                        <h2>Join Us</h2>
                        <p>Quick set up for ordering</p>
                    </div>

                    <?php if (isset($_SESSION['error']) && isset($_SESSION['show_register'])): ?>
                        <div class="error-bubble">
                            <i class="bi bi-exclamation-circle-fill me-2"></i><?= htmlspecialchars($_SESSION['error']) ?>
                        </div>
                        <?php unset($_SESSION['error'], $_SESSION['show_register']); ?>
                    <?php endif; ?>

                    <form action="index.php?page=register" method="POST" enctype="multipart/form-data">
                        <div class="input-holder">
                            <i class="bi bi-person icon-box"></i>
                            <input type="text" name="name" class="premium-input" placeholder=" " required>
                            <label>Full Name</label>
                        </div>

                        <div class="input-holder">
                            <i class="bi bi-envelope icon-box"></i>
                            <input type="email" name="email" class="premium-input" placeholder=" " required>
                            <label>Email Address</label>
                        </div>

                        <div class="input-holder">
                            <i class="bi bi-key icon-box"></i>
                            <input type="password" name="password" class="premium-input" placeholder=" " required>
                            <label>Password</label>
                            <span class="password-toggle"><i class="bi bi-eye"></i></span>
                        </div>

 
                        <div class="premium-upload-holder">
                            <input type="file" name="image" id="profileImage" accept="image/*" class="d-none" style="display:none;">
                            <label for="profileImage" class="premium-upload-btn">
                                <i class="bi bi-camera"></i>
                                <span id="fileNameDisplay">Upload Profile Picture (Optional)</span>
                            </label>
                        </div>

                        <button type="submit" class="btn-premium">Create Account</button>
                    </form>

                    <div class="switch-box">
                        Already with us? <span class="link-switch" data-target="login">Sign In</span>
                    </div>
                </div>

            </div>
        </div>
     </div>

     <script>
        const PremiumAuth = {
            card: document.querySelector('.auth-card'),
            init() {
                this.bindEvents();
            },
            bindEvents() {
                document.querySelectorAll('.link-switch').forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const isToReg = link.dataset.target === 'register';
                        this.card.style.transform = 'scale(0.98)';
                        setTimeout(() => {
                            if (isToReg) {
                                this.card.classList.add('register-active');
                            } else {
                                this.card.classList.remove('register-active');
                            }
                            this.card.style.transform = 'scale(1)';
                        }, 150);
                    });
                });

                document.querySelectorAll('.password-toggle').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const input = btn.parentElement.querySelector('input');
                        const isPass = input.type === 'password';
                        input.type = isPass ? 'text' : 'password';
                        const icon = btn.querySelector('i');
                        icon.classList.toggle('bi-eye');
                        icon.classList.toggle('bi-eye-slash');
                        icon.style.transform = 'scale(1.2)';
                        setTimeout(() => icon.style.transform = 'scale(1)', 200);
                    });
                });

                document.querySelectorAll('.premium-input').forEach(input => {
                    input.addEventListener('focus', () => {
                        input.closest('.input-holder').classList.add('focused');
                    });
                    input.addEventListener('blur', () => {
                        input.closest('.input-holder').classList.remove('focused');
                    });
                });

                document.querySelectorAll('form').forEach(form => {
                    form.addEventListener('submit', (e) => {
                        const btn = form.querySelector('.btn-premium');
                        const inputs = form.querySelectorAll('[required]');
                        let valid = true;
                        inputs.forEach(input => {
                            if (!input.value.trim()) {
                                valid = false;
                                input.style.borderColor = '#EF4444';
                                setTimeout(() => input.style.borderColor = '', 1000);
                            }
                        });
                        if (!valid) e.preventDefault();
                    });
                });
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            PremiumAuth.init();
            
             document.getElementById('profileImage')?.addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || "Upload Profile Picture (Optional)";
                document.getElementById('fileNameDisplay').textContent = fileName;
            });
        });
    </script>
</body>
</html>
