<?php
require_once '../../../config/config.php';
require_once '../../../models/user_dataModel.php';
require_once '../../../models/user_loginModel.php';

$id = $_GET['id'] ?? null;

if ($id === null) {
    echo "No se ha proporcionado un ID válido.";
    exit();
}

$userDataModel = new UserData($pdo);
$userLoginModel = new user_login($pdo);
$user = $userDataModel->getUserById($id);
$userLogin = $userLoginModel->getUserById($id);

if (!$user || !$userLogin) {
    echo "No se encontró el usuario con ID: " . htmlspecialchars($id);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $sexo = $_POST['sexo'] ?? '';
    $rol = $_POST['rol'] ?? 'user';

    try {
        $pdo->beginTransaction();
        $userDataModel->updateUser($id, $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo);
        $userLoginModel->updateUserRole($id, $rol);
        $pdo->commit();
        header('Location: user_DataAdmin.php');
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error al actualizar el usuario: " . $e->getMessage());
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">        
</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
    <div class="container mt-4">
        <h1>Editar Usuario</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($user['nombre']) ?>" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= htmlspecialchars($user['apellidos']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($user['telefono']) ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($user['fecha_nacimiento']) ?>" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($user['direccion']) ?>">
            </div>
            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <select class="form-control" id="sexo" name="sexo" required>
                    <option value="">Seleccione</option>
                    <option value="Masculino" <?= $user['sexo'] === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                    <option value="Femenino" <?= $user['sexo'] === 'Femenino' ? 'selected' : '' ?>>Femenino</option>
                </select>
            </div>
            <div class="form-group">
                <label for="rol">Rol:</label>
                <select class="form-control" id="rol" name="rol" required>
                    <option value="user" <?= $userLogin['rol'] === 'user' ? 'selected' : '' ?>>Usuario</option>
                    <option value="admin" <?= $userLogin['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
        </form>
        <a href="user_DataAdmin.php" class="btn btn-secondary mt-3">Cancelar</a>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
