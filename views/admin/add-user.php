<?php
// استدعاء الهيدر والناف بار
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h3 class="h5 fw-bold mb-0">Add New User</h3>
                </div>
                <div class="card-body p-4">
                    
                    <form action="/PHP/cafeteria-system/admin/add-user" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label text-muted small fw-semibold">Name</label>
                            <input type="text" class="form-control bg-light border-0" id="name" name="name" required style="border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-muted small fw-semibold">Email</label>
                            <input type="email" class="form-control bg-light border-0" id="email" name="email" required style="border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-muted small fw-semibold">Password</label>
                            <input type="password" class="form-control bg-light border-0" id="password" name="password" required style="border-radius: 8px;">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="room" class="form-label text-muted small fw-semibold">Room No.</label>
                                <input type="text" class="form-control bg-light border-0" id="room" name="room" required style="border-radius: 8px;">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="ext" class="form-label text-muted small fw-semibold">Extension</label>
                                <input type="text" class="form-control bg-light border-0" id="ext" name="ext" required style="border-radius: 8px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label text-muted small fw-semibold">Role</label>
                            <select class="form-select bg-light border-0" id="role" name="role" style="border-radius: 8px;">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label text-muted small fw-semibold">Profile Picture</label>
                            <input class="form-control bg-light border-0" type="file" id="image" name="image" accept="image/*" style="border-radius: 8px;">
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="/PHP/cafeteria-system/admin/users" class="btn btn-light px-4" style="border-radius: 8px;">Cancel</a>
                            <button type="submit" class="btn text-white px-4" style="background-color: #d97706; border-radius: 8px;">Save</button>
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