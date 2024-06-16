<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isActive($page) {
    return strpos($_SERVER['REQUEST_URI'], $page) !== false ? 'active' : '';
}
?>
<nav class="navbar">
    <a class="brand-title" href="/Portafolio/index.php">Mi Blog</a>
    <a href="#" class="toggle-button">
        <i class="fas fa-bars"></i>
    </a>
    <ul class="nav-list">
        <li class="nav-item"><a href="/Portafolio/index.php" class="nav-link <?= isActive('index.php') ?>"><i class="fas fa-home"></i> Home</a></li>
        
        <?php if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']): ?>
            <!-- Enlaces para visitantes no registrados -->
            <li class="nav-item"><a href="/Portafolio/app/views/admin/noticias/noticiasAdmin.php" class="nav-link <?= isActive('noticiasAdmin.php') ?>"><i class="far fa-newspaper"></i> Noticias</a></li>
            <li class="nav-item"><a href="/Portafolio/app/views/admin/user_login/register.php" class="nav-link <?= isActive('register.php') ?>"><i class="fas fa-user-plus"></i> Registro</a></li>
            <li class="nav-item"><a href="/Portafolio/app/views/admin/user_login/login.php" class="nav-link <?= isActive('login.php') ?>"><i class="fas fa-sign-in-alt"></i> Login</a></li>
        <?php elseif ($_SESSION['role'] === 'admin'): ?>
            <!-- Enlaces exclusivos para el administrador -->
            <li class="nav-item"><a href="/Portafolio/app/views/admin/citas/citasAdmin.php" class="nav-link <?= isActive('citasAdmin.php') ?>"><i class="fas fa-calendar-alt"></i> CitasAdmin</a></li>
            <li class="nav-item"><a href="/Portafolio/app/views/admin/user_data/user_DataAdmin.php" class="nav-link <?= isActive('user_DataAdmin.php') ?>"><i class="fas fa-users"></i> UsuariosAdmin</a></li>
            <li class="nav-item"><a href="/Portafolio/app/views/admin/noticias/noticiasAdmin.php" class="nav-link <?= isActive('noticiasAdmin.php') ?>"><i class="far fa-newspaper"></i> NoticiasAdmin</a></li>
            <li class="nav-item"><a href="/Portafolio/app/views/admin/profile/profile.php" class="nav-link <?= isActive('profile.php') ?>"><i class="fas fa-user"></i> PerfilAdmin</a></li>
            <li class="nav-item"><a href="/Portafolio/app/views/admin/user_login/logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        <?php elseif ($_SESSION['role'] === 'user'): ?>
            <!-- Enlaces exclusivos para usuarios regulares -->
            <li class="nav-item"><a href="/Portafolio/app/views/user/citas/citasUser.php" class="nav-link <?= isActive('citasUser.php') ?>"><i class="fas fa-calendar-alt"></i> Citas</a></li>
            <li class="nav-item"><a href="/Portafolio/app/views/user/noticias/noticiasUser.php" class="nav-link <?= isActive('noticiasUser.php') ?>"><i class="far fa-newspaper"></i> Noticias</a></li>
            <li class="nav-item"><a href="/Portafolio/app/views/user/profile/profileUser.php" class="nav-link <?= isActive('profileUser.php') ?>"><i class="fas fa-user"></i> Perfil</a></li>
            <li class="nav-item"><a href="/Portafolio/app/views/admin/user_login/logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleButton = document.querySelector('.toggle-button');
        const navList = document.querySelector('.nav-list');

        toggleButton.addEventListener('click', () => {
            navList.classList.toggle('active');
        });
    });
</script>
