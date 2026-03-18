<?php 
require_once __DIR__ . '/../../layouts/header.php'; 
require_once __DIR__ . '/../../layouts/navbar.php'; 
?>

<div class="container mt-5" style="max-width: 600px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 style="color: #d97706;">Add New Product</h3>
        <a href="/PHP/cafeteria-system/admin/products" class="text-muted text-decoration-none"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <form action="/PHP/cafeteria-system/admin/add-product" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="product_name" class="form-label fw-bold small">Product Name</label>
                    <input type="text" class="form-control bg-light border-0" id="product_name" name="product_name" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label fw-bold small">Price ($)</label>
                        <input type="number" step="0.01" class="form-control bg-light border-0" id="price" name="price" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label fw-bold small">Category</label>
                        <select class="form-select bg-light border-0" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="image" class="form-label fw-bold small">Product Image</label>
                    <input type="file" class="form-control bg-light border-0" id="image" name="image" accept="image/*">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn text-white py-2" style="background-color: #d97706; border-radius: 8px;">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>