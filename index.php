<?php
/**
 * Main Entry Point - Cafeteria System
 * Handles: Simple Routing (?page=...), Session, and Auth Middleware.
 */

// 1. Error Reporting (Development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Define Root Path for easy referencing
define('BASE_PATH', __DIR__);

// 4. Core Requirements
require_once BASE_PATH . '/config/Database.php';
require_once BASE_PATH . '/middleware/auth.php';
require_once BASE_PATH . '/controllers/UserController.php';
require_once BASE_PATH . '/controllers/AuthController.php';
require_once BASE_PATH . '/controllers/ProductController.php';
require_once BASE_PATH . '/controllers/OrderController.php';
require_once BASE_PATH . '/controllers/ReportController.php';
require_once BASE_PATH . '/controllers/CategoryController.php';
require_once BASE_PATH . '/controllers/RoomController.php';

// 5. Simple Routing Logic
$page = $_GET['page'] ?? 'home'; 

// User Controllers
$orderController = new OrderController();
$authController = new AuthController();
$productController = new ProductController();

// 6. Route Selection
switch ($page) {
    // --- Auth Routes ---
    case 'login':
        $authController->login();
        break;
    case 'register':
        $authController->register();
        break;
    case 'forget-password':
        require_once BASE_PATH . '/views/auth/forget-password.php';
        break;
    case 'logout':
        $authController->logout();
        break;

    // --- User Ordering Routes (Protected) ---
    case 'home':
        AuthMiddleware::checkUser();
        require_once BASE_PATH . '/views/user/home.php';
        break;

    case 'cart':
        AuthMiddleware::checkUser();
        require_once BASE_PATH . '/views/user/cart.php';
        break;

    case 'orders':
        AuthMiddleware::checkUser();
        $orderController->myOrders();
        break;

    case 'confirm-order':
        AuthMiddleware::checkUser();
        $orderController->confirmOrder();
        break;

    // --- Admin Routes ---
    case 'admin-dashboard':
        AuthMiddleware::checkAdmin();
        (new ReportController())->dashboard();
        break;

    case 'admin-users':
        AuthMiddleware::checkAdmin();
        (new UserController())->listUsers();
        break;

    case 'admin-add-user':
        AuthMiddleware::checkAdmin();
        (new UserController())->addUser();
        break;

    case 'admin-edit-user':
        AuthMiddleware::checkAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?page=admin-users");
            exit;
        }
        (new UserController())->editUser($id);
        break;

    case 'admin-delete-user':
        AuthMiddleware::checkAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?page=admin-users");
            exit;
        }
        (new UserController())->deleteUser($id);
        break;

    case 'admin-products':
        AuthMiddleware::checkAdmin();
        $productController->index();
        break;

    case 'admin-add-product':
        AuthMiddleware::checkAdmin();
        $productController->create();
        break;

    case 'admin-store-product':
        AuthMiddleware::checkAdmin();
        $productController->store();
        break;

    case 'admin-edit-product':
        AuthMiddleware::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productController->update();
        } else {
            $productController->edit();
        }
        break;

    case 'admin-delete-product':
        AuthMiddleware::checkAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?page=admin-products");
            exit;
        }
        $productController->delete($id);
        break;

    case 'admin-orders':
        AuthMiddleware::checkAdmin();
        $orderController->adminOrders();
        break;

    case 'admin-update-order-status':
        AuthMiddleware::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderController->adminUpdateOrderStatus();
        } else {
            header("Location: index.php?page=admin-orders");
            exit;
        }
        break;

    case 'admin-checks':
        AuthMiddleware::checkAdmin();
        $orderController->adminChecks();
        break;

    case 'admin-categories':
        AuthMiddleware::checkAdmin();
        (new CategoryController())->index();
        break;

    case 'admin-add-category':
        AuthMiddleware::checkAdmin();
        (new CategoryController())->store();
        break;

    case 'admin-delete-category':
        AuthMiddleware::checkAdmin();
        (new CategoryController())->delete();
        break;

    // --- Rooms Routes ---
    case 'admin-rooms':
        AuthMiddleware::checkAdmin();
        (new RoomController())->index();
        break;

    case 'admin-add-room':
        AuthMiddleware::checkAdmin();
        (new RoomController())->store();
        break;

    case 'admin-edit-room':
        AuthMiddleware::checkAdmin();
        (new RoomController())->update();
        break;

    case 'admin-delete-room':
        AuthMiddleware::checkAdmin();
        (new RoomController())->delete();
        break;

    // --- Default / 404 ---
    default:
        http_response_code(404);
        require_once BASE_PATH . '/views/404.php'; // Optional view or inline
        break;
}
?>