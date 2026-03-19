<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container-fluid py-4 px-4" style="background-color: #fcfcfc; min-height: 100vh;">
    <div class="d-flex align-items-center mb-4 gap-3">
        <a href="index.php?page=admin-users" class="btn btn-light shadow-sm" style="border-radius: 8px;">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
        <h2 class="h4 fw-bold mb-0 text-dark">Edit User Account</h2>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 16px; max-width: 800px;">
        <div class="card-body p-4 p-md-5">
            <form action="index.php?page=admin-edit-user&id=<?= $user['id'] ?>" method="POST" enctype="multipart/form-data">
                
                 <div class="text-center mb-5">
                    <div class="position-relative d-inline-block">
                        <label for="image" style="cursor: pointer;">
                            <?php 
                                $imageName = !empty($user['image']) ? $user['image'] : 'default.png';
                                $imageURL = "uploads/users/" . $imageName;
                                if (!file_exists(BASE_PATH . '/' . $imageURL)) {
                                    $imageURL = "https://ui-avatars.com/api/?name=" . urlencode($user['name']) . "&background=F59E0B&color=fff&size=120";
                                } else {
                                    $imageURL = "/cafeteria-system-develop/uploads/users/" . $imageName;
                                }
                            ?>
                            <div id="imagePreview" class="rounded-circle d-flex flex-column align-items-center justify-content-center border border-2 shadow-sm" 
                                 style="width: 120px; height: 120px; background-image: url('<?= $imageURL ?>'); background-size: cover; background-position: center; border-color: #d97706 !important;">
                            </div>
                            <div class="position-absolute rounded-circle d-flex align-items-center justify-content-center border border-2 border-white shadow-sm" 
                                 style="width: 32px; height: 32px; bottom: 5px; right: 5px; background-color: #d97706; color: white;">
                                <i class="fas fa-camera" style="font-size: 0.8rem;"></i>
                            </div>
                        </label>
                        <input type="file" id="image" name="image" class="d-none" accept="image/*">
                    </div>
                    <div class="mt-3">
                        <h6 class="mb-0 fw-bold text-dark"><?= htmlspecialchars($user['name']) ?></h6>
                        <small class="text-muted">Click to change profile picture</small>
                    </div>
                </div>

                <div class="row g-4">
                     <div class="col-md-6">
                        <label class="form-label fw-semibold small text-muted text-uppercase mb-2" style="letter-spacing: 0.5px;">Full Name</label>
                        <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-user text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0 py-2" name="name" 
                                   value="<?= htmlspecialchars($user['name']) ?>" required style="border-radius: 0;">
                        </div>
                    </div>

                     <div class="col-md-6">
                        <label class="form-label fw-semibold small text-muted text-uppercase mb-2" style="letter-spacing: 0.5px;">Email Address</label>
                        <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" class="form-control border-start-0 ps-0 py-2" name="email" 
                                   value="<?= htmlspecialchars($user['email']) ?>" required style="border-radius: 0;">
                        </div>
                    </div>

                     <div class="col-md-6">
                        <label class="form-label fw-semibold small text-muted text-uppercase mb-2" style="letter-spacing: 0.5px;">New Password <span class="text-danger" style="text-transform: none; font-size: 0.65rem;">(Leave blank to keep current)</span></label>
                        <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" class="form-control border-start-0 ps-0 py-2" name="password" 
                                   placeholder="••••••••" style="border-radius: 0;">
                        </div>
                    </div>

                     <div class="col-md-6">
                        <label class="form-label fw-semibold small text-muted text-uppercase mb-2" style="letter-spacing: 0.5px;">Role</label>
                        <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-user-shield text-muted"></i></span>
                            <select class="form-select border-start-0 ps-0 py-2" name="role" style="border-radius: 0;">
                                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Standard User</option>
                                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrator</option>
                            </select>
                        </div>
                    </div>

                     <div class="col-md-6">
                        <label class="form-label fw-semibold small text-muted text-uppercase mb-2" style="letter-spacing: 0.5px;">Room Number</label>
                        <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-door-closed text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0 py-2" name="room_no" 
                                   value="<?= htmlspecialchars($user['room_no']) ?>" required style="border-radius: 0;">
                        </div>
                    </div>

                     <div class="col-md-6">
                        <label class="form-label fw-semibold small text-muted text-uppercase mb-2" style="letter-spacing: 0.5px;">Phone</label>
                        <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-phone-alt text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0 py-2" name="ext" 
                                   value="<?= htmlspecialchars($user['ext']) ?>" required style="border-radius: 0;">
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-5 pt-3 border-top border-light">
                    <button type="submit" class="btn text-white fw-bold shadow-sm px-5 py-2 flex-grow-1 flex-md-grow-0" 
                            style="background-color: #d97706; border-radius: 10px;">
                        <i class="fas fa-save me-2"></i> Update Changes
                    </button>
                    <a href="index.php?page=admin-users" class="btn btn-light fw-semibold shadow-sm px-5 py-2 flex-grow-1 flex-md-grow-0" 
                       style="border-radius: 10px; border: 1px solid #e5e7eb;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function () {
    const preview = document.getElementById('imagePreview');
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.style.backgroundImage = `url(${e.target.result})`;
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>