<?php
session_start();

if (!isset($_SESSION['pregunta'])) {
    echo "No hay pregunta de seguridad configurada.";
    exit();
}

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Respuesta</title>
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
    <h1 class="text-center mt-16 text-[2rem] text-[rgb(95,22,24)] font-[600]">Verificar Respuesta</h1>
    <div class="w-full flex flex-col gap-8 items-center mt-8">
        <form class="flex flex-col items-center gap-8 mt-6" action="actualizar_contrasena.php" method="post">
            <p class="text-center text-[rgb(95,22,24)] font-[500]">
                <?php echo htmlspecialchars($_SESSION['pregunta']); ?>
            </p>
            <div class="flex flex-col items-center">
                <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="text" name="respuesta" placeholder="Respuesta" required>
                <?php if(isset($errors['respuesta'])): ?>
                    <div class="text-red-500 text-center mt-2"><?php echo $errors['respuesta']; ?></div>
                <?php endif; ?>
            </div>
            <div class="flex flex-col items-center">
                <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="password" name="nueva_contrasena" placeholder="Nueva Contraseña" required>
            </div>
            <div class="flex flex-col items-center">
                <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="password" name="confirmar_contrasena" placeholder="Confirmar Contraseña" required>
                <?php if(isset($errors['contrasena'])): ?>
                    <div class="text-red-500 text-center mt-2"><?php echo $errors['contrasena']; ?></div>
                <?php endif; ?>
            </div>
            <button class="w-36 h-10 rounded-full bg-[rgb(95,22,24)] text-white font-[600] transition-all active:bg-transparent active:border-4 active:border-[rgb(95,22,24)] active:text-[rgb(95,22,24)]" type="submit">Actualizar</button>
        </form>
    </div>
</body>
</html>
