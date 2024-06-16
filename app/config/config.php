<?php
// Definiciones de configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_PORT', '3307');     
define('DB_NAME', 'portafolio');
define('DB_USER', 'root');      
define('DB_PASSWORD', '');      

// Crear una nueva instancia de PDO para la conexión a la base de datos
try {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            

} catch (PDOException $e) {
    
    die("Error de conexión: " . $e->getMessage());
}
?>

