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
        // Simple validation
        $name = $_POST['product_name'] ?? '';
        $price = $_POST['price'] ?? 0;
        $category_id = $_POST['category_id'] ?? null;
        
        if (empty($name) || empty($price) || empty($category_id)) {
             // Handle error - maybe redirect back with error
             // For now just redirect back
             header("Location: /admin/add-product?error=missing_fields");
             exit;
        }

        $data = [
            'name' => $name,
            'price' => $price,
            'category_id' => $category_id,
            // image will be handled in separate feature branch or defaulted here
            'image' => '' // Default empty or placeholder
        ];

        if ($this->productModel->create($data)) {
            header("Location: /admin/products");
            exit;
        } else {
             header("Location: /admin/add-product?error=db_error");
             exit;
        }
    }
}
?>
