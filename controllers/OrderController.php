<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderItem.php';

class OrderController {
    private $orderModel;
    private $orderItemModel;

    public function __construct() {
        $this->orderModel = new Order();
        $this->orderItemModel = new OrderItem();
    }

    public function confirmOrder() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        
        if (!$data) {
            $this->jsonResponse(false, 'Invalid order data received.');
        }

        $userId = $_SESSION['user']['id'] ?? ($data['user_id'] ?? null);
        $roomNo = $data['room_no'] ?? '';
        $notes = $data['notes'] ?? '';
        $items = $data['items'] ?? [];

        if (!$userId || empty($items)) {
            $this->jsonResponse(false, 'Required fields are missing.');
        }

        $total_price = 0;
        foreach ($items as $item) {
            $total_price += $item['price'] * $item['quantity'];
        }

        $orderId = $this->orderModel->createOrder($userId, $roomNo, $notes, $total_price);

        if ($orderId === false) {
        }

        if (is_string($orderId) && str_starts_with($orderId, 'ERROR:')) {
            $this->jsonResponse(false, 'Critical error: ' . $orderId);
        }

        if (!empty($orderId)) {
            $added = $this->orderItemModel->addItems($orderId, $items);
            if ($added === true) {
                $this->jsonResponse(true, 'Order confirmed successfully!', ['order_id' => $orderId]);
            } else {
                $this->jsonResponse(false, 'Order created but failed to add items: ' . (is_string($added) ? $added : ''));
            }
        } else {
            $error_str = var_export($orderId, true);
            $this->jsonResponse(false, 'Critical error: Failed to generate order. ID received was: ' . $error_str);
        }
    }

    public function myOrders() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            header('Location: index.php?page=login');
            exit;
        }

        $orders = $this->orderModel->getOrdersByUserId($userId);
        
        foreach ($orders as &$order) {
            $order['items'] = $this->orderItemModel->getItemsByOrderId($order['id']);
        }
        
        require_once BASE_PATH . '/views/user/my-orders.php';
    }

    public function adminOrders() {
        $orders = $this->orderModel->getAllOrders();

        foreach ($orders as &$order) {
            $order['items'] = $this->orderItemModel->getItemsByOrderId($order['id']);
        }

        require_once BASE_PATH . '/views/admin/orders.php';
    }

    public function adminUpdateOrderStatus() {
        $orderId = $_POST['order_id'] ?? null;
        $status = $_POST['status'] ?? null;

        $allowed = ['processing', 'out_for_delivery', 'delivered', 'canceled'];
        if (!$orderId || !in_array($status, $allowed, true)) {
            $_SESSION['error'] = "Invalid order update request.";
            header("Location: index.php?page=admin-orders");
            exit;
        }

        $ok = $this->orderModel->updateOrderStatus($orderId, $status);
        if ($ok) {
            $_SESSION['success'] = "Order status updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update order status.";
        }

        header("Location: index.php?page=admin-orders");
        exit;
    }

    public function adminChecks() {
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

        require_once BASE_PATH . '/views/admin/checks.php';
    }

    private function jsonResponse($success, $message, $data = []) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success, 
            'message' => $message, 
            'data'    => $data
        ]);
        exit;
    }
}
?>
