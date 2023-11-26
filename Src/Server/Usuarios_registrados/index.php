<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mostrar Estudiantes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .titulo-y-botones {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .titulo-y-botones button {
            background-color: #45a049;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            margin-left: 10px;
        }

        .titulo-y-botones button:hover {
            background-color: #357934;
        }

        h1 {
            color: #4CAF50;
            margin-top: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        form label {
            margin-right: 10px;
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
  <h1 style="color: #fff;">Usuarios Registrados</h1>
    <div>
    <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer;" onclick="window.location.href='../Prestamos_equipos/index.php'">Prestar Material</button>

        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Registros/index.php'">Ver Registros</button>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px;
         cursor: pointer; margin: 0 10px; <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none;
          border-radius: 20px; cursor: pointer; margin: 0 10px; onclick="window.location.href='../Alta_usuarios/index.php'">Alta Usuarios</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Alta_inventario/index.php'">Alta Inventario</button>

    </div>
</div>



<h1>Mostrar Estudiantes</h1>

<!-- Formulario para buscar por código -->
<form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="codigo">Buscar por Código:</label>
    <input type="text" id="codigo" name="codigo">
    <button type="submit">Buscar</button>
</form>

<br>

<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?mostrar_ultimos=true">Mostrar últimos 50 estudiantes registrados</a>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laboratorio";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Lógica para buscar por código
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];
    $query = "SELECT * FROM usuarios WHERE codigo = '$codigo'";

    $result = $conexion->query($query);

    if ($result->num_rows > 0) {
        echo "<h2>Resultados de la búsqueda:</h2>";
        echo "<table>";
        echo "<tr><th>Nombre</th><th>Código</th><th>Serial Number</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["Nombre"] . "</td><td>" . $row["Codigo"] . "</td><td>" . $row["serialNumber"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron resultados para el código: $codigo";
    }
}

// Lógica para mostrar últimos 30 estudiantes
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['mostrar_ultimos'])) {
    $query = "SELECT * FROM usuarios ORDER BY id DESC LIMIT 50";

    $result = $conexion->query($query);

    if ($result->num_rows > 0) {
        echo "<h2>Últimos 30 estudiantes registrados:</h2>";
        echo "<table>";
        echo "<tr><th>Nombre</th><th>Código</th><th>Serial Number</th><th>Tipo de usuario</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["Nombre"] . "</td><td>" . $row["Codigo"] . "</td><td>" . $row["serialNumber"] . "</td><td>" . $row["Tipo_Usuario"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No hay estudiantes registrados.";
    }
}

$conexion->close();
?>
</body>
</html>
