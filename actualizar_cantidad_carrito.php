<?php
session_start();
include 'connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$producto_id = $data['producto_id'];
$cambio = $data['cambio'];
$usuario_id = $_SESSION['usuario_id']; // Asegúrate de que el usuario esté autenticado

$sql = "SELECT cantidad FROM carrito_compras WHERE Usuario_ID = ? AND productos_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $usuario_id, $producto_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nueva_cantidad = $row['cantidad'] + $cambio;
    
    if ($nueva_cantidad > 0) {
        $sql = "UPDATE carrito_compras SET cantidad = ? WHERE Usuario_ID = ? AND productos_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $nueva_cantidad, $usuario_id, $producto_id);
    } else {
        $sql = "DELETE FROM carrito_compras WHERE Usuario_ID = ? AND productos_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $usuario_id, $producto_id);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Producto no encontrado en el carrito']);
}

$stmt->close();
$conn->close();
?>
