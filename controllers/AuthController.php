<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . '/../config/Database.php';

require_once __DIR__ . '/../mail/PHPMailer.php';
require_once __DIR__ . '/../mail/SMTP.php';
require_once __DIR__ . '/../mail/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* 🔥 دالة إرسال الإيميل */
function sendResetEmail($toEmail, $token) {

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mostafamohamedsalah25@gmail.com';
        $mail->Password = 'your_app_password'; // حط App Password هنا
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('mostafamohamedsalah25@gmail.com', 'Cafeteria');
        $mail->addAddress($toEmail);

$link = "http://localhost:8000/index.php?page=reset-password&token=$token";
        $mail->Subject = "Reset Password";
        $mail->Body = "
            <h3>Reset your password</h3>
            <p>Click the link below:</p>
            <a href='$link'>$link</a>
            <p>This link expires in 1 hour</p>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}

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
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . "/../uploads/users/";
                
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
                redirect('index.php?page=login');
            } else {
                $_SESSION['error'] = "System error during registration.";
                $_SESSION['show_register'] = true;
            }
        }
        require __DIR__ . "/../views/auth/auth.php";
    }

    /* 🔥 التعديل هنا */
    public function forgetPassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = trim($_POST['email']);
            $user = $this->userModel->findUserByEmail($email);

            if ($user) {

                $token = bin2hex(random_bytes(32));
                $db = Database::getInstance()->getConnection();

                // حذف القديم
                $db->prepare("DELETE FROM password_resets WHERE email = ?")
                   ->execute([$email]);

                // إضافة الجديد
                $stmt = $db->prepare("
                    INSERT INTO password_resets (email, token, expires_at)
                    VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))
                ");
                $stmt->execute([$email, $token]);

                // إرسال الإيميل
                sendResetEmail($email, $token);
            }

            $_SESSION['success'] = "If this email is registered, a password reset link has been sent to it.";
            redirect('index.php?page=forget-password');
        }

        require __DIR__ . "/../views/auth/forget-password.php";
    }

    public function resetPassword() {

    $token = $_GET['token'] ?? '';
    $db = Database::getInstance()->getConnection();

    // تحقق من التوكن
    $stmt = $db->prepare("
        SELECT * FROM password_resets 
        WHERE token = ? AND expires_at > NOW()
    ");
    $stmt->execute([$token]);
    $record = $stmt->fetch();

    if (!$record) {
        die("❌ Invalid or expired link");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        if (strlen($password) < 6) {
            $_SESSION['error'] = "Password must be at least 6 characters";
        } elseif ($password !== $confirm) {
            $_SESSION['error'] = "Passwords do not match";
        } else {

            $userModel = new User();
            $user = $userModel->findUserByEmail($record['email']);

            if ($user) {
                $userModel->updateUser($user['id'], [
                    'password' => $password
                ]);
            }

            // حذف التوكن
            $db->prepare("DELETE FROM password_resets WHERE email = ?")
               ->execute([$record['email']]);

            $_SESSION['success'] = "Password updated successfully!";
            redirect('index.php?page=login');
        }
    }

    require __DIR__ . '/../views/auth/reset-password.php';
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