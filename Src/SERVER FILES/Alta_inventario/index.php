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

        .select-container {
        width: 200px; /* Ajusta el ancho según tus preferencias */
        margin-bottom: 10px; /* Espacio entre el select y otros elementos */
    }

    /* Estilos para el select */
    #material {
        width: 100%; /* El ancho del select ocupa el 100% del contenedor */
        padding: 8px; /* Espaciado interno */
        border: 1px solid #ccc; /* Borde */
        border-radius: 4px; /* Borde redondeado */
        box-sizing: border-box; /* El padding y el borde se incluyen en el ancho total */
    }
    </style>
</head>



<body>

<div style="background-color: #4CAF50; padding: 20px; text-align: center; border-radius: 10px;">
    <div class="titulo-y-botones">
        <h1 style="color: #fff;font-family: Arial, sans-serif;">Alta de Inventario</h1>
        
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Prestamos_equipos/index.php'">Prestar Material</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Registros/index.php'">Ver Registros</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Usuarios_registrados/index.php'">Usuarios Registrados</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px;
         cursor: pointer; margin: 0 10px; <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none;
          border-radius: 20px; cursor: pointer; margin: 0 10px; onclick="window.location.href='../Alta_usuarios/index.php'">Alta Usuarios</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Inventario/index.php'">Inventario</button>
        </div>

</div>

<div class="cuerpo">

<div class="form-container">
        <h2>Ingresa la informacion del equipo</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="material">Equipo o Material:</label>
           
            <div class="select-container">
    <select id="material" name="material" required>
        <option value="Fuente">Fuente</option>
        <option value="Multímetro">Multímetro</option>
        <option value="Juego_Puntas_Osc">Puntas para Osciloscopio</option>
    </select>
</div>
            <br>    
            <br>    

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
