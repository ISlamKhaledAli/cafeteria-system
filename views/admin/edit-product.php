<?php include "../../layouts/header.php"; ?>

<div class="container mt-5">
    <h3>Edit Product</h3>
    <form action="edit-product" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        
        <div class="mb-3">
            <label for="product_name" class="form-label">Product</label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">Select Category</option>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo ($product['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        
        <?php if (!empty($product['image'])): ?>
        <div class="mb-3">
            <label class="form-label">Current Image</label>
            <div>
                <img src="/uploads/products/<?php echo htmlspecialchars($product['image']); ?>" width="100">
            </div>
        </div>
        <?php endif; ?>

        <!-- Image input placeholder -->
        <!-- <div class="mb-3">
            <label for="image" class="form-label">Change Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div> -->

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/admin/products" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include "../../layouts/footer.php"; ?>
