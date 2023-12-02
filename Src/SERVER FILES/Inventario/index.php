<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
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
  <h1 style="color: #fff;">Inventario</h1>
    <div>

    <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer;" onclick="window.location.href='../Prestamos_equipos/index.php'">Prestar Material</button>

        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Registros/index.php'">Ver Registros</button>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px;
         cursor: pointer; margin: 0 10px; <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none;
          border-radius: 20px; cursor: pointer; margin: 0 10px; onclick="window.location.href='../Alta_usuarios/index.php'">Alta Usuarios</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Alta_inventario/index.php'">Alta Inventario</button>
          <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Usuarios_registrados/index.php'">Usuarios Registrados</button>
        
        </div>
</div>



<h1>Busqueda de equipo</h1>

<!-- Formulario para buscar por código -->
<form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" id="marca" name="marca" placeholder="Escriba el identificador">
    <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" type="submit">Buscar</button>
</form>

<br>

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
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['marca'])) {
    $item = $_GET['marca'];
    $query = "SELECT id, Material, Marca, Estado FROM inventario WHERE Marca = '$item'";

    $result = $conexion->query($query);

    if ($result->num_rows > 0) {       

        echo "<h2>Resultados de la búsqueda:</h2>";
        echo "<table>";
        echo "<tr><th>Material</th><th>Marca</th><th>Estado Actual</th><th>Cambiar Estado A</th><th></th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["Material"] . "</td><td>" . $row["Marca"] . "</td><td>" . $row["Estado"] . "</td>";

            echo "<td>";
            echo "<select id='estado-" . $row['id'] . "'>";
            echo "<option value='Disponible'" . ($row['Estado'] == 'Disponible' ? ' selected' : '') . ">Disponible</option>";
            echo "<option value='Por entregar'" . ($row['Estado'] == 'Por entregar' ? ' selected' : '') . ">Por entregar</option>";
            echo "<option value='Averiado'" . ($row['Estado'] == 'Averiado' ? ' selected' : '') . ">Averiado</option>";
            echo "</select>";

            echo "</td>";
            echo "<td><button onclick='actualizarEstado(" . $row['id'] . ", \"" . $row['Material'] . "\")'>Actualizar</button></td>";

            echo "</tr>";
            }
            echo "</table>";
    } else {
        echo "No se encontraron resultados.";
    }
}
$query = "SELECT id, Material, Marca, Estado FROM inventario ORDER BY Marca DESC LIMIT 100";
$result = $conexion->query($query);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Material</th><th>Marca</th><th>Estado Actual</th><th>Cambiar Estado A</th><th></th></tr>";

    while ($row = $result->fetch_assoc()) {
        // Define colores según el estado
        $color = '';
        switch ($row['Estado']) {
            case 'Disponible':
                $color = '#45a049';
                break;
            case 'Por entregar':
                $color = 'orange';
                break;
            case 'Averiado':
                $color = 'red';
                break;
            default:
                $color = 'white'; // Color predeterminado
        }

        // Agrega el estilo directamente a la etiqueta <tr>
        echo "<tr style='background-color: $color;'>";
        echo "<td style='color: white;'>" . $row["Material"] . "</td>";
        echo "<td style='color: white;'>" . $row["Marca"] . "</td>";
        echo "<td style='color: white;'>" . $row["Estado"] . "</td>";
        echo "<td>";

        echo "<select id='estado-" . $row['id'] . "'>";
        echo "<option value='Disponible'" . ($row['Estado'] == 'Disponible' ? ' selected' : '') . ">Disponible</option>";
        echo "<option value='Por entregar'" . ($row['Estado'] == 'Por entregar' ? ' selected' : '') . ">Por entregar</option>";
        echo "<option value='Averiado'" . ($row['Estado'] == 'Averiado' ? ' selected' : '') . ">Averiado</option>";
        echo "</select>";

        echo "</td>";
        echo "<td><button onclick='actualizarEstado(" . $row['id'] . ", \"" . $row['Material'] . "\")'>Actualizar</button></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No hay artículos por mostrar.";
}





$conexion->close();
?>

<script>
    function actualizarEstado(id, material) {
        // Obtener el valor seleccionado de la lista desplegable
        var nuevoEstado = document.getElementById('estado-' + id).value;

        // Realizar una solicitud al servidor para actualizar el estado
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Manejar la respuesta del servidor (si es necesario)
                    console.log(xhr.responseText);
                } else {
                    console.error('Error al actualizar el estado.');
                }
            }
        };

        // Construir la URL del script de actualización en el servidor
        var url = 'actualizar_estado.php?id=' + id + '&material=' + encodeURIComponent(material) + '&estado=' + encodeURIComponent(nuevoEstado);

        // Abrir y enviar la solicitud
        xhr.open('GET', url, true);
        xhr.send();
    }
</script>

</body>
</html>
