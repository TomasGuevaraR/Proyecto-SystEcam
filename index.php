<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SystEcam</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <!-- Mostrar alerta si hay un error en las credenciales -->
    <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_credentials'): ?>
        <script>
            alert("Usuario o contraseña incorrectos. Inténtalo de nuevo.");
        </script>
    <?php endif; ?>

    <!-- Encabezado con Logo -->
    <header>
        <div class="header-container">
            <img src="img/logo.png" alt="SystEcam" class="logo">
            <h1 class="nombre-software">SystEcam</h1>
        </div>
    </header>

    <!-- Contenedor Principal -->
    <div class="container">
        <!-- Sección de Bienvenida -->
        <div class="bienvenida">
            <h1>Bienvenido a SystEcam</h1>
            <p>"Sistema de gestión farmacéutica para la farmacia ECAM".</p>
        </div>

        <!-- Sección de Formulario de Inicio de Sesión -->
        <aside class="formulario">
            <h2>Iniciar Sesión</h2>
            <form action="Control/loginControl.php" method="post">
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" class="form-input" placeholder="Usuario" required>

                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="pass" class="form-input" placeholder="Contraseña" required>

                <button type="submit">Iniciar Sesión</button>
                <button type="button" onclick="location.href='registro.php'">Regístrate</button>
            </form>
        </aside>
    </div>

    <!-- Pie de Página -->
    <footer>
        <p>&copy; 2024 SystEcam. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
