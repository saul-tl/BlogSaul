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
$usersIndexed = [];

foreach ($users as $user) {
    $usersIndexed[$user['idUser']] = $user;
}

$userDetails = $usersIndexed[$noticia['idUser']] ?? null;
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Noticia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">
    <style>
        .card-title {
            font-size: 1.75rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .card img {
            max-height: 400px;
            object-fit: cover;
            margin-bottom: 1rem;
            border-radius: 10px;
        }
        .card-subtitle {
            margin-bottom: 1rem;
        }
        .btn-container {
            margin-top: 1rem;
        }
        .btn-primary, .btn-danger, .btn-secondary {
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover, .btn-danger:hover, .btn-secondary:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
<div class="container mt-5">
    <h1>Detalles de la Noticia</h1>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($noticia['titulo']) ?></h5>
            <img src="<?= htmlspecialchars($noticia['imagen']) ?>" alt="Imagen de la noticia" class="img-fluid">
            <h6 class="card-subtitle mb-2 text-muted">Fecha: <?= htmlspecialchars($noticia['fecha']) ?></h6>                
            <?php if ($userDetails): ?>
                <p class="card-text"><small class="text-muted">Escrito por: <?= htmlspecialchars($userDetails['nombre'] . " " . $userDetails['apellidos']) ?></small></p>
            <?php else: ?>
                <p class="card-text"><small class="text-muted">Escrito por: Usuario desconocido</small></p>
            <?php endif; ?>
            <p class="card-text"><?= nl2br(htmlspecialchars($noticia['texto'])) ?></p>
            <?php if ($is_admin): ?>
                <div class="btn-container">
                    <a href="edit.php?id=<?= $noticia['idNoticia'] ?>" class="btn btn-primary">Editar</a>
                    <a href="deleteNoticia.php?id=<?= $noticia['idNoticia'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de querer eliminar esta noticia?');">Eliminar</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($is_admin): ?>
        <a href="../noticias/noticiasAdmin.php" class="btn btn-secondary">Volver al listado</a>
    <?php else: ?>
        <a href="../../../../index.php" class="btn btn-secondary">Volver al inicio</a>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
