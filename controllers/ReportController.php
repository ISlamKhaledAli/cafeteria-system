<?php
require_once __DIR__ . '/../config/Database.php';

class ReportController {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function dashboard() {
         $stats = [];

         $stmt = $this->db->query("SELECT COUNT(*) FROM users WHERE role = 'user'");
        $stats['total_users'] = (int) $stmt->fetchColumn();

         $stmt = $this->db->query("SELECT COUNT(*) FROM products");
        $stats['total_products'] = (int) $stmt->fetchColumn();

         $stmt = $this->db->query("SELECT COUNT(*) FROM orders");
        $stats['total_orders'] = (int) $stmt->fetchColumn();

         $stmt = $this->db->query("SELECT COUNT(*) FROM orders WHERE DATE(created_at) = CURDATE()");
        $stats['orders_today'] = (int) $stmt->fetchColumn();

         $stmt = $this->db->query("SELECT COALESCE(SUM(total_price),0) FROM orders WHERE DATE(created_at) = CURDATE() AND status != 'canceled'");
        $stats['revenue_today'] = (float) $stmt->fetchColumn();

         $stmt = $this->db->query("SELECT COALESCE(SUM(total_price),0) FROM orders WHERE status != 'canceled'");
        $stats['revenue_total'] = (float) $stmt->fetchColumn();

         $stmt = $this->db->query("SELECT status, COUNT(*) as cnt FROM orders GROUP BY status");
        $byStatus = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stats['by_status'] = [];
        foreach ($byStatus as $row) {
            $stats['by_status'][$row['status']] = (int) $row['cnt'];
        }

         $stmt = $this->db->query(
            "SELECT o.id, o.total_price, o.status, o.created_at, u.name AS user_name, o.room_no
             FROM orders o
             LEFT JOIN users u ON o.user_id = u.id
             ORDER BY o.created_at DESC
             LIMIT 5"
        );
        $recent_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

         $stmt = $this->db->query(
            "SELECT p.name, SUM(oi.quantity) AS sold
             FROM order_items oi
             LEFT JOIN products p ON oi.product_id = p.id
             GROUP BY oi.product_id
             ORDER BY sold DESC
             LIMIT 5"
        );
        $top_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once BASE_PATH . '/views/admin/dashboard.php';
    }
}
?>
