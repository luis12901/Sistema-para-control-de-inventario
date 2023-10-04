<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Monitoreo</title>
    <style>
        table {
  border-collapse: collapse;
  width: 80%;
  margin: 50px auto;
  font-family: Arial, Helvetica, sans-serif;
  text-align: center;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
}

table th, table td {
  border: 1px solid #ddd;
  padding: 12px;
}
th {

color: white;
}

table th {
  background-color: #4CAF50;
  font-weight: bold;
  text-align: center;
}

table tr:nth-child(even) {
  background-color: #f2f2f2;
}

table tr:hover {
  background-color: #e6e6e6;
}

@media (max-width: 768px) {
  table {
    width: 100%;
  }
  
  table th, table td {
    padding: 8px;
  }
}

        .barra-superior {
            background-color: #999;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .titulo-y-botones {
            display: inline-block;
        }
        .boton {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        .boton:first-child {
            margin-left: 0;
        }
        .boton:last-child {
            float: right;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .centered {    
            width: 50%; /* ancho fijo */
            margin: 0 auto;
            margin-top: 40px;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

<div style="background-color: #4CAF50; padding: 20px; text-align: center; border-radius: 10px;">
    <div class="titulo-y-botones">
        <h1 style="color: #fff;">Registros</h1>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px;
         cursor: pointer; margin: 0 10px; <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none;
          border-radius: 20px; cursor: pointer; margin: 0 10px; onclick="window.location.href='index.php'">Prestar Material</button>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;">Ver Registros</button>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;">Alta Usuarios</button>
        
    </div>
    <form style = "padding: 10px 0 0 0;" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="nombre_usuario" placeholder="Buscar usuario...">
        <button type="submit">Buscar</button>
    </form>
</div>



<div class="centered">
<?php
/*
   Project: Laboratory Equipment Inventory Management
   Description: PHP script to insert data from a form into the 'registromaterial' table.
   Author: Jose Luis Murillo Salas
   Creation Date: August 20, 2023
   Contact: joseluis.murillo2022@hotmail.com
*/

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laboratorio"; // Cambio en la base de datos

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

$nombre_usuario = isset($_GET['nombre_usuario']) ? $_GET['nombre_usuario'] : '';

// Construir consulta SQL
$sql = "SELECT ID, Nombre_Est, Codigo_Est, Equipos, Otros, FechayHora, Estado, Comentarios FROM registromaterial";
if ($nombre_usuario !== '') {
    $sql .= " WHERE Nombre_Est LIKE '%$nombre_usuario%' OR Codigo_Est LIKE '%$nombre_usuario%'";
}

$result = $conexion->query($sql);

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Nombre Estudiante</th><th>Código Estudiante</th><th>Equipos</th><th>Otros</th><th>Fecha y Hora</th><th>Estado</th><th>Comentarios</th></tr>";
    // Imprimir datos de cada fila
    while ($row = $result->fetch_assoc()) {
        // Convertir epoch a formato legible con corrección de zona horaria (GMT-6)
        $fechaHoraLegible = date('Y-m-d H:i:s', $row["FechayHora"] - 21600);

        echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["Nombre_Est"] . "</td><td>" . $row["Codigo_Est"] . "</td><td>" . $row["Equipos"] . "</td><td>" . $row["Otros"] . "</td><td>" . $fechaHoraLegible . "</td><td>" . $row["Estado"] . "</td><td>" . $row["Comentarios"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron resultados";
}

// Cerrar conexión
$conexion->close();
?>




</div>

</body>
</html>
