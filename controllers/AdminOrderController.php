<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderItem.php';

class AdminOrderController {
    private $orderModel;
    private $orderItemModel;

    public function __construct() {
        $this->orderModel = new Order();
        $this->orderItemModel = new OrderItem();
    }

    public function index() {
        $orders = $this->orderModel->getAllOrders();

        foreach ($orders as &$order) {
            $order['items'] = $this->orderItemModel->getItemsByOrderId($order['id']);
        }
        unset($order);

        require_once BASE_PATH . '/views/admin/orders.php';
    }

    public function updateStatus() {
        $orderId = $_POST['order_id'] ?? null;
        $status = $_POST['status'] ?? null;

        $allowed = ['processing', 'out_for_delivery', 'delivered', 'canceled'];
        
        if (!$orderId || !in_array($status, $allowed, true)) {
            $_SESSION['error'] = "Invalid order update request.";
            redirect('index.php?page=admin-orders');
        }

        $ok = $this->orderModel->updateOrderStatus($orderId, $status);
        if ($ok) {
            $_SESSION['success'] = "Order status updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update order status.";
        }

        redirect('index.php?page=admin-orders');
    }

    public function checks() {
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;

        if (!empty($startDate) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate)) {
            $startDate = null;
        }
        if (!empty($endDate) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $endDate)) {
            $endDate = null;
        }

        $orders = $this->orderModel->getOrdersBetweenDates($startDate, $endDate);

        $stats = [
            'total' => count($orders),
            'processing' => 0,
            'out_for_delivery' => 0,
            'delivered' => 0,
            'canceled' => 0,
        ];

        foreach ($orders as &$order) {
            $orderStatus = $order['status'] ?? '';
            if (isset($stats[$orderStatus])) $stats[$orderStatus]++;

            $order['items'] = $this->orderItemModel->getItemsByOrderId($order['id']);
        }
        unset($order);

        require_once BASE_PATH . '/views/admin/checks.php';
    }
}
?>