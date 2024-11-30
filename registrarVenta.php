<?php
session_start();

// Verificación de autenticación del usuario
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit;
}

// ID del usuario autenticado
$idUsuario = $_SESSION['id_usuario'];

// Verificación de CSRF Token
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {

    // Conexión a la base de datos
    require_once("BaseDatos/Conexion.php");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Recibir los datos de la venta
    $productosVenta = json_decode($_POST['productos_venta'], true);
    $totalVenta = 0;

    // Insertar venta en la tabla `ventas`
    $stmtVenta = $conn->prepare("INSERT INTO ventas (id_usuario, fecha_venta, total) VALUES (?, NOW(), 0)");
    if (!$stmtVenta) {
        die("Error al preparar la consulta de ventas: " . $conn->error);
    }
    $stmtVenta->bind_param("i", $idUsuario);
    if (!$stmtVenta->execute()) {
        die("Error en la inserción de la venta: " . $stmtVenta->error);
    }

    // Obtener el ID de la venta registrada
    $ventaId = $conn->insert_id;

    // Insertar cada producto en la tabla `detalle_venta` y actualizar el stock
    foreach ($productosVenta as $producto) {
        $productoId = $producto['producto_id'];
        $cantidadVendida = $producto['cantidad'];
        $precio = $producto['precio_unitario'];
        $subtotal = $producto['subtotal'];

        // Insertar el detalle de la venta
        $stmtDetalle = $conn->prepare("INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio, subtotal) VALUES (?, ?, ?, ?, ?)");
        if (!$stmtDetalle) {
            die("Error al preparar la consulta de detalle de venta: " . $conn->error);
        }
        $stmtDetalle->bind_param("iiidd", $ventaId, $productoId, $cantidadVendida, $precio, $subtotal);
        if (!$stmtDetalle->execute()) {
            die("Error en la inserción de detalle de venta: " . $stmtDetalle->error);
        }

        // Actualizar el stock del producto
        $stmtStock = $conn->prepare("UPDATE productos SET cantidad = cantidad - ? WHERE id_producto = ?");
        if (!$stmtStock) {
            die("Error al preparar la consulta de actualización de stock: " . $conn->error);
        }
        $stmtStock->bind_param("ii", $cantidadVendida, $productoId);
        if (!$stmtStock->execute()) {
            die("Error al actualizar el stock: " . $stmtStock->error);
        }

        // Acumular el total de la venta
        $totalVenta += $subtotal;
    }

    // Actualizar el total de la venta en la tabla `ventas`
    $stmtUpdate = $conn->prepare("UPDATE ventas SET total = ? WHERE id_venta = ?");
    if (!$stmtUpdate) {
        die("Error al preparar la consulta de actualización de total: " . $conn->error);
    }
    $stmtUpdate->bind_param("di", $totalVenta, $ventaId);
    if (!$stmtUpdate->execute()) {
        die("Error al actualizar el total de la venta: " . $stmtUpdate->error);
    }

    // Redirigir con éxito
    header("Location: venta.php?success=true");
    exit;
} else {
    // Token CSRF inválido o solicitud no válida
    header("Location: venta.php?error=token");
    exit;
}
?>
