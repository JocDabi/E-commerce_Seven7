<?php
include '../connect.php'; // Incluye el archivo de conexión a la base de datos

// Verifica si se envió una solicitud POST y si se recibió el ID de la compra
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['compra_id'])) {
    $compra_id = $_POST['compra_id'];

    // Actualiza el estado de la compra a 'realizada' en la tabla 'comprobante'
    $sql = "UPDATE comprobante SET estado = 'realizada' WHERE ID_COMPROBANTE = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $compra_id);
    $stmt->execute();
    $stmt->close();

    // Redirige de vuelta a la página desde donde se hizo la solicitud
    header('Location: admin.html'); // Cambia esto por la página adecuada
    exit;
}

// Consulta las compras pendientes para confirmar desde la tabla 'comprobante'
$sql = "SELECT * FROM comprobante WHERE estado = 'pendiente' ORDER BY FECHA DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar compra</title>
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
</style>
<body class="w-[100%] h-screen bg-gradient-to-b from-pink-300 via-pink-200 to-pink-100 overflow-x-hidden">
    <nav class="flex justify-between">
        <a class="pt-10 pl-7" href="admin.html">
            <img class="w-[68px] h-[68px]" src="../images/Recurso 1.png" alt="">
        </a>
    </nav>
    <h1 class="text-center mt-8 text-[2rem] text-[rgb(95,22,24)] font-[600]">Confirmar compra</h1>
    <div class="container mx-auto px-4 mt-10">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='bg-white p-4 rounded-lg shadow-md mb-4'>";
                echo "<p><strong>Compra ID:</strong> " . $row['ID_COMPROBANTE'] . "</p>";
                echo "<p><strong>Usuario ID:</strong> " . $row['Usuario_ID'] . "</p>";
                echo "<p><strong>Total:</strong> $" . $row['TOTAL'] . "</p>";
                echo "<p><strong>Fecha:</strong> " . $row['FECHA'] . "</p>";
                echo "<form method='post' action='confirmar_compra.php' class='mt-4'>"; // Cambiado a confirmar_compra.php
                echo "<input type='hidden' name='compra_id' value='" . $row['ID_COMPROBANTE'] . "'>";
                echo "<button type='submit' class='bg-green-500 text-white px-4 py-2 rounded'>Confirmar</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p class='text-center text-[rgb(95,22,24)] text-[1.3rem] font-[600]'>No hay compras pendientes.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
