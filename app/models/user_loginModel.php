<?php
class user_login {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para autenticar un usuario
    public function authenticateUser($username, $password) {
        $sql = "SELECT idUser, usuario, password, rol FROM user_login WHERE usuario = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }
            
    // Método para registrar un usuario
    public function registerUser($idUser, $username, $password, $rol) {
        $sql = "INSERT INTO user_login (idUser, usuario, password, rol) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idUser, $username, $password, $rol]);
    }

    // Método para actualizar la contraseña del usuario
    public function updatePassword($idUser, $password) {        
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user_login SET password = ? WHERE idUser = ?";
        $stmt = $this->pdo->prepare($sql);
        if (!$stmt->execute([$hash, $idUser])) {
            echo 'Error actualizando contraseña: ' . implode(",", $stmt->errorInfo());
            return false; 
        }
        return true;
    }
    // Método para actualizar el rol del usuario
    public function updateUserRole($idUser, $rol) {
        $sql = "UPDATE user_login SET rol = ? WHERE idUser = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$rol, $idUser]);
    }
    
    // Método para verificar si un usuario ya existe
    public function checkIfUserExists($usuario) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM user_login WHERE usuario = ?");
        $stmt->execute([$usuario]);
        return $stmt->fetchColumn() > 0;
    }

    // Método para recuperar información del login de un usuario
    public function getUserById($idUser) {
        $sql = "SELECT * FROM user_login WHERE idUser = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idUser]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
