<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $producto_id = $_POST['producto_id'];
    $usuario_id = $_SESSION['usuario_id']; // Asegúrate de que el usuario esté autenticado
    $cantidad = 1; // Por defecto, agregar un producto

    $sql = "SELECT * FROM carrito_compras WHERE Usuario_ID = ? AND productos_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $usuario_id, $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cantidad += $row['cantidad'];
        $sql = "UPDATE carrito_compras SET cantidad = ? WHERE Usuario_ID = ? AND productos_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $cantidad, $usuario_id, $producto_id);
    } else {
        $sql = "INSERT INTO carrito_compras (Fecha, cantidad, Usuario_ID, productos_ID) VALUES (NOW(), ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $cantidad, $usuario_id, $producto_id);
    }

    if ($stmt->execute()) {
        echo "Producto agregado al carrito";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
