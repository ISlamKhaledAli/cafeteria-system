<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h3 class="h5 fw-bold mb-0">Edit User</h3>
                </div>
                <div class="card-body p-4">
                    
                    <form action="/PHP/cafeteria-system/admin/edit-user?id=<?= $user['id'] ?>" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-semibold">Name</label>
                            <input type="text" class="form-control bg-light border-0" name="name" value="<?= htmlspecialchars($user['name']) ?>" required style="border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small fw-semibold">Email</label>
                            <input type="email" class="form-control bg-light border-0" name="email" value="<?= htmlspecialchars($user['email']) ?>" required style="border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small fw-semibold">Password <span class="text-danger" style="font-size: 0.8rem;">(Leave blank to keep current)</span></label>
                            <input type="password" class="form-control bg-light border-0" name="password" style="border-radius: 8px;">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small fw-semibold">Room No.</label>
                                <input type="text" class="form-control bg-light border-0" name="room" value="<?= htmlspecialchars($user['room']) ?>" required style="border-radius: 8px;">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small fw-semibold">Extension</label>
                                <input type="text" class="form-control bg-light border-0" name="ext" value="<?= htmlspecialchars($user['ext']) ?>" required style="border-radius: 8px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small fw-semibold">Role</label>
                            <select class="form-select bg-light border-0" name="role" style="border-radius: 8px;">
                                <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small fw-semibold">Profile Picture</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <?php $imagePath = !empty($user['image']) ? $user['image'] : 'default.png'; ?>
                                <img src="/PHP/cafeteria-system/uploads/users/<?= htmlspecialchars($imagePath) ?>" alt="Current Profile" class="rounded-circle object-fit-cover shadow-sm" style="width: 50px; height: 50px;">
                                <span class="text-muted small">Current image</span>
                            </div>
                            <input class="form-control bg-light border-0" type="file" name="image" accept="image/*" style="border-radius: 8px;">
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="/PHP/cafeteria-system/admin/users" class="btn btn-light px-4" style="border-radius: 8px;">Cancel</a>
                            <button type="submit" class="btn text-white px-4" style="background-color: #d97706; border-radius: 8px;">Update changes</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
require_once __DIR__ . '/../../layouts/footer.php'; 
?>