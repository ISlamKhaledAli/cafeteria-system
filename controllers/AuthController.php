<?php

require_once __DIR__."/../models/User.php";

class AuthController {

    private $userModel;

    public function __construct(){

        $this->userModel = new User();
    }

    public function login(){

        if($_SERVER['REQUEST_METHOD']=="POST"){

            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $user = $this->userModel->findUserByEmail($email);

            if($user && password_verify($password,$user['password'])){

                $_SESSION['user']=$user;
                if($user['role']=="admin"){
                    header("Location: /PHP/cafeteria-system/admin/users");
                } else {
                    header("Location: /PHP/cafeteria-system/");
                }
                exit;
            }

            $_SESSION['error'] = "Invalid Email or Password";
        }

        require __DIR__."/../views/auth/login.php";
    }

    public function register(){

        if($_SERVER['REQUEST_METHOD']=="POST"){

            if ($this->userModel->isEmailExists($_POST['email'])) {
                $_SESSION['error'] = "Email is already registered!";
                header("Location: /PHP/cafeteria-system/register");
                exit();
            }

            // $imageName = $this->uploadImageSecure($_FILES['image']);
            $imageName = isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE 
             ? $this->uploadImageSecure($_FILES['image']) 
             : 'default.png';
            $data = [
                "name"     => $_POST['name'],
                "email"    => $_POST['email'],
                "password" => $_POST['password'],
                "room_no"  => $_POST['room_no'],
                "ext"      => $_POST['ext'],
                "role"     => "user",
                "image"    => $imageName
            ];

            if ($this->userModel->createUser($data)) {
                $_SESSION['success'] = "Account created successfully! Please login.";
                header("Location: /PHP/cafeteria-system/login");
                exit;
            } else {
                $_SESSION['error'] = "Failed to create account. Please try again.";
                header("Location: /PHP/cafeteria-system/register");
                exit;
            }
        }

        require __DIR__."/../views/auth/register.php";
    }

    public function logout(){

        session_destroy();

        header("Location: /PHP/cafeteria-system/login");
        exit;
    }

    private function uploadImageSecure($file) {
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) return 'default.png';
        if ($file['size'] > 2097152) return 'default.png'; 

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        
        if (!in_array($mime, $allowedTypes)) return 'default.png';

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $targetFilePath = __DIR__ . '/../uploads/users/' . $fileName;

        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $fileName;
        }
        return 'default.png';
    }
}