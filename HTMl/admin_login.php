<?php
session_start();

// Verificar si se enviaron datos de inicio de sesión para administrador
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simular datos de administrador (reemplaza con tus datos reales o de base de datos)
    $admin_username = "admin";
    $admin_password = "123"; // Cambia por una contraseña segura y almacenada correctamente

    // Obtener los datos ingresados por el administrador
    $input_admin_username = $_POST["admin_username"];
    $input_admin_password = $_POST["admin_password"];

    // Verificar las credenciales del administrador
    if ($input_admin_username == $admin_username && $input_admin_password == $admin_password) {
        // Credenciales válidas, iniciar sesión de administrador
        $_SESSION["admin_logged_in"] = true;

        // Redirigir al panel de administración o a la página que desees
        header("Location: admin.html");
        exit;
    } else {
        // Credenciales inválidas, mostrar un mensaje de error (opcional)
        $_SESSION['errors']['admin_login'] = "Nombre de usuario o contraseña incorrectos para administrador.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión como administrador</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="./images/Recurso 1.png">
</head>

<style>
    * {
        font-family: "Montserrat", sans-serif;
    } 
</style>

<body class="w-[100%] h-screen bg-gradient-to-b from-pink-300 via-pink-200 to-pink-100 overflow-x-hidden overflow-y-hidden">
    
    <h1 class="text-center mt-16 text-[2rem] text-[rgb(95,22,24)] font-[600]">Iniciar sesión como administrador</h1>

    <div class="w-full flex flex-col gap-8 items-center mt-8">
        <img class="w-[50%]" src="../images/Recurso 4.png" alt="">
        <form class="flex flex-col items-center gap-8 mt-6" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="text" name="admin_username" placeholder="Nombre de usuario" required>
            <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="password" name="admin_password" placeholder="Contraseña" required>
            <?php if (isset($_SESSION['errors']['admin_login'])): ?>
                <div class="text-red-500 text-center mb-4"><?php echo $_SESSION['errors']['admin_login']; ?></div>
                <?php unset($_SESSION['errors']['admin_login']); // Borrar el mensaje de error después de mostrarlo ?>
            <?php endif; ?>
            <button class="w-36 h-10 rounded-full bg-[rgb(95,22,24)] text-white font-[600] transition-all active:bg-transparent active:border-4 active:border-[rgb(95,22,24)] active:text-[rgb(95,22,24)]" type="submit">Acceder</button>
        </form>
        <p class="text-sm text-[rgb(95,22,24)] font-[500]">¿No eres administrador?<a class="underline px-2" href="login.php">Volver al inicio de sesión</a></p>
        <p class="text-sm text-[rgb(95,22,24)] font-[500]">¿Olvidaste tu contraseña?<a class="underline px-2" href="../restablecer_contrasena.php">Recupérala aquí</a></p>
    </div>

    <?php
        // Limpiar los errores después de mostrarlos
        if (isset($_SESSION['errors'])) {
                unset($_SESSION['errors']);
        }
    ?>
</body>
</html>