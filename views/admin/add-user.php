<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container py-5" style="max-width: 800px;">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark mb-1">Add New User</h2>
            <p class="text-muted mb-0 small">Create a new account for staff or students.</p>
        </div>
        <a href="/PHP/cafeteria-system/admin/users" class="text-decoration-none fw-semibold" style="color: #d97706;">
            <i class="fas fa-arrow-left me-1"></i> Back to list
        </a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger shadow-sm border-0" style="border-radius: 8px;">
            <i class="fas fa-exclamation-circle me-2"></i> <?= $_SESSION['error'] ?>
        </div>
    <?php unset($_SESSION['error']); endif; ?>
    <div class="card border-0 shadow-sm" style="border-radius: 16px; background-color: #ffffff;">
        <div class="card-body p-5">
            <form action="/PHP/cafeteria-system/admin/add-user" method="POST" enctype="multipart/form-data">
                
                <div class="text-center mb-5">
                    <div class="position-relative d-inline-block">
                        <label for="image" style="cursor: pointer;">
                            <div id="imagePreview" class="rounded-circle d-flex flex-column align-items-center justify-content-center text-muted" style="width: 110px; height: 110px; background-color: #f8f9fa; border: 2px dashed #cbd5e1;">
                                <i class="fas fa-user fs-3 mb-1" style="color: #94a3b8;"></i>
                                <span style="font-size: 0.65rem; font-weight: bold; letter-spacing: 1px; color: #94a3b8;">PREVIEW</span>
                            </div>
                            <div class="position-absolute rounded-circle d-flex align-items-center justify-content-center border border-2 border-white" style="width: 32px; height: 32px; bottom: 0; right: 0; background-color: #d97706; color: white;">
                                <i class="fas fa-camera" style="font-size: 0.8rem;"></i>
                            </div>
                        </label>
                        <input type="file" id="image" name="image" class="d-none" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <div class="mt-3">
                        <h6 class="mb-0 fw-semibold text-dark" style="font-size: 0.9rem;">Profile Picture</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">JPG, PNG or GIF (Max 2MB)</small>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-dark fw-semibold small">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted ps-3"><i class="fas fa-id-badge"></i></span>
                        <input type="text" class="form-control bg-light border-0 py-2" name="name" placeholder="John Doe" required style="border-radius: 0 8px 8px 0;">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-dark fw-semibold small">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted ps-3"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control bg-light border-0 py-2" name="email" placeholder="john.doe@company.com" required style="border-radius: 0 8px 8px 0;">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-semibold small">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted ps-3"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control bg-light border-0 py-2" name="password" placeholder="••••••••" required style="border-radius: 0 8px 8px 0;">
                        </div>
                    </div>
                    <div class="col-md-6 mt-4 mt-md-0">
                        <label class="form-label text-dark fw-semibold small">Role</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted ps-3"><i class="fas fa-user-shield"></i></span>
                            <select class="form-select bg-light border-0 py-2" name="role" style="border-radius: 0 8px 8px 0;">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-semibold small">Room Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted ps-3"><i class="fas fa-door-closed"></i></span>
                            <input type="text" class="form-control bg-light border-0 py-2" name="room" placeholder="e.g. 402" required style="border-radius: 0 8px 8px 0;">
                        </div>
                    </div>
                    <div class="col-md-6 mt-4 mt-md-0">
                        <label class="form-label text-dark fw-semibold small">Extension</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted ps-3"><i class="fas fa-phone-alt"></i></span>
                            <input type="text" class="form-control bg-light border-0 py-2" name="ext" placeholder="e.g. 8812" required style="border-radius: 0 8px 8px 0;">
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 pt-3 border-top border-light">
                    <a href="/PHP/cafeteria-system/admin/users" class="btn btn-light flex-grow-1 py-2 fw-semibold text-dark" style="border-radius: 8px; border: 1px solid #e2e8f0;">Cancel</a>
                    <button type="submit" class="btn text-white flex-grow-1 py-2 fw-semibold shadow-sm" style="background-color: #d97706; border-radius: 8px;">
                        <i class="fas fa-user-plus me-2"></i> Save User
                    </button>
                </div>
                
                <div class="text-center mt-4">
                    <small class="text-muted">User will receive an email invitation to set up their profile after creation.</small>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="/PHP/cafeteria-system/assets/js/user-form.js"></script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>