<?php
require_once '../config/config.php';
require_once '../models/user_dataModel.php';

class UserDataController {
    private $userDataModel;

    public function __construct($pdo) {
        $this->userDataModel = new UserData($pdo);
    }

    public function index() {
        session_start();
        if ($_SESSION['role'] !== 'admin') {
            header('Location: /error.php?error=accessDenied'); 
            exit();
        }
        $noticias = $this->noticiasModel->getAllNoticias();
        include '../views/admin/noticias/index.php';
    }
    


    public function show($id) {
        $user = $this->userDataModel->getUserById($id);
        if ($user) {
            include __DIR__ . '/../views/admin/user_data/show.php';
        } else {
            echo "No se encontró el usuario con ID: " . htmlspecialchars($id);
        }
    }    

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $apellidos = $_POST['apellidos'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $sexo = $_POST['sexo'] ?? '';
            $this->userDataModel->addUser($nombre, $apellidos, $telefono, $fecha_nacimiento, $direccion, $sexo);
            header('Location: /user_data');
        } else {
            include 'views/admin/user_data/create.php';
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $apellidos = $_POST['apellidos'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $sexo = $_POST['sexo'] ?? '';
            $this->userDataModel->updateUser($id, $nombre, $apellidos, $telefono, $fecha_nacimiento, $direccion, $sexo);
            header('Location: /user_data');
        } else {
            $userData = $this->userDataModel->getUserById($id);
            include 'views/admin/user_data/update.php';
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id !== null) {
                echo "ID recibido para eliminar: " . htmlspecialchars($id); 
                $this->userDataModel->deleteUser($id);
                echo "Eliminación completada."; 
                header('Location: index.php');
                exit();
            } else {
                echo "No se ha proporcionado un ID válido para eliminar.";
            }
        } else {
            $user = $this->userDataModel->getUserById($id);
            include __DIR__ . 'views/admin/user_data/delete.php';
        }
    }
}
?>
