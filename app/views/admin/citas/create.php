<?php
require_once '../../../config/config.php';
require_once '../../../models/citasModel.php';
require_once '../../../models/user_dataModel.php';

$citasModel = new Citas($pdo);
$userDataModel = new UserData($pdo);
$users = $userDataModel->getAllUsers();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUser = $_POST['idUser'] ?? '';
    $fecha_cita = $_POST['fecha_cita'] ?? '';
    $motivo_cita = $_POST['motivo_cita'] ?? '';

    
    $fecha_actual = date('Y-m-d');
    if ($fecha_cita < $fecha_actual) {
        $error = "La fecha de la cita no puede ser anterior a la fecha actual.";
    } else {
        try {
            $citasModel->addCita($idUser, $fecha_cita, $motivo_cita);
            header('Location: citasAdmin.php');
            exit();
        } catch (Exception $e) {
            $error = "Error al agregar la cita: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nueva Cita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechaCitaInput = document.getElementById('fecha_cita');
            const today = new Date().toISOString().split('T')[0];
            fechaCitaInput.setAttribute('min', today);
        });
    </script>
</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
    <div class="container mt-4">
        <h1>Agregar Nueva Cita</h1>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="idUser">Usuario:</label>
                <select class="form-control" id="idUser" name="idUser" required>
                    <option value="">Seleccione un usuario</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= htmlspecialchars($user['idUser']) ?>">
                            <?= htmlspecialchars($user['nombre'] . ' ' . $user['apellidos']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_cita">Fecha de Cita:</label>
                <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" required>
            </div>
            <div class="form-group">
                <label for="motivo_cita">Motivo de la Cita:</label>
                <textarea class="form-control" id="motivo_cita" name="motivo_cita" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Guardar Cita</button>
        </form>
        <a href="citasAdmin.php" class="btn btn-secondary mt-3">Cancelar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
