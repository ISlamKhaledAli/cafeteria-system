<?php
 

class AuthMiddleware {

    public static function checkLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            redirect('index.php?page=login');
        }

        require_once __DIR__ . '/../config/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user']['id']]);
        if (!$stmt->fetch()) {
            session_unset();
            session_destroy();
            redirect('index.php?page=login');
        }
    }

    public static function checkAdmin() {
        self::checkLogin();
        
        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            http_response_code(403);
            redirect('index.php?page=403');
        }
    }

     public static function checkUser() {
        self::checkLogin();
         $role = $_SESSION['user']['role'] ?? '';
        if (!in_array($role, ['user', 'admin'])) {
            http_response_code(403);
            redirect('index.php?page=403');
        }
    }

}
?>