<?php
session_start();
include '../connect.php'; // Incluye este archivo y verifica que esté correctamente configurado con la conexión a la base de datos
require_once('../fpdf/fpdf.php'); // Incluye la biblioteca FPDF

$errors = array();

$conn = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si se enviaron las fechas desde el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Realiza la consulta para obtener los clientes registrados en el rango de fechas
    $sql = "SELECT NOMBRE, APELLIDO, DIRECCION, EMAIL, FECHA_REGISTRO
            FROM usuario
            WHERE FECHA_REGISTRO BETWEEN ? AND ?
            ORDER BY FECHA_REGISTRO";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $fecha_inicio, $fecha_fin);
    $stmt->execute();
    $result = $stmt->get_result();

    // Genera el reporte en HTML
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reporte de Clientes</title>
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

            .download-btn {
                display: flex;
                justify-content: center;
                margin-top: 20px;
            }

            .download-btn a {
                background-color: #ee0101;
                color: #fff;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
            }

            .download-btn a:hover {
                background-color: #b30000;
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
            <h2 class="text-center mb-3 text-2xl font-bold">Reporte de Clientes por Fecha de Registro</h2>
            <?php if ($result->num_rows > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Email</th>
                            <th scope="col">Fecha Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['NOMBRE']; ?></td>
                                <td><?php echo $row['APELLIDO']; ?></td>
                                <td><?php echo $row['DIRECCION']; ?></td>
                                <td><?php echo $row['EMAIL']; ?></td>
                                <td><?php echo $row['FECHA_REGISTRO']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <div class="download-btn">
                    <a href="generar_reporte_clientes_pdf.php?fecha_inicio=<?php echo $fecha_inicio; ?>&fecha_fin=<?php echo $fecha_fin; ?>" target="_blank">Descargar Reporte en PDF</a>
                </div>
            <?php else: ?>
                <p class="text-center">No se encontraron clientes registrados en el rango de fechas seleccionado.</p>
            <?php endif; ?>
        </div>
    </body>
    </html>
    <?php
    // Cierra la conexión y el statement
    $stmt->close();
    $conn->close();
    echo ob_get_clean();
} else {
    // Redirige a la página del formulario si no se enviaron las fechas correctamente
    header("Location: formulario_reporte_clientes.php");
    exit();
}
?>
