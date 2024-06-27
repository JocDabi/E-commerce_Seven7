<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reportes de Ventas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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

        body {
            background: linear-gradient(to bottom, #f77062, #fe5196);
            overflow-x: hidden;
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
        }

        .form-control {
            border-color: #ccc;
        }

        .form-control:focus {
            border-color: #ee0101;
            box-shadow: 0 0 0 0.25rem rgba(238, 1, 1, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-5">Generar Reportes de Ventas</h1>
        <form action="generar_reporte_ventas.php" method="post">
            <div class="row mb-3">
                <div class="col">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                </div>
                <div class="col">
                    <label for="fecha_fin" class="form-label">Fecha de Fin:</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                </div>
                <div class="col align-self-end">
                    <button type="submit" class="btn btn-primary w-100" name="submit">Generar Reporte de Ventas</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
