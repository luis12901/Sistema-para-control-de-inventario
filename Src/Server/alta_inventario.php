<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laboratorio";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Lógica para mostrar últimos 30 estudiantes
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['mostrar_ultimos'])) {
    $query = "SELECT * FROM estudiantes ORDER BY id DESC LIMIT 30";

    $result = $conexion->query($query);

    if ($result->num_rows > 0) {
        echo "<h2>Últimos 30 estudiantes registrados:</h2>";
        echo "<div class='table-container'>";
        echo "<table>";
        echo "<tr><th>Nombre</th><th>Código</th><th>Serial Number</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["nombre"] . "</td><td>" . $row["codigo"] . "</td><td>" . $row["serialNumber"] . "</td></tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p>No hay estudiantes registrados.</p>";
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mostrar Estudiantes</title>
    <style>
        /* Estilos de la tabla y otros estilos... */
        .table-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

<div style="background-color: #4CAF50; padding: 20px; text-align: center; border-radius: 10px;">
    <div class="titulo-y-botones">
        <h1 style="color: #fff;">Registro de inventario prestado</h1>
        
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none;
          border-radius: 20px; cursor: pointer;" onclick="window.location.href='index.php'">Prestar Material</button>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer;" onclick="window.location.href='registros.php'">Ver Registros</button>
        
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none;
          border-radius: 20px; cursor: pointer;" onclick="window.location.href='alta_estudiantes.php'">Alta Usuarios</button>
    </div>

</div>

<div class="cuerpo">
<div class="centered">

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laboratorio";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['mostrar_ultimos'])) {
    $query = "SELECT * FROM estudiantes ORDER BY id DESC LIMIT 30";

    $result = $conexion->query($query);

    if ($result->num_rows > 0) {
        echo "<h2>Últimos 30 estudiantes registrados:</h2>";
        echo "<div class='table-container'>";
        echo "<table>";
        echo "<tr><th>Nombre</th><th>Código</th><th>Serial Number</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["nombre"] . "</td><td>" . $row["codigo"] . "</td><td>" . $row["serialNumber"] . "</td></tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p>No hay estudiantes registrados.</p>";
    }
}

$conexion->close();
?>

</div>

</body>
</html>
