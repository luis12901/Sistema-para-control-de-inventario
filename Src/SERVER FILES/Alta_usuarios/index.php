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
        <h1 style="color: #fff; font-family: Arial, sans-serif;">Alta de Usuarios</h1>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px;
         cursor: pointer; margin: 0 10px; <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none;
          border-radius: 20px; cursor: pointer; margin: 0 10px; onclick="window.location.href='../Prestamos_equipos/index.php'">Prestar Material</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Registros/index.php'">Ver Registros</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Alta_inventario/index.php'">Alta Inventario</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Usuarios_registrados/index.php'">Usuarios Registrados</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Inventario/index.php'">Inventario</button>
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
    if (isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        $codigo = $_POST['codigo'];
        $serial = $_POST['serial'];
        $user_hierarchy = 'Estudiante';

        $sqlCheckEstado = "SELECT codigo, Tipo_Usuario, Nombre FROM usuarios WHERE Codigo = ? LIMIT 1";
        $stmtCheckEstado = $conexion->prepare($sqlCheckEstado);
        $stmtCheckEstado->bind_param("s", $codigo);
        $stmtCheckEstado->execute();
        $resultCheckEstado = $stmtCheckEstado->get_result();

        if ($resultCheckEstado->num_rows > 0) {
            // Obtener los datos del primer registro encontrado
            $row = $resultCheckEstado->fetch_assoc();
            $code_found = $row['codigo'];
            $user_type = $row['Tipo_Usuario'];
            $nombre_usuario = $row['Nombre'];

            // Mostrar la información ordenada
            echo "<script>alert('Ya existe un usuario con el código: $code_found, Tipo de Usuario: $user_type y Nombre: $nombre_usuario.')</script>";
        }

        else{

            $sql_insert = "INSERT INTO usuarios (nombre, codigo, serialNumber, Tipo_Usuario) VALUES ('$nombre', '$codigo', '$serial', '$user_hierarchy')";
            if ($conexion->query($sql_insert) === TRUE) {
                echo "<script>alert('Datos del estudiante insertados correctamente.')</script>";
            } 
            else {
                echo "<script>alert('Error al insertar datos: " . $conexion->error . "')</script>";
            }
        }
    }

    if (isset($_POST['nombre_maestro'])) {
        $nombre_maestro = $_POST['nombre_maestro'];
        $codigo_maestro = $_POST['codigo_maestro'];
        $serial_maestro = $_POST['serial_maestro'];
        $user_hierarchy = 'Maestro';


        $sqlCheckEstado = "SELECT codigo, Tipo_Usuario, Nombre FROM usuarios WHERE Codigo = ? LIMIT 1";
        $stmtCheckEstado = $conexion->prepare($sqlCheckEstado);
        $stmtCheckEstado->bind_param("s", $codigo_maestro);
        $stmtCheckEstado->execute();
        $resultCheckEstado = $stmtCheckEstado->get_result();

        if ($resultCheckEstado->num_rows > 0) {
            $row = $resultCheckEstado->fetch_assoc();
            $code_found = $row['codigo'];
            $user_type = $row['Tipo_Usuario'];
            $nombre_usuario = $row['Nombre'];

            echo "<script>alert('Ya existe un usuario con el código: $code_found, Tipo de Usuario: $user_type y Nombre: $nombre_usuario.')</script>";
        }
        else{
        
            $sql_insert_maestro = "INSERT INTO usuarios (nombre, codigo, serialNumber, Tipo_Usuario) VALUES ('$nombre_maestro', '$codigo_maestro', '$serial_maestro', '$user_hierarchy')";
            if ($conexion->query($sql_insert_maestro) === TRUE) {
                echo "<script>alert('Datos del profesor insertados correctamente.')</script>";
            } else {
                echo "<script>alert('Error al insertar datos: " . $conexion->error . "')</script>";
            }
        }
    }

    if (isset($_POST['nombre_prestador'])) {
        $nombre_prestador = $_POST['nombre_prestador'];
        $codigo_prestador = $_POST['codigo_prestador'];
        $serial_prestador = $_POST['serial_prestador'];
        $user_hierarchy = 'Prestador SS';

        $sqlCheckEstado = "SELECT codigo, Tipo_Usuario, Nombre FROM usuarios WHERE Codigo = ? LIMIT 1";
        $stmtCheckEstado = $conexion->prepare($sqlCheckEstado);
        $stmtCheckEstado->bind_param("s", $codigo_prestador);
        $stmtCheckEstado->execute();
        $resultCheckEstado = $stmtCheckEstado->get_result();

        if ($resultCheckEstado->num_rows > 0) {
            $row = $resultCheckEstado->fetch_assoc();
            $code_found = $row['codigo'];
            $user_type = $row['Tipo_Usuario'];
            $nombre_usuario = $row['Nombre'];

            echo "<script>alert('Ya existe un usuario con el código: $code_found, Tipo de Usuario: $user_type y Nombre: $nombre_usuario.')</script>";
        }
        else{

            $sql_insert_prestador = "INSERT INTO usuarios (nombre, codigo, serialNumber, Tipo_Usuario) VALUES ('$nombre_prestador', '$codigo_prestador', '$serial_prestador', '$user_hierarchy')";
            if ($conexion->query($sql_insert_prestador) === TRUE) {
                echo "<script>alert('Datos del prestador insertados correctamente.')</script>";
            } else {
                echo "<script>alert('Error al insertar datos: " . $conexion->error . "')</script>";
            }
        }
    }
}

$conexion->close();
?>
</div>

</body>
</html>
