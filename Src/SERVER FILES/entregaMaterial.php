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

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$serialNumber = $data['serialNumber'];

$studentQuery = "SELECT Codigo FROM estudiantes WHERE serialNumber = ?";
$stmtStudent = $conn->prepare($studentQuery);
$stmtStudent->bind_param("s", $serialNumber);

$stmtStudent->execute();
$studentResult = $stmtStudent->get_result();

if ($studentResult->num_rows > 0) {
    $studentRow = $studentResult->fetch_assoc();
    $studentCode = $studentRow["Codigo"];

    $materialQuery = "SELECT * FROM registromaterial WHERE Codigo = ? AND Estado IN ('Por entregar', 'Entregado')";
    $stmtMaterial = $conn->prepare($materialQuery);
    $stmtMaterial->bind_param("s", $studentCode);

    $stmtMaterial->execute();
    $materialResult = $stmtMaterial->get_result();

    if ($materialResult->num_rows > 0) {
        
        $materialRow = $materialResult->fetch_assoc();
        $currentState = $materialRow["Estado"];

        if ($currentState == 'Por entregar') {

            $newState = 'Entregado';
            $updateQuery = "UPDATE registromaterial SET Estado = '$newState' WHERE Codigo = ?";
            $stmtUpdate = $conn->prepare($updateQuery);
            $stmtUpdate->bind_param("s", $studentCode);

            if ($stmtUpdate->execute()) {
                $response = array(
                    'message' => 'Estado actualizado a Entregado'
                );
                echo json_encode($response);

                $data = array(
                    'clave' => '1234',
                    'estado' => 1,
                    'acceso_nivel' => 1,
                    'acceso' => 1,
                    'nombre' => 'Entregado'
                );
                
                $data_string = json_encode($data);
                
                $ch = curl_init('http://192.168.100.19');
                //$ch = curl_init('http://192.168.43.174');
                //$ch = curl_init('http://192.168.1.144');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
                );
            } else {
                $response = array(
                    'message' => 'Error al actualizar el Estado: ' . $conn->error
                );
                echo json_encode($response);
            }

            


        } else if ($currentState == 'Entregado') {





            

            $newState = 'Recibido';

            $updateQuery = "UPDATE registromaterial SET Estado = '$newState' WHERE Codigo = ?";
            $stmtUpdate = $conn->prepare($updateQuery);
            $stmtUpdate->bind_param("s", $studentCode);

            if ($stmtUpdate->execute()) {
                $response = array(
                    'message' => 'Estado actualizado a Recibido'
                );
                echo json_encode($response);

                $data = array(
                    'clave' => '1234',
                    'estado' => 1,
                    'acceso_nivel' => 1,
                    'acceso' => 0,
                    'nombre' => 'Recibido'
                );
                
                $data_string = json_encode($data);
                
                $ch = curl_init('http://192.168.100.19');
                //$ch = curl_init('http://192.168.43.174');
                //$ch = curl_init('http://192.168.1.144');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
                );
            } else {
                $response = array(
                    'message' => 'Error al actualizar el Estado: ' . $conn->error
                );
                echo json_encode($response);
            }

            
        } 
        
        else{


            die("Estado actual no válido: $currentState");
        }


           
        

        

    

    } else {


    $materialQuery = "SELECT * FROM registromaterial WHERE Codigo = ? AND Estado = 'Recibido'";
    $stmtMaterial = $conn->prepare($materialQuery);
    $stmtMaterial->bind_param("s", $studentCode);

    $stmtMaterial->execute();
    $materialResult = $stmtMaterial->get_result();

    if ($materialResult->num_rows > 0)


        $data = array(
            'clave' => '1234',
            'estado' => 1,
            'acceso_nivel' => 0,
            'acceso' => 0,
            'nombre' => 'NA'
        );
        
        $data_string = json_encode($data);
        
        $ch = curl_init('http://192.168.100.19');
        //$ch = curl_init('http://192.168.43.174');
        //$ch = curl_init('http://192.168.1.144');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );

    }
} else {
    $response = array(
        'message' => 'No se encontró estudiante con este serialNumber'
    );
    echo json_encode($response);
}

$stmtStudent->close();
$stmtMaterial->close();
$conn->close();

$result = curl_exec($ch);
      curl_close($ch);
    $conn->close();

?>
