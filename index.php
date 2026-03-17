<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/middleware/auth.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/AuthController.php';

$request = $_SERVER['REQUEST_URI'] ?? '/';
$basePath = '/PHP/cafeteria-system'; 
$route = str_replace($basePath, '', $request);
$route = parse_url($route, PHP_URL_PATH);
$route = rtrim($route, '/');

$userController = new UserController();
$authController = new AuthController();

switch ($route) {
    case '/login':
        $authController->login();
        break;
    case '/register':
        $authController->register();
        break;
    case '/logout':
        $authController->logout();
        break;

    case '/admin/users':
        AuthMiddleware::checkAdmin();
        $userController->listUsers();
        break;
        
    case '/admin/add-user':
        AuthMiddleware::checkAdmin();
        $userController->addUser();
        break;

    case '/admin/edit-user':
        AuthMiddleware::checkAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) $userController->editUser($id);
        else echo "Error: User ID is missing!";
        break;

    case '/admin/delete-user':
        AuthMiddleware::checkAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) $userController->deleteUser($id);
        else echo "Error: User ID is missing!";
        break;

    case '':
    case '/':
        AuthMiddleware::checkLogin();
        echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
        echo "<h1>Welcome to Cafeteria, " . htmlspecialchars($_SESSION['user']['name']) . "!</h1>";
        if ($_SESSION['user']['role'] === 'admin') {
            echo "<br><a href='$basePath/admin/users' style='padding:10px 20px; background:#d97706; color:#fff; text-decoration:none; border-radius:5px;'>Go to Users Management</a>";
        }
        echo "<br><br><a href='$basePath/logout' style='color:red;'>Logout</a>";
        echo "</div>";
        break;

    default:
        http_response_code(404);
        echo "<h1 style='text-align:center; margin-top:50px;'>404 - Page Not Found</h1>";
        break;
}