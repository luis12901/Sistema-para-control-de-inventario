<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laboratorio";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Consulta para actualizar el estado a "Disponible" en todos los registros
$sql = "UPDATE inventario SET Estado = 'Disponible'";
$result = $conexion->query($sql);

// Verificar si la consulta fue exitosa
if ($result) {
    echo "Estado actualizado correctamente";
} else {
    echo "Error al actualizar el estado: " . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>
