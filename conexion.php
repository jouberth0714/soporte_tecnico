<?php
// Parámetros de conexión
$host = 'localhost';       // servidor de base de datos
$usuario = 'root';   // usuario de la base de datos
$password = ''; // contraseña de la base de datos
$basededatos = 'soporte-tecnico';  // nombre de la base de datos

// Crear conexión
$conexion = new mysqli($host, $usuario, $password, $basededatos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

echo "Conexión exitosa a la base de datos.";
?>
