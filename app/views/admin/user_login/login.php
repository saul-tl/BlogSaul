<?php
require_once '../../../config/config.php';
require_once '../../../models/user_loginModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_loginModel = new user_login($pdo);

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';
    $user_loginModel = new user_login($pdo);
    $user = $user_loginModel->authenticateUser($usuario, $password);

    if ($user && password_verify($password, $user['password'])) {
        
        $_SESSION['idUser'] = $user['idUser'];
        $_SESSION['username'] = $user['usuario'];
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['role'] = $user['rol'];
    
        
        echo '<pre>Session Data: ';
        print_r($_SESSION);
        echo '</pre>';
    
        
        if ($user['rol'] === 'admin') {
            header("Location: ../../../../index.php");
        } else {
            header("Location: ../../../../index.php");
        }
        exit();
    } else {
        $error = 'Credenciales inválidas';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../public/styles/navbarWeb.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</head>
<body>
<?php include '../../common/navbarWeb.php'; ?>
    <div class="container mt-4">
        <h1>Iniciar Sesión</h1>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
        <div class="mt-3">
            <a href="forgot_password.php">¿Olvidaste tu contraseña?</a><br>
            <a href="register.php">Registrar</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../../public/js/navbarWeb.js"></script> 
</body>
</html>
