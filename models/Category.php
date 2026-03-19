<?php
require_once __DIR__ . '/../config/Database.php';

class Category {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllCategories() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCategory($name) {
        $stmt = $this->db->prepare("INSERT INTO categories (name) VALUES (:name)");
        try {
            return $stmt->execute(['name' => $name]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function countProductsInCategory($categoryId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM products WHERE category_id = :id");
        $stmt->execute(['id' => $categoryId]);
        return (int) $stmt->fetchColumn();
    }

    public function deleteCategory($id) {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>