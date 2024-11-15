<?php
// Cargar autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php'; // Ajusta la ruta si es necesario

// Cargar las variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // Ajusta la ruta según la ubicación del archivo .env
$dotenv->load();

// Cargar las variables de entorno
$servername = getenv('DB_SERVERNAME');
$database = getenv('DB_DATABASE');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');

// Verifica que las variables de entorno están definidas
if (!$servername || !$database || !$username || !$password) {
    die("Error: Las credenciales de la base de datos no están configuradas correctamente.");
}

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    // Registra el error en un archivo de log (asegúrate de tener permisos para escribir en el log)
    error_log("Error de conexión: " . $conn->connect_error, 3, '/ruta/del/log/errors.log');
    
    // Muestra un mensaje genérico al usuario para evitar exponer detalles de la base de datos
    die("Conexión fallida. Por favor, intenta más tarde.");
}

echo "Conexión exitosa";
?>
