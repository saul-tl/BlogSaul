<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/user_loginModel.php';
require_once __DIR__ . '/../models/user_dataModel.php';

class user_loginController {
    private $user_loginModel;
    private $user_dataModel;

    public function __construct($pdo) {
        $this->user_loginModel = new user_login($pdo);
        $this->user_dataModel = new UserData($pdo);
    }

    public function login() {
        session_start(); // Inicia sesión
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = $_POST['usuario'] ?? '';
            $password = $_POST['password'] ?? '';
    
            $user = $this->user_loginModel->authenticateUser($usuario);
    
            if ($user && password_verify($password, $user['password'])) {
                
                $_SESSION['user_id'] = $user['idUser'];
                $_SESSION['username'] = $user['usuario'];
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['role'] = $user['rol'];
    
                
                echo '<pre>Session Data: ';
                print_r($_SESSION);
                echo '</pre>';
    
                // Redireccionar según el rol
                if ($user['rol'] === 'admin') {
                    header("Location: ../../../../templates/index.php");
                } else {
                    header("Location: ../citas/index.php");
                }
                exit();
            } else {
                // Si las credenciales son incorrectas, manejar el error
                $error = 'Credenciales inválidas';
                include 'views/user_login/login.php';
            }
        } else {
            
            include 'views/user_data/login.php';
        }
    } 
    echo '<pre>Logged In: ' . $_SESSION['isLoggedIn'] . "\n";
    echo 'Role: ' . $_SESSION['role'] . "\n";
    echo 'Username: ' . $_SESSION['username'] . '</pre>';

    public function delete($id) {
        if ($_SESSION['role'] !== 'admin') {
            // Si no es admin, no permite la acción y redirige o muestra un mensaje
            header("Location: /unauthorized.php");
            exit();
        }
        // Continúa con la eliminación si es admin
        $this->model->deleteById($id);
        header("Location: /items/list");
    }
    
    public function logout() {
        session_start();
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        session_destroy();
        header('Location: /login');
        exit();
    }
    

    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idUser = $_SESSION['idUser'];
            $oldPassword = $_POST['oldPassword'] ?? '';
            $newPassword = $_POST['newPassword'] ?? '';
            $user = $this->user_loginModel->getUserById($idUser);
            if ($user && password_verify($oldPassword, $user['password'])) {
                $this->user_loginModel->updatePassword($idUser, $newPassword);
                echo "Contraseña actualizada con éxito.";
            } else {
                echo "La contraseña antigua es incorrecta.";
            }
        } else {
            include __DIR__ . '/../views/user_login/change_password.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $apellidos = $_POST['apellidos'] ?? '';
            $email = $_POST['email'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $sexo = $_POST['sexo'] ?? '';
            $usuario = $_POST['usuario'] ?? '';
            $password = $_POST['password'] ?? '';
            $rol = $_POST['rol'] ?? 'user';
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            try {
                $this->user_dataModel->addUser($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo);
                $idUser = $this->user_dataModel->getLastInsertId();
                $this->user_loginModel->registerUser($idUser, $usuario, $hashedPassword, $rol);
                header('Location: /login');
                exit();
            } catch (Exception $e) {
                die("Error al registrar el usuario: " . $e->getMessage());
            }
        } else {
            include __DIR__ . '/../views/user_login/register.php';
        }
    }    
}
?>
