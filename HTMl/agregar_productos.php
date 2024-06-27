<?php
require '../connect.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar y obtener datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $imagen = trim($_POST['imagen'] ?? '');
    $cantidad = intval($_POST['cantidad'] ?? 0);

    // Validar que los campos obligatorios no estén vacíos
    if (empty($nombre) || empty($descripcion) || empty($imagen)) {
        $response['message'] = 'Por favor completa todos los campos obligatorios';
    } else {
        // Preparar la consulta SQL para insertar el producto
        $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, imagen, cantidad) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssdsi', $nombre, $descripcion, $precio, $imagen, $cantidad);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Producto agregado exitosamente';
        } else {
            $response['message'] = 'Error al agregar el producto: ' . $stmt->error;
        }
        $stmt->close();
    }
} else {
    $response['message'] = 'Método no permitido';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
