<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container-fluid py-4 px-4" style="background-color: #fcfcfc; min-height: 100vh;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold mb-0 text-dark">Users Management</h2>
        <div class="d-flex gap-3 align-items-center">
            <div class="position-relative">
                <i class="fas fa-search position-absolute text-muted" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
                <input type="text" id="userSearch" class="form-control ps-5 bg-white border" placeholder="Search users..." 
                       style="border-radius: 8px; border-color: #eaeaea !important; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            </div>
            <a href="index.php?page=admin-add-user" class="btn text-white fw-semibold shadow-sm" style="background-color: #d97706; border-radius: 8px; padding: 8px 20px;">
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
                            <th class="fw-bold border-bottom py-3">Name & Email</th>
                            <th class="fw-bold border-bottom py-3">Room</th>
                            <th class="fw-bold border-bottom py-3">Phone</th>
                            <th class="fw-bold border-bottom py-3">Role</th>
                            <th class="text-end pe-4 fw-bold border-bottom py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody" class="border-top-0 bg-white">
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <?php 
                                            $imageName = !empty($user['image']) ? $user['image'] : 'default.png';
                                            $imageURL = "uploads/users/" . $imageName;
                                            if (!file_exists(BASE_PATH . '/' . $imageURL)) {
                                                $imageURL = "https://ui-avatars.com/api/?name=" . urlencode($user['name']) . "&background=F59E0B&color=fff";
                                            } else {
                                                $imageURL = "uploads/users/" . $imageName;
                                            }
                                        ?>
                                        <img src="<?= $imageURL ?>" 
                                             alt="<?= htmlspecialchars($user['name']) ?>" 
                                             class="rounded-circle shadow-sm border" 
                                             style="width: 45px; height: 45px; object-fit: cover; border-color: #eee !important;">
                                    </td>
                                    
                                    <td class="py-3">
                                        <div class="fw-bold text-dark" style="font-size: 0.95rem;"><?= htmlspecialchars($user['name']) ?></div>
                                        <div class="text-muted" style="font-size: 0.8rem;"><?= htmlspecialchars($user['email']) ?></div>
                                    </td>
                                    
                                    <td>
                                        <span class="badge text-secondary border px-3 py-2 rounded-pill" style="background-color: #f3f4f6; font-weight: 500;">
                                            Room <?= htmlspecialchars($user['room_no']) ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-muted fw-semibold" style="font-size: 0.9rem;">
                                        <?= htmlspecialchars($user['ext']) ?>
                                    </td>

                                    <td>
                                        <span class="badge rounded-pill px-3 py-1 fw-bold text-uppercase" 
                                              style="font-size: 0.65rem; background-color: <?= ($user['role'] === 'admin' ? '#FEF3C7' : '#E0F2FE') ?>; 
                                                     color: <?= ($user['role'] === 'admin' ? '#B45309' : '#0369A1') ?>;">
                                            <?= htmlspecialchars($user['role']) ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="index.php?page=admin-edit-user&id=<?= $user['id'] ?>" class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="fas fa-pen text-muted" style="font-size: 0.8rem;"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center" 
                                               style="width: 32px; height: 32px;" onclick="handleDelete(<?= $user['id'] ?>)">
                                                <i class="fas fa-trash text-danger" style="font-size: 0.8rem;"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-users-slash fs-1 mb-3 opacity-25"></i>
                                    <p class="mb-0">No users found. Start by adding a new one.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top py-3 px-4">
            <span class="text-muted small">Showing <?= count($users) ?> registered accounts</span>
        </div>
    </div>
</div>

<script>
 document.getElementById('userSearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#usersTableBody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

function handleDelete(userId) {
    Swal.fire({
        title: 'Delete User?',
        text: "This action cannot be undone. All orders for this user might be affected.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `index.php?page=admin-delete-user&id=${userId}`;
        }
    });
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>