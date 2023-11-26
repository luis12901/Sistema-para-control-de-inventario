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
$comentarios = $_POST['comm'];
$nombre_prestador = $_POST['nombre_prestador'];
$codigo_prestador = $_POST['codigo_prestador'];

// Consulta para verificar si el estudiante existe
$sql = "SELECT * FROM usuarios WHERE codigo = '$codigo'";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    $sql = "SELECT * FROM usuarios WHERE codigo = '$codigo_prestador'";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {

        // Verificamos si el estudiante tiene un registro con estado "Entregado"
        $sql_check = "SELECT * FROM registromaterial WHERE codigo_est = '$codigo' AND estado = 'Entregado'";
        $result_check = $conexion->query($sql_check);

        if ($result_check->num_rows > 0) {
            echo json_encode(array("Alerta" => "Este usuario ya tiene equipo prestado y no lo ha devuelto."));
        } else {
            // El estudiante no tiene un equipo prestado, podemos insertar el registro

            $equipos = isset($_POST['Equipos']) ? $_POST['Equipos'] : [];
            $equiposStr = implode(',', $equipos);

            // Actualizamos el estado de los equipos que comienzan con "F"
            foreach ($equipos as $equipo) {
                if (strpos($equipo, 'F') === 0) {
                    $updateEquipoSQL = "UPDATE inventario SET Estado = 'Por entregar' WHERE Marca = '$equipo' AND Estado = 'Disponible' LIMIT 1";
                    if ($conexion->query($updateEquipoSQL) !== TRUE) {
                        echo json_encode(array("error" => "Error al actualizar el estado del equipo: " . $conexion->error));
                        $conexion->close();
                        return;
                    }
                }
                else if (strpos($equipo, 'M') === 0) {
                    $updateEquipoSQL = "UPDATE inventario SET Estado = 'Por entregar' WHERE Marca = '$equipo' AND Estado = 'Disponible' LIMIT 1";
                    if ($conexion->query($updateEquipoSQL) !== TRUE) {
                        echo json_encode(array("error" => "Error al actualizar el estado del equipo: " . $conexion->error));
                        $conexion->close();
                        return;
                    }
                }
                else if($equipo === 'Juego_Puntas_Osc'){
                    $updateEquipoSQL = "UPDATE inventario SET Estado = 'Por entregar' WHERE Material = 'Juego_Puntas_Osc' AND Estado = 'Disponible' LIMIT 1";
                    if ($conexion->query($updateEquipoSQL) !== TRUE) {
                        echo json_encode(array("error" => "Error al actualizar el estado del equipo: " . $conexion->error));
                        $conexion->close();
                        return;
                    }
                }

            }

            // Obtener la fecha actual en formato epoch
            $fecha_epoch = time();

            $otros = isset($_POST['otros']) ? $_POST['otros'] : 'NA';
            $estado = 'Entregado';
            $sql_insert = "INSERT INTO registromaterial (Nombre_Est, Codigo_Est, Nombre_Prest, Codigo_Prest, FechayHora, equipos, otros, estado, comentarios) 
                            VALUES ('$nombre', '$codigo','$nombre_prestador' , '$codigo_prestador', $fecha_epoch, '$equiposStr', '$otros', '$estado', '$comentarios')";

            if ($conexion->query($sql_insert) === TRUE) {
                echo json_encode(array("message" => "Datos insertados correctamente."));

                if (isset($_POST['Equipos'])) {
                    $equipos_seleccionados = explode(',', $equiposStr);

                    $num_equipos = count($equipos_seleccionados);
                    for ($i = 0; $i < $num_equipos; $i++) {
                        $equipo = $equipos_seleccionados[$i];

                        if (strpos($equipo, 'F') === 0) {
                            $update_sql = "UPDATE inventario SET Estado = 'Por entregar' WHERE Material = '$equipo' AND Estado = 'Disponible' LIMIT 1";
                            $conexion->query($update_sql);
                        }
                    }
                }
            } else {
                echo json_encode(array("error" => "Error al insertar datos: " . $conexion->error));
            }
        }
    } else {
        echo "Prestador de servicio social no encontrado.";
    }
} else {
    echo "La informacion del estudiante es incorrecta o no está registrado en nuestra base de datos.";
}
$conexion->close();
?>
