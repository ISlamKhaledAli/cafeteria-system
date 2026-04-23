<?php
 

require_once __DIR__ . "/../models/User.php";

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }
 
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $user = $this->userModel->findUserByEmail($email);

            $verified = false;
            if ($user) {
                 if (!empty($user['password']) && password_verify($password, $user['password'])) {
                    $verified = true;
                } else {
                     if (is_string($user['password']) && hash_equals($user['password'], $password)) {
                        $verified = true;
                        $this->userModel->updateUser($user['id'], ['password' => $password]);
                        $user = $this->userModel->findUserByEmail($email);
                    }
                }
            }

            if ($user && $verified) {
                $_SESSION['user'] = [
                    'id'    => $user['id'],
                    'name'  => $user['name'],
                    'email' => $user['email'],
                    'role'  => $user['role'],
                    'image' => $user['image']
                ];
                $_SESSION['user_id'] = $user['id'];

                if (($user['role'] ?? 'user') === 'admin') {
                    redirect('index.php?page=admin-dashboard');
                } else {
                    redirect('index.php?page=home');
                }
            }
            $_SESSION['error'] = "Authentication failed. Please check your credentials.";
        }
         require __DIR__ . "/../views/auth/auth.php";
    }

    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $email = trim($_POST['email']);
            
            if ($this->userModel->isEmailExists($email)) {
                $_SESSION['error'] = "This email is already registered.";
                $_SESSION['show_register'] = true;
                redirect('index.php?page=register');
            }

             $image_name = 'default.png';
            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $upload_dir = __DIR__ . "/../uploads/users/";
                
                 if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $file = $_FILES['image'];
                $allowed_extensions = ['jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif', 'webp' => 'image/webp'];
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($file['tmp_name']);

                if($file['size'] > 5242880) {
                    $_SESSION['error'] = "Image is too large (max 5MB).";
                    $_SESSION['show_register'] = true;
                    redirect('index.php?page=register');
                } elseif (!in_array($mime, $allowed_extensions)) {
                    $_SESSION['error'] = "Invalid image type. Allowed: JPG, PNG, GIF, WEBP.";
                    $_SESSION['show_register'] = true;
                    redirect('index.php?page=register');
                } else {
                    $ext = array_search($mime, $allowed_extensions, true);
                    $unique_name = time() . "_" . bin2hex(random_bytes(8)) . "." . $ext;
                    if (move_uploaded_file($file['tmp_name'], $upload_dir . $unique_name)) {
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
                redirect('index.php?page=login');
            } else {
                $_SESSION['error'] = "System error during registration.";
                $_SESSION['show_register'] = true;
            }
        }
        require __DIR__ . "/../views/auth/auth.php";
    }

    public function forgetPassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            
            $_SESSION['success'] = "If this email is registered, a password reset link has been sent to it.";
            
            redirect('index.php?page=forget-password');
        }
        require __DIR__ . "/../views/auth/forget-password.php";
    }

   
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = array();
        session_unset();
        session_destroy();
        redirect('index.php?page=login');
    }
}
?>