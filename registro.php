<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Registro - SystEcam</title>
    <link rel="stylesheet" href="css/styRegistro.css">
</head>
<body>
    <!-- Encabezado con Logo -->
    <header>
        <div class="header-container">
            <a href="index.php"><img src="img/logo.png" alt="SystEcam" class="logo"></a>
            <div class="nombre-container">
                <h1 class="nombre-software"><a href="index.php">SystEcam</a></h1>
            </div>
        </div>
    </header>

    <!-- Contenedor Principal -->
    <div class="container">
        <!-- Sección de Bienvenida -->
        <div class="bienvenida">
            <h1>SystEcam</h1> <!-- Solo el nombre del sistema -->
        </div>

        <!-- Sección de Formulario de Registro -->
        <aside class="formulario">
            <h2>Registro de Datos</h2> 
            
            <form action="control/registerC.php" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
                
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" placeholder="Correo" required>
                
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="pass" placeholder="Contraseña" required>
                
                <input type="hidden" name="rol" value="2">

                <div class="col-md-12">
                    <!-- Checkbox para términos y condiciones -->
                    <label>
                        <input type="checkbox" name="terms" required> 
                        Acepta los términos y condiciones
                        <a href="condiciones.html" target="_blank">Ver más</a>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary">Registro</button>
            </form>
        </aside>
    </div>

    <!-- Pie de Página -->
    <footer>
        <p>&copy; 2024 SystEcam. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
