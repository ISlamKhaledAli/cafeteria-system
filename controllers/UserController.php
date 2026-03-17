<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function listUsers() {
        $users = $this->userModel->getAllUsers();
        require_once __DIR__ . '/../views/admin/users.php';
    }

    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'     => $_POST['name'],
                'email'    => $_POST['email'],
                'password' => $_POST['password'],
                'room'     => $_POST['room'],
                'ext'      => $_POST['ext'],
                'role'     => $_POST['role'] ?? 'user'
            ];

            $data['image'] = $this->uploadImage($_FILES['image']);

            if ($this->userModel->createUser($data)) {
                header("Location: /PHP/cafeteria-system/admin/users");
                exit();
            } else {
                echo "Error adding user!";
            }
        } else {
            require_once __DIR__ . '/../views/admin/add-user.php';
        }
    }

    public function editUser($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'  => $_POST['name'],
                'email' => $_POST['email'],
                'room'  => $_POST['room'],
                'ext'   => $_POST['ext'],
                'role'  => $_POST['role']
            ];

            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }

            if (!empty($_FILES['image']['name'])) {
                $data['image'] = $this->uploadImage($_FILES['image']);
            }

            if ($this->userModel->updateUser($id, $data)) {
                header("Location: /PHP/cafeteria-system/admin/users");
                exit();
            }
        } else {
            $user = $this->userModel->getUserById($id);
            require_once __DIR__ . '/../views/admin/edit-user.php';
        }
    }

    public function deleteUser($id) {
        $this->userModel->deleteUser($id);
        header("Location: /PHP/cafeteria-system/admin/users");
        exit();
    }

    private function uploadImage($file) {
        if (empty($file['name'])) {
            return 'default.png'; 
        }

        $targetDir = __DIR__ . '/../uploads/users/';
        
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . '_' . basename($file["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $fileName;
        }

        return 'default.png';  
    }
}
?>