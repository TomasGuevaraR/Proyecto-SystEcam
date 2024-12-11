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
   

    <!-- Pie de Página -->
    <footer>
        <p>&copy; 2024 SystEcam. Todos los derechos reservados.</p>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
