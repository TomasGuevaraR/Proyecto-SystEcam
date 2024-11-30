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
    <link rel="stylesheet" href= "css/moduser.css">
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


<?php
    // Diferenciar las vistas según el rol
    if ($_SESSION['rol'] == 'admin') {
        echo "<div class='bienvenida'>Bienvenido, Admin " . $_SESSION['nombre'] . "</div>";
    } else {
        echo "<div class='bienvenida'>Bienvenido, Usuario " . $_SESSION['nombre'] . "</div>";
    }
?>

<main>
    <div class="grupo">
        <!-- Botón para Venta -->
        <a href="venta.php">
            <button><i class="bi bi-cash-coin"></i>VENTA</button>
        </a>
        <!-- Botón para Productos con enlace a modproducto.php -->
        <a href="modproducto.php">
            <button><i class="bi bi-box-seam"></i>PRODUCTOS</button>
        </a>

        <a href="reporte.php">
        <button><i class="bi bi-bar-chart"></i> REPORTES</button>
        </a>

    </div>
    <div class="grupo">
    <a href="clientes.php">
            <button><i class="bi bi-truck"></i>CLIENTES</button>
        </a>

        <!-- Botón para Proveedores -->
        <button><i class="bi bi-truck"></i>PROVEEDORES</button>

        <!-- Botón para Usuarios con enlace a usuarios.php -->
        <a href="usuarios.php">
            <button><i class="bi bi-truck"></i>USUARIOS</button>
        </a>

        <!-- Botón para Perfil con enlace a perfil.php -->
        <a href="perfil.php">
            <button><i class="bi bi-truck"></i>PERFIL</button>
        </a>
    </div>
</main>


    

    <!-- Pie de Página -->
    <footer>
        <p>&copy; 2024 SystEcam. Todos los derechos reservados.</p>
    </footer>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 
</body>
</html>

