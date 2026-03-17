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
        $name = $_POST['product_name'] ?? '';
        $price = $_POST['price'] ?? 0;
        $category_id = $_POST['category_id'] ?? null;
        
        if (empty($name) || empty($price) || empty($category_id)) {
             header("Location: /admin/add-product?error=missing_fields");
             exit;
        }

        $data = [
            'name' => $name,
            'price' => $price,
            'category_id' => $category_id,
            'image' => ''
        ];

        if ($this->productModel->create($data)) {
            header("Location: /admin/products");
            exit;
        } else {
             header("Location: /admin/add-product?error=db_error");
             exit;
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
             header("Location: /admin/products");
             exit;
        }
        $product = $this->productModel->getProductById($id);
        $categories = $this->productModel->getCategories();
        require_once __DIR__ . '/../views/admin/edit-product.php';
    }

    public function update() {
        $id = $_POST['product_id'] ?? null;
        if (!$id) {
             header("Location: /admin/products");
             exit;
        }

        $name = $_POST['product_name'] ?? '';
        $price = $_POST['price'] ?? 0;
        $category_id = $_POST['category_id'] ?? null;

        if (empty($name) || empty($price) || empty($category_id)) {
             header("Location: /admin/edit-product?id=$id&error=missing_fields");
             exit;
        }

        $data = [
            'name' => $name,
            'price' => $price,
            'category_id' => $category_id,
            // image handled later
            'image' => '' 
        ];

        if ($this->productModel->update($id, $data)) {
            header("Location: /admin/products");
            exit;
        } else {
             header("Location: /admin/edit-product?id=$id&error=db_error");
             exit;
        }
    }
}
?>
