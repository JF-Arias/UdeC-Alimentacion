<?php
$servername = "auth-db847.hstgr.io";
$database = "u983503200_20242_cd703g2";
$username = "u983503200_20242_cd703g2";
$password = "Udec2024*";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa";
?>
