<?php
require_once '../../../config/config.php';
require_once '../../../models/citasModel.php';

session_start();
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}

$citasModel = new Citas($pdo);

// Acciones para añadir nueva cita
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fecha_cita']) && isset($_POST['motivo_cita'])) {
    $idUser = $_SESSION['idUser'];
    $fecha_cita = $_POST['fecha_cita'];
    $motivo_cita = $_POST['motivo_cita'];

    if ($fecha_cita >= date('Y-m-d')) {
        if ($citasModel->addCita($idUser, $fecha_cita, $motivo_cita)) {
            $citaSolution = "Se ha creado correctamente la cita";
        } else {
            $citasBad = "No se ha podido crear la cita";
        }
    } else {
        $citasBad = "No se puede crear una cita para una fecha anterior a la actual.";
    }
}

// Acciones para eliminar cita
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idCita'])) {
    if ($citasModel->deleteCita($_POST['idCita'])) {
        header('Location: index.php');
        exit;
    } else {
        $citasBad = "Error al intentar eliminar la cita";
    }
}

$citasPendientes = $citasModel->getCitasPendientes($_SESSION['idUser']);
$historialCitas = $citasModel->getHistorialCitas($_SESSION['idUser']);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">    
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">
    <style>
        .past-appointment {
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4">Gestión de Citas</h1>
        <?php if (!empty($citasBad)): ?>
            <div class="alert alert-danger"><?= $citasBad ?></div>
        <?php endif; ?>
        <?php if (!empty($citaSolution)): ?>
            <div class="alert alert-success"><?= $citaSolution ?></div>
        <?php endif; ?>
        <!-- Formulario para añadir nuevas citas -->
        <div class="card mb-4">
            <div class="card-header">Solicitar Nueva Cita</div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="fecha_cita" class="form-label">Fecha de la cita:</label>
                        <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" required>
                    </div>
                    <div class="mb-3">
                        <label for="motivo_cita" class="form-label">Motivo de la cita:</label>
                        <textarea class="form-control" id="motivo_cita" name="motivo_cita" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Solicitar Cita</button>
                </form>
            </div>
        </div>

        <!-- Listado de citas pendientes -->
        <h2 class="mb-3">Citas Pendientes</h2>
        <?php foreach ($citasPendientes as $cita): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Cita el <?= htmlspecialchars($cita['fecha_cita']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($cita['motivo_cita']) ?></p>
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <a type="button" class="btn btn-outline-primary" href="edit.php?id=<?= $cita['idCita'] ?>">Modificar</a>
                    <form action="" method="post" onsubmit="return confirm('¿Estás seguro que deseas eliminar esta cita?');">
                        <input type="hidden" name="idCita" value="<?= $cita['idCita']; ?>">
                        <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Historial de citas -->
        <h2 class="mb-3">Historial de Citas</h2>
        <?php foreach ($historialCitas as $cita): ?>
        <div class="card mb-3 past-appointment">
            <div class="card-body">
                <h5 class="card-title">Cita el <?= htmlspecialchars($cita['fecha_cita']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($cita['motivo_cita']) ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../../public/js/navbarWeb.js"></script> 
</body>
</html>
