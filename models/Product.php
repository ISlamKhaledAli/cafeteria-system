<?php
require_once __DIR__ . '/../config/Database.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllProducts() {
        $query = "SELECT p.id, p.name AS product_name, p.price, p.image, c.name AS category_name 
                  FROM products p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  ORDER BY p.id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories() {
        $stmt = $this->db->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO products (name, price, category_id, image) 
                  VALUES (:name, :price, :category_id, :image)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':price', $data['price']);
        $stmt->bindValue(':category_id', $data['category_id']);
        $stmt->bindValue(':image', $data['image'] ?? '');
        
        return $stmt->execute();
    }
}
?>
