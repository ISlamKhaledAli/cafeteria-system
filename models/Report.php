<?php
require_once __DIR__ . '/../config/Database.php';

class Report {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getGeneralStats() {
        $stats = [];

        $stats['total_users'] = (int) $this->db->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetchColumn();
        $stats['total_products'] = (int) $this->db->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $stats['total_orders'] = (int) $this->db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        $stats['orders_today'] = (int) $this->db->query("SELECT COUNT(*) FROM orders WHERE DATE(created_at) = CURDATE()")->fetchColumn();
        
        $stats['revenue_today'] = (float) $this->db->query("SELECT COALESCE(SUM(total_price),0) FROM orders WHERE DATE(created_at) = CURDATE() AND status != 'canceled'")->fetchColumn();
        $stats['revenue_total'] = (float) $this->db->query("SELECT COALESCE(SUM(total_price),0) FROM orders WHERE status != 'canceled'")->fetchColumn();

        $stmt = $this->db->query("SELECT status, COUNT(*) as cnt FROM orders GROUP BY status");
        $byStatus = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $stats['by_status'] = [];
        foreach ($byStatus as $row) {
            $stats['by_status'][$row['status']] = (int) $row['cnt'];
        }

        return $stats;
    }

    public function getRecentOrders($limit = 5) {
        $stmt = $this->db->prepare("
            SELECT o.id, o.total_price, o.status, o.created_at, u.name AS user_name, o.room_no
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            ORDER BY o.created_at DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopProducts($limit = 5) {
        $stmt = $this->db->prepare("
            SELECT p.name, SUM(oi.quantity) AS sold
            FROM order_items oi
            LEFT JOIN products p ON oi.product_id = p.id
            GROUP BY oi.product_id
            ORDER BY sold DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>