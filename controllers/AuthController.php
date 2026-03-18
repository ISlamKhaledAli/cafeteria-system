<?php
/**
 * Auth Controller - Cafeteria System
 * UPDATED: Serves unified animated auth.php view.
 */

require_once __DIR__ . "/../models/User.php";

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * Handle Login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $user = $this->userModel->findUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id'    => $user['id'],
                    'name'  => $user['name'],
                    'email' => $user['email'],
                    'role'  => $user['role'],
                    'image' => $user['image']
                ];
                $_SESSION['user_id'] = $user['id'];

                header("Location: index.php?page=home");
                exit;
            }
            $_SESSION['error'] = "Authentication failed. Please check your credentials.";
        }
        // FIXED: Universal auth view
        require __DIR__ . "/../views/auth/auth.php";
    }

    /**
     * Handle Registration
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $email = trim($_POST['email']);
            
            if ($this->userModel->isEmailExists($email)) {
                $_SESSION['error'] = "This email is already registered.";
                $_SESSION['show_register'] = true;
                header("Location: index.php?page=register");
                exit();
            }

            // --- Handle Image Upload (Optional) ---
            $image_name = 'default.png';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . "/../uploads/users/";
                
                // Ensure directory exists
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $file_tmp = $_FILES['image']['tmp_name'];
                $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($file_ext, $allowed_extensions)) {
                    $unique_name = time() . "_" . uniqid() . "." . $file_ext;
                    if (move_uploaded_file($file_tmp, $upload_dir . $unique_name)) {
                        $image_name = $unique_name;
                    }
                }
            }

            $data = [
                "name"     => $_POST['name'],
                "email"    => $email,
                "password" => $_POST['password'],
                "room_no"  => 'Lobby',
                "ext"      => '',
                "role"     => "user",
                "image"    => $image_name
            ];

            if ($this->userModel->createUser($data)) {
                $_SESSION['success'] = "Welcome to the family! Please sign in.";
                header("Location: index.php?page=login");
                exit;
            } else {
                $_SESSION['error'] = "System error during registration.";
                $_SESSION['show_register'] = true;
            }
        }
        require __DIR__ . "/../views/auth/auth.php";
    }

    /**
     * Handle Logout
     */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = array();
        session_unset();
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
?>