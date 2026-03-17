<?php include "../../layouts/header.php"; ?>

<div class="container mt-5">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Products List</h3>
    <a href="add-product" class="btn btn-primary">Add Product</a>
</div>

<table class="table table-bordered">
<thead>
<tr>
<th>Image</th>
<th>Product Name</th>
<th>Price</th>
<th>Category</th>
<th>Actions</th>
</tr>
</thead>

<tbody>
<?php if (!empty($products)): ?>
    <?php foreach ($products as $product): ?>
        <tr>
            <td>
                <?php if (!empty($product['image'])): ?>
                    <img src="/uploads/products/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" width="60" height="60">
                <?php else: ?>
                    <span class="text-muted">No Image</span>
                <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($product['product_name']); ?></td>
            <td><?php echo htmlspecialchars($product['price']); ?> EGP</td>
            <td><?php echo htmlspecialchars($product['category_name'] ?? 'N/A'); ?></td>
            <td>
                <a href="edit-product?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="delete-product?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="text-center">No products found.</td>
    </tr>
<?php endif; ?>
</tbody>

</table>

</div>

<?php include "../../layouts/footer.php"; ?>
