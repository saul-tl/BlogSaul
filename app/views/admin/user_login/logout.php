<?php
session_start();


session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de login
header("Location: http://localhost/Portafolio/app/views/admin/user_login/login.php");
exit();
?>
