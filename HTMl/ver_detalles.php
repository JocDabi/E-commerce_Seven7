<?php
session_start();
include '../connect.php';

// Asegúrate de que el usuario esté autenticado y tenga un ID en la sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['user_id'];
$comprobante_id = $_GET['comprobante_id'];

// Obtener los detalles del comprobante
$sql = "SELECT * FROM comprobante WHERE ID_COMPROBANTE = ? AND Usuario_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $comprobante_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$comprobante = $result->fetch_assoc();
$stmt->close();

// Obtener los productos del comprobante
$sql_productos = "SELECT cp.*, p.nombre FROM comprobante_producto cp JOIN productos p ON cp.Producto_ID = p.id WHERE cp.Comprobante_ID = ?";
$stmt_productos = $conn->prepare($sql_productos);
$stmt_productos->bind_param("i", $comprobante_id);
$stmt_productos->execute();
$result_productos = $stmt_productos->get_result();
$productos = $result_productos->fetch_all(MYSQLI_ASSOC);
$stmt_productos->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Comprobante</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/Recurso 1.png">
</head>
<style>
    * {
        font-family: "Montserrat", sans-serif;
    }

    nav {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        display: flex;
        justify-content: space-between; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        backdrop-filter: blur(8px);
    }

    .nav-placeholder {
        height: 68px; 
    }

    .menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background: white;
        border: 1px solid #ccc;
        width: 200px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .menu a {
        display: block;
        padding: 10px;
        text-decoration: none;
        color: #333;
    }

    .menu a:hover {
        background-color: #f0f0f0;
    }

    .menu .login-button {
        text-align: center;
        background-color: #ee0101;
        color: white;
        padding: 10px;
        cursor: pointer;
    }

    .menu .login-button:hover {
        background-color: #b30000;
    }
</style>
<body class="w-[100%] bg-gradient-to-b from-pink-300 via-pink-200 to-pink-100 overflow-x-hidden">
    <nav>
        <a class="pt-6 pl-7" href="index.html">
            <img class="w-[68px] h-[68px]" src="../images/Recurso 1.png" alt="">
        </a>
        <div>
            <img class="pt-7 pr-6 w-[70px] cursor-pointer menu-toggle" src="../images/menu.png" alt="">
            <div class="menu">
                <a href="catalogo.php">Catálogo</a>
                <a href="carrito.php">Carrito de compras</a>
                <a href="historial.html">Historial de compras</a>
                <a href="../logout.php" class="login-button">Cerrar sesión</a>
            </div>
        </div>
    </nav>

    <div class="nav-placeholder"></div>

    <h1 class="text-center mt-16 text-[2rem] text-[rgb(95,22,24)] font-[600]">Detalles del Comprobante</h1>

    <div class="w-full flex flex-col items-center mt-8">
        <div class="bg-black/15 w-[80%] mb-4 p-4 rounded-lg">
            <p class="text-[rgb(95,22,24)] text-sm font-[500]">Fecha: <?php echo $comprobante['FECHA']; ?></p>
            <p class="text-[rgb(95,22,24)] text-sm font-[500]">Total: $<?php echo number_format($comprobante['TOTAL'], 2); ?></p>
            <p class="text-[rgb(95,22,24)] text-sm font-[500]">Estado: <?php echo $comprobante['estado']; ?></p>
            <h3 class="text-[rgb(95,22,24)] text-xl font-[600] mt-4">Productos</h3>
            <ul class="list-disc list-inside">
                <?php foreach ($productos as $producto): ?>
                    <li class="text-[rgb(95,22,24)] text-sm font-[500]">
                        <?php echo $producto['nombre']; ?> - Cantidad: <?php echo $producto['Cantidad']; ?> - Precio: $<?php echo number_format($producto['Precio'], 2); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector('.menu-toggle').addEventListener('click', function() {
                const menu = document.querySelector('.menu');
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>
</body>
</html>
