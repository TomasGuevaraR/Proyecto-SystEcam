<?php

session_start();
if (!isset($_SESSION['nombre']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Conexión a la base de datos
include '../BaseDatos/Conexion.php';

// Verificar que el ID del producto está en la URL
if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];

    // Eliminar el producto de la base de datos
    $query = "DELETE FROM productos WHERE id_producto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_producto);

    if ($stmt->execute()) {
        // Redirigir a la página de eliminar productos después de la eliminación
        header("Location: ../eliminarProducto.php?mensaje=Producto eliminado correctamente");

    } else {
        echo "Error al eliminar el producto.";
    }

    $stmt->close();
}
$conn->close();
?>
