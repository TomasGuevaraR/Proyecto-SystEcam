<?php
require_once("../BaseDatos/Conexion.php");

// Verificar si se ha enviado el formulario
if (isset($_POST['id']) && isset($_POST['rol'])) {
    $id = $_POST['id'];
    $rol = $_POST['rol'];

    // Prevenir inyecciones SQL utilizando declaraciones preparadas
    $sql = "UPDATE usuarios SET roles_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ii", $rol, $id); // 'ii' indica que ambos parámetros son enteros
        if ($stmt->execute()) {
            echo "Rol actualizado correctamente.";
        } else {
            echo "Error al actualizar el rol: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    // Redirigir al usuario de vuelta a la lista de usuarios
    header("Location: ../usuarios.php");
    exit; // Asegúrate de salir después de redirigir
} else {
    echo "Datos incompletos para actualizar el rol.";
}
$conn->close();
?>
