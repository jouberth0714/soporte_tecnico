<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registro de Usuarios - Solo Administradores</title>
</head>
<body>
    <h1>Panel de Registro - Administrador: <?php echo htmlspecialchars($_SESSION['usuario']); ?></h1>
    <a href="logout.php">Cerrar sesión</a>

    <h2>Crear nuevo usuario o administrador</h2>
    <form action="procesar_registro.php" method="post" autocomplete="off">
        <label>Usuario:<br>
            <input type="text" name="usuario" required>
        </label><br><br>

        <label>Contraseña:<br>
            <input type="password" name="contrasena" required>
        </label><br><br>

        <label>Rol:<br>
            <select name="rol" required>
                <option value="usuario">Usuario</option>
                <option value="admin">Administrador</option>
            </select>
        </label><br><br>

        <button type="submit">Crear Usuario</button>
    </form>

    <?php
    if (isset($_GET['msg'])) {
        echo "<p style='color:green'>" . htmlspecialchars($_GET['msg']) . "</p>";
    }
    if (isset($_GET['error'])) {
        echo "<p style='color:red'>" . htmlspecialchars($_GET['error']) . "</p>";
    }
    ?>
</body>
</html>
