<?php
session_start();

// Verificar si se ha iniciado sesión correctamente y obtener la dirección de conexión
include 'connect.php';

$errors = array();

// Verificar la conexión
$conn = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];
$respuesta = $_POST['respuesta'];
$nueva_contrasena = $_POST['nueva_contrasena'];
$confirmar_contrasena = $_POST['confirmar_contrasena'];

// Verificar la coincidencia de las contraseñas
if ($nueva_contrasena !== $confirmar_contrasena) {
    $errors['contrasena'] = "Las contraseñas no coinciden.";
}

// Verificar la respuesta
$sql = "SELECT respuesta FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($respuesta_correcta);
    $stmt->fetch();

    if ($respuesta_correcta === $respuesta) {
        // Hashear la nueva contraseña
        $hashed_contrasena = password_hash($nueva_contrasena, PASSWORD_BCRYPT);

        // Actualizar la contraseña en la base de datos
        $sql_update = "UPDATE usuario SET contrasena = ? WHERE email = ?";
        $stmt_update = $conn->prepare($sql_update);

        if ($stmt_update === false) {
            die("Error: " . $conn->error);
        }

        $stmt_update->bind_param("ss", $hashed_contrasena, $email);

        if ($stmt_update->execute()) {
            // Contraseña actualizada correctamente
            $success_message = "Contraseña actualizada exitosamente.";
        } else {
            $errors['general'] = "Error al actualizar la contraseña: " . $stmt_update->error;
        }

        $stmt_update->close();
    } else {
        $errors['respuesta'] = "Respuesta incorrecta.";
    }

    $stmt->close();
} else {
    $errors['email'] = "No se encontró una cuenta con ese email.";
}

$conn->close();

// Si hay errores, redirigir de vuelta a verificar_respuesta.php con los errores
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: verificar_respuesta.php");
    exit();
}

// Mostrar el formulario con el mensaje de éxito y redirección automática
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Contraseña</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="./images/Recurso 1.png">
    <meta http-equiv="refresh" content="3;url=HTML/login.php" /> <!-- Redirección automática después de 5 segundos -->
</head>
<style>
    * {
        font-family: "Montserrat", sans-serif;
    }
</style>
<body class="w-[100%] h-screen bg-gradient-to-b from-pink-300 via-pink-200 to-pink-100 overflow-x-hidden">
    <h1 class="text-center mt-16 text-[2rem] text-[rgb(95,22,24)] font-[600]">Actualizar Contraseña</h1>
    <div class="w-full flex flex-col gap-8 items-center mt-8">
        <div class="text-green-500 text-sm text-center mb-4">
            <?php echo $success_message; ?>
        </div>
        <form class="flex flex-col items-center gap-8 mt-6">
            <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center" type="text" name="email" placeholder="Email" value="<?php echo $email; ?>" disabled>
            <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center" type="password" name="nueva_contrasena" placeholder="Nueva Contraseña" disabled>
            <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center" type="password" name="confirmar_contrasena" placeholder="Confirmar Contraseña" disabled>
        </form>
    </div>
</body>
</html>
