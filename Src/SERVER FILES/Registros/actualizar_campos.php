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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $otros = $_POST['otros'];
    $equipos = $_POST['equipos'];
    $comentarios = $_POST['comentarios'];

    // Actualizar campos en la base de datos
    $sql = "UPDATE registromaterial SET Otros='$otros', Equipos='$equipos', Comentarios='$comentarios' WHERE ID=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Campos actualizados correctamente.')</script>";

        echo "Campos actualizados correctamente.";
    } else {
        echo "<script>alert('Error al actualizar campos: " . $conexion->error . "')</script>";

    }
}

// Cerrar la conexión
$conn->close();
?>
