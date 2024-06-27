<?php
// Conexión a la base de datos (ejemplo básico)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "seven7";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los datos del cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$nuevaCantidad = $data['cantidad'];

// Preparar la consulta SQL para actualizar la cantidad
$sql = "UPDATE productos SET cantidad = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $nuevaCantidad, $id);

// Ejecutar la consulta y verificar si fue exitosa
if ($stmt->execute()) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'message' => 'Error al actualizar la cantidad: ' . $conn->error));
}

// Cerrar conexión y liberar recursos
$stmt->close();
$conn->close();
?>
