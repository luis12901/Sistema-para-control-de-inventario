<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laboratorio";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Obtener la fecha actual en el formato de MySQL (YYYY-MM-DD) GMT-06:00
$hoy = date('Y-m-d', time() - 21600);

$sql = "SELECT ID, Nombre_Est, Codigo_Est, Nombre_Prest, Codigo_Prest, Equipos, Otros, FechayHora, Estado, Comentarios FROM registromaterial WHERE DATE(FROM_UNIXTIME(FechayHora)) = '$hoy'";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    // Crear un archivo Excel
    $excelFileName = 'registromaterial_' . $hoy . '.xls';
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$excelFileName\"");

    // Salida de datos del archivo Excel
    echo "ID\tNombre Estudiante\tCódigo Estudiante\tNombre Prestador\tCódigo Prestador\tEquipos\tOtros\tFecha y Hora\tEstado\tComentarios\n";

    while ($row = $result->fetch_assoc()) {
        echo "{$row['ID']}\t{$row['Nombre_Est']}\t{$row['Codigo_Est']}\t{$row['Nombre_Prest']}\t{$row['Codigo_Prest']}\t{$row['Equipos']}\t{$row['Otros']}\t{$row['FechayHora']}\t{$row['Estado']}\t{$row['Comentarios']}\n";
    }

    $conexion->close();
} else {
    echo "No se encontraron resultados para la fecha de hoy: fecha actual -- $hoy";
    $conexion->close();
}
?>
