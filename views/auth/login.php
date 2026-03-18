<?php
/**
 * Login View - Premium Cafeteria Auth
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cafeteria System</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom Auth CSS - FIXED: Relative path with fallback -->
    <link rel="stylesheet" href="assets/css/auth.css">
    <style>
        /* CRITICAL LAYOUT FALLBACK - Premium Fix */
        .auth-wrapper { display: flex !important; height: 100vh !important; width: 100% !important; flex-direction: row !important; }
        .auth-brand { flex: 1.2; display: flex !important; align-items: center; justify-content: center; background: #111827; color: white; padding: 60px; }
        .auth-form-area { flex: 1; display: flex !important; align-items: center; justify-content: center; background: white; padding: 40px; }
        .brand-content { text-align: center; max-width: 440px; }
        .password-wrapper { position: relative !important; width: 100%; }
        .password-toggle { position: absolute !important; right: 15px !important; top: 50% !important; transform: translateY(-50%) !important; cursor: pointer; color: #6B7280; z-index: 10; font-size: 1.2rem; }
        .auth-box { width: 100%; max-width: 420px; }
        .btn-primary-auth { background-color: #F59E0B !important; color: white !important; border-radius: 12px !important; padding: 14px !important; width: 100% !important; border: none; font-weight: 600; }
        @media (max-width: 992px) { .auth-brand { display: none !important; } }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <!-- Left Side: Branding -->
    <div class="auth-brand">
        <div class="brand-content">
            <div class="brand-logo"><i class="bi bi-cup-hot-fill"></i></div>
            <h1>The Cafeteria</h1>
            <p>Access your favorite refreshments, meals, and snacks with a few clicks. Your modern dining experience starts here.</p>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="auth-form-area">
        <div class="auth-box">
            <div class="auth-header">
                <h2>Welcome Back</h2>
                <p>Enter your credentials to access your account.</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert-premium">
                    <i class="bi bi-exclamation-circle-fill fs-5"></i>
                    <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success border-0 rounded-4 py-3 mb-4" style="background-color: #ECFDF5; color: #065F46;">
                    <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <form action="index.php?page=login" method="POST" class="needs-validation" novalidate>
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="name@example.com" required>
                    <label for="floatingEmail">Email Address</label>
                </div>

                <div class="password-wrapper mb-4">
                    <div class="form-floating">
                        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <i class="bi bi-eye password-toggle"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label text-muted small" for="rememberMe">Remember me</label>
                    </div>
                    <a href="#" class="text-orange text-decoration-none small fw-bold">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary-auth mb-4">Log In to Account</button>

                <p class="text-center text-muted small mb-0">
                    Don't have an account? 
                    <a href="index.php?page=register" class="text-orange text-decoration-none fw-bold">Sign Up Free</a>
                </p>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/auth.js"></script>
</body>
</html>