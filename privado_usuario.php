<?php
session_start();
if (!isset($_SESSION['validado']) || $_SESSION['rol'] !== 'usuario') {
    header('Location: index.html?errorUsuario=Acceso+no+autorizado');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Usuario</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?> (Usuario)</h1>
  <p>Esta es una sección privada solo para usuarios registrados.</p>
  <a href="logout.php">Cerrar sesión</a>
</body>
</html>
