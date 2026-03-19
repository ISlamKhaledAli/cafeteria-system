<?php
 

class AuthMiddleware {

    public static function checkLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }

         require_once __DIR__ . '/../config/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user']['id']]);
        if (!$stmt->fetch()) {
            session_unset();
            session_destroy();
            header("Location: index.php?page=login");
            exit;
        }
    }

    public static function checkAdmin() {
        self::checkLogin();
        
        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            http_response_code(403);
            die("<h1 style='text-align:center; color:red; margin-top:50px;'>403 Forbidden: Admins Only!</h1>");
        }
    }

     public static function checkUser() {
        self::checkLogin();
         $role = $_SESSION['user']['role'] ?? '';
        if (!in_array($role, ['user', 'admin'])) {
            http_response_code(403);
            die("<h1 style='text-align:center; color:red; margin-top:50px;'>403 Forbidden!</h1>");
        }
    }

}
?>