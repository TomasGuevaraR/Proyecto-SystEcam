<?php
session_start();

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Error de validación CSRF');
}

// Validar datos recibidos
if (!isset($_POST['producto_id']) || !isset($_POST['cantidad']) || !isset($_POST['precio_total'])) {
    die('Datos incompletos');
}

$producto_id = filter_var($_POST['producto_id'], FILTER_VALIDATE_INT);
$cantidad = filter_var($_POST['cantidad'], FILTER_VALIDATE_INT);
$precio_total = filter_var($_POST['precio_total'], FILTER_VALIDATE_FLOAT);

if ($producto_id === false || $cantidad === false || $precio_total === false) {
    die('Datos inválidos');
}

// Verificar stock disponible
$stmt = $conn->prepare("SELECT stock FROM productos WHERE id_producto = ?");
$stmt->bind_param("i", $producto_id);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if ($producto['stock'] < $cantidad) {
    die('Stock insuficiente');
}

// Proceder con la venta
// ... 