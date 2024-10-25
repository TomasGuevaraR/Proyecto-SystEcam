<?php

// Creación de la conexión a MySQL
$conn = new mysqli("localhost", "root", "", "basesystecam");

// Verificación de la conexión
if ($conn->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;}


//echo"Conexión exitosa a la base de datos.";


?>
