<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Alta de Inventario</title>
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
        <h1 style="color: #fff;">Alta de Inventario</h1>
        
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='index.php'">Prestar Material</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='registros.php'">Ver Registros</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='usuarios_registrados.php'">Usuarios Registrados</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px;
         cursor: pointer; margin: 0 10px; <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none;
          border-radius: 20px; cursor: pointer; margin: 0 10px; onclick="window.location.href='alta_estudiantes.php'">Alta Usuarios</button>
    </div>

</div>

<div class="cuerpo">

<div class="form-container">
        <h2>Ingresa la informacion del equipo</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="material">Equipo o Material:</label>
            <input type="text" id="material" name="material" required>

            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" required>

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
    if (isset($_POST['material'])) {
        $nombre = $_POST['material'];
        $marca = $_POST['marca'];
        $estado = 'Disponible';

        $sql_insert = "INSERT INTO inventario (material, marca, estado) VALUES ('$nombre', '$marca', '$estado')";
        if ($conexion->query($sql_insert) === TRUE) {
            echo "<script>alert('Datos insertados correctamente.')</script>";
        } else {
            echo "<script>alert('Error al insertar datos: " . $conexion->error . "')</script>";
        }
    }
}

$conexion->close();
?>

</body>
</html>
