<?php
// actualizar_estado.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laboratorio";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
$material = isset($_GET['material']) ? $_GET['material'] : '';
$estado = isset($_GET['estado']) ? $_GET['estado'] : '';

if (!empty($id) && !empty($material) && !empty($estado)) {
    // Actualizar el estado en la tabla 'inventario'
    $updateSQL = "UPDATE inventario SET Estado = ? WHERE id = ? AND Material = ? LIMIT 1";
    $stmtUpdate = $conn->prepare($updateSQL);
    $stmtUpdate->bind_param("sss", $estado, $id, $material);

    if ($stmtUpdate->execute()) {
        echo "Estado de '$material' actualizado a '$estado'.";
    } else {
        echo "Error al actualizar el estado: " . $stmtUpdate->error;
    }

    $stmtUpdate->close();
} else {
    echo "Parámetros no válidos.";
}

$conn->close();
?>
