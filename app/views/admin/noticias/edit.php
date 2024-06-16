<?php
require_once '../../../config/config.php';
require_once '../../../models/noticiaModel.php';
require_once '../../../models/user_dataModel.php';

$id = $_GET['id'] ?? null;

if ($id === null) {
    echo "No se ha proporcionado un ID válido.";
    exit();
}

$noticiaModel = new Noticia($pdo);
$noticia = $noticiaModel->getNoticiaById($id);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!$noticia) {
    echo "No se encontró la noticia con ID: " . htmlspecialchars($id);
    exit();
}

$userDataModel = new UserData($pdo);
$users = $userDataModel->getAllUsers();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $texto = $_POST['texto'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $idUser = $_POST['idUser'] ?? '';

    $target_file = $noticia['imagen'];

    if (!empty($_FILES["imagen"]["tmp_name"])) {
        $target_dir = "../../../../public/uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);

        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            $error = "Error al mover la imagen subida.";
        }
    }

    if (empty($error)) {
        try {
            $noticiaModel = new Noticia($pdo);
            $noticiaModel->updateNoticia($id, $titulo, $target_file, $texto, $fecha, $idUser);
            header('Location: noticiasAdmin.php');
            exit();
        } catch (Exception $e) {
            $error = "Error al crear la noticia: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Noticia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">    
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">
</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
    <div class="container mt-4">
        <h1>Editar Noticia</h1>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($noticia['titulo']) ?>" required>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" class="form-control" id="imagen" name="imagen">
                <img src="<?= htmlspecialchars($noticia['imagen']) ?>" alt="Imagen actual" class="img-fluid mt-2" style="max-width: 300px;">
            </div>
            <div class="form-group">
                <label for="texto">Texto:</label>
                <textarea class="form-control" id="texto" name="texto" required><?= htmlspecialchars($noticia['texto']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="<?= htmlspecialchars($noticia['fecha']) ?>" required>
            </div>
            <div class="form-group">
                <label for="idUser">Autor:</label>
                <select class="form-control" id="idUser" name="idUser" required>
                    <option value="">Seleccione un autor</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= htmlspecialchars($user['idUser']) ?>" <?= $user['idUser'] == $noticia['idUser'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($user['nombre'] . ' ' . $user['apellidos']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Noticia</button>
        </form>
        <a href="noticiasAdmin.php" class="btn btn-secondary mt-3">Cancelar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
