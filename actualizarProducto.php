<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    // Obtener los datos del formulario
    $id_producto = $_POST['id_producto'];
    $precio_venta = $_POST['precio_venta'];
    $ubicacion = $_POST['ubicacion'];

    // Validar que los campos no estén vacíos
    if (isset($_POST['id_producto']) && isset($_POST['precio_venta']) && isset($_POST['ubicacion'])) {
        $id_producto = $_POST['id_producto'];
        $precio_venta = $_POST['precio_venta'];
        $ubicacion = $_POST['ubicacion'];
    
        // Verificar que los campos no estén vacíos
        if (!empty($id_producto) && !empty($precio_venta) && !empty($ubicacion)) {
            // Actualizar el producto en la base de datos
            include('BaseDatos/conexion.php');
            $sql = "UPDATE productos SET precio_venta = ?, ubicacion = ? WHERE id_producto = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('dsi', $precio_venta, $ubicacion, $id_producto);
    
            if ($stmt->execute()) {
                echo "Producto actualizado correctamente.";
            } else {
                echo "Error al actualizar el producto: " . $conn->error;
            }
            $stmt->close();
            $conn->close();
        } else {
            echo "Por favor complete todos los campos.";
        }
    } else {
        echo "Por favor complete todos los campos.";
    }
    
?>