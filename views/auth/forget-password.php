<?php
require_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg p-5 text-center" style="border-radius: 24px; background-color: #ffffff;">
                <div class="mb-4">
                    <i class="fas fa-key text-warning display-4 opacity-75"></i>
                </div>
                <h3 class="fw-bold text-dark mb-2">Forgot Password?</h3>
                <p class="text-muted small mb-5">Enter your email and we'll send you a recovery link.</p>

                <form action="index.php?page=login" method="GET">
                    <input type="hidden" name="page" value="login">
                    <div class="mb-4 text-start">
                        <label class="form-label fw-semibold small text-muted text-uppercase" style="letter-spacing: 0.5px;">Email Address</label>
                        <div class="input-group shadow-sm" style="border-radius: 12px; overflow: hidden;">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" class="form-control border-start-0 ps-0 py-2" placeholder="john@example.com" required style="border-radius: 0;">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn text-white fw-bold shadow-sm w-100 py-3 mb-4 transition-all" 
                            style="background-color: #d97706; border-radius: 12px;">
                        Send Request
                    </button>
                    
                    <a href="index.php?page=login" class="text-decoration-none small fw-bold" style="color: #6b7280;">
                        <i class="fas fa-arrow-left me-1"></i> Back to Login
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-all { transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .transition-all:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(217, 119, 6, 0.2) !important; }
</style>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
