<?php 
class Noticia{
    private $pdo;
    public function __construct($pdo){
        $this->pdo = $pdo;
    }
    
    //Metodo para obtener todas las noticias
    public function getAllNoticias(){
        $stmt = $this->pdo->prepare('SELECT * FROM noticias');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addNoticiaAdmi($titulo, $imagen, $texto, $fecha, $idUser) {
        $sql = "INSERT INTO noticias (titulo, imagen, texto, fecha, idUser) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$titulo, $imagen, $texto, $fecha, $idUser]);
    }
    // Método para obtener noticias por id de usuario
    public function getNoticiasByUserId($idUser) {
        $stmt = $this->pdo->prepare('SELECT * FROM noticias WHERE idUser = ?');
        $stmt->execute([$idUser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addNoticia($idUser, $titulo, $imagen, $texto, $fecha) {
        try {
            $sql = "INSERT INTO noticias (idUser, titulo, imagen, texto, fecha) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$idUser, $titulo, $imagen, $texto, $fecha]);
            return true;
        } catch (PDOException $e) {           
            error_log("Error al añadir noticia: " . $e->getMessage());
            return false;
        }
    }
    public function updateNoticia($id, $titulo, $imagen, $texto, $fecha, $idUser) {
        $sql = "UPDATE noticias SET titulo = ?, imagen = ?, texto = ?, fecha = ?, idUser = ? WHERE idNoticia = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$titulo, $imagen, $texto, $fecha, $idUser, $id]);
    }
    public function getNoticiaById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM noticias WHERE idNoticia = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function deleteNoticia($id) {
        $sql = "DELETE FROM noticias WHERE idNoticia = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}
?>