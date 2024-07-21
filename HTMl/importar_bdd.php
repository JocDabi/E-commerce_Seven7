<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Base de Datos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="./images/Recurso 1.png">
    <style>
        * {
            font-family: "Montserrat", sans-serif;
        } 
    </style>
</head>
<body class="w-[100%] h-screen bg-gradient-to-b from-pink-300 via-pink-200 to-pink-100 overflow-x-hidden overflow-y-hidden">
    
    <h1 class="text-center mt-16 text-[2rem] text-[rgb(95,22,24)] font-[600]">Importar Base de Datos</h1>

    <div class="w-full flex flex-col gap-8 items-center mt-8">
        <p class="text-sm text-[rgb(95,22,24)] font-[500]"><a class="underline px-2" href="admin.html">Volver al panel de administración</a></p>
    </div>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include '../connect.php'; // Incluye tu archivo de conexión a la base de datos

            function importDatabase($host, $user, $pass, $dbname, $inputFile) {
                // Ruta completa al ejecutable mysql
                $mysqlPath = '"C:\xampp\mysql\bin\mysql.exe"'; // Asegúrate de ajustar la ruta

                $command = "$mysqlPath --host=$host --user=$user --password=$pass $dbname < $inputFile 2>&1";
                exec($command, $output, $result);

                if ($result == 0) {
                    return true;
                } else {
                    echo "<div class='text-red-500 text-center mt-4'>Error al importar la base de datos: " . implode("<br>", $output) . "</div>";
                    return false;
                }
            }

            $host = $db_host;
            $user = $db_usuario;
            $pass = $db_contra;
            $dbname = $db_nombre;

            if (isset($_FILES['sqlfile']) && $_FILES['sqlfile']['error'] == UPLOAD_ERR_OK) {
                $inputFile = $_FILES['sqlfile']['tmp_name'];
                if (importDatabase($host, $user, $pass, $dbname, $inputFile)) {
                    echo "<div class='text-green-500 text-center mt-4'>Base de datos importada exitosamente desde " . htmlspecialchars($_FILES['sqlfile']['name']) . "</div>";
                } else {
                    echo "<div class='text-red-500 text-center mt-4'>Error al importar la base de datos</div>";
                }
            } else {
                echo "<div class='text-red-500 text-center mt-4'>Error al subir el archivo</div>";
            }
        }
    ?>
</body>
</html>
