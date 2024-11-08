<?php

// Obtener todos los estudiantes
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

// Insertar un nuevo estudiante
function insertarEstudiante($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data['nombre_estudiante']) && !empty($data['apellidos_estudiante']) && !empty($data['edad_estudiante']) && !empty($data['pass'])) {
        try {
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

// Actualizar un estudiante
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
