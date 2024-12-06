<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_producto = $_POST['id_producto'];
    $precio_venta = $_POST['precio_venta'];
    $ubicacion = $_POST['ubicacion'];

    if (!empty($id_producto) && !empty($precio_venta) && !empty($ubicacion)) {
        include('BaseDatos/conexion.php'); // Ajusta la ruta a tu archivo de conexión

        $sql = "UPDATE productos SET precio_venta = ?, ubicacion = ? WHERE id_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('dsi', $precio_venta, $ubicacion, $id_producto);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Producto actualizado correctamente.');
                    window.location.href = 'modproducto.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error al actualizar el producto.');
                    window.location.href = 'modproducto.php';
                  </script>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<script>
                alert('Por favor complete todos los campos.');
                window.location.href = 'modproducto.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Método no permitido.');
            window.location.href = 'modproducto.php';
          </script>";
}
?>
