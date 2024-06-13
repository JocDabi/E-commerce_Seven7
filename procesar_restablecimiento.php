<?php
session_start();
include 'connect.php';

$errors = array();

$conn = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];

// Verificar si el email existe en la base de datos
$sql = "SELECT pregunta_id, respuesta FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($pregunta_id, $respuesta);
    $stmt->fetch();

    // Obtener la pregunta de seguridad
    $sql_pregunta = "SELECT pregunta FROM preguntas_seguridad WHERE id = ?";
    $stmt_pregunta = $conn->prepare($sql_pregunta);

    if ($stmt_pregunta === false) {
        die("Error: " . $conn->error);
    }

    $stmt_pregunta->bind_param("i", $pregunta_id);
    $stmt_pregunta->execute();
    $stmt_pregunta->store_result();

    if ($stmt_pregunta->num_rows > 0) {
        $stmt_pregunta->bind_result($pregunta);
        $stmt_pregunta->fetch();
        $_SESSION['email'] = $email;
        $_SESSION['pregunta'] = $pregunta;
        header("Location: verificar_respuesta.php");
        exit();
    }

    $stmt_pregunta->close();
} else {
    $errors['email'] = "No se encontró una cuenta con ese email.";
    $_SESSION['errors'] = $errors;
    header("Location: restablecer_contrasena.php");
    exit();
}

$stmt->close();
$conn->close();
?>
