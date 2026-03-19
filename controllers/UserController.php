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
                'name'     => $_POST['name']    ?? '',
                'email'    => $_POST['email']   ?? '',
                'password' => $_POST['password'] ?? '',
                'room'  => $_POST['room_no'] ?? '',
                'ext'      => $_POST['ext']     ?? '',
                'role'     => $_POST['role']    ?? 'user'
            ];

            if ($this->userModel->isEmailExists($data['email'])) {
                $_SESSION['error'] = "This email is already registered!";
                redirect('index.php?page=admin-add-user');
            }

            $data['image'] = $this->uploadImage($_FILES['image'] ?? null);

            if ($this->userModel->createUser($data)) {
                $_SESSION['success'] = "User added successfully!";
                redirect('index.php?page=admin-users');
            } else {
                $_SESSION['error'] = "Error adding user!";
                redirect('index.php?page=admin-add-user');
            }
        } else {
            require_once __DIR__ . '/../views/admin/add-user.php';
        }
    }

    public function editUser($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'    => $_POST['name']    ?? '',
                'email'   => $_POST['email']   ?? '',
                'room' => $_POST['room_no'] ?? '',
                'ext'     => $_POST['ext']     ?? '',
                'role'    => $_POST['role']    ?? 'user'
            ];

            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }

            $oldUser = $this->userModel->getUserById($id);

            // Prevent downgrading the last admin
            if ($oldUser['role'] === 'admin' && $data['role'] !== 'admin') {
                if ($this->userModel->countAdmins() <= 1) {
                    $_SESSION['error'] = "Cannot downgrade the last admin in the system!";
                    redirect("index.php?page=admin-edit-user&id=$id");
                }
            }

            if (!empty($_FILES['image']['name'])) {
                $newImage = $this->uploadImage($_FILES['image']);
                if ($newImage && $newImage !== 'default.png') {
                    $data['image'] = $newImage;
                    if (!empty($oldUser['image']) && $oldUser['image'] !== 'default.png') {
                        $oldPath = __DIR__ . '/../uploads/users/' . $oldUser['image'];
                        if (file_exists($oldPath)) unlink($oldPath);
                    }
                }
            }

            if ($this->userModel->updateUser($id, $data)) {
                $_SESSION['success'] = "User updated successfully!";
                redirect('index.php?page=admin-users');
            } else {
                $_SESSION['error'] = "Error updating user!";
                redirect("index.php?page=admin-edit-user&id=$id");
            }
        } else {
            $user = $this->userModel->getUserById($id);
            require_once __DIR__ . '/../views/admin/edit-user.php';
        }
    }

    public function deleteUser($id) {
        $user = $this->userModel->getUserById($id);

        if ($user && $user['role'] === 'admin') {
            if ($this->userModel->countAdmins() <= 1) {
                $_SESSION['error'] = "Cannot delete the last admin in the system!";
                redirect('index.php?page=admin-users');
            }
        }

        if ($user && !empty($user['image']) && $user['image'] !== 'default.png') {
            $imagePath = __DIR__ . '/../uploads/users/' . $user['image'];
            if (file_exists($imagePath)) unlink($imagePath);
        }

        $this->userModel->deleteUser($id);
        $_SESSION['success'] = "User deleted successfully!";
        redirect('index.php?page=admin-users');
    }

    private function uploadImage($file) {
         if (!isset($file) || !isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK || empty($file['name'])) {
            return 'default.png';
        }

        if ($file['size'] > 2097152) {
            return 'default.png';  
        }

        $allowedTypes = [
            'jpg'  => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'webp' => 'image/webp'
        ];

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime  = $finfo->file($file['tmp_name']);
        $ext   = array_search($mime, $allowedTypes, true);

        if ($ext === false) {
            return 'default.png';  
        }

        $targetDir = __DIR__ . '/../uploads/users/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName       = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return $fileName;
        }

        return 'default.png';
    }
}
?>