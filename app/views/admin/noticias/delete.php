<?php
require_once '../../../config/config.php';
require_once '../../../models/noticiaModel.php';

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    if ($id !== null) {
        $noticiaModel->deleteNoticia($id);
        header('Location: noticiasAdmin.php');
        exit();
    } else {
        echo "No se ha proporcionado un ID válido para eliminar.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Noticia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">    
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">
</head>
<body>
<?php include '../../../../templates/navbarWeb.php' ?>
    <div class="container mt-4">
        <h1>Eliminar Noticia</h1>
        <div class="alert alert-danger" role="alert">
            ¿Estás seguro de que quieres eliminar esta noticia?
            <ul>
                <li>Título: <?= htmlspecialchars($noticia['titulo']) ?></li>
                <li>Fecha: <?= htmlspecialchars($noticia['fecha']) ?></li>
                <li>Texto: <?= htmlspecialchars($noticia['texto']) ?></li>
            </ul>
        </div>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <button type="submit" class="btn btn-danger">Eliminar Noticia</button>
            <a href="noticiasAdmin.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
