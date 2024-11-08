<?php

$host = "localhost"; // Cambia esto si tu base de datos está en otro servidor
$db_name = "api";
$username = "root"; // Cambia según tu configuración
$password = ""; // Cambia según tu configuración

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Configuración de cabeceras para CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Definir las operaciones en función del método HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Obtener todos los registros de la tabla estudiantes
        obtenerEstudiantes($conn);
        break;
    
    case 'POST':
        // Insertar un nuevo registro en la tabla estudiantes
        insertarEstudiante($conn);
        break;

    case 'PUT':
        // Actualizar un registro existente en la tabla estudiantes
        actualizarEstudiante($conn);
        break;

    default:
        header("HTTP/1.1 405 Method Not Allowed");
        echo json_encode(["mensaje" => "Método no permitido"]);
        break;
}

// Función para obtener todos los estudiantes
function obtenerEstudiantes($conn) {
    try {
        $stmt = $conn->prepare("SELECT * FROM estudiantes");
        $stmt->execute();
        $estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($estudiantes);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}

// Función para insertar un nuevo estudiante
function insertarEstudiante($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data['nombre_estudiante']) && !empty($data['apellidos_estudiante']) && !empty($data['edad_estudiante']) && !empty($data['pass'])) {
        try {
            // Hash de la contraseña antes de guardarla
            $passwordHash = md5($data['pass']);

            $stmt = $conn->prepare("INSERT INTO estudiantes (nombre_estudiante, apellidos_estudiante, edad_estudiante, pass) VALUES (:nombre, :apellidos, :edad, :pass)");
            $stmt->bindParam(':nombre', $data['nombre_estudiante']);
            $stmt->bindParam(':apellidos', $data['apellidos_estudiante']);
            $stmt->bindParam(':edad', $data['edad_estudiante']);
            $stmt->bindParam(':pass', $passwordHash);
            $stmt->execute();
            echo json_encode(["mensaje" => "Estudiante insertado correctamente"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["mensaje" => "Datos incompletos"]);
    }
}

// Función para actualizar un estudiante
function actualizarEstudiante($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data['id_estudiante']) && !empty($data['nombre_estudiante']) && !empty($data['apellidos_estudiante']) && !empty($data['edad_estudiante'])) {
        try {
            $stmt = $conn->prepare("UPDATE estudiantes SET nombre_estudiante = :nombre, apellidos_estudiante = :apellidos, edad_estudiante = :edad WHERE id_estudiante = :id");
            $stmt->bindParam(':nombre', $data['nombre_estudiante']);
            $stmt->bindParam(':apellidos', $data['apellidos_estudiante']);
            $stmt->bindParam(':edad', $data['edad_estudiante']);
            $stmt->bindParam(':id', $data['id_estudiante']);
            $stmt->execute();
            echo json_encode(["mensaje" => "Estudiante actualizado correctamente"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["mensaje" => "Datos incompletos"]);
    }
}

?>
