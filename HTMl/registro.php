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

<body class="w-[100%] bg-gradient-to-b from-pink-300 via-pink-200 to-pink-100 overflow-x-hidden">
    <h1 class="text-center mt-32 text-[2rem] text-[rgb(95,22,24)] font-[600]">Registrarse</h1>
    
    <div class="w-full flex flex-col gap-8 items-center mt-4">
        <form class="flex flex-col items-center gap-7 mt-6" action="../procesar_registro.php" method="post">
            <div class="relative">
                <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="text" name="nombre" placeholder="Nombre" maxlength="30" required autocomplete="off">
                <p class="text-gray-600 text-xs absolute left-0 top-full mt-1 hidden">Máximo 30 caracteres</p>
                <?php if(isset($_SESSION['errors']['nombre'])): ?>
                    <div class="text-red-500 text-sm text-center mb-4">
                        <?php echo $_SESSION['errors']['nombre']; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="relative">
                <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="text" name="apellido" placeholder="Apellido" maxlength="30" required autocomplete="off">
                <p class="text-gray-600 text-xs absolute left-0 top-full mt-1 hidden">Máximo 30 caracteres</p>
                <?php if(isset($_SESSION['errors']['apellido'])): ?>
                    <div class="text-red-500 text-sm text-center mb-4">
                        <?php echo $_SESSION['errors']['apellido']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="relative">
                <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="text" name="direccion" placeholder="Dirección" maxlength="100" required autocomplete="off">
                <p class="text-gray-600 text-xs absolute left-0 top-full mt-1 hidden">Máximo 100 caracteres</p>
            </div>

            <div class="relative">
                <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="email" name="email" placeholder="Email" required autocomplete="off">
                <?php if(isset($_SESSION['errors']['email'])): ?>
                    <div class="text-red-500 text-sm text-center mb-4">
                        <?php echo $_SESSION['errors']['email']; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="relative">
                <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="password" name="contrasena" placeholder="Contraseña" minlength="8" required autocomplete="off">
                <p class="text-gray-600 text-xs absolute left-0 top-full mt-1 hidden">Mínimo 8 caracteres</p>
            </div>

            <div class="relative">
                <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center placeholder:text-[rgb(95,22,24)] placeholder:font-[500] focus:placeholder-transparent" type="password" name="confirmar_contrasena" placeholder="Confirmar contraseña" minlength="8" required autocomplete="off">
                <?php if(isset($_SESSION['errors']['contrasena'])): ?>
                    <div class="text-red-500 text-sm text-center mb-4">
                        <?php echo $_SESSION['errors']['contrasena']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pregunta de Seguridad -->
            <select class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center" name="pregunta" required>
                <option value="" disabled selected>Seleccione una pregunta de seguridad</option>
                <option value="1">¿Cuál es el nombre de tu primera mascota?</option>
                <option value="2">¿Cuál es el nombre de la ciudad donde naciste?</option>
                <option value="3">¿Cuál es tu comida favorita?</option>
            </select>
            <div class="relative">
                <input class="w-[250px] h-[40px] bg-white/70 outline-0 rounded-full text-center" type="text" name="respuesta" placeholder="Respuesta" maxlength="30" required autocomplete="off">
                <p class="text-gray-600 text-xs absolute left-0 top-full mt-1 hidden">Máximo 30 caracteres</p>
            </div>

            <div class="flex gap-2 ml-10">
                <input type="checkbox" id="privacidad" required> 
                <label class="text-[0.8rem] text-[rgb(95,22,24)]" for="privacidad">He leído y estoy de acuerdo con las <a href="#" class="underline">políticas de privacidad.</a></label>
            </div>
            <button class="w-36 h-10 rounded-full bg-[rgb(95,22,24)] text-white font-[600] transition-all active:bg-transparent active:border-4 active:border-[rgb(95,22,24)] active:text-[rgb(95,22,24)]" type="submit">Registrarse</button>
        </form>
        <p class="text-center text-[rgb(95,22,24)] font-[500] mt-4">
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