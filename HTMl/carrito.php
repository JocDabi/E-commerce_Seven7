<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
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
<body class="w-[100%] h-screen bg-gradient-to-b from-pink-300 via-pink-200 to-pink-100 overflow-x-hidden">
    <nav>
        <a class="pt-6 pl-7" href="index.html">
            <img class="w-[68px] h-[68px]" src="../images/Recurso 1.png" alt="">
        </a>
        <div>
            <img class="pt-7 pr-6 w-[70px] cursor-pointer menu-toggle" src="../images/menu.png" alt="">
            <div class="menu">
                <a href="catalogo.php">Catálogo</a>
                <a href="carrito.php">Carrito de compras</a>
                <a href="historial.html">Historial de compras</a>
                <a href="../logout.php" class="login-button" id="logout-button">Cerrar sesión</a>
            </div>
        </div>
    </nav>
    <div class="nav-placeholder"></div>
    <h1 class="text-center my-10 text-[2rem] text-[rgb(95,22,24)] font-[600]">Carrito de Compras</h1>
    <section class="flex flex-col items-center gap-8 mt-10" id="carrito">
        <!-- Aquí se cargarán los productos del carrito -->
    </section>

    <p id="total" class="text-[rgb(95,22,24)] text-xl font-bold mt-8 px-2">Total: $0</p>
    <div class="w-full h-auto flex flex-col items-center my-8">
        <a href="https://wa.me/+584126933166">
            <button class="w-[170px] h-[50px] bg-white rounded-full text-[rgb(95,22,24)] font-bold">Finalizar compra</button>
        </a>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            cargarCarrito();

            async function obtenerInventario() {
                try {
                    const response = await fetch('obtener_productos.php');
                    const inventario = await response.json();
                    console.log('Inventario:', inventario); // Depuración
                    return inventario;
                } catch (error) {
                    console.error('Error al obtener el inventario:', error);
                    return [];
                }
            }

            function cargarCarrito() {
                let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
                const carritoElement = document.getElementById('carrito');
                carritoElement.innerHTML = '';

                if (carrito.length === 0) {
                    carritoElement.innerHTML = '<p class="text-center text-[rgb(95,22,24)] text-[1.3rem] font-[600]">El carrito está vacío.</p>';
                    actualizarTotal();
                    return;
                }

                carrito.forEach(item => {
                    const div = document.createElement('div');
                    div.classList.add('w-[100%]', 'h-[200px]', 'bg-black/15', 'flex');
                    div.innerHTML = `
                        <div class="flex gap-2 items-center">
                            <img class="w-[12%] h-[10%] ml-4 cursor-pointer" src="../images/x.png" alt="" onclick='eliminarDelCarrito(${JSON.stringify(item.id)})'>
                            <img class="w-[70%] h-[80%] pt-6" src="../images/${item.imagen}" alt="${item.nombre}">
                        </div>
                        <div class="flex flex-col gap-2 pt-6 justify-center">
                            <p class="text-[rgb(95,22,24)] font-[500]">${item.nombre}</p>
                            <span class="text-xl text-[rgb(95,22,24)] font-[700]">$${item.precio}</span>
                            <div class="flex pt-6 justify-end">
                                <button class="w-[30px] bg-[rgb(95,22,24)]/50 text-xl text-white" onclick='actualizarCantidad(${JSON.stringify(item.id)}, -1)'> - </button>
                                <div class="w-[40px] bg-white/15 text-center">${item.cantidad}</div>
                                <button class="w-[30px] bg-[rgb(95,22,24)]/50 text-xl text-white" onclick='actualizarCantidad(${JSON.stringify(item.id)}, 1)'> + </button>
                            </div>
                        </div>
                    `;
                    carritoElement.appendChild(div);
                });

                actualizarTotal();
            }

            function actualizarTotal() {
                let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
                let total = carrito.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
                document.getElementById('total').textContent = `Total: $${total.toFixed(2)}`;
            }

            window.eliminarDelCarrito = function(productoID) {
                let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
                carrito = carrito.filter(item => item.id !== productoID);
                localStorage.setItem('carrito', JSON.stringify(carrito));
                cargarCarrito();
                alert('Producto eliminado del carrito');
            };

            window.actualizarCantidad = async function(productoID, cantidad) {
                let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
                const inventario = await obtenerInventario();
                const productoInventario = inventario.find(item => item.id === productoID);
                const producto = carrito.find(item => item.id === productoID);

                if (producto) {
                    const nuevaCantidad = producto.cantidad + cantidad;
                    if (nuevaCantidad <= 0) {
                        eliminarDelCarrito(productoID);
                    } else if (productoInventario && nuevaCantidad <= productoInventario.cantidad) {
                        producto.cantidad = nuevaCantidad;
                        localStorage.setItem('carrito', JSON.stringify(carrito));
                        cargarCarrito();
                    } else {
                        alert('Cantidad no disponible en el inventario.');
                    }
                }
            };

            document.querySelector('.menu-toggle').addEventListener('click', function() {
                const menu = document.querySelector('.menu');
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            });

            // Agregar listener al botón de cerrar sesión
            document.getElementById('logout-button').addEventListener('click', function() {
                localStorage.removeItem('carrito');
            });
        });
    </script>
</body>
</html>
