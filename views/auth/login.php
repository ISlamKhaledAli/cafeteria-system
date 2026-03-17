<?php require_once __DIR__."/../../layouts/header.php"; ?>

<div class="container mt-5" style="max-width: 400px;">
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <h3 class="text-center mb-4" style="color: #d97706;">Login</h3>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger shadow-sm border-0" style="border-radius: 8px;">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= $_SESSION['error'] ?>
                </div>
            <?php unset($_SESSION['error']); endif; ?>

            <form method="POST" action="/PHP/cafeteria-system/login">
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button class="btn w-100 text-white" style="background-color: #d97706; border-radius: 8px;">
                    Login
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="/PHP/cafeteria-system/register" class="text-decoration-none text-muted">Create Account</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__."/../../layouts/footer.php"; ?>