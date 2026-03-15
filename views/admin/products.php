<?php
require_once "../../config/database.php";

$db = db_pdo();

$stmt = $db->prepare(
	"SELECT p.id, p.name AS product_name, p.price, p.image, c.name AS category_name
	 FROM products p
	 LEFT JOIN categories c ON p.category_id = c.id
	 ORDER BY p.id DESC"
);

$stmt->execute();
$products = $stmt->fetchAll();
?>

<?php include "../../layouts/header.php"; ?>

<div class="container mt-5">

<h3 class="mb-4">Products List</h3>

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
					<img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" width="60" height="60">
				<?php else: ?>
					No Image
				<?php endif; ?>
			</td>
			<td><?php echo htmlspecialchars($product['product_name']); ?></td>
			<td><?php echo htmlspecialchars($product['price']); ?></td>
			<td><?php echo htmlspecialchars($product['category_name'] ?? ''); ?></td>
			<td>
				<button type="button" class="btn btn-sm btn-primary">Edit</button>
				<button type="button" class="btn btn-sm btn-danger">Delete</button>
			</td>
		</tr>
	<?php endforeach; ?>
<?php else: ?>
	<tr>
		<td colspan="5">No products found.</td>
	</tr>
<?php endif; ?>
</tbody>

</table>

</div>

<?php include "../../layouts/footer.php"; ?>
