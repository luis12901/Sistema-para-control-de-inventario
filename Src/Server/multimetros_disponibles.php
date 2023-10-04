<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laboratorio";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

// Realizar la consulta para obtener las marcas de los multímetros disponibles
$sql = "SELECT Marca FROM inventario WHERE Material = 'Multímetro' AND Estado = 'Disponible'";
$result = $conn->query($sql);

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    $marcas = array();
    while ($row = $result->fetch_assoc()) {
        $marcas[] = $row['Marca'];
    }
    // Devolver las marcas como JSON
    echo json_encode($marcas);
} else {
    echo json_encode(array());
}

// Cerrar la conexión
$conn->close();
?>
