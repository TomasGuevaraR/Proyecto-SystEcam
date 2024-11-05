<?php

require_once "../BaseDatos/conexion.php";


$name = $_POST["nombre"];
$usuario = $_POST["usuario"];
$email = $_POST["email"];
$pass = $_POST["pass"];
$rol = $_POST["rol"]; // Suponiendo que esto viene del formulario y es un ID válido en la tabla roles

// Ajustar la consulta SQL a los campos de tu base de datos
$sql = "INSERT INTO usuarios (nombre, usuario, email, pass, roles_id) 
        VALUES ('$name', '$usuario', '$email', '$pass', $rol)";

// Ejecutar la consulta y verificar si fue exitosa
$registroExitoso = false;  // Bandera para controlar si se muestra el modal

if ($conn->query($sql) === TRUE) {
    $registroExitoso = true;
} else {
    echo "Error en el registro: " . $conn->error;
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Usuarios</title>
</head>
<body>
<a href="index.php" class="btn btn-primary">Inicio</a>

<!-- Modal de Bootstrap -->
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro Exitoso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        El usuario ha sido registrado exitosamente.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="cerrarModal" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<?php if ($registroExitoso): ?>
<script>
    // Mostrar el modal si el registro fue exitoso
    var registroModal = new bootstrap.Modal(document.getElementById('registroModal'));
    registroModal.show();

    // Redirigir al hacer clic en el botón "Cerrar"
    document.getElementById('cerrarModal').addEventListener('click', function() {
        window.location.href = '../index.php';
    });
</script>
<?php endif; ?>

</body>
</html>
