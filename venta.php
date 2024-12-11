<?php  
session_start(); 

// Permitir acceso tanto a admin como a user
if (!isset($_SESSION['nombre']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'user')) {
    header('Location: index.php');
    exit;
}

// CSRF Token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once("BaseDatos/Conexion.php");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los productos junto con la cantidad
$sql = "SELECT id_producto, nombre_producto, precio_venta, cantidad FROM productos";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt->execute();
$resultProductos = $stmt->get_result();



// Consulta para obtener el historial de ventas
$sqlVentas = "SELECT * FROM ventas";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SystEcam - Módulo de Ventas</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/styusuario.css">
</head>
<body>

<!-- Encabezado con Logo -->
<header>
    <div class="header-container">
        <a href="modulos.php">
            <img src="img/logo.png" alt="SystEcam" class="logo">
         </a>
        <h1 class="nombre-software"><a href="modulos.php" style="text-decoration: none; color: inherit;">SystEcam</a></h1>
        <div class="dropdown" style="position: absolute; right: 0;">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Menú
            </button>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item active" href="modulos.php">Inicio</a></li>
                <li><a class="dropdown-item" href="venta.php">Venta</a></li>
                <li><a class="dropdown-item" href="modproducto.php">Producto</a></li>
                <li><a class="dropdown-item" href="reporte.php">Reportes</a></li>
                <li><a class="dropdown-item" href="usuarios.php">Usuarios</a></li>
                <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Cerrar</a></li>
            </ul>
        </div>
    </div>
</header>
<br><br><br>

