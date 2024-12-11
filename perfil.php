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
    <title>SystEcam - Perfil</title>
    <link rel="stylesheet" href="css/perf.css">
</head>
<body>

    <!-- Encabezado con Logo -->
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

    <!-- Tarjeta del perfil del usuario -->
    <div class="profile-card">
        <div class="icon">
            <i class="bi bi-person-circle"></i>
        </div>
        <h3>Mi Perfil</h3>
        <p><i class="bi bi-person"></i><strong>ID: </strong><?php echo $_SESSION['id_usuario']; ?></p>
        <p><i class="bi bi-person"></i><strong>Nombre: </strong><?php echo $_SESSION['nombre']; ?></p>
        <p><i class="bi bi-person-badge"></i><strong>Usuario: </strong><?php echo $_SESSION['usuario']; ?></p>
        <p><i class="bi bi-envelope"></i><strong>Email: </strong><?php echo $_SESSION['email']; ?></p>

        <!-- Botón para editar perfil 
        <a href="editar_perfil.php" class="btn">Editar Perfil</a> -->
    </div>

    <!-- Pie de Página -->
    <footer class="text-center mt-5">
        <p>&copy; 2024 SystEcam. Todos los derechos reservados.</p>
    </footer>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 
</body>
</html>
