<?php
require_once '../config/config.php';
require_once '../models/noticiaModel.php';

class NoticiasController {
    private $noticiasModel;

    public function __construct($pdo) {
        $this->noticiasModel = new Noticia($pdo);
    }

    public function index() {
        $noticias = $this->noticiasModel->getAllNoticias();
        include '../views/admin/noticias/index.php';
    }

    public function show($id) {
        $noticia = $this->noticiasModel->getNoticiaById($id);
        if ($noticia) {
            include '../views/admin/noticias/show.php';
        } else {
            echo "No se encontró la noticia con ID: $id";
        }
    }

    public function create($id) {
        session_start();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: error.php?error=accessDenied");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $titulo = $_POST['titulo'] ?? '';
            $imagen = $_POST['imagen'] ?? '';
            $texto = $_POST['texto'] ?? '';
            $fecha = $_POST['fecha'] ?? '';
            $idUser = $_POST['idUser'] ?? '';

            try {
                $this->noticiasModel->addNoticia($titulo, $imagen, $texto, $fecha, $idUser);
                header('Location: index.php');
                exit();
            } catch (Exception $e) {
                die("Error al crear la noticia: " . $e->getMessage());
            }
        } else {
            $users = $this->userDataModel->getAllUsers();
            include '../views/admin/noticias/create.php';
        }
    }

    public function update($id) {
        session_start();

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: error.php?error=accessDenied");
            exit;
        }        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $titulo = $_POST['titulo'] ?? '';
            $imagen = $_POST['imagen'] ?? '';
            $texto = $_POST['texto'] ?? '';
            $fecha = $_POST['fecha'] ?? '';
            $idUser = $_POST['idUser'] ?? '';

            try {
                $this->noticiasModel->updateNoticia($id, $titulo, $imagen, $texto, $fecha, $idUser);
                header('Location: index.php');
                exit();
            } catch (Exception $e) {
                die("Error al actualizar la noticia: " . $e->getMessage());
            }
        } else {
            $noticia = $this->noticiasModel->getNoticiaById($id);
            $users = $this->userDataModel->getAllUsers();
            include '../views/admin/noticias/update.php';
        }
    }

    public function delete($id) {
        session_start();

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: error.php?error=accessDenied");
            exit;
        }        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->noticiasModel->deleteNoticia($id);
            header('Location: index.php');
            exit();
        } else {
            $noticia = $this->noticiasModel->getNoticiaById($id);
            if ($noticia) {
                include '../views/admin/noticias/delete.php';
            } else {
                echo "No se encontró la noticia con ID: $id";
            }
        }
    }
}
?>
