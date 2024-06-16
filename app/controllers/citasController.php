<?php
require_once '../config/config.php';
require_once '../models/citasModel.php';

class CitasController {
    private $citasModel;

    public function __construct() {
        $dsn = 'mysql:host='. DB_HOST .';dbname='. DB_NAME;
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->citasModel = new Citas($pdo);
    }
    public function addCita($idUser, $fecha_cita, $motivo_cita) {
        $sql = "INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$idUser, $fecha_cita, $motivo_cita]);
    }
    public function index() {
        $citas = $this->citasModel->getAllCitas();        
        require '../views/admin/citas/index.php';
    }

    public function show($id) {
        $cita = $this->citasModel->getCitaById($id);
        if ($cita) {
            $user = $this->userDataModel->getUserById($cita['idUser']);
            include '../views/admin/citas/show.php';
        } else {
            echo "No se encontró la cita con ID: $id";
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idUser = $_POST['idUser'] ?? '';
            $fecha_cita = $_POST['fecha_cita'] ?? '';
            $motivo_cita = $_POST['motivo_cita'] ?? '';
            $this->citasModel->addCita($idUser, $fecha_cita, $motivo_cita);
            header('Location: /citas');
        } else {
            include '../views/admin/citas/create.php';
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idUser = $_POST['idUser'] ?? '';
            $fecha_cita = $_POST['fecha_cita'] ?? '';
            $motivo_cita = $_POST['motivo_cita'] ?? '';
            $this->citasModel->updateCita($id, $idUser, $fecha_cita, $motivo_cita);
            header('Location: index.php');
            exit();
        } else {
            $cita = $this->citasModel->getCitaById($id);
            $user = $this->userDataModel->getUserById($cita['idUser']);
            $users = $this->userDataModel->getAllUsers();
            include '../views/admin/citas/edit.php';
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->citasModel->deleteCita($id);
            header('Location: ../views/admin/citas/index.php');
            exit();
        } else {
            $cita = $this->citasModel->getCitaById($id);
            if ($cita) {
                $user = $this->userDataModel->getUserById($cita['idUser']);
                include '../views/admin/citas/delete.php';
            } else {
                echo "No se encontró la cita con ID: $id";
            }
        }
    }
    
}
?>
