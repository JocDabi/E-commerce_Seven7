<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="./images/Recurso 1.png">
</head>

<style>
    *{
        font-family: "Montserrat", sans-serif;
    }
</style>

<body class="w-[100%] h-screen bg-gradient-to-b from-pink-300 via-pink-200 to-pink-100 overflow-x-hidden">
    <h1 class="text-center mt-32 text-[2rem] text-[rgb(95,22,24)] font-[600]">Registrarse</h1>
    
    <div class="w-full flex flex-col gap-8 items-center mt-4">
        <form class="flex flex-col items-center gap-4 mt-6" action="../procesar_registro.php" method="post">
            <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="text" name="nombre" placeholder="Nombre" required>
            <?php if(isset($_SESSION['errors']['nombre'])): ?>
                <div class="text-red-500 text-sm text-center mb-4">
                    <?php echo $_SESSION['errors']['nombre']; ?>
                </div>
            <?php endif; ?>
            
            <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="text" name="apellido" placeholder="Apellido" required>
            <?php if(isset($_SESSION['errors']['apellido'])): ?>
                <div class="text-red-500 text-sm text-center mb-4">
                    <?php echo $_SESSION['errors']['apellido']; ?>
                </div>
            <?php endif; ?>

            <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="text" name="direccion" placeholder="Dirección" required>
            <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="email" name="email" placeholder="Email" required>
            <?php if(isset($_SESSION['errors']['email'])): ?>
                <div class="text-red-500 text-sm text-center mb-4">
                    <?php echo $_SESSION['errors']['email']; ?>
                </div>
            <?php endif; ?>
            
            <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="password" name="contrasena" placeholder="Contraseña" required>
            <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="password" name="confirmar_contrasena" placeholder="Confirmar contraseña" required>
            <?php if(isset($_SESSION['errors']['contrasena'])): ?>
                <div class="text-red-500 text-sm text-center mb-4">
                    <?php echo $_SESSION['errors']['contrasena']; ?>
                </div>
            <?php endif; ?>

            <!-- Pregunta de Seguridad -->
            <select class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center" name="pregunta" required>
                <option value="" disabled selected>Seleccione una pregunta de seguridad</option>
                <option value="1">¿Cuál es el nombre de tu primera mascota?</option>
                <option value="2">¿Cuál es el nombre de la ciudad donde naciste?</option>
                <option value="3">¿Cuál es tu comida favorita?</option>
            </select>
            <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center" type="text" name="respuesta" placeholder="Respuesta" required>

            <div class="flex gap-2 ml-10">
                <input type="checkbox" id="privacidad" required> 
                <label class="text-[0.8rem] text-[rgb(95,22,24)]" for="privacidad">He leído y estoy de acuerdo con las <a href="#" class="underline">políticas de privacidad.</a></label>
            </div>
            <button class="w-36 h-10 rounded-full bg-[rgb(95,22,24)] text-white font-[600]" type="submit">Registrarse</button>
        </form>
    </div>

    <?php
        // Limpiar los errores después de mostrarlos
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
    ?>
</body>
</html>
