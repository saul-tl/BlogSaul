<?php
require_once '../config/config.php';
require_once '../models/user_dataModel.php';
require_once '../models/user_loginModel.php';

class ProfileController {
    private $userDataModel;

    public function __construct($pdo) {
        $this->userDataModel = new UserData($pdo);
    }

    // Visualización del perfil del usuario
    public function viewProfile() {
        session_start();
        if (!isset($_SESSION['isLoggedIn']) || $_SESSION['role'] !== 'user') {
            header('Location: /login.php'); // Redirige a login si no está logueado o no es un usuario regular.
            exit();
        }

        $userId = $_SESSION['user_id'];
        $userDetails = $this->userDataModel->getUserById($userId);

        include 'views/user/profile/viewProfile.php';
    }

    // Edición del perfil del usuario
public function editNum(closure) {
    session_start();
    if (!isset($_SESSION['isLoggedIn']) || $_SESSION['role'] !== 'user') {
        header('Location: /login.php'); // Redirige si no está logueado o no tiene permisos
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $currentPassword = $_POST['currentPassword'] ?? '';
        $newPassword = $_POST['newPassword'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        // Validar la contraseña actual antes de hacer cualquier cambio
        $user = $this->userDataModel->getUserById($_SESSION['idUser']);
        if (!password_verify($currentPassword, $user['password'])) {
            echo "La contraseña actual no es correcta.";
            return; // Detener la ejecución si la contraseña es incorrecta
        }

        // Actualizar contraseña si es necesario
        if ($newPassword && $newPassword === $confirmPassword) {            
            $this->user_loginModel->updatePassword($_SESSION['idUse'], password_hash($newPassword, PASSWORD_DEFAULT));
        }

        
        $updatedInfo = [
            'email' => $email,
            'telefono' => $telefono
        ];
        $this->userDataModel->updateUser($_SESSION['idUser'], $updatedInfo);
        
        header('Location: /profile.php'); 
        exit();
    }

    include 'loged/views/user/profile/editProfile.php';
}

}
