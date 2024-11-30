
<?php
session_start();

// Permitir acceso tanto a admin como a user
if (!isset($_SESSION['nombre']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'user')) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>SystEcam</title>
    <link rel="stylesheet" href="css/styproducto.css">
</head>
<body>

    <!-- Encabezado con Logo -->
    <header>
        <div class="header-container">
            <img src="img/logo.png" alt="SystEcam" class="logo">
            <h1 class="nombre-software">SystEcam</h1>
            <div class="dropdown" style="position: absolute; right: 0;">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Menú
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item active" href="#">Venta</a></li>
                    <li><a class="dropdown-item" href="#">Producto</a></li>
                    <li><a class="dropdown-item" href="#">Reportes</a></li>
                    <li><a class="dropdown-item" href="#">Clientes</a></li>
                    <li><a class="dropdown-item" href="#">Proveedores</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Cerrar</a></li>
                </ul>
            </div>
        </div>
    </header>

   
    <div class="container text-center mt-5">
        <h1 class="titulo">Administrador de Productos</h1>
    </div>

    <div class="container text-center mt-4">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <a href="consultar.php" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Consultar
            </a>
        </div>

        <?php if ($_SESSION['rol'] === 'admin') : ?>
            <div class="col-md-2">
                <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modalAgregar">
                    <i class="bi bi-plus-circle"></i> Agregar
                </button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#modalEditar">
                    <i class="bi bi-pencil"></i> Editar
                </button>
            </div>
            <div class="col-md-2">
                <a href="eliminarProducto.php" class="btn btn-danger w-100" onclick="return confirmarEliminacion();">
                    <i class="bi bi-trash"></i> Eliminar
                </a>
            </div>


        <?php endif; ?>
    </div>

    


    <!-- Modal para Agregar -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarLabel">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form method="POST" action="agregarProducto.php">
                    <div class="mb-3">
                        <label for="nombre_producto" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" placeholder="Ingrese nombre del producto">
                    </div>

                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Ingrese la cantidad" min="0">
                    </div>

                    <div class="mb-3">
                        <label for="precio_costo" class="form-label">Precio Costo</label>
                        <input type="number" class="form-control" id="precio_costo" name="precio_costo" placeholder="Ingrese el precio costo" min="0" step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for="precio_venta" class="form-label">Precio de Venta</label>
                        <input type="number" class="form-control" id="precio_venta" name="precio_venta" placeholder="Ingrese el precio de venta" min="0" step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for="laboratorio" class="form-label">Laboratorio</label>
                        <input type="text" class="form-control" id="laboratorio" name="laboratorio" placeholder="Ingrese el laboratorio">
                    </div>

                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Ingrese la categoría">
                    </div>

                    <div class="mb-3">
                        <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                        <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" placeholder="Ingrese la fecha de vencimiento">
                    </div>

                    <div class="mb-3">
                        <label for="cod_invima" class="form-label">codigo invima</label>
                        <input type="text" class="form-control" id="cod_invima" name="cod_invima" placeholder="Ingrese el codigo invima">
                    </div>

                    <div class="mb-3">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ingrese la ubicación">
                    </div>




                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Agregar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
<!-- Modal para Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para editar -->
                <form method="POST" action="actualizarProducto.php">
                    <!-- Selección de producto -->
                    <div class="mb-3">
                        <label for="producto_id" class="form-label">Seleccione el Producto</label>
                        <select class="form-select" id="id_producto" name="id_producto" required onchange="cargarDatosProducto()">
                            <option value="" selected>Seleccione el producto a editar</option>
                            <?php
                            // Incluir conexión
                            include('BaseDatos/conexion.php');
                            // Consulta para obtener los productos
                            $sql = "SELECT id_producto, nombre_producto FROM productos";
                            $resultado = $conn->query($sql);
                            if ($resultado->num_rows > 0) {
                                while ($row = $resultado->fetch_assoc()) {
                                    echo "<option value='{$row['id_producto']}'>{$row['nombre_producto']}</option>";
                                }
                            } else {
                                echo "<option value=''>No hay productos disponibles</option>";
                            }
                            // Cerrar la conexión
                            $conn->close();
                            ?>
                        </select>
                    </div>

                    <!-- Campos a editar (inicialmente vacíos) -->
                    <div class="mb-3">
                         <label for="precio_venta" class="form-label">Precio de Venta</label>
                         <input type="number" class="form-control" id="precio_venta" name="precio_venta" placeholder="Ingrese el precio de venta" min="0" step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ingrese la ubicación">
                    </div>


                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Guardar Cambios
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para cargar los datos del producto seleccionado
    function cargarDatosProducto() {
        var producto_id = document.getElementById('producto_id').value;
        if (producto_id) {
            // Llamada AJAX para obtener los datos del producto
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'obtenerProducto.php?id_producto=' + producto_id, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    var producto = JSON.parse(this.responseText);
                    // Cargar los datos en los campos
                    document.getElementById('precio_venta').value = producto.precio_venta;
                    document.getElementById('ubicacion').value = producto.ubicacion;
                }
            };
            xhr.send();
        }
    }
</script>
   




<script>
    function confirmarEliminacion() {
        // Mensaje de confirmación
        var mensaje = "Eliminar un producto puede tener inconvenientes con la base de datos. ¿Está seguro de que desea continuar?";
        return confirm(mensaje); // Si el usuario hace clic en "Aceptar", retorna true, de lo contrario retorna false.
    }
</script>

    <!-- Pie de Página -->
    <footer>
        <p>&copy; 2024 SystEcam. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

