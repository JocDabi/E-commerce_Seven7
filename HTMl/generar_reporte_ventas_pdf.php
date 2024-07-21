<?php
include '../connect.php'; // Incluye este archivo y verifica que esté correctamente configurado con la conexión a la base de datos
require_once('../fpdf/fpdf.php'); // Incluye la biblioteca FPDF

$errors = array();

$conn = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si se enviaron las fechas desde el formulario
if (isset($_GET['fecha_inicio']) && isset($_GET['fecha_fin'])) {
    $fecha_inicio = $_GET['fecha_inicio'];
    $fecha_fin = $_GET['fecha_fin'];

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

    // Crear instancia de FPDF
    class PDF extends FPDF
    {
        // Cabecera de página
        function Header()
        {
            // Logo
            $this->Image('../images/Recurso 1.png', 10, 6, 30);
            // Arial bold 15
            $this->SetFont('Arial', 'B', 15);
            // Movernos a la derecha
            $this->Cell(80);
            // Título
            $this->Cell(30, 10, 'Reporte de Ventas', 0, 1, 'C');
            // Subtítulo
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Seven7 C.A. J-32116366-8', 0, 1, 'C');
            $this->Cell(0, 10, 'Fecha: ' . date('d-m-Y'), 0, 1, 'C');
            // Salto de línea
            $this->Ln(10);
        }

        // Pie de página
        function Footer()
        {
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Número de página
            $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
        }
    }

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Encabezado de la tabla
    $pdf->Cell(40, 10, 'Fecha', 1);
    $pdf->Cell(30, 10, 'Total', 1);
    $pdf->Cell(40, 10, 'Nombre', 1);
    $pdf->Cell(40, 10, 'Apellido', 1);
    $pdf->Cell(50, 10, 'Email', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);

    // Datos de la tabla
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pdf->Cell(40, 10, $row['FECHA'], 1);
            $pdf->Cell(30, 10, '$' . number_format($row['TOTAL'], 2), 1);
            $pdf->Cell(40, 10, $row['NOMBRE'], 1);
            $pdf->Cell(40, 10, $row['APELLIDO'], 1);
            $pdf->Cell(50, 10, $row['EMAIL'], 1);
            $pdf->Ln();
        }
    } else {
        $pdf->Cell(0, 10, 'No se encontraron ventas en el rango de fechas seleccionado.', 1, 1, 'C');
    }

    $stmt->close();
    $conn->close();

    // Salida del PDF
    $pdf->Output('D', 'reporte_ventas.pdf');
} else {
    // Redirige a la página del formulario si no se enviaron las fechas correctamente
    header("Location: generar_reporte_ventas.php");
    exit();
}
?>
