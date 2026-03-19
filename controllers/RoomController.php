<?php
require_once __DIR__ . '/../models/Room.php';

class RoomController {
    private $roomModel;

    public function __construct() {
        $this->roomModel = new Room();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        $rooms = $this->roomModel->getAllRooms();
        require_once __DIR__ . '/../views/admin/rooms.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            if (!empty($name)) {
                try {
                    $this->roomModel->createRoom($name);
                    $_SESSION['success'] = "Room added successfully.";
                } catch (PDOException $e) {
                    $_SESSION['error'] = "Room already exists or error occurred.";
                }
            } else {
                $_SESSION['error'] = "Room name cannot be empty.";
            }
        }
        header('Location: index.php?page=admin-rooms');
        exit;
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = trim($_POST['name'] ?? '');
            if ($id && !empty($name)) {
                try {
                    $this->roomModel->updateRoom($id, $name);
                    $_SESSION['success'] = "Room updated successfully.";
                } catch (PDOException $e) {
                    $_SESSION['error'] = "Room name already exists or error occurred.";
                }
            } else {
                $_SESSION['error'] = "Invalid data provided.";
            }
        }
        header('Location: index.php?page=admin-rooms');
        exit;
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $this->roomModel->deleteRoom($id);
                $_SESSION['success'] = "Room deleted successfully.";
            } else {
                $_SESSION['error'] = "Invalid room ID.";
            }
        }
        header('Location: index.php?page=admin-rooms');
        exit;
    }
}
?>
