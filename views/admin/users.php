<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container-fluid py-4 px-4" style="background-color: #fcfcfc; min-height: 100vh;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold mb-0 text-dark">Users Management</h2>
        <div class="d-flex gap-3 align-items-center">
            <div class="position-relative">
                <i class="fas fa-search position-absolute text-muted" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
                <input type="text" id="searchInput" class="form-control ps-5 bg-white border" placeholder="Search users..." style="border-radius: 8px; border-color: #eaeaea !important; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            </div>
            <a href="/PHP/cafeteria-system/admin/add-user" class="btn text-white fw-semibold shadow-sm" style="background-color: #d97706; border-radius: 8px; padding: 8px 20px;">
                <i class="fas fa-user-plus me-2"></i> Add User
            </a>
        </div>
    </div>

    <div class="card border border-light shadow-sm" style="border-radius: 12px; overflow: hidden; border-color: #f0f0f0 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #fafafa;">
                        <tr class="text-muted" style="font-size: 0.75rem; letter-spacing: 0.8px; text-transform: uppercase;">
                            <th class="ps-4 fw-bold border-bottom py-3">Profile</th>
                            <th class="fw-bold border-bottom py-3">Name</th>
                            <th class="fw-bold border-bottom py-3">Room Number</th>
                            <th class="fw-bold border-bottom py-3">Extension</th>
                            <th class="text-end pe-4 fw-bold border-bottom py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody" class="border-top-0 bg-white">
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <?php $imagePath = !empty($user['image']) ? $user['image'] : 'default.png'; ?>
                                        <img src="/PHP/cafeteria-system/uploads/users/<?= htmlspecialchars($imagePath) ?>" 
                                             alt="Profile" 
                                             class="rounded-circle object-fit-cover border" 
                                             style="width: 45px; height: 45px; border-color: #eee !important;">
                                    </td>
                                    
                                    <td class="fw-bold text-dark" style="font-size: 0.95rem;">
                                        <?= htmlspecialchars($user['name']) ?>
                                    </td>
                                    
                                    <td>
                                        <span class="badge text-secondary border px-3 py-2 rounded-pill" style="background-color: #f3f4f6; font-weight: 500;">
                                            Room <?= htmlspecialchars($user['room']) ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-muted" style="font-size: 0.95rem;">
                                        <?= htmlspecialchars($user['ext']) ?>
                                    </td>
                                    
                                    
                                    <td class="text-end pe-4">
                                        <a href="/PHP/cafeteria-system/admin/edit-user?id=<?= $user['id'] ?>" class="text-secondary me-3 text-decoration-none">
                                            <i class="fas fa-pen text-muted hover-warning transition"></i>
                                        </a>
                                        <a href="/PHP/cafeteria-system/admin/delete-user?id=<?= $user['id'] ?>" class="text-secondary text-decoration-none" onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                                            <i class="fas fa-trash text-muted hover-danger transition"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-users fs-1 mb-3 opacity-25"></i>
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
                    <li class="page-item disabled"><a class="page-link border rounded text-secondary" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link border-0 rounded text-white" style="background-color: #d97706;" href="#">1</a></li>
                    <li class="page-item"><a class="page-link border rounded text-dark" href="#">2</a></li>
                    <li class="page-item"><a class="page-link border rounded text-dark" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<script src="/PHP/cafeteria-system/assets/js/users-table.js"></script>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>