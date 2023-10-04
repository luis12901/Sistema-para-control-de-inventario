
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de préstamo de equipos</title>
  <link rel="stylesheet" href="style.css" media="screen">
</head>
<body>


<div id="Encabezado-principal">
  <h1 style="color: #fff;">Formulario de préstamo de equipos</h1>
    <div id="Encabezado">
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='registros.php'">Ver Registros</button>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;">Alta Usuarios</button>
        <button style="background-color: #45a049; color: white; padding: 12px 24px; border: none; border-radius: 20px; cursor: pointer; margin: 0 10px;" onclick="window.location.href='index.php'">Prestar Material</button>
    </div>
</div>




<?php include('consulta.php'); ?>




  <form  id="formulario" action="procesar.php" method="post">
  <div id="formulario" style="margin-top:30px;margin-bottom:50px;">

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


    <div id="checkbox-group">
        <input type="checkbox" id="puntas" name="Equipos[]" value="Juego_Puntas_Osc">
        <label for="puntas">Puntas Osc (UD. <?php echo $countPuntas; ?>)</label>
    </div>

    <div id="checkbox-group">
        <input type="checkbox" id="fuente" name="Equipos[]" value="Fuente" onchange="mostrarFuentesDisponibles(this)">
        <label for="fuente">Fuente (UD. <?php echo $countFuentes; ?>)</label>
        <div id="fuentesDisponibles"></div>
    </div>

    <div id="checkbox-group">
        <input type="checkbox" id="multimetro" name="Equipos[]" value="Multímetro" onchange="mostrarMultimetrosDisponibles(this)">
        <label for="multimetro">Multímetro (UD. <?php echo $countMultimetros; ?>)</label>
        <div id="multimetrosDisponibles"></div>
    </div>




    <label for="otros">Otros:</label>
    <input type="text" id="otros" name="otros">







  <label for="comments">Comentarios:</label>
  <input type="text" id="comm" name="comm">
 

    
    <button id="buscarButton" type="button" onclick="enviarFormulario()">Enviar</button>
  </form>

  <script src="script.js"></script>


</body>
</html>
