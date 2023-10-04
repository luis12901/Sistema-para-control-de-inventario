<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Obtener los datos enviados en el cuerpo de la petición HTTP
$data = json_decode(file_get_contents("php://input"), true);

// Establecer la zona horaria
date_default_timezone_set('America/Mexico_City');

// Obtener la fecha y hora actual
$fecha = new Datetime();
$timestamp = $fecha->getTimestamp();

// Conectar a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$dbname = "laboratorio";

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


$sql = "SELECT * FROM registro_de_material WHERE serialNumber = ? AND Estado = 'Por entregar'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $serialNumber);

$stmt->execute();

$resultado_consulta = $stmt->get_result();

if ($resultado_consulta->num_rows > 0) {
    $updateQuery = "UPDATE registro_de_material SET Estado = 'Entregado' WHERE serialNumber = ? AND Estado = 'Por entregar'";
    $stmtUpdate = $conn->prepare($updateQuery);
    $stmtUpdate->bind_param("s", $serialNumber);

    if ($stmtUpdate->execute()) {
        echo "El material para el estudiante ha sido marcado como entregado.";
    } else {
        echo "Error al actualizar el estado del material: " . $conn->error;
    }

    $stmtUpdate->close();
} else {
    echo "No hay material por entregar para el estudiante.";
}

$stmt->close();

?>
