<?php
require_once '../../../config/config.php';
require_once '../../../models/user_dataModel.php';

session_start();
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['role'] === null) {
    header('Location: ../../user_login/login.php');
    exit;
}

$userDataModel = new UserData($pdo);
$user = $userDataModel->getUserById($_SESSION['idUser']);

if (!$user) {
    echo "No se encontró la información del usuario.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">
    <link rel="stylesheet" href="../../../../public/styles/profile.css">

</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
<div class="container">
    <div class="profile-container">
        <div class="profile-header">            
            <h1><?= htmlspecialchars($user['nombre']) ?> <?= htmlspecialchars($user['apellidos']) ?></h1>
            <p><?= htmlspecialchars($user['email']) ?></p>
        </div>
        <div class="profile-info">
            <p><strong>Nombre:</strong> <?= htmlspecialchars($user['nombre']) ?></p>
            <p><strong>Apellidos:</strong> <?= htmlspecialchars($user['apellidos']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        </div>
        <div class="text-center">
            <a href="editProfile.php" class="btn btn-primary">Editar Perfil</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
