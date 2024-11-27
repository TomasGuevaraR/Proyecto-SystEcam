<?php

session_start(); 

// Permitir acceso tanto a admin como a user
if (!isset($_SESSION['nombre']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'user')) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>SystEcam</title>
    <link rel="stylesheet" href= "css/reporte.css">
</head>
<body>

    <!-- Encabezado con Logo -->
    <header>
        <div class="header-container">
            <img src="img/logo.png" alt="SystEcam" class="logo">
            <h1 class="nombre-software">SystEcam</h1>
            <div class="dropdown" style="position: absolute; right: 0;">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Menú
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item active" href="#">Venta</a></li>
                    <li><a class="dropdown-item" href="modproducto.php">Producto</a></li>
                    <li><a class="dropdown-item" href="#">Reportes</a></li>
                    <li><a class="dropdown-item" href="#">Clientes</a></li>
                    <li><a class="dropdown-item" href="#">Proveedores</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Cerrar</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
<!-- Contenido principal -->
<main class="container my-4">
    <section class="report-filters bg-light p-4 rounded shadow-sm">
        <h2 class="text-primary mb-3">Reportes</h2>
        <form id="reportFilterForm" method="POST" action="procesarReporte.php">
            <div class="row g-3">
                <!-- Filtro por fecha -->
                <div class="col-md-4">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="fecha_fin" class="form-label">Fecha Fin:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
                </div>

                <!-- Opciones de reportes -->
                <div class="col-md-4">
                    <label for="tipo_reporte" class="form-label">Tipo de Reporte:</label>
                    <select id="tipo_reporte" name="tipo_reporte" class="form-select">
                        <option value="venta" selected>Venta</option>
                        <option value="productos_totales">Productos Totales</option>
                        <option value="por_vencer">Productos por Vencer</option>
                        <option value="por_categoria">Productos por Categoría</option>
                        <option value="por_ubicacion">Productos por Ubicación</option>
                    </select>
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2">Generar Reporte</button>
                <button type="button" class="btn btn-success me-2" onclick="window.print()">Imprimir</button>
                <button type="button" class="btn btn-warning me-2" onclick="exportarExcel()">Exportar a Excel</button>
                <button type="button" class="btn btn-danger" onclick="exportarPDF()">Exportar a PDF</button>
            </div>
        </form>
    </section>

    <!-- Resultados del reporte -->
    <section class="report-results bg-light p-4 mt-4 rounded shadow-sm">
        <h2 class="text-primary mb-3">Resultados del Reporte</h2>
        <div id="reportData">
            <!-- Tabla de resultados -->
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Laboratorio</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Fecha de Vencimiento</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" class="text-center">No hay datos para mostrar. Realice una consulta.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>



     <!-- Pie de Página -->
     <footer>
        <p>&copy; 2024 SystEcam. Todos los derechos reservados.</p>
    </footer>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 
    <script>
        // Función para exportar datos a Excel
        function exportarExcel() {
            window.location.href = 'exportarExcel.php';
        }
    </script>
</body>
</html>


