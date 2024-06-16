<?php
class UserData{ 
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    //Metodo para obtener todos los usuarios
    public function getAllUsers() {
        $stmt = $this->pdo->prepare('SELECT idUser, nombre, apellidos, email FROM users_data');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id){
        $stmt = $this->pdo->prepare('SELECT * FROM users_data WHERE idUser =?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

     // Método para obtener el último ID insertado
    public function getLastInsertId() {
        return $this->pdo->lastInsertId();
    }

    //Metodo para añadir un nuevo usuario
    public function addUser($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo) {
        $sql = "INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo]);
    }
    
    //Metodo para eliminar un usuario
    public function deleteUser($id) {
        $sql = "DELETE FROM users_data WHERE idUser = ?";
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute([$id])) {
            echo "Usuario eliminado exitosamente";
        } else {
            echo "Error al eliminar el usuario"; 
        }
    }
    

    //Modificar un usuario
    public function updateUser($id, $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo) {
        $sql = "UPDATE users_data SET nombre = ?, apellidos = ?, email = ?, telefono = ?, fecha_nacimiento = ?, direccion = ?, sexo = ? WHERE idUser = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $id]);
    }    
}
?>