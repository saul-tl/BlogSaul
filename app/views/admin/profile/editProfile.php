<?php
require_once '../../../config/config.php';
require_once '../../../models/user_dataModel.php';
require_once '../../../models/user_loginModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userDataModel = new UserData($pdo);
$userLoginModel = new user_login($pdo);

if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    header('Location: login.php');
    exit;
}

$user = $userLoginModel->getUserById($_SESSION['idUser']);
$userDetails = $userDataModel->getUserById($_SESSION['idUser']);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $sexo = $_POST['sexo'] ?? '';
    $currentPassword = $_POST['currentPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    
    if (!$currentPassword && !$newPassword && !$confirmPassword) {
        $userDataModel->updateUser($_SESSION['idUser'], $nombre, $apellidos, $telefono, $fecha_nacimiento, $direccion, $sexo);
        $success = 'Información personal actualizada correctamente.';
    }

    
    if ($currentPassword && $newPassword && $confirmPassword) {
        if (password_verify($currentPassword, $user['password'])) {
            if ($newPassword === $confirmPassword) {                
                $updateResult = $userLoginModel->updatePassword($_SESSION['idUser'], $newPassword);
                if ($updateResult) {
                    $success = 'Contraseña actualizada correctamente.';
                } else {
                    $error = 'Error al actualizar contraseña.';
                }
            } else {
                $error = 'Las contraseñas nuevas no coinciden.';
            }
        } else {
            $error = 'La contraseña actual no es correcta.';
        }
    }
          
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
<div class="container">
        <h2>Editar Perfil</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <form action="editProfile.php" method="POST">
            <div class="mb-3">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($userDetails['nombre']) ?>">
            </div>
            <div class="mb-3">
                <label for="apellidos">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= htmlspecialchars($userDetails['apellidos']) ?>">
            </div>
            <div class="mb-3">
                <label for="email">Correo Electrónico:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($userDetails['email']) ?>">
            </div>
            <div class="mb-3">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($userDetails['telefono']) ?>">
            </div>
            <div class="mb-3">
                <label for="currentPassword">Contraseña Actual:</label>
                <input type="password" class="form-control" id="currentPassword" name="currentPassword">
            </div>
            <div class="mb-3">
                <label for="newPassword">Nueva Contraseña:</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword">
            </div>
            <div class="mb-3">
                <label for="confirmPassword">Confirmar Nueva Contraseña:</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="../../../../public/js/navbarWeb.js"></script>
</body>
</html>
