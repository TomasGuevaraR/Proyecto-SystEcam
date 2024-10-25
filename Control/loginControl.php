<?php
session_start();

require_once("../BaseDatos/conexion.php");

$usuario = $_POST["usuario"];
$pass = $_POST["pass"];

// Consulta preparada para mayor seguridad y evitar errores de formato
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? AND pass = ?");
$stmt->bind_param("ss", $usuario, $pass);  // "ss" indica que ambas son strings
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $fila = $result->fetch_assoc();
    
    // Almacena más datos del usuario en la sesión
    $_SESSION['id'] = $fila["id"];
    $_SESSION['nombre'] = $fila["nombre"];
    $_SESSION['usuario'] = $fila["usuario"];
    $_SESSION['email'] = $fila["email"];
    $_SESSION['rol'] = ($fila["roles_id"] == 1) ? 'admin' : 'user';  // Admin = 1, User = otro valor

    // Redirigir tanto a administradores como a usuarios a la misma página
    header('Location: ../modulos.php');
    exit;
} else {
    // Redirigir al login si las credenciales son incorrectas
    header('Location: ../index.php?error=invalid_credentials');
    exit;
}

$conn->close();
?>
