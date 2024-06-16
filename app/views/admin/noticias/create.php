<?php
require_once '../../../config/config.php';
require_once '../../../models/noticiaModel.php';
require_once '../../../models/user_dataModel.php';

$userDataModel = new UserData($pdo);
$users = $userDataModel->getAllUsers();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$noticiaModel = new Noticia($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $texto = $_POST['texto'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $idUser = $_POST['idUser'] ?? '';

    $target_dir = "../../../../public/uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);

    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        try {
            $noticiaModel->addNoticiaAdmi($titulo, $target_file, $texto, $fecha, $idUser);
            header('Location: noticiasAdmin.php');
            exit();
        } catch (Exception $e) {
            die("Error al crear la noticia: " . $e->getMessage());
        }
    } else {
        die("Error al mover la imagen subida.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nueva Noticia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">    
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">
</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
    <div class="container mt-4">
        <h1>Agregar Nueva Noticia</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" class="form-control" id="imagen" name="imagen" required>
            </div>
            <div class="form-group">
                <label for="texto">Texto:</label>
                <textarea class="form-control" id="texto" name="texto" required></textarea>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="idUser">Autor:</label>
                <select class="form-control" id="idUser" name="idUser" required>
                    <option value="">Seleccione un autor</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= htmlspecialchars($user['idUser']) ?>">
                            <?= htmlspecialchars($user['nombre'] . ' ' . $user['apellidos']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Guardar Noticia</button>
        </form>
        <a href="noticiasAdmin.php" class="btn btn-secondary mt-3">Cancelar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
