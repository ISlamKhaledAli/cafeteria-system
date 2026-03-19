<?php
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Cafeteria System</title>
     <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
     <link rel="stylesheet" href="assets/css/auth.css">
    <style>
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
     <div class="auth-brand">
        <div class="brand-content">
            <div class="brand-logo"><i class="bi bi-cup-hot-fill"></i></div>
            <h1>Join The Cafeteria</h1>
            <p>Start ordering your favorite meals and snacks effortlessly. Create an account to track your orders and enjoy a personalized experience.</p>
        </div>
    </div>

     <div class="auth-form-area py-5">
        <div class="auth-box">
            <div class="auth-header">
                <h2>Create Account</h2>
                <p>Join us today! It only takes a minute.</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert-premium">
                    <i class="bi bi-exclamation-circle-fill fs-5"></i>
                    <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form action="index.php?page=register" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control" id="floatingName" placeholder="John Doe" required>
                    <label for="floatingName">Full Name</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="name@example.com" required>
                    <label for="floatingEmail">Email Address</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-7">
                        <div class="form-floating">
                            <select name="room_no" class="form-select" id="floatingRoom">
                                <option value="Application1">Room 1</option>
                                <option value="Application2">Room 2</option>
                                <option value="Cloud">Cloud Room</option>
                            </select>
                            <label for="floatingRoom">Room No</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-floating">
                            <input type="text" name="ext" class="form-control" id="floatingExt" placeholder="01012345678">
                            <label for="floatingExt">Phone</label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold mb-2">Profile Picture</label>
                    <input type="file" name="image" class="form-control rounded-4 py-2" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary-auth mb-4">Get Started Free</button>

                <p class="text-center text-muted small mb-0">
                    Already have an account? 
                    <a href="index.php?page=login" class="text-orange text-decoration-none fw-bold">Sign In Instead</a>
                </p>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/auth.js"></script>
</body>
</html>