<?php
require_once __DIR__ . '/../models/Product.php';

class CategoryController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function index() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY id DESC");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../views/admin/categories.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            if (!empty($name)) {
                $stmt = $this->db->prepare("INSERT INTO categories (name) VALUES (:name)");
                $stmt->execute(['name' => $name]);
                $_SESSION['success'] = "Category added successfully!";
            } else {
                $_SESSION['error'] = "Category name is required!";
            }
        }
        header("Location: index.php?page=admin-categories");
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
             $stmt = $this->db->prepare("SELECT COUNT(*) FROM products WHERE category_id = :id");
            $stmt->execute(['id' => $id]);
            if ($stmt->fetchColumn() > 0) {
                $_SESSION['error'] = "Cannot delete: Products exist in this category!";
            } else {
                $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
                $stmt->execute(['id' => $id]);
                $_SESSION['success'] = "Category deleted successfully!";
            }
        }
        header("Location: index.php?page=admin-categories");
        exit;
    }
}
?>
