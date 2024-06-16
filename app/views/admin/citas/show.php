<?php
require_once '../../../config/config.php';
require_once '../../../models/citasModel.php';
require_once '../../../models/user_dataModel.php';

$id = $_GET['id'] ?? null;

if ($id === null) {
    echo "No se ha proporcionado un ID válido.";
    exit();
}

$citasModel = new Citas($pdo);
$cita = $citasModel->getCitaById($id);

if (!$cita) {
    echo "No se encontró la cita con ID: " . htmlspecialchars($id);
    exit();
}

$userDataModel = new UserData($pdo);
$user = $userDataModel->getUserById($cita['idUser']);

if (!$user) {
    echo "No se encontró el usuario con ID: " . htmlspecialchars($cita['idUser']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Cita</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
    <div class="container mt-4">
        <h1>Detalle de Cita</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Cita #<?= htmlspecialchars($cita['idCita']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Fecha: <?= htmlspecialchars($cita['fecha_cita']) ?></h6>
                <p class="card-text">Motivo: <?= htmlspecialchars($cita['motivo_cita']) ?></p>
                <p class="card-text">Usuario: <?= htmlspecialchars($user['nombre'] . ' ' . $user['apellidos']) ?></p>
                <a href="edit.php?id=<?= htmlspecialchars($cita['idCita']) ?>" class="btn btn-primary">Editar</a>
                <a href="delete.php?id=<?= htmlspecialchars($cita['idCita']) ?>" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
        <a href="citasAdmin.php" class="btn btn-secondary mt-3">Volver al listado</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
