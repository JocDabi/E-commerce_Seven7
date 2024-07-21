<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte de Clientes por Fecha de Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: "Montserrat", sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 5rem;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .btn-primary {
            background-color: #ee0101;
            border-color: #ee0101;
        }

        .btn-primary:hover {
            background-color: #b30000;
            border-color: #b30000;
        }

        .form-label {
            color: #5f1618;
            font-size: 20px;
        }

        .form-control {
            border-color: #ccc;
            width: 100%;
            height: 40px;
        }

        .form-control:focus {
            border-color: #ee0101;
            box-shadow: 0 0 0 0.25rem rgba(238, 1, 1, 0.25);
        }

        .error-message {
            color: red;
            font-size: 14px;
            display: none;
        }
    </style>
</head>
<body class="w-[100%] h-screen bg-gradient-to-b from-pink-400 via-pink-200 to-pink-100 overflow-x-hidden">
    <nav class="flex justify-between">
        <a class="pt-10 pl-7" href="admin.html">
            <img class="w-[68px] h-[68px]" src="../images/Recurso 1.png" alt="">
        </a>
    </nav>
    <div class="container bg-gray-200">
        <h1 class="text-center mb-5 text-2xl font-bold">Generar Reporte de Clientes por Fecha de Registro</h1>
        <form id="reporte-clientes-form" action="generar_reporte_clientes.php" method="post">
            <div class="row mb-3">
                <div class="col">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
                    <input type="date" class="form-control rounded-full" id="fecha_inicio" name="fecha_inicio" required>
                </div>
                <div class="col">
                    <label for="fecha_fin" class="form-label">Fecha de Fin:</label>
                    <input type="date" class="form-control rounded-full" id="fecha_fin" name="fecha_fin" required>
                </div>
                <div class="flex justify-center mt-8 text-white">
                    <button type="submit" class="btn btn-primary w-[200px] h-[80px] rounded-xl shadow-xl" name="submit">Generar Reporte de Clientes</button>
                </div>
                <p id="error-message" class="error-message">¡La fecha seleccionada es incorrecta...! Ingrese una fecha correcta.</p>
            </div>
        </form>

        <?php
        if (isset($_GET['file']) && !empty($_GET['file'])) {
            $file = $_GET['file'];
            echo '<div class="text-center mt-3">';
            echo '<a href="' . $file . '" class="btn btn-success" download>Descargar Reporte en PDF</a>';
            echo '</div>';
        }
        ?>
    </div>

    <script>
        document.getElementById('reporte-clientes-form').addEventListener('submit', function(event) {
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = document.getElementById('fecha_fin').value;
            const fechaActual = new Date().toISOString().split('T')[0]; // Obtener la fecha actual en formato YYYY-MM-DD

            if (fechaInicio > fechaFin || fechaInicio > fechaActual || fechaFin > fechaActual) {
                event.preventDefault(); // Evitar el envío del formulario
                const errorMessage = document.getElementById('error-message');
                errorMessage.style.display = 'block'; // Mostrar el mensaje de error
                setTimeout(function() {
                    errorMessage.style.display = 'none'; // Ocultar el mensaje de error después de 5 segundos
                }, 5000);
            }
        });
    </script>
</body>
</html>
