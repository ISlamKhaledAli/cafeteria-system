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
            redirect('index.php?page=admin-add-product');
        }

        $image = $this->uploadImageSecure($_FILES['image'] ?? null);

        $data = [
            'name'        => $name,
            'price'       => $price,
            'category_id' => $category_id,
            'image'       => $image
        ];

        if ($this->productModel->create($data)) {
            $_SESSION['success'] = "Product added successfully!";
            redirect('index.php?page=admin-products');
        } else {
            $_SESSION['error'] = "Database error while adding product!";
            redirect('index.php?page=admin-add-product');
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            redirect('index.php?page=admin-products');
        }
        $product    = $this->productModel->getProductById($id);
        $categories = $this->productModel->getCategories();
        require_once __DIR__ . '/../views/admin/edit-product.php';
    }

    public function update() {
        $id = $_POST['product_id'] ?? null;
        if (!$id) {
            redirect('index.php?page=admin-products');
        }

        $name        = trim($_POST['product_name'] ?? '');
        $price       = $_POST['price']       ?? 0;
        $category_id = $_POST['category_id'] ?? null;

        if (empty($name) || empty($price) || empty($category_id)) {
            $_SESSION['error'] = "All fields are required!";
            redirect("index.php?page=admin-edit-product&id=$id");
        }

        $data = [
            'name'        => $name,
            'price'       => $price,
            'category_id' => $category_id
        ];

        $oldProduct = $this->productModel->getProductById($id);

        if (!empty($_FILES['image']['name'])) {
            $newImage = $this->uploadImageSecure($_FILES['image']);
            
            if ($newImage !== '') {
                $data['image'] = $newImage;
                
                if (!empty($oldProduct['image']) && file_exists(__DIR__ . '/../uploads/products/' . $oldProduct['image'])) {
                    unlink(__DIR__ . '/../uploads/products/' . $oldProduct['image']);
                }
            }
        }

        if ($this->productModel->update($id, $data)) {
            $_SESSION['success'] = "Product updated successfully!";
            redirect('index.php?page=admin-products');
        } else {
            $_SESSION['error'] = "Error updating product!";
            redirect("index.php?page=admin-edit-product&id=$id");
        }
    }

    public function delete($id) {
        $product = $this->productModel->getProductById($id);
        
        if ($this->productModel->delete($id)) {
            if ($product && !empty($product['image']) && file_exists(__DIR__ . '/../uploads/products/' . $product['image'])) {
                unlink(__DIR__ . '/../uploads/products/' . $product['image']);
            }
            
            $_SESSION['success'] = "Product deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete product!";
        }
        redirect('index.php?page=admin-products');
    }

    private function uploadImageSecure($file) {
        if (!isset($file['error']) || is_array($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            return '';
        }

        if ($file['size'] > 2097152) {
            return ''; 
        }

        $allowedTypes = [
            'jpg'  => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'webp' => 'image/webp'
        ];
        
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $ext = array_search($mime, $allowedTypes, true);

        if ($ext === false) {
            return '';
        }

        $targetDir = __DIR__ . '/../uploads/products/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $fileName;
        }

        return '';  
    }
}
?>