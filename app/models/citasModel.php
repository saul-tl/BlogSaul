<?php 
class Citas {
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    // Obtener todas las citas
    public function getAllCitas() {
        $stmt = $this->pdo->prepare('SELECT * FROM citas');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una cita por su ID
    public function getCitaById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM citas WHERE idCita = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener citas de un usuario que aún no se han realizado
    public function getCitasUsuario($idUser) {
        $sql = "SELECT * FROM citas WHERE idUser = ? AND fecha_cita >= CURDATE() ORDER BY fecha_cita ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idUser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Añadir una nueva cita
    public function addCita($idUser, $fecha_cita, $motivo_cita) {
        if (strtotime($fecha_cita) < strtotime(date('Y-m-d'))) {
            return false;// No se permite añadir citas para fechas pasadas
        }
        $sql = "INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$idUser, $fecha_cita, $motivo_cita]);
    }

    // Actualizar una cita
    public function updateCita($idCita, $idUser, $fecha_cita, $motivo_cita) {
        $sql = "UPDATE citas SET idUser = ?, fecha_cita = ?, motivo_cita = ? WHERE idCita = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$idUser, $fecha_cita, $motivo_cita, $idCita]);
    }    

    // Eliminar una cita
    public function deleteCita($id) {
        $sql = "DELETE FROM citas WHERE idCita = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function getCitasPendientes($idUser) {
        $sql = "SELECT * FROM citas WHERE idUser = ? AND fecha_cita >= CURDATE() ORDER BY fecha_cita ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idUser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getHistorialCitas($idUser) {
        $sql = "SELECT * FROM citas WHERE idUser = ? AND fecha_cita < CURDATE() ORDER BY fecha_cita DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idUser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
