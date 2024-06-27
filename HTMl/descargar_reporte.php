<?php
require('../fpdf/fpdf.php'); // Incluir la clase FPDF

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    include '../connect.php'; // Asegúrate de que este archivo esté correctamente configurado con la conexión a la base de datos

    $conn = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Realiza la consulta para obtener los clientes registrados en el rango de fechas
    $sql = "SELECT NOMBRE, APELLIDO, DIRECCION, EMAIL, FECHA_REGISTRO
            FROM usuario
            WHERE FECHA_REGISTRO BETWEEN ? AND ?
            ORDER BY FECHA_REGISTRO";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $fecha_inicio, $fecha_fin);
    $stmt->execute();
    $result = $stmt->get_result();

    // Configurar la instancia de FPDF
    class PDF extends FPDF
    {
        // Cabecera de página
        function Header()
        {
            // Logo y título
            $this->Image('logo.png', 10, 10, 30);
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(0, 10, 'Reporte de Clientes por Fecha de Registro', 0, 1, 'C');
            $this->Ln(5);
        }

        // Pie de página
        function Footer()
        {
            // Posición a 1.5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Número de página
            $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }
    }

    // Crear nueva instancia de FPDF
    $pdf = new PDF();
    $pdf->AliasNbPages(); // Alias para el total de páginas

    // Añadir una página
    $pdf->AddPage();

    // Establecer formato de fuente
    $pdf->SetFont('Arial', '', 12);

    // Construir el contenido del PDF
    $pdf->Cell(40, 10, 'Nombre', 1);
    $pdf->Cell(40, 10, 'Apellido', 1);
    $pdf->Cell(60, 10, 'Dirección', 1);
    $pdf->Cell(40, 10, 'Email', 1);
    $pdf->Cell(40, 10, 'Fecha de Registro', 1);
    $pdf->Ln();

    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(40, 10, $row['NOMBRE'], 1);
        $pdf->Cell(40, 10, $row['APELLIDO'], 1);
        $pdf->Cell(60, 10, $row['DIRECCION'], 1);
        $pdf->Cell(40, 10, $row['EMAIL'], 1);
        $pdf->Cell(40, 10, $row['FECHA_REGISTRO'], 1);
        $pdf->Ln();
    }

    // Nombre del archivo para descarga
    $filename = 'reporte_clientes_' . date('YmdHis') . '.pdf';

    // Salida del PDF (descarga directa)
    $pdf->Output('D', $filename);

    // Cerrar la conexión y la declaración
    $stmt->close();
    $conn->close();
}
?>
