<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION["user_id"])) {
    // No está autenticado, redirigir a login
    header("Location: login.php");
    exit();
}

// Opcional: obtener el nombre de usuario para mostrarlo
$usuario = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : "Usuario";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Soporte Técnico</title>
</head>
<body>
    <h1>Bienvenido al Dashboard</h1>
    <p>Hola, <?php echo htmlspecialchars($usuario); ?>. Has iniciado sesión correctamente.</p>

    <p><a href="logout.php">Cerrar sesión</a></p>

    <!-- Aquí puedes agregar el contenido protegido de tu aplicación -->
</body>
</html>
