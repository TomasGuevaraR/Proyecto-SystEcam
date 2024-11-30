<?php
// Asegúrate de tener la conexión a la base de datos
require_once '../BaseDatos/Conexion.php';

$errores = [];
$mensaje = '';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener las fechas y otros datos del formulario
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_fin = $_POST['fecha_fin'] ?? '';
    $id_usuario = $_POST['id_usuario'] ?? '';
    $nombre_usuario = $_POST['nombre_usuario'] ?? '';

    // Validar que las fechas no estén vacías
    if (empty($fecha_inicio) || empty($fecha_fin)) {
        $errores[] = 'Por favor, introduce ambas fechas.';
    } else {
        // Guardar reporte en la base de datos
        $query = "INSERT INTO historial_reportes (fecha_inicio, fecha_fin, id_usuario, nombre_usuario) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind de los parámetros con los datos del formulario
            $stmt->bind_param('ssss', $fecha_inicio, $fecha_fin, $id_usuario, $nombre_usuario);

            if ($stmt->execute()) {
                // Mensaje de éxito
                $mensaje = 'Reporte guardado con éxito.';
            } else {
                $errores[] = 'Error al guardar el reporte: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            $errores[] = 'Error en la preparación de la consulta: ' . $conn->error;
        }
    }
    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Reporte</title>
</head>
<body>

<?php if (!empty($errores)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (isset($mensaje)): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($mensaje) ?>
    </div>
<?php endif; ?>

</body>
</html>
