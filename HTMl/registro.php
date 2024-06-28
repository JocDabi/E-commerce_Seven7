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
    * {
        font-family: "Montserrat", sans-serif;
    }
    .error {
        border: 2px solid red;
    }
</style>

<body class="w-full h-auto bg-gradient-to-b from-pink-300 via-pink-200 to-pink-100 overflow-x-hidden">
    <h1 class="text-center mt-8 text-2xl text-red-900 font-semibold">Registrarse</h1>
    
    <div class="w-full flex flex-col items-center mt-4">
        <form class="flex flex-col items-center gap-7 mt-6 w-full max-w-xl" action="../procesar_registro.php" method="post">
            
            <div class="relative flex items-center w-full">
                <label class="text-red-900 text-lg font-bold w-1/3 text-right pr-4" for="nombre">Nombre:</label>
                <input class="w-2/4 h-10 bg-white/70 outline-none rounded-full text-center placeholder:text-red-900 placeholder:font-medium focus:placeholder-transparent" type="text" name="nombre" maxlength="20" required autocomplete="off">
                <p class="text-gray-600 text-xs absolute left-32 top-full mt-1 hidden">Máximo 20 caracteres</p>
            </div>
            <?php if(isset($_SESSION['errors']['nombre'])): ?>
                <div class="text-red-500 text-sm text-center">
                    <?php echo $_SESSION['errors']['nombre']; ?>
                </div>
            <?php endif; ?>
            
            <div class="relative flex items-center w-full">
                <label class="text-red-900 text-lg font-bold w-1/3 text-right pr-4" for="apellido">Apellido:</label>
                <input class="w-2/4 h-10 bg-white/70 outline-none rounded-full text-center placeholder:text-red-900 placeholder:font-medium focus:placeholder-transparent" type="text" name="apellido" maxlength="20" required autocomplete="off">
                <p class="text-gray-600 text-xs absolute left-32 top-full mt-1 hidden">Máximo 20 caracteres</p>
            </div>
            <?php if(isset($_SESSION['errors']['apellido'])): ?>
                <div class="text-red-500 text-sm text-center mt-2">
                    <?php echo $_SESSION['errors']['apellido']; ?>
                </div>
            <?php endif; ?>

            <div class="relative flex items-center w-full">
                <label class="text-red-900 text-lg font-bold w-1/3 text-right pr-4" for="direccion">Dirección:</label>
                <input class="w-2/4 h-10 bg-white/70 outline-none rounded-full text-center placeholder:text-red-900 placeholder:font-medium focus:placeholder-transparent" type="text" name="direccion" maxlength="20" required autocomplete="off">
                <p class="text-gray-600 text-xs absolute left-32 top-full mt-1 hidden">Máximo 20 caracteres</p>
            </div>

            <div class="relative flex items-center w-full">
                <label class="text-red-900 text-lg font-bold w-1/3 text-right pr-4" for="email">Email:</label>
                <input class="w-2/4 h-10 bg-white/70 outline-none rounded-full text-center placeholder:text-red-900 placeholder:font-medium focus:placeholder-transparent" type="email" name="email" required autocomplete="off">
            </div>
            <?php if(isset($_SESSION['errors']['email'])): ?>
                <div class="text-red-500 text-sm text-center mt-2">
                    <?php echo $_SESSION['errors']['email']; ?>
                </div>
            <?php endif; ?>
            
            <div class="relative flex items-center w-full">
                <label class="text-red-900 text-lg font-bold w-1/3 text-right pr-4" for="contrasena">Contraseña:</label>
                <input class="w-2/4 h-10 bg-white/70 outline-none rounded-full text-center placeholder:text-red-900 placeholder:font-medium focus:placeholder-transparent" type="password" name="contrasena" minlength="8" required autocomplete="off">
                <p class="text-gray-600 text-xs absolute left-32 top-full mt-1 hidden">Mínimo 8 caracteres</p>
            </div>

            <div class="relative flex items-center w-full">
                <label class="text-red-900 text-lg font-bold w-1/3 text-right pr-4" for="confirmar_contrasena">Confirmar contraseña:</label>
                <input class="w-2/4 h-10 bg-white/70 outline-none rounded-full text-center placeholder:text-red-900 placeholder:font-medium focus:placeholder-transparent" type="password" name="confirmar_contrasena" minlength="8" required autocomplete="off">
            </div>
            <?php if(isset($_SESSION['errors']['contrasena'])): ?>
                <div class="text-red-500 text-sm text-center mt-2">
                    <?php echo $_SESSION['errors']['contrasena']; ?>
                </div>
            <?php endif; ?>

            <!-- Pregunta de Seguridad -->
            <div class="flex items-center w-full">
                <label for="pregunta" class="text-red-900 text-lg font-bold w-1/3 text-right pr-4">Pregunta de seguridad:</label>
                <select class="w-2/4 h-10 bg-white/70 outline-none rounded-full text-center" name="pregunta" required>
                    <option value="" disabled selected>Seleccione una pregunta de seguridad</option>
                    <option value="1">¿Cuál es el nombre de tu primera mascota?</option>
                    <option value="2">¿Cuál es el nombre de la ciudad donde naciste?</option>
                    <option value="3">¿Cuál es tu comida favorita?</option>
                </select>
            </div>
            
            <div class="relative flex items-center w-full">
                <label class="text-red-900 text-lg font-bold w-1/3 text-right pr-4" for="respuesta">Respuesta:</label>
                <input class="w-2/4 h-10 bg-white/70 outline-none rounded-full text-center placeholder:text-red-900 placeholder:font-medium focus:placeholder-transparent" type="text" name="respuesta" maxlength="30" required autocomplete="off">
                <p class="text-gray-600 text-xs absolute left-32 top-full mt-1 hidden">Máximo 30 caracteres</p>
            </div>

            <div class="flex items-center w-full pl-20 mt-2">
                <input class="mr-2" type="checkbox" id="privacidad" required> 
                <label class="text-sm text-red-900" for="privacidad">He leído y estoy de acuerdo con las <a href="#" class="underline">políticas de privacidad.</a></label>
            </div>

            <button class="w-36 h-10 rounded-full bg-red-900 text-white font-semibold transition-all active:bg-transparent active:border-4 active:border-red-900 active:text-red-900" type="submit">Registrarse</button>
        </form>

        <p class="text-center text-red-900 font-medium mt-4">
            ¿Tienes una cuenta? <a href="login.php" class="underline">Iniciar sesión</a>
        </p>
    </div>

    <?php
        // Limpiar los errores después de mostrarlos
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
    ?>

    <script>
        // Función para mostrar el mensaje cuando el input está enfocado
        function showMessage(event) {
            const input = event.target;
            const message = input.nextElementSibling;
            if (message && message.tagName === 'P') {
                message.classList.remove('hidden');
            }
        }

        // Función para ocultar el mensaje cuando el input pierde el enfoque
        function hideMessage(event) {
            const input = event.target;
            const message = input.nextElementSibling;
            if (message && message.tagName === 'P') {
                message.classList.add('hidden');
            }
        }

        // Función para verificar el contenido del input
        function validateInput(event) {
            const input = event.target;
            const minLength = input.getAttribute('minlength');
            const maxLength = input.getAttribute('maxlength');

            if ((minLength && input.value.length < minLength) || (maxLength && input.value.length > maxLength)) {
                input.classList.add('error');
            } else {
                input.classList.remove('error');
            }
        }

        // Añadir los eventos a los inputs
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', showMessage);
            input.addEventListener('blur', hideMessage);
            input.addEventListener('input', validateInput);
        });
    </script>
</body>
</html>