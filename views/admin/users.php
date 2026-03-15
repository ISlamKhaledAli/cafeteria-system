<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container-fluid py-4 px-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold mb-0">Users Management</h2>
        <div class="d-flex gap-3 align-items-center">
            <div class="position-relative">
                <i class="fas fa-search position-absolute text-muted" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
                <input type="text" class="form-control ps-5 bg-light border-0" placeholder="Search users..." style="border-radius: 8px;">
            </div>
            <a href="/admin/add-user" class="btn text-white fw-semibold" style="background-color: #d97706; border-radius: 8px; padding: 8px 16px;">
                <i class="fas fa-user-plus me-2"></i> Add User
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-white">
                        <tr class="text-muted" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                            <th class="ps-4 fw-semibold border-bottom-0 py-3">PROFILE</th>
                            <th class="fw-semibold border-bottom-0 py-3">NAME</th>
                            <th class="fw-semibold border-bottom-0 py-3">ROOM NUMBER</th>
                            <th class="fw-semibold border-bottom-0 py-3">EXTENSION</th>
                            <th class="text-end pe-4 fw-semibold border-bottom-0 py-3">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <?php 
                                            $imagePath = !empty($user['image']) ? $user['image'] : 'default.png';
                                        ?>
                                        <img src="/uploads/users/<?= htmlspecialchars($imagePath) ?>" 
                                             alt="Profile" 
                                             class="rounded-circle object-fit-cover shadow-sm" 
                                             style="width: 45px; height: 45px;">
                                    </td>
                                    
                                    <td class="fw-semibold text-dark">
                                        <?= htmlspecialchars($user['name']) ?>
                                    </td>
                                    
                                    <td>
                                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill" style="font-weight: 500;">
                                            Room <?= htmlspecialchars($user['room']) ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-secondary">
                                        <?= htmlspecialchars($user['ext']) ?>
                                    </td>
                                    
                                    <td class="text-end pe-4">
                                        <a href="/admin/edit-user?id=<?= $user['id'] ?>" class="text-secondary me-3 transition-colors hover-primary">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="/admin/delete-user?id=<?= $user['id'] ?>" class="text-secondary transition-colors hover-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fs-1 mb-3 text-light"></i>
                                    <p>No users found. Start by adding a new user.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="text-muted small">Showing 1 to <?= count($users) ?> users</span>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0 gap-1">
                    <li class="page-item disabled">
                        <a class="page-link border rounded text-secondary" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link border-0 rounded text-white" style="background-color: #d97706;" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link border rounded text-dark" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link border rounded text-dark" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link border rounded text-dark" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php 
require_once __DIR__ . '/../../layouts/footer.php'; 
?>