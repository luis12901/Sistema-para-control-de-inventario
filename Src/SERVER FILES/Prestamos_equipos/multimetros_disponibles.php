<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laboratorio";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

$sql = "SELECT Marca FROM inventario WHERE Material = 'Multímetro' AND Estado = 'Disponible'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $marcas = array();
    while ($row = $result->fetch_assoc()) {
        $marcas[] = $row['Marca'];
    }
    echo json_encode($marcas);
} else {
    echo json_encode(array());
}

$conn->close();
?>
