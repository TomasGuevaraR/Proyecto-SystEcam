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
                <input type="text" name="usuario" id="usuario" class="form-input" placeholder="Usuario">

                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="pass" class="form-input" placeholder="Contraseña">

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
