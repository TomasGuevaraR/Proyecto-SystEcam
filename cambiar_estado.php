<?php
require_once("BaseDatos/Conexion.php");

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$estado = $data['estado'];

// Verifica que el estado sea "Activo" o "Suspendido" y que el ID sea un número
if (!in_array($estado, ['Activo', 'Suspendido']) || !is_numeric($id)) {
    echo json_encode(['success' => false]);
    exit;
}

// Prepara la consulta para actualizar el estado del usuario
$sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $estado, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>
