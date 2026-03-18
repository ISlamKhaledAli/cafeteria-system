<?php 
require_once __DIR__ . '/../../layouts/header.php'; 
require_once __DIR__ . '/../../layouts/navbar.php'; 
?>

<div class="container mt-5">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Products List</h3>
    <a href="/PHP/cafeteria-system/admin/add-product" class="btn text-white" style="background-color: #d97706;">Add Product</a>
</div>

<div class="card shadow-sm border-0" style="border-radius: 12px;">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
        <thead class="bg-light">
        <tr>
        <th class="ps-4 py-3">Image</th>
        <th class="py-3">Product Name</th>
        <th class="py-3">Price</th>
        <th class="py-3">Category</th>
        <th class="pe-4 py-3 text-end">Actions</th>
        </tr>
        </thead>

        <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td class="ps-4 py-3">
                        <?php if (!empty($product['image'])): ?>
                            <img src="/PHP/cafeteria-system/uploads/products/<?php echo htmlspecialchars($product['image']); ?>" class="rounded shadow-sm" alt="Product" style="width: 60px; height: 60px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px;">
                                <i class="fas fa-image"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="fw-bold text-dark"><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td class="fw-bold text-success">$<?php echo htmlspecialchars($product['price']); ?></td>
                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($product['category_name'] ?? 'N/A'); ?></span></td>
                    <td class="pe-4 text-end">
                        <a href="/PHP/cafeteria-system/admin/edit-product?id=<?php echo $product['id']; ?>" class="text-secondary me-3 text-decoration-none"><i class="fas fa-pen text-muted"></i></a>
                        <a href="/PHP/cafeteria-system/admin/delete-product?id=<?php echo $product['id']; ?>" class="text-secondary text-decoration-none" onclick="return confirm('Are you sure you want to delete this product?')"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center py-5 text-muted">
                    <i class="fas fa-box-open fs-1 mb-3 opacity-25"></i>
                    <p>No products found.</p>
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
        </table>
    </div>
</div>

</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>