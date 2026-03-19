<?php
require_once __DIR__ . '/../models/Category.php';

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        require_once __DIR__ . '/../views/admin/categories.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            
            if (!empty($name)) {
                if ($this->categoryModel->createCategory($name)) {
                    $_SESSION['success'] = "Category added successfully!";
                } else {
                    $_SESSION['error'] = "Failed to add category. It might already exist.";
                }
            } else {
                $_SESSION['error'] = "Category name is required!";
            }
        }
        redirect('index.php?page=admin-categories');
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            if ($this->categoryModel->countProductsInCategory($id) > 0) {
                $_SESSION['error'] = "Cannot delete: Products exist in this category!";
            } else {
                if ($this->categoryModel->deleteCategory($id)) {
                    $_SESSION['success'] = "Category deleted successfully!";
                } else {
                    $_SESSION['error'] = "Failed to delete category!";
                }
            }
        }
        redirect('index.php?page=admin-categories');
    }
}
?>