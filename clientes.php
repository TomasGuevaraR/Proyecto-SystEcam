<?php
session_start();
if (!isset($_SESSION['nombre']) || $_SESSION['rol'] !== 'admin') {
    header('Location: modulos.php');
    exit;
}

require_once("BaseDatos/Conexion.php");

$sql = "SELECT * FROM usuarios";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SystEcam - Lista de Usuarios</title>
    <link rel="stylesheet" href="css/styusuario.css">
</head>
<body>

<header>
    <div class="header-container">
        <img src="img/logo.png" alt="SystEcam" class="logo">
        <h1 class="nombre-software"><a href="modulos.php" style="text-decoration: none; color: inherit;">SystEcam</a></h1>
        <div class="dropdown" style="position: absolute; right: 0;">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Menú
            </button>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item active" href="modulos.php">Inicio</a></li>
                <li><a class="dropdown-item" href="#">Venta</a></li>
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
<main class="container my-4">
        <!-- Formulario para gestionar clientes -->
        <section class="client-form bg-light p-4 rounded shadow-sm">
            <br>
            <h2 class="text-primary mb-3">Gestión de Clientes</h2>
            <form id="clienteForm" method="POST" action="procesarCliente.php">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del cliente" required>
                    </div>
                    <div class="col-md-4">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Teléfono">
                    </div>
                    <div class="col-md-4">
                        <label for="correo" class="form-label">Correo Electrónico:</label>
                        <input type="email" id="correo" name="correo" class="form-control" placeholder="Correo electrónico">
                    </div>
                    <div class="col-md-12">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <textarea id="direccion" name="direccion" class="form-control" placeholder="Dirección del cliente" rows="2"></textarea>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">Guardar Cliente</button>
                    <button type="reset" class="btn btn-secondary">Limpiar</button>
                </div>
            </form>
        </section>

        <!-- Tabla de resultados -->
        <section class="client-table bg-light p-4 mt-4 rounded shadow-sm">
            <h2 class="text-primary mb-3">Listado de Clientes</h2>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Juan Pérez</td>
                        <td>555-1234</td>
                        <td>juan.perez@example.com</td>
                        <td>Calle Falsa 123</td>
                        <td>2024-11-22</td>
                        <td>
                            <button class="btn btn-primary btn-sm me-1"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7" class="text-center">No hay clientes registrados.</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>



<footer>
    <p>&copy; 2024 SystEcam. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
