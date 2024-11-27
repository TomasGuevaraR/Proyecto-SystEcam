<?php
require('lib/fpdf.php');
require_once("BaseDatos/Conexion.php");

// Validar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Validar el ID de venta
if (!isset($_GET['id_venta'])) {
    die("ID de venta no proporcionado.");
}

$id_venta = intval($_GET['id_venta']);

// Consulta para obtener los detalles de la venta
$sqlDetalle = "SELECT p.nombre_producto, v.cantidad, p.precio_venta, 
                      (v.cantidad * p.precio_venta) AS subtotal
               FROM detalle_venta v
               INNER JOIN productos p ON v.id_producto = p.id_producto
               WHERE v.id_venta = ?";
$stmtDetalle = $conn->prepare($sqlDetalle);

if (!$stmtDetalle) {
    die("Error al preparar la consulta de detalles: " . $conn->error);
}

// Asociar parámetros y ejecutar la consulta
$stmtDetalle->bind_param("i", $id_venta);

if (!$stmtDetalle->execute()) {
    die("Error al ejecutar la consulta de detalles: " . $stmtDetalle->error);
}

// Obtener los resultados
$resultDetalle = $stmtDetalle->get_result();

if ($resultDetalle->num_rows == 0) {
    die("No se encontraron detalles para esta venta.");
}

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Factura - Detalle de Venta #'.$id_venta, 0, 1, 'C');
$pdf->Ln(10);

// Encabezados
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, 'Producto', 1);
$pdf->Cell(30, 10, 'Cantidad', 1);
$pdf->Cell(40, 10, 'Precio Unitario', 1);
$pdf->Cell(40, 10, 'Subtotal', 1);
$pdf->Ln();

// Detalles
$pdf->SetFont('Arial', '', 12);
$total = 0;
while ($row = $resultDetalle->fetch_assoc()) {
    $pdf->Cell(80, 10, $row['nombre_producto'], 1);
    $pdf->Cell(30, 10, $row['cantidad'], 1);
    $pdf->Cell(40, 10, '$' . number_format($row['precio_venta'], 2), 1);
    $pdf->Cell(40, 10, '$' . number_format($row['subtotal'], 2), 1);
    $pdf->Ln();
    $total += $row['subtotal'];
}

// Total
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(150, 10, 'Total', 1);
$pdf->Cell(40, 10, '$' . number_format($total, 2), 1);

// Salida
$pdf->Output();
?>
