<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Usuario</title>
</head>
<body>
  <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?> (Usuario)</h1>
  <a href="logout.php">Cerrar sesión</a>
  <p>Contenido exclusivo para usuarios.</p>
</body>
</html>
