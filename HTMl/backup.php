<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respaldo y Restauración de Base de Datos</title>
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
            text-align: center;
        }

        .btn {
            background-color: #ee0101;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #b30000;
        }

        .btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body class="w-[100%] h-screen bg-gradient-to-b from-pink-400 via-pink-200 to-pink-100 overflow-x-hidden">
    <div class="container">
        <h1>Respaldo y Restauración de Base de Datos</h1>
        <form method="post" action="exportar_bdd.php">
            <button type="submit" class="btn">Exportar Base de Datos</button>
        </form>
        <form method="post" action="importar_bdd.php" enctype="multipart/form-data">
            <input type="file" name="sqlfile" accept=".sql" required class="mt-4 mb-4">
            <button type="submit" class="btn">Importar Base de Datos</button>
        </form>
    </div>
</body>
</html>
