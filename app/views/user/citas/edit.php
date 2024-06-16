<?php
require_once '../../../config/config.php';
require_once '../../../models/citasModel.php';

session_start();
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}

// Instanciando el modelo de citas
$citasModel = new Citas($pdo);

// Verificar si hay una solicitud para obtener la cita por ID
if (isset($_GET['id'])) {
    $cita = $citasModel->getCitaById($_GET['id']);
}

// Verificar si el formulario ha sido enviado para actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idCita'])) {
    $fecha_cita = $_POST['fecha_cita'];
    $motivo_cita = $_POST['motivo_cita'];

    if (strtotime($fecha_cita) < strtotime(date('Y-m-d'))) {
        $error = "No se puede actualizar la cita a una fecha pasada.";
    } else {
        if ($citasModel->updateCita($_POST['idCita'], $_SESSION['idUser'], $fecha_cita, $motivo_cita)) {
            header('Location: citasUser.php');
            exit;
        } else {
            $error = "No se pudo actualizar la cita.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cita</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">            
</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
<div class="container mt-5">
    <h2>Editar Cita</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form action="" method="POST">
        <input type="hidden" name="idCita" value="<?= htmlspecialchars($cita['idCita']) ?>">
        <div class="mb-3">
            <label for="fecha_cita" class="form-label">Fecha de la cita:</label>
            <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" value="<?= htmlspecialchars($cita['fecha_cita']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="motivo_cita" class="form-label">Motivo de la cita:</label>
            <textarea class="form-control" id="motivo_cita" name="motivo_cita" required><?= htmlspecialchars($cita['motivo_cita']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
