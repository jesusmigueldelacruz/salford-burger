<?php
// Configuración de la base de datos para Salford Burger
// Configurar zona horaria UTC-5 (Hora de Perú)
date_default_timezone_set('America/Lima');

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'salford_burger');
define('DB_USER', 'root');
define('DB_PASS', ''); // XAMPP por defecto no tiene contraseña

// Función para obtener conexión a la base de datos
function getDBConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        // En producción, no mostrar detalles del error
        error_log("Error de conexión a la base de datos: " . $e->getMessage());
        die("Error de conexión a la base de datos. Por favor, inténtalo más tarde.");
    }
}

// Función para verificar la conexión
function testConnection() {
    try {
        $pdo = getDBConnection();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
