<?php
session_start();
include 'connect.php';

$errors = array();

$conn = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los datos del formulario
$email = $_POST['email'];
$contrasena = $_POST['contrasena'];

// Verificar si el usuario existe
$sql = "SELECT * FROM usuario WHERE EMAIL = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    // Verificar la contraseña
    if (password_verify($contrasena, $user['CONTRASENA'])) {
        // Contraseña correcta, iniciar sesión
        $_SESSION['user_id'] = $user['ID_USUARIO'];
        $_SESSION['user_nombre'] = $user['NOMBRE'];
        header("Location: HTML/index.html");
        exit();
    } else {
        // Contraseña incorrecta
        $errors['login'] = "Contraseña incorrecta.";
    }
} else {
    // Usuario no encontrado
    $errors['login'] = "El email no está registrado.";
}

$stmt->close();
$conn->close();

// Si hay errores, redirigir de vuelta al formulario de inicio de sesión y mostrar los errores
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: HTML/login.php");
    exit();
}
?>
