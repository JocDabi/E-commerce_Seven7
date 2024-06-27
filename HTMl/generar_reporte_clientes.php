<?php
session_start();
include '../connect.php'; // Incluye este archivo y verifica que esté correctamente configurado con la conexión a la base de datos

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

    // Muestra el resultado en una tabla HTML
    if ($result->num_rows > 0) {
        echo '<div class="container mt-5">';
        echo '<h2 class="text-center mb-3">Reporte de Clientes por Fecha de Registro</h2>';
        echo '<table class="table table-striped">';
        echo '<thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Email</th>
                    <th scope="col">Fecha de Registro</th>
                </tr>
              </thead>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['NOMBRE'] . '</td>';
            echo '<td>' . $row['APELLIDO'] . '</td>';
            echo '<td>' . $row['DIRECCION'] . '</td>';
            echo '<td>' . $row['EMAIL'] . '</td>';
            echo '<td>' . $row['FECHA_REGISTRO'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo '<div class="container mt-5">';
        echo '<p class="text-center">No se encontraron clientes registrados en el rango de fechas seleccionado.</p>';
        echo '</div>';
    }

    $stmt->close();
} else {
    // Redirige a la página del formulario si no se enviaron las fechas correctamente
    header("Location: formulario_reporte_clientes.php");
    exit();
}

$conn->close();
?>
