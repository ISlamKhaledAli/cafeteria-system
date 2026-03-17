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

        $image = $this->uploadImage($_FILES['image'] ?? null);

        $data = [
            'name' => $name,
            'price' => $price,
            'category_id' => $category_id,
            'image' => $image
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
            'category_id' => $category_id
        ];

        if (!empty($_FILES['image']['name'])) {
            $data['image'] = $this->uploadImage($_FILES['image']);
        }

        if ($this->productModel->update($id, $data)) {
            header("Location: /admin/products");
            exit;
        } else {
             header("Location: /admin/edit-product?id=$id&error=db_error");
             exit;
        }
    }

    public function delete($id) {
         if ($this->productModel->delete($id)) {
             header("Location: /admin/products");
             exit;
         } else {
             header("Location: /admin/products?error=delete_failed");
             exit;
         }
    }

    private function uploadImage($file) {
        if (empty($file['name'])) {
            return ''; // Or return 'default.png' but view logic checks empty
        }

        $targetDir = __DIR__ . '/../uploads/products/';
        
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileExt = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (!in_array($fileExt, $allowed)) {
             return ''; // Invalid type
        }

        $fileName = time() . '_' . uniqid() . '.' . $fileExt;
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $fileName;
        }

        return '';  
    }
}
?>
