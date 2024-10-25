<?php
// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Incluir conexión
    include('BaseDatos/conexion.php');

    // Obtener los datos del formulario
    $producto_id = $_POST['producto_id'];
    $nuevo_precio = $_POST['nuevo_precio'];

    // Validar que los campos no estén vacíos
    if (!empty($producto_id) && !empty($nuevo_precio)) {
        // Preparar la consulta de actualización
        $sql = "UPDATE productos SET precio = ? WHERE id_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $nuevo_precio, $producto_id);

        // Ejecutar la consulta y verificar si se actualizó correctamente
        if ($stmt->execute()) {
            echo "El precio del producto ha sido actualizado correctamente.";
        } else {
            echo "Error al actualizar el precio: " . $conn->error;
        }

        // Cerrar la declaración y la conexión
        $stmt->close();
        $conn->close();
    } else {
        echo "Por favor, complete todos los campos.";
    }
}
?>
