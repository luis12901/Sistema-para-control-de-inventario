<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8">
    <title>Registro de inventario</title>
    <style>
        table {
            border-collapse: collapse;
  width: 80%;
  max-width: 200px; /* Set a max-width to limit expansion */
  margin: 0 auto; /* Center the table */
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
    width: 80%;
   
  }
  
  table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            cursor: pointer;
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
            font-family: Arial, sans-serif;
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


        .table-container {
            padding: 30px;
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }

    
    </style>
</head>
<body>
<div style="background-color: #4CAF50; padding: 20px; text-align: center; border-radius: 10px;">
    <div class="titulo-y-botones">
        
        <h1 style="color: #fff;">Registro de inventario en uso</h1>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer;" onclick="window.location.href='../Prestamos_equipos/index.php'">Prestar Material</button>

        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer;" onclick="window.location.href='../Alta_usuarios/index.php'">Alta Usuarios</button>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer;" onclick="window.location.href='../Alta_inventario/index.php'">Alta Inventario</button>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer;" onclick="window.location.href='../Usuarios_registrados/index.php'">Usuarios Registrados</button>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Inventario/index.php'">Inventario</button>
    </div>


    
    <form id="exportarExcelForm" style="padding: 10px 0 0 0;" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer;" class="boton" onclick="exportarExcel()">Exportar Excel</button>
    <br>
    <input type="text" name="codigo_usuario" placeholder="Código de usuario ...">
    <button type="submit">Buscar</button>
</form>

</div>

<div class="table-container">
    <center>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "laboratorio"; // Cambio en la base de datos

        $conexion = new mysqli($servername, $username, $password, $dbname);

        if ($conexion->connect_error) {
            die("Error en la conexión a la base de datos: " . $conexion->connect_error);
        }

        $codigo_usuario = isset($_GET['codigo_usuario']) ? $_GET['codigo_usuario'] : '';

        $sql = "SELECT ID, Nombre_Est, Codigo_Est, Nombre_Prest, Codigo_Prest,Equipos, Otros, FechayHora, Estado, Comentarios FROM registromaterial";
        if ($codigo_usuario !== '') {
            $sql .= " WHERE Codigo_Est LIKE '%$codigo_usuario%'";
        }
        $sql .= " ORDER BY ID DESC LIMIT 50";

        $result = $conexion->query($sql);

        
        
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Nombre Estudiante</th><th>Código Estudiante</th><th>Nombre Prestador</th><th>Código Prestador</th><th>Equipos</th><th>Otros</th><th>Fecha y Hora</th><th>Estado</th><th>Comentarios</th><th>Actualizar</th></tr>";
    
            while ($row = $result->fetch_assoc()) {
                $fechaHoraLegible = date('Y-m-d H:i:s', $row["FechayHora"]);
    
                echo "<tr>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["Nombre_Est"] . "</td>";
                echo "<td>" . $row["Codigo_Est"] . "</td>";
                echo "<td>" . $row["Nombre_Prest"] . "</td>";
                echo "<td>" . $row["Codigo_Prest"] . "</td>";
                echo "<td contenteditable='true' id='equipos-" . $row['ID'] . "'>" . $row["Equipos"] . "</td>";
                echo "<td contenteditable='true' id='otros-" . $row['ID'] . "'>" . $row["Otros"] . "</td>";
                echo "<td>" . $fechaHoraLegible . "</td>";
                echo "<td>" . $row["Estado"] . "</td>";
                echo "<td contenteditable='true' id='comentarios-" . $row['ID'] . "'>" . $row["Comentarios"] . "</td>";
                echo "<td><button onclick='updateCampos(" . $row['ID'] . ")'>Actualizar Campos</button></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else {
            echo "No se encontraron resultados";
        }

        $conexion->close();
        ?>
    </center>
</div>

<script src="../js/script.js"></script>
</body>
</html>
