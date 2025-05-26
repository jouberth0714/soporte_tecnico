<?php
session_start();
if (!isset($_SESSION['validado']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.html?errorAdmin=Acceso+no+autorizado');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Administrador</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?> (Administrador)</h1>
  <p>Esta es una sección privada solo para administradores.</p>
  <a href="logout.php">Cerrar sesión</a>
</body>
</html>
