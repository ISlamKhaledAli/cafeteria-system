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

<<<<<<< HEAD
// ==========================================
// 1. Require Middleware & Controllers
// ==========================================
require_once __DIR__ . '/middleware/auth.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/OrderController.php'; // كنترولر الطلبات (Dev 4)
// require_once __DIR__ . '/controllers/AdminOrderController.php'; // (Dev 5) ضفها لما تدمج كوده

// ==========================================
// 2. Setup Routing Variables
// ==========================================
$request = $_SERVER['REQUEST_URI'] ?? '/';
$basePath = '/PHP/cafeteria-system'; 
$route = str_replace($basePath, '', $request);
$route = parse_url($route, PHP_URL_PATH);
$route = rtrim($route, '/');

// Instantiate Controllers
$userController = new UserController();
$authController = new AuthController();
$orderController = new OrderController();

// ==========================================
// 3. Routing Switch
// ==========================================
switch ($route) {
    // ------------------------------------------
    // Auth Routes (Dev 1)
    // ------------------------------------------
    case '/login':
=======
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
>>>>>>> 0289bb93717993938ae4d7f277d25ea1433930e8
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

<<<<<<< HEAD
    // ------------------------------------------
    // Admin: Users Management (Dev 3)
    // ------------------------------------------
    case '/admin/users':
        AuthMiddleware::checkAdmin();
        $userController->listUsers();
        break;
        
    case '/admin/add-user':
        AuthMiddleware::checkAdmin();
        $userController->addUser();
=======
    // --- User Ordering Routes (Protected) ---
    case 'home':
        AuthMiddleware::checkUser();
        require_once BASE_PATH . '/views/user/home.php';
>>>>>>> 0289bb93717993938ae4d7f277d25ea1433930e8
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
<<<<<<< HEAD
        if ($id) $userController->deleteUser($id);
        else echo "Error: User ID is missing!";
        break;
    
    // ------------------------------------------
    // Admin: Products Management (Dev 2)
    // ------------------------------------------
    case '/admin/products':
        AuthMiddleware::checkAdmin();
        $controller = new ProductController();
        $controller->index();
=======
        if (!$id) {
            header("Location: index.php?page=admin-users");
            exit;
        }
        (new UserController())->deleteUser($id);
>>>>>>> 0289bb93717993938ae4d7f277d25ea1433930e8
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

<<<<<<< HEAD
    // ------------------------------------------
    // Admin: Orders & Checks (Dev 5)
    // ------------------------------------------
    case '/admin/orders':
        AuthMiddleware::checkAdmin();
        // $adminOrderController->index();
        require_once __DIR__ . '/views/admin/orders.php';
        break;

    case '/admin/checks':
        AuthMiddleware::checkAdmin();
        // $reportController->index();
        require_once __DIR__ . '/views/admin/checks.php';
        break;

    // ------------------------------------------
    // User: Ordering System (Dev 4)
    // ------------------------------------------
    case '/home':
        AuthMiddleware::checkLogin();
        require_once __DIR__ . '/views/user/home.php';
        break;

    case '/cart':
        AuthMiddleware::checkLogin();
        require_once __DIR__ . '/views/user/cart.php';
        break;

    case '/my-orders':
        AuthMiddleware::checkLogin();
        require_once __DIR__ . '/views/user/my-orders.php';
        break;

    case '/confirmOrder':
        // هذا المسار يتم استدعاؤه بواسطة JavaScript (Fetch API) من ملف cart.js
        AuthMiddleware::checkLogin();
        $orderController->confirmOrder();
        break;

    // ------------------------------------------
    // Root Route (Redirect based on Role)
    // ------------------------------------------
    case '':
    case '/':
        AuthMiddleware::checkLogin();
        // توجيه ذكي بناءً على نوع المستخدم
        if ($_SESSION['user']['role'] === 'admin') {
            header("Location: $basePath/admin/users"); // يمكن تغييرها لـ /admin/orders لاحقاً
        } else {
            header("Location: $basePath/home");
        }
        exit();

    // ------------------------------------------
    // 404 Not Found
    // ------------------------------------------
    default:
        http_response_code(404);
        require_once __DIR__ . '/layouts/header.php';
        echo "<div class='container text-center mt-5 pt-5' style='min-height: 60vh;'>";
        echo "<h1 class='display-1 fw-bold' style='color: #d97706;'>404</h1>";
        echo "<h3 class='text-muted'>Page Not Found</h3>";
        echo "<p class='text-muted mb-4'>The page you are looking for doesn't exist or has been moved.</p>";
        echo "<a href='$basePath/' class='btn text-white' style='background-color: #d97706;'>Return to Home</a>";
        echo "</div>";
        require_once __DIR__ . '/layouts/footer.php';
=======
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
>>>>>>> 0289bb93717993938ae4d7f277d25ea1433930e8
        break;
}
?>