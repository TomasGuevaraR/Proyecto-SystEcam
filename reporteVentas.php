<?php

session_start();
require_once 'BaseDatos/Conexion.php';

// Permitir acceso tanto a admin como a user
if (!isset($_SESSION['nombre']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'user')) {
    header('Location: index.php');
    exit;
}

// Recupera los valores de la sesión
$id_usuario = $_SESSION['id_usuario'];
$nombre_usuario = $_SESSION['nombre'];

$errores = [];
$resultados = null;
$fecha_inicio = $fecha_fin = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir fechas del formulario
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_fin = $_POST['fecha_fin'] ?? '';

    // Validar que las fechas no estén vacías
    if (!empty($fecha_inicio) && !empty($fecha_fin)) {
        // Asegurarse de incluir todas las horas del día en fecha_fin
        $fecha_fin .= ' 23:59:59';

        $query = "SELECT v.id_venta, v.fecha_venta, v.cantidad, v.total, 
                 dv.id_producto, dv.cantidad AS cantidad_producto, dv.precio, dv.subtotal,
                 p.nombre_producto
          FROM ventas v
          INNER JOIN detalle_venta dv ON v.id_venta = dv.id_venta
          INNER JOIN productos p ON dv.id_producto = p.id_producto
          WHERE v.fecha_venta BETWEEN ? AND ?";

        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('ss', $fecha_inicio, $fecha_fin);
            if ($stmt->execute()) {
                $resultados = $stmt->get_result();
            } else {
                $errores[] = 'Error en la ejecución de la consulta: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $errores[] = 'Error en la preparación de la consulta: ' . $conn->error;
        }
    } else {
        $errores[] = 'Por favor, introduce ambas fechas.';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SystEcam - Módulo de Ventas</title>
    <link rel="stylesheet" href="css/reporteVenta.css">
</head>
<body>
<header>
    <div class="header-container">
        <a href="modulos.php">
            <img src="img/logo.png" alt="SystEcam" class="logo">
        </a>
        <h1 class="nombre-software"><a href="reporte.php" style="text-decoration: none; color: inherit;">SystEcam</a></h1>
        <div class="dropdown" style="position: absolute; right: 0;">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Menú
            </button>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item active" href="modulos.php">Inicio</a></li>
                <li><a class="dropdown-item" href="venta.php">Venta</a></li>
                <li><a class="dropdown-item" href="modproducto.php">Producto</a></li>
                <li><a class="dropdown-item" href="reporte.php">Reportes</a></li>
                <li><a class="dropdown-item" href="usuarios.php">Usuarios</a></li>
                <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Cerrar</a></li>
            </ul>
        </div>
    </div>
</header>

<br>

<?php if (!empty($errores)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<br>


<div class="d-flex gap-3 my-3">
    <form method="POST" action="Control/guardar_reporte.php">
        <input type="hidden" name="fecha_inicio" value="<?= htmlspecialchars($fecha_inicio) ?>">
        <input type="hidden" name="fecha_fin" value="<?= htmlspecialchars($fecha_fin) ?>">
        <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($id_usuario) ?>">
        <input type="hidden" name="nombre_usuario" value="<?= htmlspecialchars($nombre_usuario) ?>">
        <button type="submit" class="btn btn-success">Guardar Reporte</button>
    </form>

    <form method="POST" action="imprimirReporte.php">
        <input type="hidden" name="fecha_inicio" value="<?= htmlspecialchars($fecha_inicio) ?>">
        <input type="hidden" name="fecha_fin" value="<?= htmlspecialchars($fecha_fin) ?>">
        <button type="submit" class="btn btn-primary">Imprimir Reporte</button>
    </form>

    <form method="POST" action="exportarReporteVentas.php">
        <input type="hidden" name="fecha_inicio" value="<?= htmlspecialchars($fecha_inicio) ?>">
        <input type="hidden" name="fecha_fin" value="<?= htmlspecialchars($fecha_fin) ?>">
        <button type="submit" class="btn btn-info">Exportar a Excel</button>
    </form>
</div>
<?php if ($resultados && $resultados->num_rows > 0): ?>
    <section class="mt-4 bg-light p-4 rounded shadow-sm">
        <h3 class="text-success">Resultados</h3>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID Venta</th>
                    <th>Fecha Venta</th>
                    <th>ID Producto</th>
                    <th>Nombre del Producto</th>
                    <th>Cantidad Producto</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            
            <tbody>
                <?php while ($row = $resultados->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_venta']) ?></td>
                        <td><?= htmlspecialchars($row['fecha_venta']) ?></td>
                        <td><?= htmlspecialchars($row['id_producto']) ?></td>
                        <td><?= htmlspecialchars($row['nombre_producto']) ?></td>
                        <td><?= htmlspecialchars($row['cantidad_producto']) ?></td>
                        <td>$<?= number_format($row['precio'], 2) ?></td>
                        <td>$<?= number_format($row['subtotal'], 2) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
    
<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <div class="alert alert-warning">No se encontraron resultados.</div>
<?php endif; ?>

<footer class="text-center mt-5">
    <p>&copy; 2024 SystEcam. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
