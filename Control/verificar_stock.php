<?php
// Conectar a la base de datos
$conexion = new mysqli('localhost', "root", "", "basesystecam");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Verificar si se enviaron los datos correctamente
if (isset($_POST['producto_id']) && isset($_POST['cantidad'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad = (int)$_POST['cantidad'];

    // Consulta para obtener la cantidad disponible del producto
    $consulta = "SELECT cantidad FROM productos WHERE id_producto = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $cantidad_disponible = (int)$fila['cantidad'];

        if ($cantidad > $cantidad_disponible) {
            echo json_encode([
                'status' => 'error',
                'message' => 'No hay suficiente stock disponible.'
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => 'Stock suficiente.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Producto no encontrado en la base de datos.'
        ]);
    }
    
    $stmt->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Datos no enviados correctamente.'
    ]);
}

$conexion->close();
?>
