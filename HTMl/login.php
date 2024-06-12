<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesion</title>
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

<body class="w-[100%] h-screen bg-gradient-to-b from-pink-300 via-pink-200 to-pink-100 overflow-x-hidden">
    
    <h1 class="text-center mt-16 text-[2rem] text-[rgb(95,22,24)] font-[600]">Iniciar sesión</h1>

    <div class="w-full flex flex-col gap-8 items-center mt-8">
        <img class="w-[50%]" src="../images/Recurso 4.png" alt="">
        <form class="flex flex-col items-center gap-8 mt-6" action="../procesar_login.php" method="post">
            <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="email" name="email" placeholder="Email" required>
            <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="password" name="contrasena" placeholder="Contraseña" required>
            <?php if (isset($_SESSION['errors']['login'])): ?>
                <div class="text-red-500 text-center mb-4"><?php echo $_SESSION['errors']['login']; ?></div>
                <?php unset($_SESSION['errors']['login']); // Borrar el mensaje de error después de mostrarlo ?>
            <?php endif; ?>
            <button class="w-36 h-10 rounded-full bg-[rgb(95,22,24)] text-white font-[600]" type="submit">Acceder</button>
        </form>
        <p class="text-sm text-[rgb(95,22,24)] font-[500]">¿No tienes una cuenta?<a class="underline px-2" href="registro.php">Registrate</a></p>
    </div>

    <?php
        // Limpiar los errores después de mostrarlos
        if (isset($_SESSION['errors'])) {
                unset($_SESSION['errors']);
        }
    ?>
</body>
</html>

