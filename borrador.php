<?php
// Incluir la conexión a la base de datos
require_once("BaseDatos/Conexion.php");

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener todos los usuarios
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es"> <!-- Cambié 'en' a 'es' para idioma español -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SystEcam</title>
    <!-- Añadir estilos de Bootstrap para mejor visualización -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>nombre</th>
                <th>usuario</th>
                <th>email</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Comprobar si hay resultados de la consulta
        if ($result->num_rows > 0) {
            // Mostrar los datos en la tabla
            while($fila = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $fila['id'] . "</td>";
                echo "<td>" . $fila['nombre'] . "</td>";
                echo "<td>" . $fila['usuario'] . "</td>";
                echo "<td>" . $fila['email'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No hay resultados</td></tr>";
        }
        // Liberar los resultados y cerrar la conexión
        $result->free();
        $conn->close();
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
