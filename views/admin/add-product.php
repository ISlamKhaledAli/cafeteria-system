<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container-fluid py-4 px-4" style="background-color: #fcfcfc; min-height: 100vh;">

    <div class="d-flex align-items-center mb-4 gap-3">
        <a href="index.php?page=admin-products" class="btn btn-light shadow-sm" style="border-radius: 8px;">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
        <h2 class="h4 fw-bold mb-0 text-dark">Add New Product</h2>
    </div>

    <div class="card border border-light shadow-sm" style="border-radius: 12px; max-width: 640px;">
        <div class="card-body p-4">

            <form action="index.php?page=admin-store-product" method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="product_name" class="form-label fw-semibold small text-muted text-uppercase" style="letter-spacing: 0.6px;">Product Name</label>
                    <input type="text" class="form-control bg-white shadow-sm" id="product_name"
                           name="product_name" required placeholder="e.g. Chicken Sandwich"
                           style="border-radius: 10px; border-color: #eaeaea;">
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label fw-semibold small text-muted text-uppercase" style="letter-spacing: 0.6px;">Price (EGP)</label>
                    <input type="number" step="0.01" min="0" class="form-control bg-white shadow-sm"
                           id="price" name="price" required placeholder="e.g. 35.00"
                           style="border-radius: 10px; border-color: #eaeaea;">
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label fw-semibold small text-muted text-uppercase" style="letter-spacing: 0.6px;">Category</label>
                    <select class="form-select bg-white shadow-sm" id="category_id" name="category_id" required
                            style="border-radius: 10px; border-color: #eaeaea;">
                        <option value="">-- Select Category --</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label fw-semibold small text-muted text-uppercase" style="letter-spacing: 0.6px;">Product Image (optional)</label>
                    <input type="file" class="form-control bg-white shadow-sm" id="image" name="image"
                           accept="image/*" style="border-radius: 10px; border-color: #eaeaea;">
                    <div id="imagePreview" class="mt-2" style="display:none;">
                        <img id="previewImg" src="#" alt="Preview" class="rounded shadow-sm"
                             style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn text-white fw-semibold shadow-sm px-4"
                            style="background-color: #d97706; border-radius: 10px;">
                        <i class="fas fa-save me-2"></i> Save Product
                    </button>
                    <a href="index.php?page=admin-products" class="btn btn-light fw-semibold shadow-sm px-4"
                       style="border-radius: 10px;">
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
    const img = document.getElementById('previewImg');
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
