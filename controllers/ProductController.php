<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        require_once __DIR__ . '/../views/admin/products.php';
    }

    public function create() {
        $categories = $this->productModel->getCategories();
        require_once __DIR__ . '/../views/admin/add-product.php';
    }

    public function store() {
        $name        = trim($_POST['product_name'] ?? '');
        $price       = $_POST['price']       ?? 0;
        $category_id = $_POST['category_id'] ?? null;

        if (empty($name) || empty($price) || empty($category_id)) {
            $_SESSION['error'] = "All fields are required!";
            header("Location: index.php?page=admin-add-product");
            exit;
        }

        $image = $this->uploadImage($_FILES['image'] ?? null);

        $data = [
            'name'        => $name,
            'price'       => $price,
            'category_id' => $category_id,
            'image'       => $image
        ];

        if ($this->productModel->create($data)) {
            $_SESSION['success'] = "Product added successfully!";
            header("Location: index.php?page=admin-products");
            exit;
        } else {
            $_SESSION['error'] = "Database error while adding product!";
            header("Location: index.php?page=admin-add-product");
            exit;
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?page=admin-products");
            exit;
        }
        $product    = $this->productModel->getProductById($id);
        $categories = $this->productModel->getCategories();
        require_once __DIR__ . '/../views/admin/edit-product.php';
    }

    public function update() {
        $id = $_POST['product_id'] ?? null;
        if (!$id) {
            header("Location: index.php?page=admin-products");
            exit;
        }

        $name        = trim($_POST['product_name'] ?? '');
        $price       = $_POST['price']       ?? 0;
        $category_id = $_POST['category_id'] ?? null;

        if (empty($name) || empty($price) || empty($category_id)) {
            $_SESSION['error'] = "All fields are required!";
            header("Location: index.php?page=admin-edit-product&id=$id");
            exit;
        }

        $data = [
            'name'        => $name,
            'price'       => $price,
            'category_id' => $category_id
        ];

        if (!empty($_FILES['image']['name'])) {
            $data['image'] = $this->uploadImage($_FILES['image']);
        }

        if ($this->productModel->update($id, $data)) {
            $_SESSION['success'] = "Product updated successfully!";
            header("Location: index.php?page=admin-products");
            exit;
        } else {
            $_SESSION['error'] = "Error updating product!";
            header("Location: index.php?page=admin-edit-product&id=$id");
            exit;
        }
    }

    public function delete($id) {
        if ($this->productModel->delete($id)) {
            $_SESSION['success'] = "Product deleted successfully!";
            header("Location: index.php?page=admin-products");
            exit;
        } else {
            $_SESSION['error'] = "Failed to delete product!";
            header("Location: index.php?page=admin-products");
            exit;
        }
    }

    private function uploadImage($file) {
        if (!isset($file) || !isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK || empty($file['name'])) {
            return '';
        }

        $targetDir = __DIR__ . '/../uploads/products/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($fileExt, $allowed)) {
            return '';
        }

        $fileName       = time() . '_' . uniqid() . '.' . $fileExt;
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return $fileName;
        }

        return '';
    }
}
?>
