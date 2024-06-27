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
$nombre = trim($_POST['nombre']);
$apellido = trim($_POST['apellido']);
$direccion = trim($_POST['direccion']);
$email = trim($_POST['email']);
$contrasena = trim($_POST['contrasena']);
$confirmar_contrasena = trim($_POST['confirmar_contrasena']);
$pregunta_id = $_POST['pregunta'];
$respuesta = trim($_POST['respuesta']);

// Verificar campos vacíos o solo espacios en blanco
if (empty($nombre)) {
    $errors['nombre'] = "El nombre no puede estar vacío.";
}

if (empty($apellido)) {
    $errors['apellido'] = "El apellido no puede estar vacío.";
}

if (empty($direccion)) {
    $errors['direccion'] = "La dirección no puede estar vacía.";
}

if (empty($email)) {
    $errors['email'] = "El email no puede estar vacío.";
}

if (empty($contrasena)) {
    $errors['contrasena'] = "La contraseña no puede estar vacía.";
}

if (empty($confirmar_contrasena)) {
    $errors['confirmar_contrasena'] = "Debe confirmar la contraseña.";
}

if (empty($respuesta)) {
    $errors['respuesta'] = "La respuesta no puede estar vacía.";
}

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

// Obtener la fecha actual
$fecha_registro = date("Y-m-d H:i:s");

// Crear la consulta SQL para insertar los datos en la tabla de usuarios
$sql = "INSERT INTO usuario (NOMBRE, APELLIDO, DIRECCION, EMAIL, CONTRASENA, PREGUNTA_ID, RESPUESTA, FECHA_REGISTRO) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("ssssssss", $nombre, $apellido, $direccion, $email, $hashed_contrasena, $pregunta_id, $respuesta, $fecha_registro);

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
