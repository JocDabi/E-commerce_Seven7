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
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$direccion = $_POST['direccion'];
$email = $_POST['email'];
$contrasena = $_POST['contrasena'];
$confirmar_contrasena = $_POST['confirmar_contrasena'];
$pregunta_id = $_POST['pregunta'];
$respuesta = $_POST['respuesta'];

// Verificar la coincidencia de las contraseñas
if ($contrasena !== $confirmar_contrasena) {
    $errors['contrasena'] = "Las contraseñas no coinciden.";
}

// Verificar el nombre
if (!preg_match("/^[a-zA-Z\s]*$/", $nombre)) {
    $errors['nombre'] = "El nombre no debe contener números.";
}

// Verificar el apellido
if (!preg_match("/^[a-zA-Z\s]*$/", $apellido)) {
    $errors['apellido'] = "El apellido no debe contener números.";
}

// Verificar que el email tiene un dominio válido
if (!preg_match("/^(?=.*@(gmail\.com|hotmail\.com|outlook\.com))/", $email)) {
    $errors['email'] = "El email debe tener un dominio válido: @gmail.com, @hotmail.com, @outlook.com";
}

// Verificar si el email ya está registrado
$sql_check_email = "SELECT EMAIL FROM usuario WHERE EMAIL = ?";
$stmt_check_email = $conn->prepare($sql_check_email);

if ($stmt_check_email === false) {
    die("Error: " . $conn->error);
}

$stmt_check_email->bind_param("s", $email);
$stmt_check_email->execute();
$stmt_check_email->store_result();

if ($stmt_check_email->num_rows > 0) {
    $errors['email'] = "Este email ya está registrado.";
}

$stmt_check_email->close();

// Si hay errores, redirigir de vuelta al formulario y mostrar los errores
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: HTML/registro.php");
    exit();
}

// Hashear la contraseña
$hashed_contrasena = password_hash($contrasena, PASSWORD_BCRYPT);

// Crear la consulta SQL para insertar los datos en la tabla de usuarios
$sql = "INSERT INTO usuario (NOMBRE, APELLIDO, DIRECCION, EMAIL, CONTRASENA, PREGUNTA_ID, RESPUESTA) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("sssssis", $nombre, $apellido, $direccion, $email, $hashed_contrasena, $pregunta_id, $respuesta);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Registro exitoso, redirigir al usuario a la página de inicio de sesión
    header("Location: HTML/login.php");
    exit(); // Asegura que el script se detenga después de enviar la cabecera de redirección
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
