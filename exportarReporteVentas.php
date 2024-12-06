<?php
require_once 'BaseDatos/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir fechas
    $fecha_inicio = $_POST['fecha_inicio'] ?? null;
    $fecha_fin = $_POST['fecha_fin'] ?? null;

    if ($fecha_inicio && $fecha_fin) {
        // Asegurar que la fecha_fin incluye el final del día
        $fecha_fin .= ' 23:59:59';

        // Consulta de datos
        $query = "SELECT v.id_venta, v.fecha_venta, dv.id_producto, dv.cantidad AS cantidad_producto, 
                         dv.precio, dv.subtotal, p.nombre_producto
                  FROM ventas v
                  INNER JOIN detalle_venta dv ON v.id_venta = dv.id_venta
                  INNER JOIN productos p ON dv.id_producto = p.id_producto
                  WHERE v.fecha_venta BETWEEN ? AND ?";
        
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param('ss', $fecha_inicio, $fecha_fin);
            $stmt->execute();
            $resultados = $stmt->get_result();

            // Preparar archivo para exportación
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=reporte_ventas.xls");
            header("Pragma: no-cache");
            header("Expires: 0");

            // Encabezados del archivo, incluyendo el nombre del producto
            echo "ID Venta\tFecha Venta\tID Producto\tNombre Producto\tCantidad Producto\tPrecio\tSubtotal\n";

            // Llenar los datos
            while ($row = $resultados->fetch_assoc()) {
                echo $row['id_venta'] . "\t" .
                     $row['fecha_venta'] . "\t" .
                     $row['id_producto'] . "\t" .
                     $row['nombre_producto'] . "\t" .
                     $row['cantidad_producto'] . "\t" .
                     $row['precio'] . "\t" .
                     $row['subtotal'] . "\n";
            }

            $stmt->close();
        } else {
            die("Error en la consulta: " . $conn->error);
        }
    } else {
        die("Por favor, proporciona fechas válidas.");
    }
} else {
    die("Acceso no permitido.");
}

$conn->close();
