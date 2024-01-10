
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de préstamo de equipos</title>
  <link rel="icon" href="img/osciloscopio.png" type="image/png">
  <link rel="stylesheet" href="style.css" media="screen">
  
</head>
<body>
<div id="notification" class="notification"></div>

<div style="background-color: #4CAF50; padding: 20px; text-align: center; border-radius: 10px; display: flex; flex-direction: column; align-items: center;">
    <div style="display: flex; align-items: center; margin-bottom: 20px;">
        <a href="../Main/index.html"><img src="img/home_icon.png" alt="Icono" style="width: 30px; height: 30px; margin-right: 10px;"></a>
        <h1 style="color: #fff; margin: 0;">Formulario de préstamo de equipos</h1>
    </div>
    
    <div>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Registros/index.php'">Ver Registros</button>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Alta_usuarios/index.php'">Alta Usuarios</button>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Alta_inventario/index.php'">Alta Inventario</button>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Usuarios_registrados/index.php'">Usuarios Registrados</button>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='../Inventario/index.php'">Inventario</button>
    </div>
</div>






<?php include('consulta.php'); ?>




  <form  id="formulario" action="procesar.php" method="post">
  <div id="formulario" style="margin-top:30px;margin-bottom:50px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.9);">

    <img src="udg.png" alt="">

  </div>
    <label for="nombre">Nombre del Estudiante: (Nombre y Apellidos)</label>
    <input type="text" id="nombre" name="nombre" required><br>
    <label for="codigo">Código del Estudiante:</label>
    <input type="text" id="codigo" name="codigo" required><br>

    <button id="buscarButton" type="button" onclick="buscarEstudiante()">Buscar Estudiante</button>

    <label for="nombre" style ="margin: 20px 0 10px 0;">Nombre del Prestador: (Nombre y Apellidos)</label>
    <input type="text" id="nombre_prestador" name="nombre_prestador" required><br>
    <label for="codigo" style ="margin: 10px 0 10px 0;">Código del Prestador:</label>
    <input type="text" id="codigo_prestador" name="codigo_prestador" required><br>

    <button id="buscarButton" style = "margin: 0 0 20px 0"; type="button" onclick="buscarPrestador()">Buscar Prestador</button>



<input type="checkbox" id="puntas" name="Equipos[]" value="Juego_Puntas_Osc">
<h3>Juego_Puntas_Osc (UD. <?php echo $countPuntas; ?>)</h3>



<h3 for="fuente">Fuentes (UD. <?php echo $countFuentes; ?>)</h3>
    <div id="fuentesDisponibles" class="checkbox-group">
  <input type="checkbox" id="fuente" name="Equipos[]" value="Fuente" onchange="mostrarFuentesDisponibles(this)">
</div>



<h3 for="multimetro">Multímetros (UD. <?php echo $countMultimetros; ?>)</h3>
<div id="multimetrosDisponibles" class="checkbox-group">
  <input type="checkbox" id="multimetro" name="Equipos[]" value="Multímetro" onchange="mostrarMultimetrosDisponibles(this)">
</div>




 


  <label for="otros">Otros:</label>
  <input type="text" id="otros" name="otros">


  <label for="comments">Comentarios:</label>
  <input type="text" id="comm" name="comm">
 
    <button id="buscarButton" type="button" onclick="enviarFormulario()">Enviar</button>
 
 
  </form>
  <script src="../js/script.js"></script>
</body>
</html>