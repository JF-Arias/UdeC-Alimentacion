<?php

// Incluir la configuración de la base de datos
require_once '../config/database.php';

// Incluir los controladores
require_once '../controllers/estudiantesController.php';

// Definir las rutas
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    obtenerEstudiantes($conn); // Obtener estudiantes
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    insertarEstudiante($conn); // Insertar estudiante
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    actualizarEstudiante($conn); // Actualizar estudiante
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(["mensaje" => "Método no permitido"]);
}
?>
