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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    if ($id !== null) {
        $citasModel->deleteCita($id);
        header('Location: citasAdmin.php');
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
    <title>Eliminar Cita</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>    
    <div class="container mt-4">
        <h1>Eliminar Cita</h1>
        <div class="alert alert-danger" role="alert">
            ¿Estás seguro de que quieres eliminar esta cita?
            <ul>
                <li>ID: <?= htmlspecialchars($cita['idCita']) ?></li>
                <li>Fecha: <?= htmlspecialchars($cita['fecha_cita']) ?></li>
                <li>Motivo: <?= htmlspecialchars($cita['motivo_cita']) ?></li>
                <li>Usuario: <?= htmlspecialchars($user['nombre'] . ' ' . $user['apellidos']) ?></li>
            </ul>
        </div>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <button type="submit" class="btn btn-danger">Eliminar Cita</button>
            <a href="citasAdmin.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
