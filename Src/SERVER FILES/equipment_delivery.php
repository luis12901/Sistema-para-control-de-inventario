<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"), true);
date_default_timezone_set('America/Mexico_City');

$host = "localhost";
$user = "root";
$password = "";
$dbname = "laboratorio";

$conn = new mysqli($host, $user, $password, $dbname);

$response = array(); // Para almacenar la respuesta

if ($conn->connect_error) {
    $response['error'] = "Error de conexión: " . $conn->connect_error;
} else {
    $serialNumber = isset($data['serialNumber']) ? $conn->real_escape_string($data['serialNumber']) : '';

    if (empty($serialNumber)) {
        $response['error'] = "Error: El campo 'serialNumber' no puede estar vacío.";
    } else {
        $studentQuery = "SELECT nombre, codigo FROM usuarios WHERE serialNumber = ?";
        $stmtStudent = $conn->prepare($studentQuery);
        $stmtStudent->bind_param("s", $serialNumber);

        $stmtStudent->execute();
        $studentResult = $stmtStudent->get_result();

        if ($studentResult->num_rows > 0) {
            $studentRow = $studentResult->fetch_assoc();
            $studentName = $studentRow["nombre"];
            $studentCode = $studentRow["codigo"];

            $studentCode = $conn->real_escape_string($studentCode);

            $query = "SELECT Nombre_Prest, Codigo_Prest, Equipos, Otros, Estado, Comentarios FROM registromaterial WHERE codigo_est = ? ORDER BY ID DESC LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $studentCode);

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nombrePrestador = $row['Nombre_Prest'];
                $codigoPrestador = $row['Codigo_Prest'];
                $equipos = $row['Equipos'];
                $otros = $row['Otros'];
                $estado = $row['Estado'];
                $comentarios = $row['Comentarios'];

                $studentName = $conn->real_escape_string($studentName);
                $studentCode = $conn->real_escape_string($studentCode);
                $nombrePrestador = $conn->real_escape_string($nombrePrestador);
                $codigoPrestador = $conn->real_escape_string($codigoPrestador);
                $equipos = $conn->real_escape_string($equipos);
                $otros = $conn->real_escape_string($otros);
                $estado = $conn->real_escape_string($estado);
                $comentarios = $conn->real_escape_string($comentarios);

                if ($estado == 'Entregado') {
                    $fecha_epoch = time() - 21600; // 6 horas menos que el GMT

                    $insertQuery = "INSERT INTO registromaterial (Nombre_est, Codigo_est, Nombre_Prest, Codigo_Prest, FechayHora, Equipos, Otros, Estado, Comentarios) VALUES (?, ?, ?, ?, ?, ?, ?, 'Recibido', ?)";
                    $stmtInsert = $conn->prepare($insertQuery);
                    $stmtInsert->bind_param("ssssssss", $studentName, $studentCode, $nombrePrestador, $codigoPrestador, $fecha_epoch, $equipos, $otros, $comentarios);

                    if ($stmtInsert->execute()) {
                       
                        $response['message'] = "Nuevo registro insertado exitosamente";

                        // Dividir la cadena de equipos en un array
                        $equiposArray = explode(',', $equipos);

                        // Iterar sobre el array de equipos
                        foreach ($equiposArray as $equipo) {
                            // Actualizar el estado en la tabla 'inventario' para cada equipo
                            $equipo = trim($equipo); // Eliminar posibles espacios en blanco alrededor
                            if (!empty($equipo)) {
                                $updateEquipoSQL = "UPDATE inventario SET Estado = 'Disponible' WHERE Marca = ? AND Estado = 'Por entregar' LIMIT 1";
                                $stmtUpdate = $conn->prepare($updateEquipoSQL);
                                $stmtUpdate->bind_param("s", $equipo);

                                if ($stmtUpdate->execute()) {
                                    echo "Estado de equipo '$equipo' actualizado a 'Disponible'.";
                                } else {
                                    echo "Error al actualizar el estado del equipo '$equipo': " . $stmtUpdate->error;
                                }

                                $stmtUpdate->close();
                            }
                        }
                        
                    } else {
                        
                        $response['error'] = "Error al insertar el nuevo registro: " . $conn->error;
                    }

                    $stmtInsert->close();
                } else {
                    $response['error'] = "No hay nada por recibir de parte de este usuario. No se puede proceder con la inserción.";
                }
            }

            $stmt->close();
        } else {
            $response['error'] = "No se encontraron resultados para el serialNumber '$serialNumber'.";
        }

        $stmtStudent->close();
    }

    $conn->close();
}

echo json_encode($response);
?>
