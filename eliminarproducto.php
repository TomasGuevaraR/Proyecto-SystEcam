<?php
session_start();
if (!isset($_SESSION['nombre']) || $_SESSION['rol'] !== 'admin') {
    header('Location: modulos.php');
    exit;
}

// Conexión a la base de datos
include 'BaseDatos/conexion.php'; // Verifica que esta ruta sea correcta

// Consulta para obtener todos los productos
$query = "SELECT id_producto, nombre_producto, cantidad, precio_venta FROM productos";
$result = $conn->query($query);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Eliminar Productos</title>
    <link rel="stylesheet" href="css/consultar.css">
</head>
<body>

<!-- Encabezado -->
<header>
        <div class="header-container">
            <a href="modulos.php">
                <img src="img/logo.png" alt="SystEcam" class="logo">
            </a>
            <h1 class="nombre-software">
                <a href="modproducto.php" style="text-decoration: none; color: inherit;">SystEcam</a>
            </h1>
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
    .

<div class="container mt-5">
    <h2 class="text-center">Lista de Productos</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id_producto']; ?></td>
                    <td><?php echo $row['nombre_producto']; ?></td>
                    <td><?php echo $row['cantidad']; ?></td>
                    <td><?php echo $row['precio_venta']; ?></td>
                    <td>
                        <a href="Control/eliminarProductoControl.php?id_producto=<?php echo $row['id_producto']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                    </td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
