<?php
session_start();
include_once('BaseDatos/conexion.php'); // Asegúrate de ajustar la ruta a tu archivo de conexión

// Definimos el nombre del archivo exportado
$arquivo = 'productos_exportados.xls';

// Crear la tabla HTML
$html = '';
$html .= '<table border="1">';
$html .= '<tr>';
$html .= '<td colspan="7">Lista de Productos</td>';
$html .= '</tr>';

// Encabezados de la tabla
$html .= '<tr>';
$html .= '<td><b>ID</b></td>';
$html .= '<td><b>Nombre del Producto</b></td>';
$html .= '<td><b>Cantidad</b></td>';
$html .= '<td><b>Precio de Costo</b></td>';
$html .= '<td><b>Precio de Venta</b></td>';
$html .= '<td><b>Laboratorio</b></td>';
$html .= '<td><b>Fecha de Vencimiento</b></td>';
$html .= '</tr>';

// Seleccionar todos los elementos de la tabla productos
$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $row["id_producto"] . '</td>';
        $html .= '<td>' . $row["nombre_producto"] . '</td>';
        $html .= '<td>' . $row["cantidad"] . '</td>';
        $html .= '<td>' . $row["precio_costo"] . '</td>';
        $html .= '<td>' . $row["precio_venta"] . '</td>';
        $html .= '<td>' . $row["laboratorio"] . '</td>';
        $html .= '<td>' . date('d/m/Y', strtotime($row["fecha_vencimiento"])) . '</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr><td colspan="7">No hay datos disponibles</td></tr>';
}

// Configuración en la cabecera
header("Expires: Mon, 26 Jul 2227 05:00:00 GMT");
header("Last-Modified: " . gmdate("D,d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/x-msexcel");
header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
header("Content-Description: PHP Generated Data");

// Enviar contenido al archivo
echo $html;
exit;
?>
