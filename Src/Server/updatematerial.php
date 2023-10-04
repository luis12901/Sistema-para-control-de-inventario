<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Estado</title>
</head>
<body>
    <h1>Actualizar Estado</h1>
    <button onclick="updateStatus()">Actualizar Estado</button>

    <script>
        function updateStatus() {
            // Enviar una solicitud al servidor usando AJAX
            var xhr = new XMLHttpRequest();

            xhr.open("GET", "http://192.168.100.146/update.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert("Estado actualizado correctamente.");
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
