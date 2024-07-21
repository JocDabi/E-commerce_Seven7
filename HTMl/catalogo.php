<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="./images/Recurso 1.png">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
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
            top: 68px; /* Ajustar según la altura de tu barra de navegación */
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

        .swiper-button-next, .swiper-button-prev {
            color: #6e1a1a;
        }

        .swiper-pagination-bullet {
            background: #6e1a1a;
        }

        .swiper-pagination-bullet-active {
            background: #b30000;
        }

        .swiper-container {
            width: 100%;
            box-sizing: border-box;
        }

        .swiper-slide {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: auto; /* Ajuste para centrar correctamente */
            max-width: 300px;
            height: auto;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 1rem;
            padding: 1rem;
            margin: 0 auto;
            box-sizing: border-box;
        }

        .swiper-slide img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .swiper-slide h3, .swiper-slide p, .swiper-slide button {
            margin: 0.5rem 0;
        }
    </style>
</head>
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

    <section class="swiper-container my-10">
        <div class="swiper-wrapper" id="catalogo">
            <!-- Aquí se cargarán los productos del catálogo -->
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </section>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
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
                                div.classList.add('swiper-slide');
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

                            // Inicializar Swiper
                            new Swiper('.swiper-container', {
                                slidesPerView: 'auto',
                                centeredSlides: true,
                                spaceBetween: 20,
                                navigation: {
                                    nextEl: '.swiper-button-next',
                                    prevEl: '.swiper-button-prev',
                                },
                                pagination: {
                                    el: '.swiper-pagination',
                                    clickable: true,
                                },
                                breakpoints: {
                                    640: {
                                        slidesPerView: 'auto',
                                        spaceBetween: 20,
                                    },
                                    768: {
                                        slidesPerView: 'auto',
                                        spaceBetween: 40,
                                    },
                                    1024: {
                                        slidesPerView: 'auto',
                                        spaceBetween: 50,
                                    },
                                },
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
