
<?php

/*
   Project: Laboratory Equipment Inventory Management
   Description: PHP script to retrieve the counts of available equipment types from the inventory.
   Author: Jose Luis Murillo Salas
   Creation Date: August 20, 2023
   Contact: joseluis.murillo2022@hotmail.com
  */

?>


<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "laboratorio";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
  }

    // Consulta para contar la cantidad de 'Juego_Puntas_Osc' disponibles
  $sql = "SELECT COUNT(*) as countPuntas FROM inventario WHERE Material = 'Juego_Puntas_Osc' AND Estado = 'Disponible'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $countPuntas = $row['countPuntas'];

  // Consulta para contar la cantidad de 'Fuente' disponibles
  $sql = "SELECT COUNT(*) as countFuentes FROM inventario WHERE Material = 'Fuente' AND Estado = 'Disponible'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $countFuentes = $row['countFuentes'];

  // Consulta para contar la cantidad de 'Multimetro' disponibles
  $sql = "SELECT COUNT(*) as countMultimetros FROM inventario WHERE Material = 'Multimetro' AND Estado = 'Disponible'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $countMultimetros = $row['countMultimetros'];

  $conn->close();
  ?>