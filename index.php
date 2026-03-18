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
    case 'logout':
        $authController->logout();
        break;

    // --- User Ordering Routes (Protected) ---
    case 'home':
        AuthMiddleware::checkLogin(); // FIXED: Enforce login
        require_once BASE_PATH . '/views/user/home.php';
        break;

    case 'cart':
        AuthMiddleware::checkLogin(); // FIXED: Enforce login
        require_once BASE_PATH . '/views/user/cart.php';
        break;

    case 'orders':
        AuthMiddleware::checkLogin(); // FIXED: Enforce login
        $orderController->myOrders();
        break;

    case 'confirm-order':
        $orderController->confirmOrder();
        break;

    // --- Admin Routes ---
    case 'admin-users':
        AuthMiddleware::checkAdmin();
        (new UserController())->listUsers();
        break;

    case 'admin-products':
        AuthMiddleware::checkAdmin();
        $productController->index();
        break;

    // --- Default / 404 ---
    default:
        http_response_code(404);
        require_once BASE_PATH . '/views/404.php'; // Optional view or inline
        break;
}
?>