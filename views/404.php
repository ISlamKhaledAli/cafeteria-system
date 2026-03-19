<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5 text-center mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mb-4">
                <i class="fas fa-exclamation-triangle text-warning display-1 opacity-25"></i>
            </div>
            <h1 class="display-4 fw-bold text-dark mb-3">404</h1>
            <h2 class="h4 text-muted mb-4">Oops! The page you're looking for was not found.</h2>
            <p class="text-muted mb-5">It might have been removed, renamed, or did not exist in the first place.</p>
            <a href="index.php?page=home" class="btn btn-warning rounded-pill px-5 fw-bold shadow-sm">
                Back to Safety <i class="fas fa-home ms-2"></i>
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
