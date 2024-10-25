<?php
require_once("BaseDatos/conexion.php");

$nombre_producto = $_POST["nombre_producto"];
$cantidad = $_POST["cantidad"];
$precio_costo = $_POST["precio_costo"];
$precio_venta = $_POST["precio_venta"];
$laboratorio = $_POST["laboratorio"];
$categoria = $_POST["categoria"];
$fecha_vencimiento = $_POST["fecha_vencimiento"];
$ubicacion = $_POST["ubicacion"];

// Consulta SQL para insertar los productos
$sql = "INSERT INTO productos (nombre_producto, cantidad, precio_costo, precio_venta, laboratorio, categoria, fecha_vencimiento, ubicacion) 
        VALUES ('$nombre_producto', '$cantidad', '$precio_costo', '$precio_venta', '$laboratorio', '$categoria', '$fecha_vencimiento', '$ubicacion')";

// Ejecutar la consulta y verificar si fue exitosa
if ($conn->query($sql) === TRUE) {
    echo "Registro exitoso";
} else {
    echo "Error en el registro: " . $conn->error;
}

$conn->close();

?>
