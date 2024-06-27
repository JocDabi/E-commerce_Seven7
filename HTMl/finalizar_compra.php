<?php
// finalizar_compra.php

session_start();
include '../connect.php';

// Asegúrate de que el usuario esté autenticado y tenga un ID en la sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['user_id'];
$carrito = json_decode($_POST['carrito'], true);
$total = 0;

foreach ($carrito as $producto) {
    $total += $producto['precio'] * $producto['cantidad'];
}

$fecha = date('Y-m-d');
$estado = 'pendiente';

$conn->begin_transaction();

try {
    // Insertar en la tabla comprobante
    $sql = "INSERT INTO comprobante (FECHA, TOTAL, Usuario_ID, estado) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sdis", $fecha, $total, $usuario_id, $estado);
        $stmt->execute();
        $comprobante_id = $stmt->insert_id;
        $stmt->close();

        // Insertar en la tabla comprobante_producto
        $sql_item = "INSERT INTO comprobante_producto (Comprobante_ID, Producto_ID, Cantidad, Precio) VALUES (?, ?, ?, ?)";
        $stmt_item = $conn->prepare($sql_item);
        if ($stmt_item) {
            foreach ($carrito as $producto) {
                $stmt_item->bind_param("iiid", $comprobante_id, $producto['id'], $producto['cantidad'], $producto['precio']);
                $stmt_item->execute();
            }
            $stmt_item->close();
        }

        // Insertar en la tabla historial_compras
        $sql_historial = "INSERT INTO historial_compras (FECHA, TOTAL, Usuario_ID, Comprobante_ID) VALUES (?, ?, ?, ?)";
        $stmt_historial = $conn->prepare($sql_historial);
        if ($stmt_historial) {
            $stmt_historial->bind_param("sdii", $fecha, $total, $usuario_id, $comprobante_id);
            $stmt_historial->execute();
            $stmt_historial->close();
        }

        $conn->commit();

        // Limpiar el carrito
        unset($_SESSION['carrito']);
        header('Location: historial.php?success=1');
    } else {
        throw new Exception("Error preparando statement: " . $conn->error);
    }
} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>