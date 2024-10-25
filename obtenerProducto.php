<?php
if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];

    // Incluir conexión
    include('BaseDatos/conexion.php');

    // Consulta para obtener los datos del producto
    $sql = "SELECT precio_venta, ubicacion FROM productos WHERE id_producto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $producto = $resultado->fetch_assoc();
        // Devolver los datos como JSON
        echo json_encode($producto);
    } else {
        echo json_encode(['error' => 'Producto no encontrado']);
    }

    // Cerrar la conexión
    $conn->close();
}
?>
