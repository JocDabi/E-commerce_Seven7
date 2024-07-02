<?php
include '../connect.php'; // Incluye tu archivo de conexión a la base de datos

function importDatabase($host, $user, $pass, $dbname, $inputFile) {
    // Ruta completa al ejecutable mysql
    $mysqlPath = '"C:\xampp\mysql\bin\mysql.exe"'; // Asegúrate de ajustar la ruta

    $command = "$mysqlPath --host=$host --user=$user --password=$pass $dbname < $inputFile 2>&1";
    exec($command, $output, $result);

    if ($result == 0) {
        return true;
    } else {
        echo "Command: $command<br>";
        echo "Result: $result<br>";
        echo "Output: " . implode("<br>", $output) . "<br>";
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
        echo "Base de datos importada exitosamente desde " . $_FILES['sqlfile']['name'];
    } else {
        echo "Error al importar la base de datos";
    }
} else {
    echo "Error al subir el archivo";
}
?>
