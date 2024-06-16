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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    if ($id !== null) {
        $userDataModel->deleteUser($id);
        header('Location: user_DataAdmin.php');
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
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Eliminar Usuario</h1>
        <div class="alert alert-danger" role="alert">
            ¿Estás seguro de que quieres eliminar este usuario?
            <ul>
                <li>Nombre: <?= htmlspecialchars($user['nombre']) ?> <?= htmlspecialchars($user['apellidos']) ?></li>
                <li>Email: <?= htmlspecialchars($user['email']) ?></li>
            </ul>
        </div>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <button type="submit" class="btn btn-danger">Eliminar Usuario</button>
            <a href="user_DataAdmin.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
