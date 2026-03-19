<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Cafeteria</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card" style="max-width: 420px; padding: 40px 36px; display: block;">
            
            <div class="header-section text-center mb-4">
                <i class="bi bi-shield-lock text-warning" style="font-size: 3.5rem; color: var(--primary) !important;"></i>
                <h2 class="mt-3" style="font-size: 1.8rem;">Reset Password</h2>
                <p>Enter your email to receive a recovery link.</p>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="error-bubble" style="background: rgba(16, 185, 129, 0.1); border-left-color: #10B981; color: #34D399;">
                    <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <form action="index.php?page=forget-password" method="POST">
                <div class="input-holder">
                    <i class="bi bi-envelope icon-box"></i>
                    <input type="email" name="email" class="premium-input" placeholder=" " required>
                    <label>Registered Email Address</label>
                </div>

                <button type="submit" class="btn-premium mb-4">Send Recovery Link</button>

                <div class="switch-box mt-0">
                    Remembered your password? <a href="index.php?page=login" class="link-switch text-decoration-none">Sign In</a>
                </div>
            </form>

        </div>
    </div>
    
    <script src="assets/js/auth.js"></script>
</body>
</html>