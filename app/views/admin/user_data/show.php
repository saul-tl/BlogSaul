<?php
require_once '../../../config/config.php';
require_once '../../../models/user_dataModel.php';

$id = $_GET['id'] ?? null;

if ($id === null) {
    echo "No se ha proporcionado un ID válido.";
    exit();
}

$userDataModel = new UserData($pdo);
$user = $userDataModel->getUserById($id);

if (!$user) {
    echo "No se encontró el usuario con ID: " . htmlspecialchars($id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">        
</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
    <div class="container mt-4">
        <h1>Detalle del Usuario</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($user['nombre']) ?> <?= htmlspecialchars($user['apellidos']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Email: <?= htmlspecialchars($user['email']) ?></h6>
                <p class="card-text">Teléfono: <?= htmlspecialchars($user['telefono']) ?></p>
                <p class="card-text">Fecha de Nacimiento: <?= htmlspecialchars($user['fecha_nacimiento']) ?></p>
                <p class="card-text">Dirección: <?= htmlspecialchars($user['direccion']) ?></p>
                <p class="card-text">Sexo: <?= htmlspecialchars($user['sexo']) ?></p>
                <a href="edit.php?id=<?= htmlspecialchars($user['idUser']) ?>" class="btn btn-primary">Editar</a>
                <a href="delete.php?id=<?= htmlspecialchars($user['idUser']) ?>" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
        <a href="user_DataAdmin.php" class="btn btn-secondary mt-3">Volver al listado</a>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
