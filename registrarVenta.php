<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    die("Error: usuario no autenticado.");
}

require_once("BaseDatos/Conexion.php");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar el token CSRF
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die("Error de seguridad: token CSRF no válido.");
}

// Asegurarse de que el usuario esté autenticado y obtener su ID
$id_usuario = $_SESSION['id_usuario'];

// Decodificar el JSON de productos
$productosVenta = json_decode($_POST['productos_venta'], true);

if (empty($productosVenta)) {
    echo json_encode(['success' => false, 'message' => 'No se recibieron productos para la venta.']);
    exit;
}

// Comenzar la transacción
$conn->begin_transaction();

try {
    // Recorrer los productos y guardarlos en la tabla de ventas
    foreach ($productosVenta as $producto) {
        $productoId = $producto['producto_id'];
        $cantidad = $producto['cantidad'];
        $precioTotal = $producto['subtotal'];

        // Preparar la declaración SQL con el campo `id_usuario` incluido
        $stmt = $conn->prepare("INSERT INTO ventas (id_producto, cantidad, total, fecha_venta, id_usuario) VALUES (?, ?, ?, NOW(), ?)");
        
        if (!$stmt) {
            throw new Exception("Error en la consulta SQL: " . $conn->error);
        }

        $stmt->bind_param("iidi", $productoId, $cantidad, $precioTotal, $id_usuario);

        if (!$stmt->execute()) {
            throw new Exception("Error al registrar la venta: " . $stmt->error);
        }
    }

    // Confirmar la transacción
    $conn->commit();

    // Responder con éxito
    echo json_encode(['success' => true, 'message' => 'Venta registrada correctamente.']);
} catch (Exception $e) {
    // En caso de error, revertir la transacción
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
