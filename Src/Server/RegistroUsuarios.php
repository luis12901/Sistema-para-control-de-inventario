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
$dbname = "rfid";

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
	 echo "conexion invalida";
}
else{
	 echo "conexion valida";
}


    $sql = "INSERT INTO registrousuarios (serialNumber, fecha) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $data['serialNumber'], $timestamp);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(array("mensaje" => "Datos insertados correctamente."));
		 echo "CR";
    } else {
        echo json_encode(array("mensaje" => "Error al insertar datos: " . $conn->error));
		 echo "CF";
    }

?>