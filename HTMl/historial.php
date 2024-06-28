<?php
session_start();
include '../connect.php';

// Asegúrate de que el usuario esté autenticado y tenga un ID en la sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['user_id'];

// Obtener el historial de compras del usuario
$sql = "SELECT * FROM historial_compras WHERE Usuario_ID = ? ORDER BY FECHA DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$compras = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de compras</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="./images/Recurso 1.png">
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

    /* Placeholder para evitar el solapamiento */
    .nav-placeholder {
        height: 68px; 
    }

    /* Ocultar el menú inicialmente */
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

    /* Estilo de los enlaces del menú */
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

<body class="w-[100%] h-auto bg-gradient-to-b from-pink-300 via-pink-200 to-pink-100 overflow-x-hidden">
    <nav>
        <a class="pt-6 pl-7" href="index.html">
            <img class="w-[68px] h-[68px]" src="../images/Recurso 1.png" alt="">
        </a>
        <div>
            <img class="pt-7 pr-6 w-[70px] cursor-pointer menu-toggle" src="../images/menu.png" alt="">
            <div class="menu">
                <a href="catalogo.php">Catálogo</a>
                <a href="carrito.php">Carrito de compras</a>
                <a href="historial.php">Historial de compras</a>
                <a href="../logout.php" class="login-button">Cerrar sesión</a>
            </div>
        </div>
    </nav>
    
    <h1 class="text-center mt-32 text-[2rem] text-[rgb(95,22,24)] font-[600]">Historial de compras</h1>

    <div class="w-full flex flex-col items-center mt-8">
        <?php foreach ($compras as $compra): ?>
            <div class="bg-black/15 h-[120px] w-[80%] mb-4 p-4 rounded-lg">
                <h3 class="text-[rgb(95,22,24)] text-xl font-[600]">Compra <?php echo isset($compra['estado']) && $compra['estado'] === 'pendiente' ? 'pendiente' : 'realizada'; ?></h3>
                <p class="text-[rgb(95,22,24)] text-sm font-[500]">Fecha: <?php echo $compra['FECHA']; ?></p>
                <a href="ver_detalles.php?comprobante_id=<?php echo $compra['Comprobante_ID']; ?>" class="w-40 bg-white/90 rounded-full ml-[150px] text-[rgb(95,22,24)] font-bold text-center p-2">Ver detalles</a>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        // JavaScript para manejar el clic en el menú hamburguesa
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            const menu = document.querySelector('.menu');
            // Alternar la visibilidad del menú
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });
    </script>
</body>
</html>
