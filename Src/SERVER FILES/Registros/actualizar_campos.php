<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laboratorio";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $otros = $_POST['otros'];
    $equipos = $_POST['equipos'];
    $comentarios = $_POST['comentarios'];
    
    $sql = "UPDATE registromaterial SET Otros='$otros', Equipos='$equipos', Comentarios='$comentarios' WHERE ID=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Campos actualizados correctamente.";
    } else {
        echo "Error al actualizar campos: " . $conn->error;
    }
}

$conn->close();
?>
