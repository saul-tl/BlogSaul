<?php
require_once '../../../config/config.php';
require_once '../../../models/noticiaModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

$noticiaModel = new Noticia($pdo);
$noticias = $noticiaModel->getAllNoticias();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Noticias</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">        
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
    <div class="container mt-4">
        <h1>Listado de Noticias</h1>
        <?php if ($is_admin): ?>
            <a href="create.php" class="btn btn-success mb-3">Agregar Nueva Noticia</a>
        <?php else: ?>
            <a href="../../../../index.php" class="btn btn-secondary mb-3">Volver al inicio</a>
        <?php endif; ?>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($noticias) && is_array($noticias)): ?>
                    <?php foreach ($noticias as $noticia): ?>
                    <tr>
                        <td><?= htmlspecialchars($noticia['idNoticia']) ?></td>
                        <td><?= htmlspecialchars($noticia['titulo']) ?></td>
                        <td><?= htmlspecialchars($noticia['fecha']) ?></td>
                        <td>
                            <a href="show.php?id=<?= $noticia['idNoticia'] ?>" class="btn btn-primary">Detalles</a>
                            <?php if ($is_admin): ?>
                                <a href="edit.php?id=<?= $noticia['idNoticia'] ?>" class="btn btn-warning">Editar</a>
                                <a href="delete.php?id=<?= $noticia['idNoticia'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de querer eliminar esta noticia?');">Eliminar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No hay noticias disponibles para mostrar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="../../../../public/js/navbarWeb.js"></script> 
</body>
</html>
