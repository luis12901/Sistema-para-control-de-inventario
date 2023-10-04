<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "laboratorio";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consultar el estado actual
$sql = "SELECT Estado FROM registromaterial WHERE iD = 1"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentState = $row["Estado"];

    // Cambiar el estado
    if ($currentState == 'Por entregar') {
        $newState = 'Entregado';
    } else if ($currentState == 'Entregado') {
        $newState = 'Recibido';
    } else if($currentState == 'Recibido'){
        $newState = 'Por entregar';
    }
    else{
        die("Estado actual no válido: $currentState");
    }

    // Actualizar el estado en la base de datos
    $updateSql = "UPDATE registromaterial SET Estado = '$newState' WHERE iD = 1"; // Cambia "tu_tabla" y "id" según tu estructura
    if ($conn->query($updateSql) === TRUE) {
        echo "Estado actualizado correctamente a: $newState";
    } else {
        echo "Error al actualizar el estado: " . $conn->error;
    }
} else {
    echo "No se encontraron registros.";
}

$conn->close();
?>
