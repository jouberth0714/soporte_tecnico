<?php
define('DB_SERVIDOR', 'localhost');
define('DB_USUARIO', 'root');
define('DB_CONTRASENA', ''); // Pon tu contraseña si tienes
define('DB_NOMBRE', 'soporte_tecnico');

$conn = new mysqli(DB_SERVIDOR, DB_USUARIO, DB_CONTRASENA, DB_NOMBRE);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
