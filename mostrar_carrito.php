<?php
session_start();
include 'connect.php';

$usuario_id = $_SESSION['usuario_id']; // Asegúrate de que el usuario esté autenticado

$sql = "SELECT productos.nombre, productos.precio, carrito_compras.cantidad 
        FROM carrito_compras 
        JOIN productos ON carrito_compras.productos_ID = productos.ID 
        WHERE carrito_compras.Usuario_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];

while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($productos);
?>
