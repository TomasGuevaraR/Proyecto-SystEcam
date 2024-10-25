<?php
session_start();
if (!isset($_SESSION['nombre']) || $_SESSION['rol'] !== 'admin') {
    header('Location: modulos.php');
    exit;
}


require_once("BaseDatos/Conexion.php");

// Inicializa la variable para el modal
$showModal = false;
$showTable = true; // Variable para controlar si se muestra la tabla


// Manejo de errores mejorado
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Usar declaraciones preparadas para prevenir inyecciones SQL
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>SystEcam - Lista de Usuarios</title>
    <link rel="stylesheet" href="css/styusuario.css">
</head>
<body>

    <!-- Encabezado con Logo -->
    <header>
        <div class="header-container">
            <img src="img/logo.png" alt="SystEcam" class="logo">
            <h1 class="nombre-software">
                <a href="modulos.php" style="text-decoration: none; color: inherit;">SystEcam</a>
            </h1>
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

    <br>
    <br>
    <br>

    <div class="container">
        <?php if ($showTable): // Solo muestra la tabla si el acceso está permitido ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($fila = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($fila['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['usuario']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['email']) . "</td>";
                        echo "<td>" . ($fila['roles_id'] == 1 ? 'Admin' : 'Usuario') . "</td>";
                        echo "<td><button type='button' class='btn btn-primary btn-edit' data-bs-toggle='modal' data-bs-target='#editModal' ";
                        echo "data-id='" . htmlspecialchars($fila['id']) . "' ";
                        echo "data-nombre='" . htmlspecialchars($fila['nombre']) . "' ";
                        echo "data-usuario='" . htmlspecialchars($fila['usuario']) . "' ";
                        echo "data-email='" . htmlspecialchars($fila['email']) . "' ";
                        echo "data-rol='" . htmlspecialchars($fila['roles_id']) . "'>";
                        echo "Editar</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay resultados</td></tr>";
                }
                ?>
                </tbody>
            </table>
        <?php endif; // Fin de la verificación de acceso ?>
    </div>

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="editForm" action="control/rolcontrol.php" method="POST">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="mb-3">
                        <label for="edit-rol" class="form-label">Rol</label>
                        <select class="form-select" id="edit-rol" name="rol" required>
                             <option value="2">Usuario</option>
                             <option value="1">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="editar">Guardar cambios</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Acceso Denegado -->
    <div class="modal fade" id="accessDeniedModal" tabindex="-1" aria-labelledby="accessDeniedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accessDeniedModalLabel">Acceso Denegado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Lo sentimos, solo los administradores pueden acceder a esta página.
                </div>
                <div class="modal-footer">
                    <a href="modulos.php" class="btn btn-primary">Ir a Módulos</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir el script para mostrar el modal si es necesario -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($showModal): ?>
                var myModal = new bootstrap.Modal(document.getElementById('accessDeniedModal'));
                myModal.show();
            <?php endif; ?>
        });
    </script>

    <br><br>
    <footer>
        <p>&copy; 2024 SystEcam. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/editUser.js"></script>
</body>
</html>
