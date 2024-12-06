<?php
require_once 'BaseDatos/Conexion.php';

$fecha_inicio = $_POST['fecha_inicio'] ?? '';
$fecha_fin = $_POST['fecha_fin'] ?? '';

if (!empty($fecha_inicio) && !empty($fecha_fin)) {
    $fecha_fin .= ' 23:59:59';

    $query = "SELECT v.id_venta, v.fecha_venta, dv.id_producto, dv.cantidad AS cantidad_producto, dv.precio, dv.subtotal
              FROM ventas v
              INNER JOIN detalle_venta dv ON v.id_venta = dv.id_venta
              WHERE v.fecha_venta BETWEEN ? AND ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('ss', $fecha_inicio, $fecha_fin);
        $stmt->execute();
        $resultados = $stmt->get_result();
        
        if ($resultados->num_rows > 0) {
            while ($row = $resultados->fetch_assoc()) {
                echo "ID Venta: " . $row['id_venta'] . "<br>";
                echo "Fecha Venta: " . $row['fecha_venta'] . "<br>";
                echo "ID Producto: " . $row['id_producto'] . "<br>";
                echo "Cantidad Producto: " . $row['cantidad_producto'] . "<br>";
                echo "Precio: " . $row['precio'] . "<br>";
                echo "Subtotal: " . $row['subtotal'] . "<hr>";
            }
        } else {
            echo "No se encontraron resultados.";
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }
} else {
    echo "Error: No se enviaron fechas válidas para la impresión.";
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Imprimir Reporte</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Reporte de Ventas</h1>
    <table>
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Fecha Venta</th>
                <th>ID Producto</th>
                <th>Cantidad Producto</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultados->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_venta']) ?></td>
                    <td><?= htmlspecialchars($row['fecha_venta']) ?></td>
                    <td><?= htmlspecialchars($row['id_producto']) ?></td>
                    <td><?= htmlspecialchars($row['cantidad_producto']) ?></td>
                    <td>$<?= number_format($row['precio'], 2) ?></td>
                    <td>$<?= number_format($row['subtotal'], 2) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <script>
        window.onload = () => window.print();
    </script>
</body>
</html>
