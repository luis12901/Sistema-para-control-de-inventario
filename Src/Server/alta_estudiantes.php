<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Alta de estudiantes</title>
    <style>
        .cuerpo {
  font-family: Arial, sans-serif;
    max-width: 500px;
  margin: 20px auto;
  padding: 30px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);

  display: flex;
  flex-direction: column;
  align-items: flex-start; 
}

        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 60px;
            cursor: pointer;
        }
    </style>
</head>



<body>

<div style="background-color: #4CAF50; padding: 20px; text-align: center; border-radius: 10px;">
    <div class="titulo-y-botones">
        <h1 style="color: #fff;">Alta de Usuarios</h1>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px;
         cursor: pointer; margin: 0 10px; <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none;
          border-radius: 20px; cursor: pointer; margin: 0 10px; onclick="window.location.href='index.php'">Prestar Material</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='registros.php'">Ver Registros</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='alta_inventario.php'">Alta Inventario</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='usuarios_registrados.php'">Usuarios Registrados</button>

    </div>

</div>

<div class="cuerpo">
<div class="centered">

<div class="form-container">
        <h2>Ingresar Datos del Estudiante</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="codigo">Código:</label>
            <input type="text" id="codigo" name="codigo" required>

            <label for="serial">Serial Number:</label>
            <input type="text" id="serial" name="serial" required>

            <button type="submit">Guardar</button>
        </form>
    </div>

    <div class="form-container">
        <h2>Ingresar Datos del Profesor</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre_maestro" name="nombre_maestro" required>

            <label for="codigo">Código:</label>
            <input type="text" id="codigo_maestro" name="codigo_maestro" required>

            <label for="serial">Serial Number:</label>
            <input type="text" id="serial_maestro" name="serial_maestro" required>

            <button type="submit">Guardar</button>
        </form>
    </div>

    <div class="form-container">
        <h2>Ingresar Datos del Prestador de servicio</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre_prestador" name="nombre_prestador" required>

            <label for="codigo">Código:</label>
            <input type="text" id="codigo_prestador" name="codigo_prestador" required>

            <label for="serial">Serial Number:</label>
            <input type="text" id="serial_prestador" name="serial_prestador" required>

            <button type="submit">Guardar</button>
        </form>
    </div>



</div>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laboratorio";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar qué formulario se envió y obtener los datos correspondientes
    if (isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        $codigo = $_POST['codigo'];
        $serial = $_POST['serial'];

        $sql_insert = "INSERT INTO estudiantes (nombre, codigo, serialNumber) VALUES ('$nombre', '$codigo', '$serial')";
        if ($conexion->query($sql_insert) === TRUE) {
            echo "<script>alert('Datos del estudiante insertados correctamente.')</script>";
        } else {
            echo "<script>alert('Error al insertar datos: " . $conexion->error . "')</script>";
        }
    }

    if (isset($_POST['nombre_maestro'])) {
        $nombre_maestro = $_POST['nombre_maestro'];
        $codigo_maestro = $_POST['codigo_maestro'];
        $serial_maestro = $_POST['serial_maestro'];

        $sql_insert_maestro = "INSERT INTO maestros (nombre, codigo, serialNumber) VALUES ('$nombre_maestro', '$codigo_maestro', '$serial_maestro')";
        if ($conexion->query($sql_insert_maestro) === TRUE) {
            echo "Datos de maestro insertados correctamente.";
        } else {
            echo "Error al insertar datos del maestro: " . $conexion->error;
        }
    }

    if (isset($_POST['nombre_prestador'])) {
        $nombre_prestador = $_POST['nombre_prestador'];
        $codigo_prestador = $_POST['codigo_prestador'];
        $serial_prestador = $_POST['serial_prestador'];

        $sql_insert_prestador = "INSERT INTO prestadores (nombre, codigo, serialNumber) VALUES ('$nombre_prestador', '$codigo_prestador', '$serial_prestador')";
        if ($conexion->query($sql_insert_prestador) === TRUE) {
            echo "Datos de prestador insertados correctamente.";
        } else {
            echo "Error al insertar datos del prestador: " . $conexion->error;
        }
    }
}

$conexion->close();
?>
</div>

</body>
</html>
