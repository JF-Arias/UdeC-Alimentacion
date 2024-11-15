<?php
// Incluir la conexión a la base de datos
include '../includes/db_connection.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página 1</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Bienvenido a la página 1</h1>
    <p>Esta es tu página de inicio conectada a la base de datos.</p>

    <?php
    // Consulta a la base de datos
    $sql = "SELECT * FROM tu_tabla";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Imprimir los datos de cada fila
        while($row = $result->fetch_assoc()) {
            echo "<p>ID: " . $row["id"] . " - Nombre: " . $row["nombre"] . "</p>";
        }
    } else {
        echo "<p>No se encontraron resultados.</p>";
    }
    $conn->close();
    ?>
</body>
</html>
