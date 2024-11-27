<?php
session_start();
if (!isset($_SESSION['nombre']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'user')) {
    header('Location: index.php');
    exit;
}

require_once("BaseDatos/Conexion.php");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (!isset($_GET['id_venta'])) {
    die("ID de venta no proporcionado.");
}

$id_venta = intval($_GET['id_venta']);

// Obtener detalles de la venta
$sqlDetalle = "SELECT p.nombre_producto, v.cantidad, p.precio_venta, 
                      (v.cantidad * p.precio_venta) AS subtotal 
               FROM detalle_venta v
               INNER JOIN productos p ON v.id_producto = p.id_producto
               WHERE v.id_venta = ?";
$stmtDetalle = $conn->prepare($sqlDetalle);

if ($stmtDetalle === false) {
    die("Error al preparar la consulta de detalle de venta: " . $conn->error);
}

$stmtDetalle->bind_param("i", $id_venta);
$stmtDetalle->execute();
$resultDetalle = $stmtDetalle->get_result();

if (!$resultDetalle->num_rows) {
    die("No se encontraron detalles para esta venta.");
}

// Obtener el nombre del vendedor
$sqlVendedor = "SELECT u.nombre 
                FROM ventas v
                INNER JOIN usuarios u ON v.id_usuario = u.id
                WHERE v.id_venta = ?";
$stmtVendedor = $conn->prepare($sqlVendedor);

if ($stmtVendedor === false) {
    die("Error al preparar la consulta del vendedor: " . $conn->error);
}

$stmtVendedor->bind_param("i", $id_venta);
$stmtVendedor->execute();
$resultVendedor = $stmtVendedor->get_result();
$rowVendedor = $resultVendedor->fetch_assoc();
$vendedor = $rowVendedor['nombre'] ?? 'No disponible';

// Calcular el total de la venta
$sqlTotal = "SELECT SUM(v.cantidad * p.precio_venta) AS total
             FROM detalle_venta v
             INNER JOIN productos p ON v.id_producto = p.id_producto
             WHERE v.id_venta = ?";
$stmtTotal = $conn->prepare($sqlTotal);

if ($stmtTotal === false) {
    die("Error al preparar la consulta del total de venta: " . $conn->error);
}

$stmtTotal->bind_param("i", $id_venta);
$stmtTotal->execute();
$resultTotal = $stmtTotal->get_result();
$rowTotal = $resultTotal->fetch_assoc();
$totalVenta = $rowTotal['total'] ?? 0;


/*
// FUTURO: Obtener el cliente (cuando se cree el módulo de clientes)
// $sqlCliente = "SELECT c.nombre_cliente FROM ventas v
//                INNER JOIN clientes c ON v.id_cliente = c.id_cliente
//                WHERE v.id_venta = ?";
// $stmtCliente = $conn->prepare($sqlCliente);
// $stmtCliente->bind_param("i", $id_venta);
// $stmtCliente->execute();
// $resultCliente = $stmtCliente->get_result();
// $rowCliente = $resultCliente->fetch_assoc(); */


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Detalle de Venta</title>
</head>
<body>
<div class="container mt-5">
    <h2>Detalle de Venta: #<?= htmlspecialchars($id_venta) ?></h2>
    <p><strong>Vendedor:</strong> <?= htmlspecialchars($vendedor) ?></p>
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($detalle = $resultDetalle->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($detalle['nombre_producto']) ?></td>
                    <td><?= htmlspecialchars($detalle['cantidad']) ?></td>
                    <td>$<?= number_format($detalle['precio_venta'], 2) ?></td>
                    <td>$<?= number_format($detalle['subtotal'], 2) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <h3 class="text-end">Total: $<?= number_format($totalVenta, 2) ?></h3>
    <button class="btn btn-secondary" onclick="window.print()">Imprimir Factura</button>
    <a href="venta.php" class="btn btn-primary">Regresar</a>
    <a href="generarFactura.php?id_venta=<?= $id_venta ?>" target="_blank" class="btn btn-primary">Descargar Factura (PDF)</a>


</div>
</body>
</html>
