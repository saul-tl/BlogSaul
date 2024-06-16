<?php
require_once '../../../config/config.php';
require_once '../../../models/noticiaModel.php';
require_once '../../../models/user_dataModel.php';

session_start();
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['role'] !== 'user') {
    header('Location: ../../../views/admin/user_login/login.php');
    exit;
}

$noticiaModel = new Noticia($pdo);

$error = '';
$success = '';

// Procesar creación de noticias
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo'])) {
    $idUser = $_SESSION['idUser'];
    $titulo = $_POST['titulo'];
    $texto = $_POST['texto'];
    $fecha = date('Y-m-d'); // Fecha actual
    $imagen = $_FILES['imagen']['name']; // Nombre del archivo de imagen

    // Guardar imagen en el servidor
    $targetDir = "../../../../public/uploads/";
    $targetFile = $targetDir . basename($imagen);

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $targetFile)) {
        if ($noticiaModel->addNoticia($idUser, $titulo, $targetFile, $texto, $fecha)) {
            $success = "Noticia creada exitosamente.";
        } else {
            $error = "Error al crear la noticia.";
        }
    } else {
        $error = "Error al subir la imagen.";
    }
}

// Filtrar solo noticias del usuario logueado
$noticias = $noticiaModel->getNoticiasByUserId($_SESSION['idUser']);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">    
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">
    <style>
        .noticia-img {
            max-width: 70%;
            height: auto;
        }
        .img-container {
            max-width: 20%;
            margin: 0;
        }
    </style>
</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
<div class="container mt-5">
    <h1>Gestión de Noticias</h1>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <!-- Formulario para añadir nuevas noticias -->
    <div class="card mb-4">
        <div class="card-header">Agregar Nueva Noticia</div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                <div class="mb-3">
                    <label for="texto" class="form-label">Texto:</label>
                    <textarea class="form-control" id="texto" name="texto" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen:</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Noticia</button>
            </form>
        </div>
    </div>

    <!-- Listado de noticias del usuario -->
    <h2>Mis Noticias</h2>
    <?php if (empty($noticias)): ?>
        <p>No hay noticias creadas por ti. ¡Crea una nueva noticia para empezar a mostrar algo aquí!</p>
    <?php else: ?>
        <?php foreach ($noticias as $noticia): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($noticia['titulo']) ?></h5>                    
                    <div class="img-container">
                        <img src="<?= htmlspecialchars($noticia['imagen']) ?>" alt="Imagen de la noticia" class="img-fluid noticia-img mb-2">
                    </div>
                    <p class="card-text"><?= htmlspecialchars($noticia['texto']) ?></p>
                    <div><small class="text-muted">Fecha: <?= htmlspecialchars($noticia['fecha']) ?></small></div>
                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                        <a href="edit.php?id=<?= $noticia['idNoticia'] ?>" class="btn btn-outline-primary">Editar</a>
                        <a href="deleteNoticia.php?id=<?= $noticia['idNoticia'] ?>" class="btn btn-outline-danger" onclick="return confirm('¿Estás seguro de querer eliminar esta noticia?');">Eliminar</a>
                    </div>    
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
