<?php
require_once __DIR__ . '/../includes/conexion.php';

// Verificar si los datos del formulario fueron enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Verificar las credenciales (simplificado, sin cifrado)
    $sql = "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        echo "Inicio de sesión exitoso. Bienvenido, $username!";
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>
