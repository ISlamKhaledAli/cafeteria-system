<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container-fluid py-4 px-4" style="background-color: #fcfcfc; min-height: 100vh;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold mb-0 text-dark">Products Management</h2>
        <div class="d-flex gap-3 align-items-center">
            <div class="position-relative">
                <i class="fas fa-search position-absolute text-muted" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
                <input type="text" id="productSearch" class="form-control ps-5 bg-white border"
                       placeholder="Search products..."
                       style="border-radius: 8px; border-color: #eaeaea !important; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            </div>
            <a href="index.php?page=admin-add-product" class="btn text-white fw-semibold shadow-sm"
               style="background-color: #d97706; border-radius: 8px; padding: 8px 20px;">
                <i class="fas fa-plus me-2"></i> Add Product
            </a>
        </div>
    </div>

    <div class="card border border-light shadow-sm" style="border-radius: 12px; overflow: hidden; border-color: #f0f0f0 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #fafafa;">
                        <tr class="text-muted" style="font-size: 0.75rem; letter-spacing: 0.8px; text-transform: uppercase;">
                            <th class="ps-4 fw-bold border-bottom py-3">Image</th>
                            <th class="fw-bold border-bottom py-3">Product Name</th>
                            <th class="fw-bold border-bottom py-3">Price</th>
                            <th class="fw-bold border-bottom py-3">Category</th>
                            <th class="text-end pe-4 fw-bold border-bottom py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody" class="border-top-0 bg-white">
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <?php 
                                            $img = !empty($product['image']) ? $product['image'] : 'default.png';
                                            $imgSrc = (strpos($img, 'http') === 0) ? $img : 'uploads/products/' . $img;
                                        ?>
                                        <img src="<?= $imgSrc ?>"
                                            alt="<?= htmlspecialchars($product['product_name']) ?>"
                                            class="rounded shadow-sm"
                                            style="width: 50px; height: 50px; object-fit: cover;"
                                            onerror="this.src='https://placehold.co/80x80?text=<?= urlencode($product['product_name']) ?>'">
                                    </td>
                                    <td class="fw-bold text-dark" style="font-size: 0.95rem;">
                                        <?= htmlspecialchars($product['product_name']) ?>
                                    </td>
                                    <td>
                                        <span class="badge text-secondary border px-3 py-2 rounded-pill"
                                              style="background-color: #f3f4f6; font-weight: 500;">
                                            <?= number_format((float)$product['price'], 2) ?> EGP
                                        </span>
                                    </td>
                                    <td class="text-muted" style="font-size: 0.95rem;">
                                        <?= htmlspecialchars($product['category_name'] ?? 'N/A') ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="index.php?page=admin-edit-product&id=<?= $product['id'] ?>"
                                           class="text-secondary me-3 text-decoration-none">
                                            <i class="fas fa-pen text-muted"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="text-secondary text-decoration-none"
                                           onclick="confirmDeleteProduct(<?= $product['id'] ?>)">
                                            <i class="fas fa-trash text-muted"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-box-open fs-1 mb-3 opacity-25"></i>
                                    <p>No products found. Start by adding a new product.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="text-muted small">Showing <?= count($products ?? []) ?> products</span>
        </div>
    </div>
</div>

<script>
 document.getElementById('productSearch').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#productsTableBody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});

function confirmDeleteProduct(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This product will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `index.php?page=admin-delete-product&id=${id}`;
        }
    });
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
