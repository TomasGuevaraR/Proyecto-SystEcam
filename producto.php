<?php

session_start(); 

// Permitir acceso tanto a admin como a user
if (!isset($_SESSION['nombre']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'user')) {
    header('Location: index.php');
    exit;
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "basesystecam");

// Verificación de la conexión
if ($conn->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    exit;
}

// Consulta para obtener los productos
$sql = "SELECT `id`, `nombre_producto`, `cantidad`, `precio_costo`, `precio_venta`, `laboratorio`, `categoria`, `fecha_vencimiento`, `ubicacion` FROM `productos`";
$result = $conn->query($sql);


if ($result) {
    
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>ID</th><th>Nombre del Producto</th><th>Cantidad</th><th>Precio Costo</th><th>Precio Venta</th><th>Laboratorio</th><th>Categoría</th><th>Fecha de Vencimiento</th><th>Ubicación</th></tr></thead>";
    echo "<tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['nombre_producto']}</td>";
        echo "<td>{$row['cantidad']}</td>";
        echo "<td>{$row['precio_costo']}</td>";
        echo "<td>{$row['precio_venta']}</td>";
        echo "<td>{$row['laboratorio']}</td>";
        echo "<td>{$row['categoria']}</td>";
        echo "<td>{$row['fecha_vencimiento']}</td>";
        echo "<td>{$row['ubicacion']}</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "Error al obtener productos: " . $conn->error;
}


$conn->close();
?>
