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
$nombrePrestador = $_POST['nombre_prestador'];
$codigoPrestador = $_POST['codigo_prestador'];

// Consulta para verificar si el estudiante existe
$sqlEstudiante = "SELECT * FROM usuarios WHERE codigo = ?";
$stmtEstudiante = $conexion->prepare($sqlEstudiante);
$stmtEstudiante->bind_param("s", $codigo);
$stmtEstudiante->execute();
$resultEstudiante = $stmtEstudiante->get_result();

if ($resultEstudiante->num_rows > 0) {
    // Verificamos si el prestador de servicio social existe
    $sqlPrestador = "SELECT * FROM usuarios WHERE codigo = ?";
    $stmtPrestador = $conexion->prepare($sqlPrestador);
    $stmtPrestador->bind_param("s", $codigoPrestador);
    $stmtPrestador->execute();
    $resultPrestador = $stmtPrestador->get_result();

    if ($resultPrestador->num_rows > 0) {
        // Verificamos el estado del último registro del estudiante
        $sqlCheckEstado = "SELECT Estado FROM registromaterial WHERE codigo_est = ? ORDER BY ID DESC LIMIT 1";
        $stmtCheckEstado = $conexion->prepare($sqlCheckEstado);
        $stmtCheckEstado->bind_param("s", $codigo);
        $stmtCheckEstado->execute();
        $resultCheckEstado = $stmtCheckEstado->get_result();

        if ($resultCheckEstado->num_rows > 0) {
            $rowEstado = $resultCheckEstado->fetch_assoc();
            $estado = $rowEstado['Estado'];
            $estado = $conexion->real_escape_string($estado);

            if ($estado == 'Entregado') {
                echo json_encode(array("Alerta" => "Este usuario ya tiene equipo prestado y no lo ha devuelto."));
            } elseif ($estado == 'Recibido') {
                registerDelivery();
            }
        } else {
            registerDelivery();
        }
    } else {
        echo "Prestador de servicio social no encontrado.";
    }
} else {
    echo "La información del estudiante es incorrecta o no está registrado en nuestra base de datos.";
}

function registerDelivery()
{
    global $conexion, $nombre, $codigo, $nombrePrestador, $codigoPrestador, $comentarios;

    // El estudiante no tiene un equipo prestado, podemos insertar el registro

    $equipos = isset($_POST['Equipos']) ? $_POST['Equipos'] : [];
    $equiposStr = implode(',', $equipos);

    
    

    // Obtener la fecha actual en formato epoch
    $fecha_epoch = time() - 21600; // 6 horas menos que el GMT
    $otros = isset($_POST['otros']) ? $_POST['otros'] : 'NA';
    $estado = 'Entregado';

    $sqlInsert = "INSERT INTO registromaterial (Nombre_Est, Codigo_Est, Nombre_Prest, Codigo_Prest, FechayHora, equipos, otros, estado, comentarios) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmtInsert = $conexion->prepare($sqlInsert);
    $stmtInsert->bind_param("sssssssss", $nombre, $codigo, $nombrePrestador, $codigoPrestador, $fecha_epoch, $equiposStr, $otros, $estado, $comentarios);


  

    if ($stmtInsert->execute()) {
        echo json_encode(array("message" => "Datos insertados correctamente."));


        foreach ($equipos as $equipo) {
            $updateEquipoSQL = "UPDATE inventario SET Estado = 'Por entregar' WHERE Marca = ? AND Estado = 'Disponible' LIMIT 1";
            $stmtUpdateEquipo = $conexion->prepare($updateEquipoSQL);
            $stmtUpdateEquipo->bind_param("s", $equipo);
    
            if (!$stmtUpdateEquipo->execute()) {
                echo json_encode(array("error" => "Error al actualizar el estado del equipo: " . $conexion->error));
                $stmtUpdateEquipo->close();
                return;
            }
    
            $stmtUpdateEquipo->close();
        }


        if (!empty($equipos)) {
            foreach ($equipos as $equipo) {
                if (strpos($equipo, 'F') === 0 || strpos($equipo, 'M') === 0) {
                    $updateSQL = "UPDATE inventario SET Estado = 'Por entregar' WHERE Material = ? AND Estado = 'Disponible' LIMIT 1";
                    $stmtUpdate = $conexion->prepare($updateSQL);
                    $stmtUpdate->bind_param("s", $equipo);
                    $stmtUpdate->execute();
                    $stmtUpdate->close();
                } 
            }
        }
        header("Location: ../Registros/index.php");
        exit(); // Asegurar que el script se detenga después de la redirección
    } else {
        echo json_encode(array("error" => "Error al insertar datos: " . $conexion->error));
    }

    $stmtInsert->close();
}

$conexion->close();
?>

