<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Productos</title>
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
<body class="w-[100%] bg-gradient-to-b from-pink-300 via-pink-200 to-pink-100 overflow-x-hidden">
    <nav>
        <a class="pt-6 pl-7" href="admin.html">
            <img class="w-[68px] h-[68px]" src="../images/Recurso 1.png" alt="">
        </a>
        <div>
            <img class="pt-7 pr-6 w-[70px] cursor-pointer menu-toggle" src="../images/menu.png" alt="">
            <div class="menu">
                <a href="../logout.php" class="login-button">Cerrar sesión</a>
            </div>
        </div>
    </nav>

    <div class="nav-placeholder"></div>

    <h1 class="text-center mt-12 text-[2rem] text-[rgb(95,22,24)] font-[600]">Stock</h1>

    <section class="flex flex-col items-center gap-8 mt-10" id="admin-catalogo">
        <!-- Aquí se cargarán los productos del catálogo -->
    </section>

    <section class="flex flex-col items-center gap-8 mt-10">
        <h2 class="text-center text-[1.5rem] text-[rgb(95,22,24)] font-[600]">Agregar Producto</h2>
        <form action="agregar_productos.php" method="post" id="form-agregar-producto" class="flex flex-col gap-4 w-[80%] max-w-[400px]">
            <input type="text" id="nombre" name="nombre" placeholder="Nombre del Producto" class="p-2 border border-gray-300 rounded" required>
            <input type="text" id="descripcion" name="descripcion" placeholder="Descripción" class="p-2 border border-gray-300 rounded" required>
            <input type="text" id="imagen" name="imagen" placeholder="Nombre del Archivo de Imagen" class="p-2 border border-gray-300 rounded" required>
            <input type="number" id="precio" name="precio" placeholder="Precio" class="p-2 border border-gray-300 rounded" required>
            <input type="number" id="cantidad" name="cantidad" placeholder="Cantidad" class="p-2 border border-gray-300 rounded" required>
            <button type="submit" class="p-2 mb-6 bg-[rgb(95,22,24)] text-white rounded">Agregar Producto</button>
        </form>
    </section>

    <script>
        // Funciones para manejar el catálogo de productos
        function cargarCatalogo() {
            fetch('obtener_productos.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(productos => {
                    const catalogo = document.getElementById('admin-catalogo');
                    catalogo.innerHTML = '';
                    if (productos.length === 0) {
                        catalogo.innerHTML = '<p class="text-center text-[rgb(95,22,24)] text-[1.3rem] font-[600]">No hay productos disponibles.</p>';
                    } else {
                        productos.forEach(item => {
                            const div = document.createElement('div');
                            div.classList.add('w-[100%]', 'h-[240px]', 'bg-black/15', 'flex');
                            div.innerHTML = `
                                <div class="flex gap-2 items-center">
                                    <img class="w-[12%] h-[10%] ml-4 cursor-pointer" src="../images/x.png" alt="" onclick="eliminarProducto(${item.id})">
                                    <img class="w-[70%] h-[80%] pt-6" src="../images/${item.imagen}" alt="${item.nombre}">
                                </div>
                                <div class="flex flex-col gap-2 pt-6 justify-center">
                                    <p class="text-[rgb(95,22,24)] font-[500]">${item.nombre}</p>
                                    <span class="text-xl text-[rgb(95,22,24)] font-[700]">$${item.precio}</span>
                                    <p class="text-[rgb(95,22,24)] font-[400]">${item.descripcion}</p>
                                    <p class="text-[rgb(95,22,24)] font-[400]">Cantidad: ${item.cantidad}</p>
                                    <input type="number" id="cantidad-${item.id}" class="w-[80%] h-[30px] p-2 border border-gray-300 rounded" placeholder="Nueva Cantidad">
                                    <button onclick="editarCantidad(${item.id})" class="w-[80%] h-[28px] bg-[rgb(95,22,24)] text-white rounded">Editar Cantidad</button>
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

        function agregarProducto(event) {
            event.preventDefault();

            const formData = new FormData(document.getElementById('form-agregar-producto'));

            fetch('agregar_productos.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Producto agregado exitosamente');
                    document.getElementById('form-agregar-producto').reset();
                    cargarCatalogo();
                } else {
                    alert('Error al agregar el producto: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error al agregar el producto:', error);
                alert('Error al agregar el producto: ' + error.message);
            });
        }

        function eliminarProducto(id) {
            fetch('eliminar_producto.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Producto eliminado exitosamente');
                    cargarCatalogo();
                } else {
                    alert('Error al eliminar el producto: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error al eliminar el producto:', error);
                alert('Error al eliminar el producto: ' + error.message);
            });
        }

        function editarCantidad(id) {
            const nuevaCantidad = document.getElementById(`cantidad-${id}`).value;
            fetch('editar_cantidad.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id, cantidad: nuevaCantidad })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Cantidad actualizada exitosamente');
                    cargarCatalogo();
                } else {
                    alert('Error al actualizar la cantidad: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error al actualizar la cantidad:', error);
                alert('Error al actualizar la cantidad: ' + error.message);
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            cargarCatalogo();
            document.getElementById('form-agregar-producto').addEventListener('submit', agregarProducto);

            document.querySelector('.menu-toggle').addEventListener('click', function() {
                const menu = document.querySelector('.menu');
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>
</body>
</html>
