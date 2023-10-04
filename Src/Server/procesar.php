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
$dbname = "laboratorio";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'];
$codigo = $_POST['codigo'];
$comentarios = $_POST['comm']; // Agregamos la captura de comentarios

// Verificamos si el estudiante tiene un registro con estado "Entregado"
$sql_check = "SELECT * FROM registromaterial WHERE codigo_est = '$codigo' AND estado = 'Entregado'";
$result_check = $conexion->query($sql_check);

if ($result_check->num_rows > 0) {
    echo json_encode(array("Alerta" => "Este usuario ya tiene equipo prestado y no lo ha devuelto."));
} else {
    // El estudiante no tiene un equipo prestado, podemos insertar el registro

    $equipos = '';

    if (isset($_POST['Equipos'])) {
        foreach ($_POST['Equipos'] as $equipo) {
            if ($equipo === 'Fuente') {
               /* // Agregar la marca de la fuente seleccionada
                $marca = $_POST['marca_fuente']; // Asumiendo que tienes un campo 'marca_fuente' en tu formulario
                $equipos .= "Fuente ($marca),";*/
            } else {
                $equipos .= "$equipo,";
            }
        }
        $equipos = rtrim($equipos, ','); // Eliminar la última coma
    } else {
        $equipos = 'NA';
    }

    // Obtener la fecha actual en formato epoch
    $fecha_epoch = time();

    $otros = isset($_POST['otros']) ? $_POST['otros'] : 'NA';
    $estado = 'Entregado';
    $sql_insert = "INSERT INTO registromaterial (Nombre_Est, Codigo_Est, FechayHora, equipos, otros, estado, comentarios) 
                    VALUES ('$nombre', '$codigo', $fecha_epoch, '$equipos', '$otros', '$estado', '$comentarios')"; // Agregamos comentarios

    if ($conexion->query($sql_insert) === TRUE) {
        echo json_encode(array("message" => "Datos insertados correctamente."));

        if (isset($_POST['Equipos'])) {
            $equipos_seleccionados = explode(',', $equipos);

            $num_equipos = count($equipos_seleccionados);
            for ($i = 0; $i < $num_equipos; $i++) {
                $equipo = $equipos_seleccionados[$i];

                $update_sql = "UPDATE inventario SET Estado = 'Por entregar' WHERE Material = '$equipo' AND Estado = 'Disponible' LIMIT 1";
                $conexion->query($update_sql);
            }
        }
    } else {
        echo json_encode(array("error" => "Error al insertar datos: " . $conexion->error));
    }
}

$conexion->close();
?>