<div class="container mt-5">
    <h2>Registrar Venta</h2>
    <form id="agregarProductoForm" class="mb-4">
        <div class="mb-3">
            <label for="producto" class="form-label">Producto</label>
            <select class="form-select" id="producto" name="producto_id" required>
                <option value="">Seleccione un producto</option>
                <?php while ($row = $resultProductos->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($row['id_producto']) ?>" 
                    data-precio="<?= htmlspecialchars($row['precio_venta']) ?>"
                    data-nombre="<?= htmlspecialchars($row['nombre_producto']) ?>"
                    data-stock="<?= htmlspecialchars($row['cantidad']) ?>">
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

        <button type="button" id="agregarProducto" class="btn btn-success">Agregar Producto</button>
    </form>

    <!-- Lista de productos agregados -->
    <div class="mb-4">
        <h3>Productos en esta venta</h3>
        <table class="table" id="productosAgregados">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td id="totalVenta">0.00</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Registrar Venta Form -->
    <form method="POST" action="registrarVenta.php" id="registrarVentaForm">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="productos_venta" id="productos_venta" value="">
        <button type="submit" class="btn btn-primary" id="registrarVenta">Registrar Venta</button>
        <button type="button" class="btn btn-secondary" id="cancelarVenta">Cancelar Venta</button>
    </form>

    <?php
// Definir la consulta SQL para obtener el historial de ventas
$sqlVentas = "
    SELECT v.id_venta, SUM(d.cantidad) AS total_cantidad, v.total, v.fecha_venta
    FROM ventas v
    INNER JOIN detalle_venta d ON v.id_venta = d.id_venta
    WHERE v.id_usuario = ?
    GROUP BY v.id_venta, v.total, v.fecha_venta
    ORDER BY v.fecha_venta DESC
    LIMIT 25";


// Preparamos la consulta
$stmtVentas = $conn->prepare($sqlVentas);

// Verificamos si la preparación fue exitosa
if ($stmtVentas === false) {
    die("Error al preparar la consulta: " . $conn->error);
}

// Vinculamos el parámetro (id_usuario de la sesión)
$stmtVentas->bind_param("i", $_SESSION['id_usuario']);  // "i" es para entero (id_usuario)

// Ejecutamos la consulta
$stmtVentas->execute();

// Obtenemos los resultados
$resultVentas = $stmtVentas->get_result();
?>

<div class="container mt-5">
    <h2 class="mt-5">Historial de Ventas</h2>
    <table class="table">
    <thead>
        <tr>
            <th>ID Venta</th>
            <th>Cantidad</th>
            <th>Precio Total</th>
            <th>Fecha</th>
            <th>Acciones</th> <!-- Nueva columna -->
        </tr>
    </thead>
    <tbody>
        <?php while ($venta = $resultVentas->fetch_assoc()): ?>
            <tr>
                <td><?= $venta['id_venta'] ?></td>
                <td><?= $venta['total_cantidad'] ?></td>
                <td><?= $venta['total'] ?></td>
                <td><?= $venta['fecha_venta'] ?></td>
                <td>
                    <!-- Botón para ver el detalle -->
                    <a href="detalleVenta.php?id_venta=<?= $venta['id_venta'] ?>" class="btn btn-info btn-sm">Ver Detalle</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</div>


<script>
$(document).ready(function() {
    let productosEnVenta = [];
    
    // Actualizar el precio total y verificar el stock al cambiar producto o cantidad
    function actualizarPrecio() {
        let precioUnitario = $('#producto').find(':selected').data('precio');
        let stockDisponible = $('#producto').find(':selected').data('stock');
        let cantidad = $('#cantidad').val();

        // Verificar si la cantidad es mayor al stock
        if (cantidad > stockDisponible) {
            alert(`Cantidad solicitada supera el stock disponible de ${stockDisponible}.`);
            $('#cantidad').val(stockDisponible); // Opcional: establece la cantidad al stock máximo
            cantidad = stockDisponible;
        }

        if (precioUnitario && cantidad) {
            $('#precio_total').val(precioUnitario * cantidad);
        }
    }

    $('#producto, #cantidad').on('change input', actualizarPrecio);

    // Añadir producto a la tabla
    $('#agregarProducto').click(function() {
        let productoId = $('#producto').val();
        let nombreProducto = $('#producto').find(':selected').data('nombre');
        let cantidad = $('#cantidad').val();
        let precioUnitario = $('#producto').find(':selected').data('precio');
        let stockDisponible = $('#producto').find(':selected').data('stock');
        let subtotal = precioUnitario * cantidad;

        if (!productoId || !cantidad) {
            alert('Por favor seleccione un producto y especifique la cantidad.');
            return;
        }

        // Verificar si la cantidad es mayor al stock disponible antes de añadir
        if (cantidad > stockDisponible) {
            alert(`Cantidad solicitada supera el stock disponible de ${stockDisponible}.`);
            return;
        }

        // Agregar producto a la lista de productos en venta
        productosEnVenta.push({
            producto_id: productoId,
            nombre: nombreProducto,
            cantidad: cantidad,
            precio_unitario: precioUnitario,
            subtotal: subtotal
        });

        // Agregar la fila a la tabla de productos
        let row = `<tr>
            <td>${nombreProducto}</td>
            <td>${cantidad}</td>
            <td>${precioUnitario}</td>
            <td>${subtotal}</td>
            <td><button type="button" class="btn btn-danger btn-sm eliminarProducto">Eliminar</button></td>
        </tr>`;
        $('#productosAgregados tbody').append(row);

        // Actualizar total
        let total = parseFloat($('#totalVenta').text()) + subtotal;
        $('#totalVenta').text(total.toFixed(2));

        // Reset formulario
        $('#producto').val('');
        $('#cantidad').val('');
        $('#precio_total').val('');
    });

    // Eliminar producto de la lista y tabla
    $(document).on('click', '.eliminarProducto', function() {
        let row = $(this).closest('tr');
        let subtotal = parseFloat(row.find('td:eq(3)').text());

        // Eliminar producto de la lista
        let index = row.index();
        productosEnVenta.splice(index, 1);

        // Eliminar la fila de la tabla
        row.remove();

        // Actualizar total
        let total = parseFloat($('#totalVenta').text()) - subtotal;
        $('#totalVenta').text(total.toFixed(2));
    });

    // Al enviar el formulario
    $('#registrarVentaForm').submit(function(e) {
        e.preventDefault();

        // Pasar los productos en venta al formulario
        $('#productos_venta').val(JSON.stringify(productosEnVenta));

        // Enviar formulario
        $(this).unbind('submit').submit();
    });

    $('#cancelarVenta').click(function() {
        // Limpiar todo
        $('#productosAgregados tbody').empty();
        $('#totalVenta').text('0.00');
        productosEnVenta = [];
    });
});

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/verificar_stock.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
