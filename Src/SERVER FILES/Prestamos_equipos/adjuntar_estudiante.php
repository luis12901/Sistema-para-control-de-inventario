<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

date_default_timezone_set('America/Mexico_City');

$host = "localhost";
$user = "root";
$password = "";
$dbname = "laboratorio";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$studentQuery = "SELECT id, nombre, codigo FROM formulario WHERE estado = ? ORDER BY ID ASC LIMIT 1";
$estado = "Disponible";
$stmt = $conn->prepare($studentQuery);
$stmt->bind_param("s", $estado);
$stmt->execute();
$studentResult = $stmt->get_result();

if ($studentResult->num_rows > 0) {
    $studentRow = $studentResult->fetch_assoc();
    $studentID = $studentRow["id"];
    $studentName = $studentRow["nombre"];
    $studentCode = $studentRow["codigo"];

    $respuesta = array(
        "encontrado" => true,
        "nombre" => $studentName,
        "codigo" => $studentCode
    );

    echo json_encode($respuesta);

    $deleteQuery = "DELETE FROM formulario WHERE id = ?";
    $stmtDelete = $conn->prepare($deleteQuery);
    $stmtDelete->bind_param("i", $studentID);
    $stmtDelete->execute();

    /*
    // Actualizar el estado del registro a "No disponible"
    $updateQuery = "UPDATE formulario SET estado = 'No disponible' WHERE id = ?";
    $stmtUpdate = $conn->prepare($updateQuery);
    $stmtUpdate->bind_param("i", $studentID);
    $stmtUpdate->execute();
    */
} else {
    $respuesta = array(
        "encontrado" => false
    );
    echo json_encode($respuesta);
}

$conn->close();
?>
