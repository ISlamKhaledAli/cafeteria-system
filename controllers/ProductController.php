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

        $image = '';
        try {
            $image = $this->uploadImageSecure($_FILES['image'] ?? null);
        } catch (Exception $e) {
            $_SESSION['error'] = "Image Upload Error: " . $e->getMessage();
            redirect('index.php?page=admin-add-product');
        }

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

        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            try {
                $newImage = $this->uploadImageSecure($_FILES['image']);
                
                if ($newImage !== '') {
                    $data['image'] = $newImage;
                    
                    if (!empty($oldProduct['image']) && strpos($oldProduct['image'], 'http') !== 0 && file_exists(__DIR__ . '/../uploads/products/' . $oldProduct['image'])) {
                        unlink(__DIR__ . '/../uploads/products/' . $oldProduct['image']);
                    }
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Image Upload Error: " . $e->getMessage();
                redirect("index.php?page=admin-edit-product&id=$id");
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

        try {
            if ($this->productModel->delete($id)) {
                if ($product && !empty($product['image']) && strpos($product['image'], 'http') !== 0 && file_exists(__DIR__ . '/../uploads/products/' . $product['image'])) {
                    unlink(__DIR__ . '/../uploads/products/' . $product['image']);
                }
                
                $_SESSION['success'] = "Product deleted successfully!";
            } else {
                $_SESSION['error'] = "Failed to delete product!";
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Cannot delete this product! It is included in user orders.";
        }
        
        redirect('index.php?page=admin-products');
    }

    private function uploadImageSecure($file) {
        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE || empty($file['name'])) {
            return '';
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $uploadErrors = [
                UPLOAD_ERR_INI_SIZE   => 'File is larger than upload_max_filesize in php.ini.',
                UPLOAD_ERR_FORM_SIZE  => 'File exceeds MAX_FILE_SIZE in the HTML form.',
                UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.'
            ];
            $errorMsg = $uploadErrors[$file['error']] ?? 'Unknown upload error.';
            throw new Exception($errorMsg);
        }

        if ($file['size'] > 5242880) { // 5MB
            throw new Exception('File size exceeds 5MB limit.');
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
            throw new Exception("Invalid file type. Allowed: JPG, PNG, GIF, WEBP. Detected: $mime");
        }

        $targetDir = __DIR__ . '/../uploads/products/';
        if (!is_dir($targetDir)) {
            if(!mkdir($targetDir, 0777, true)){
                throw new Exception('Failed to create destination folder (uploads/products/). Check permissions.');
            }
        }

        $fileName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $fileName;
        }

        throw new Exception('Failed to move uploaded file. Check folder permissions (chmod 777).');
    }
}
?>