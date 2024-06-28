<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
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

    nav {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        display: flex;
        justify-content: space-between; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        backdrop-filter: blur(8px);
    }

    .nav-placeholder {
        height: 68px; 
    }

    .menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background: white;
        border: 1px solid #ccc;
        width: 200px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .menu a {
        display: block;
        padding: 10px;
        text-decoration: none;
        color: #333;
    }

    .menu a:hover {
        background-color: #f0f0f0;
    }

    .menu .login-button {
        text-align: center;
        background-color: #ee0101;
        color: white;
        padding: 10px;
        cursor: pointer;
    }

    .menu .login-button:hover {
        background-color: #b30000;
    }
</style>

<body class="w-[100%] h-auto bg-gradient-to-b from-pink-300 via-pink-200 to-pink-100 overflow-x-hidden">
    <nav>
        <a class="pt-6 pl-7" href="index.html">
            <img class="w-[68px] h-[68px]" src="../images/Recurso 1.png" alt="">
        </a>
        <div>
            <img class="pt-7 pr-6 w-[70px] cursor-pointer menu-toggle" src="../images/menu.png" alt="">
            <div class="menu">
                <a href="catalogo.php">Catálogo</a>
                <a href="carrito.php">Carrito de compras</a>
                <a href="historial.php">Historial de compras</a>
                <a href="../logout.php" class="login-button">Cerrar sesión</a>
            </div>
        </div>
    </nav>

    <div class="nav-placeholder"></div>

    <h1 class="text-center my-10 text-[2rem] text-[rgb(95,22,24)] font-[600]">Catálogo</h1>

    <section class="flex flex-col items-center gap-24" id="catalogo">
        <!-- Aquí se cargarán los productos del catálogo -->
    </section>

    <script>
        // Funciones para manejar el carrito en localStorage
        function obtenerCarrito() {
            return JSON.parse(localStorage.getItem('carrito')) || [];
        }

        function guardarCarrito(carrito) {
            localStorage.setItem('carrito', JSON.stringify(carrito));
        }

        function agregarAlCarrito(producto) {
            const carrito = obtenerCarrito();
            const productoExistente = carrito.find(item => item.id === producto.id);

            if (productoExistente) {
                productoExistente.cantidad += 1;
            } else {
                producto.cantidad = 1;
                carrito.push(producto);
            }

            guardarCarrito(carrito);
            alert('Producto agregado al carrito');
        }

        function eliminarDelCarrito(productoId) {
            let carrito = obtenerCarrito();
            carrito = carrito.filter(item => item.id !== productoId);
            guardarCarrito(carrito);
        }

        function actualizarCantidad(productoId, cantidad) {
            const carrito = obtenerCarrito();
            const producto = carrito.find(item => item.id === productoId);

            if (producto) {
                producto.cantidad += cantidad;
                if (producto.cantidad <= 0) {
                    eliminarDelCarrito(productoId);
                } else {
                    guardarCarrito(carrito);
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            cargarCatalogo();

            function cargarCatalogo() {
                fetch('obtener_productos.php')
                    .then(response => response.json())
                    .then(productos => {
                        const catalogo = document.getElementById('catalogo');
                        catalogo.innerHTML = '';
                        if (productos.length === 0) {
                            catalogo.innerHTML = '<p class="text-center text-[rgb(95,22,24)] text-[1.3rem] font-[600]">No hay productos disponibles.</p>';
                        } else {
                            productos.forEach(item => {
                                const div = document.createElement('div');
                                div.classList.add('w-[80%]', 'h-[550px]', 'bg-black/10', 'rounded-2xl', 'px-4', 'mx-2');
                                div.innerHTML = `
                                    <h3 class="text-center text-[rgb(95,22,24)] text-[1.3rem] font-[600] my-2">${item.nombre}</h3>
                                    <img src="../images/${item.imagen}" alt="${item.nombre}">
                                    <p class="text-[rgb(95,22,24)] font-[400]">${item.descripcion}</p>
                                    <p class="text-end text-[rgb(95,22,24)] text-[1.6rem] font-bold mr-4">$${item.precio}</p>
                                    <div class="flex justify-center my-8">
                                        <button class="w-[170px] h-[40px] bg-white rounded-full text-[rgb(95,22,24)] font-bold" onclick='agregarAlCarrito(${JSON.stringify(item)})'>Agregar al carrito</button>
                                    </div>
                                `;
                                catalogo.appendChild(div);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar el catálogo:', error);
                    });
            }

            document.querySelector('.menu-toggle').addEventListener('click', function() {
                const menu = document.querySelector('.menu');
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>
</body>
</html>
