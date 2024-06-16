<?php
require_once '../../../config/config.php';
require_once '../../../models/citasModel.php';
$citasModel = new Citas($pdo);
$citas = $citasModel->getAllCitas();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Citas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">        
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
    <div class="container mt-4">
        <h1>Listado de Citas</h1>
        <a href="create.php" class="btn btn-success mb-3">Agregar Nueva Cita</a>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Fecha de Cita</th>
                    <th>Motivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($citas) && is_array($citas)): ?>
                    <?php foreach ($citas as $cita): ?>
                    <tr>
                        <td><?= htmlspecialchars($cita['idCita']) ?></td>
                        <td><?= htmlspecialchars($cita['idUser']) ?></td>
                        <td><?= htmlspecialchars($cita['fecha_cita']) ?></td>
                        <td><?= htmlspecialchars($cita['motivo_cita']) ?></td>
                        <td>
                            <a href="show.php?id=<?= $cita['idCita'] ?>" class="btn btn-primary">Detalles</a>
                            <a href="edit.php?id=<?= $cita['idCita'] ?>" class="btn btn-warning">Editar</a>
                            <a href="delete.php?id=<?= $cita['idCita'] ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No hay citas disponibles para mostrar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <script src="../../../../public/js/navbarWeb.js"></script> 
</body>
</html>
