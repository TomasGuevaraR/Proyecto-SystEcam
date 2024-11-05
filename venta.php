<?php  
session_start(); 

// Permitir acceso tanto a admin como a user
if (!isset($_SESSION['nombre']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'user')) {
    header('Location: index.php');
    exit;
}

// Al inicio del archivo, después de session_start()
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once("BaseDatos/Conexion.php");

// Inicializa la variable para el modal y la tabla
$showModal = false;
$showTable = true;

// Manejo de errores mejorado
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta sin la columna `estado`
$sql = "SELECT id_producto, nombre_producto, precio_venta FROM productos"; // Eliminada la condición WHERE estado = 1
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt->execute();
$resultProductos = $stmt->get_result();

// Obtener el historial de ventas
$sqlVentas = "SELECT * FROM ventas"; // Asumiendo que tienes una tabla 'ventas'
$stmtVentas = $conn->prepare($sqlVentas);
if (!$stmtVentas) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmtVentas->execute();
$resultVentas = $stmtVentas->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>SystEcam - Módulo de Ventas</title>
    <link rel="stylesheet" href="css/styusuario.css">
</head>
<body>

    <!-- Encabezado con Logo -->
    <header>
        <div class="header-container">
            <img src="img/logo.png" alt="SystEcam" class="logo">
            <h1 class="nombre-software">
                <a href="modulos.php" style="text-decoration: none; color: inherit;">SystEcam</a>
            </h1>
            <div class="dropdown" style="position: absolute; right: 0;">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Menú
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item active" href="modulos.php">Inicio</a></li>
                    <li><a class="dropdown-item" href="#">Venta</a></li>
                    <li><a class="dropdown-item" href="modproducto.php">Producto</a></li>
                    <li><a class="dropdown-item" href="#">Reportes</a></li>
                    <li><a class="dropdown-item" href="#">Clientes</a></li>
                    <li><a class="dropdown-item" href="#">Proveedores</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Cerrar</a></li>
                </ul>
            </div>
        </div>
    </header>
<br>
    <div class="container mt-5">
        <h2>Registrar Venta</h2>
        <form method="POST" action="registrarVenta.php">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="mb-3">
                <label for="producto" class="form-label">Producto</label>
                <select class="form-select" id="producto" name="producto_id" required>
                    <option value="">Seleccione un producto</option>
                    <?php while ($row = $resultProductos->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['id_producto']) ?>" data-precio="<?= htmlspecialchars($row['precio_venta']) ?>">
                            <?= htmlspecialchars($row['nombre_producto']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
            </div>

            <div class="mb-3">
                <label for="precio_total" class="form-label">Precio Total</label>
                <input type="text" class="form-control" id="precio_total" name="precio_total" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Registrar Venta</button>
            <button type="reset" class="btn btn-secondary">Cancelar</button>
        </form>

        <h2 class="mt-5">Historial de Ventas</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>ID Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Total</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($venta = $resultVentas->fetch_assoc()): ?>
                    <tr>
                        <td><?= $venta['id_venta'] ?></td>
                        <td><?= $venta['id_producto'] ?></td>
                        <td><?= $venta['cantidad'] ?></td>
                        <td><?= $venta['precio_total'] ?></td>
                        <td><?= $venta['fecha_venta'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Detectar cambios en el producto seleccionado
    $('#producto').change(function() {
        // Obtener el precio unitario del producto seleccionado
        let precioUnitario = $(this).find(':selected').data('precio');
        
        // Mostrar el precio unitario en el campo de precio total
        $('#precio_total').val(precioUnitario);
        
        // Si hay una cantidad, calcular el precio total
        let cantidad = $('#cantidad').val();
        if (cantidad) {
            $('#precio_total').val(precioUnitario * cantidad);
        }
    });

    // Detectar cambios en la cantidad
    $('#cantidad').on('input', function() {
        // Obtener el precio unitario del producto seleccionado
        let precioUnitario = $('#producto').find(':selected').data('precio');
        
        // Calcular el precio total
        let cantidad = $(this).val();
        if (precioUnitario && cantidad) {
            $('#precio_total').val(precioUnitario * cantidad);
        }
    });
});
</script>


    <footer>
        <p>&copy; 2024 SystEcam. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/editUser.js"></script>
</body>
</html>
