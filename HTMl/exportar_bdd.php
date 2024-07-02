<?php
include '../connect.php'; // Incluye tu archivo de conexión a la base de datos

function exportDatabase($host, $user, $pass, $dbname, $outputFile) {
    // Ruta completa al ejecutable mysqldump
    $mysqldumpPath = '"C:\xampp\mysql\bin\mysqldump.exe"'; // Asegúrate de ajustar la ruta

    $command = "$mysqldumpPath --host=$host --user=$user --password=$pass $dbname > $outputFile 2>&1";
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
$outputFile = 'respaldo.sql';

if (exportDatabase($host, $user, $pass, $dbname, $outputFile)) {
    // Descarga el archivo
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($outputFile));
    header('Content-Length: ' . filesize($outputFile));
    readfile($outputFile);
    exit();
} else {
    echo "Error al exportar la base de datos";
}
?>
