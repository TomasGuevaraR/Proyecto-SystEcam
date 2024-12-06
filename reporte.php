<?php
session_start(); 

// Permitir acceso el admin 
if (!isset($_SESSION['nombre']) || ($_SESSION['rol'] !== 'admin')) {
    header('Location: modulos.php');
    exit;
}

// Conexión a la base de datos
require_once 'BaseDatos/Conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>SystEcam - Reporte de Ventas</title>
    <link rel="stylesheet" href="css/reporte.css">
</head>
<body>
    <!-- Encabezado -->
    <header>
        <div class="header-container">
            <a href="modulos.php">
                <img src="img/logo.png" alt="SystEcam" class="logo">
            </a>
            <h1 class="nombre-software"><a href="modulos.php" style="text-decoration: none; color: inherit;">SystEcam</a></h1>
            <div class="dropdown" style="position: absolute; right: 0;">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Menú
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="#">Venta</a></li>
                    <li><a class="dropdown-item" href="modproducto.php">Producto</a></li>
                    <li><a class="dropdown-item active" href="#">Reportes</a></li>
                    <li><a class="dropdown-item" href="#">Clientes</a></li>
                    <li><a class="dropdown-item" href="#">Proveedores</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Cerrar</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="container my-4">
        <!-- Filtros -->
        <section class="bg-light p-4 rounded shadow-sm">
            <h2 class="text-primary mb-3">Reporte de Ventas</h2>
            <form id="reportFilterForm" method="POST" action="reporteVentas.php">
                <div class="row g-3">
                    <!-- Filtro por fecha -->
                    <div class="col-md-6">
                        <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="fecha_fin" class="form-label">Fecha Fin:</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">Generar Reporte</button>
                </div>
            </form>
        </section>
    </main> 

<section class="mt-5 bg-light p-4 rounded shadow-sm">
    <h2 class="text-primary mb-3">Historial de Reportes</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Tipo de Reporte</th>
                    <th>Fecha de Creación</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sqlHistorial = "SELECT * FROM historial_reportes ORDER BY fecha_creacion DESC";
                $resultHistorial = $conn->query($sqlHistorial);

                if ($resultHistorial->num_rows > 0) {
                    while ($row = $resultHistorial->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id_reporte']}</td>
                                <td>{$row['nombre_usuario']}</td>
                                <td>{$row['tipo_reporte']}</td>
                                <td>{$row['fecha_creacion']}</td>
                                <td>{$row['fecha_inicio']}</td>
                                <td>{$row['fecha_fin']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No hay registros en el historial.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>
<br>
<br>
<footer>
    <p>&copy; 2024 SystEcam. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/editUser.js"></script>
</body>
</html>


