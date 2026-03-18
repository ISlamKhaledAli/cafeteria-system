<?php require_once __DIR__."/../../layouts/header.php"; ?>

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <h3 class="text-center mb-4" style="color: #d97706;">Register</h3>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger shadow-sm border-0" style="border-radius: 8px;">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= $_SESSION['error'] ?>
                </div>
            <?php unset($_SESSION['error']); endif; ?>

            <form method="POST" action="/PHP/cafeteria-system/register" enctype="multipart/form-data">
                <div class="mb-3">
                    <input name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required minlength="6">
                </div>
                <div class="mb-3">
                    <input name="room_no" class="form-control" placeholder="Room Number">
                </div>
                <div class="mb-3">
                    <input name="ext" class="form-control" placeholder="Extension">
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Profile Image (Optional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <button class="btn w-100 text-white" style="background-color: #d97706; border-radius: 8px;">
                    Register
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="/PHP/cafeteria-system/login" class="text-decoration-none text-muted">Already have an account? Login</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__."/../../layouts/footer.php"; ?>