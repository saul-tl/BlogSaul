<?php
require_once '../../../config/config.php';
require_once '../../../models/user_loginModel.php';

$user_loginModel = new user_login($pdo);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUser = $_SESSION['idUser'];
    $oldPassword = $_POST['oldPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $user = $user_loginModel->getUserById($idUser);

    if ($user && password_verify($oldPassword, $user['password'])) {
        $user_loginModel->updatePassword($idUser, $newPassword);
        echo "Contraseña actualizada con éxito.";
    } else {
        echo "La contraseña antigua es incorrecta.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Cambiar Contraseña</h1>
        <form action="change_password.php" method="POST">
            <div class="form-group">
                <label for="oldPassword">Contraseña Actual:</label>
                <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
            </div>
            <div class="form-group">
                <label for="newPassword">Nueva Contraseña:</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
            </div>
            <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
        </form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
