<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container-fluid py-4 px-4" style="background-color: #fcfcfc; min-height: 100vh;">
    
    <div class="mb-4">
        <h2 class="h4 fw-bold mb-1 text-dark">Category Management</h2>
        <p class="text-muted small">Manage your cafeteria product categories here.</p>
    </div>

    <div class="row g-4">
         <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="font-size:1.1rem;">Add New Category</h5>
                    <form action="index.php?page=admin-add-category" method="POST">
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase mb-2" style="letter-spacing: 0.5px;">Category Name</label>
                            <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-tag text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0 py-2" name="name" placeholder="e.g. Drinks" required style="border-radius: 0;">
                            </div>
                        </div>
                        <button type="submit" class="btn text-white fw-bold shadow-sm w-100 py-2" 
                                style="background-color: #d97706; border-radius: 10px;">
                            <i class="fas fa-plus me-2"></i> Save Category
                        </button>
                    </form>
                </div>
            </div>
        </div>

         <div class="col-md-8">
            <div class="card border border-light shadow-sm" style="border-radius: 12px; overflow: hidden; border-color: #f0f0f0 !important;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background-color: #fafafa;">
                                <tr class="text-muted" style="font-size: 0.75rem; letter-spacing: 0.8px; text-transform: uppercase;">
                                    <th class="ps-4 fw-bold border-bottom py-3">ID</th>
                                    <th class="fw-bold border-bottom py-3">Category Name</th>
                                    <th class="text-end pe-4 fw-bold border-bottom py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <tr>
                                            <td class="ps-4 py-3 fw-bold text-muted">#<?= $cat['id'] ?></td>
                                            <td class="fw-bold text-dark"><?= htmlspecialchars($cat['name']) ?></td>
                                            <td class="text-end pe-4">
                                                <a href="javascript:void(0);" onclick="confirmDelete(<?= $cat['id'] ?>)" class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center ms-auto" style="width: 32px; height: 32px;">
                                                    <i class="fas fa-trash text-danger" style="font-size: 0.8rem;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted">No categories created yet.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Delete Category?',
        text: "Make sure no products are using this category first.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `index.php?page=admin-delete-category&id=${id}`;
        }
    });
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
