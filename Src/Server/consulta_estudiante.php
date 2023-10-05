<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"), true);
date_default_timezone_set('America/Mexico_City');

$host = "localhost";
$user = "root";
$password = "";
$dbname = "laboratorio";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$serialNumber = $data['serialNumber'];

$studentQuery = "SELECT nombre, codigo FROM estudiantes WHERE serialNumber = ?";
$stmtStudent = $conn->prepare($studentQuery);
$stmtStudent->bind_param("s", $serialNumber);

$stmtStudent->execute();
$studentResult = $stmtStudent->get_result();

if ($studentResult->num_rows > 0) {
    $studentRow = $studentResult->fetch_assoc();
    $studentName = $studentRow["nombre"];
    $studentCode = $studentRow["codigo"];

    // Insert into 'formulario' table
    $insertQuery = "INSERT INTO formulario (nombre, codigo, estado) VALUES (?, ?, 'Disponible')";
    $stmtInsert = $conn->prepare($insertQuery);
    $stmtInsert->bind_param("ss", $studentName, $studentCode);
    
    if ($stmtInsert->execute()) {
        echo "Nuevo registro insertado en formulario.";
    } else {
        echo "Error al insertar el nuevo registro: " . $conn->error;
    }

    $stmtInsert->close();
} else {
   

    $studentQuery = "SELECT nombre, codigo FROM prestadores WHERE serialNumber = ?";
    $stmtStudent = $conn->prepare($studentQuery);
    $stmtStudent->bind_param("s", $serialNumber);

    $stmtStudent->execute();
    $studentResult = $stmtStudent->get_result();

    if ($studentResult->num_rows > 0) {
        $studentRow = $studentResult->fetch_assoc();
        $studentName = $studentRow["nombre"];
        $studentCode = $studentRow["codigo"];
    
        // Insert into 'formulario' table
        $insertQuery = "INSERT INTO formulario (nombre, codigo, estado) VALUES (?, ?, 'Disponible')";
        $stmtInsert = $conn->prepare($insertQuery);
        $stmtInsert->bind_param("ss", $studentName, $studentCode);
        
        if ($stmtInsert->execute()) {
            echo "Nuevo registro insertado en formulario.";
        } else {
            echo "Error al insertar el nuevo registro: " . $conn->error;
        }
    
        $stmtInsert->close();
    }

}

$stmtStudent->close();
$conn->close();

sleep(1);
?>
