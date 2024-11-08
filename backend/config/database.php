<?php

$host = 'localhost'; // O tu servidor de base de datos
$dbname = 'api'; // Nombre de la base de datos
$username = 'root'; // Nombre de usuario de MySQL
$password = ''; // Contraseña de MySQL (vacía si usas XAMPP por defecto)

try {
    // Crear una instancia de la conexión a la base de datos
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Establecer el modo de error para las excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
