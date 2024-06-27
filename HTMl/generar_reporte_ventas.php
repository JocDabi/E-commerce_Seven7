<?php
include '../connect.php'; // Verifica que este archivo esté correctamente configurado con la conexión a la base de datos

// Verifica si se enviaron las fechas desde el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Realiza la consulta para obtener las ventas en el rango de fechas
    $sql = "SELECT hc.FECHA, hc.TOTAL, u.NOMBRE, u.APELLIDO, u.EMAIL
            FROM historial_compras hc
            INNER JOIN usuario u ON hc.Usuario_ID = u.ID_USUARIO
            WHERE hc.FECHA BETWEEN ? AND ?
            ORDER BY hc.FECHA";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $fecha_inicio, $fecha_fin);
    $stmt->execute();
    $result = $stmt->get_result();

    // Comienza la salida HTML
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reporte de Ventas</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <style>
            * {
                font-family: "Montserrat", sans-serif;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            .container {
                max-width: 960px;
                margin: 0 auto;
                padding: 2rem;
            }

            .table {
                width: 100%;
                border-collapse: collapse;
                background-color: rgba(255, 255, 255, 0.9);
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
                overflow: hidden;
            }

            .table th,
            .table td {
                padding: 10px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            .table th {
                background-color: #f2f2f2;
                font-weight: bold;
                color: #5f1618;
            }

            .table tbody tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            .table tbody tr:hover {
                background-color: #f1f1f1;
            }

            .text-center {
                text-align: center;
                margin-bottom: 1rem;
            }

            .mt-5 {
                margin-top: 5rem;
            }

            .mb-3 {
                margin-bottom: 3rem;
            }

            .text-center {
                text-align: center;
            }
        </style>
    </head>
    <body class="w-[100%] h-screen bg-gradient-to-b from-pink-400 via-pink-200 to-pink-100 overflow-x-hidden">
        <nav class="flex justify-between">
            <a class="pt-10 pl-7" href="admin.html">
                <img class="w-[68px] h-[68px]" src="../images/Recurso 1.png" alt="">
            </a>
        </nav>
        <div class="container mt-5">
            <h2 class="text-center mb-3 text-2xl font-bold">Reporte de Ventas</h2>
            <?php if ($result->num_rows > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Total</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['FECHA']; ?></td>
                                <td><?php echo $row['TOTAL']; ?></td>
                                <td><?php echo $row['NOMBRE']; ?></td>
                                <td><?php echo $row['APELLIDO']; ?></td>
                                <td><?php echo $row['EMAIL']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">No se encontraron ventas en el rango de fechas seleccionado.</p>
            <?php endif; ?>
        </div>
    </body>
    </html>
    <?php

    // Cierra la conexión y el statement
    $stmt->close();
    $conn->close();
} else {
    // Redirige a la página del formulario si no se enviaron las fechas correctamente
    header("Location: generar_reporte_ventas.php");
    exit();
}
?>
