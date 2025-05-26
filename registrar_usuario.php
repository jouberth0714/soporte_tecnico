<?php
session_start();

// Verificar que el usuario esté logueado y sea administrador
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login_admin.php');
    exit;
}

$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_usuario = trim($_POST['nuevo_usuario']);
    $correo = trim($_POST['correo']);
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];
    $rol = $_POST['rol'];

    // Validaciones básicas
    if (empty($nuevo_usuario) || empty($correo) || empty($nueva_contrasena) || empty($confirmar_contrasena) || empty($rol)) {
        $error = "Por favor, complete todos los campos.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo electrónico no es válido.";
    } elseif ($nueva_contrasena !== $confirmar_contrasena) {
        $error = "Las contraseñas no coinciden.";
    } elseif (!in_array($rol, ['admin', 'usuario'])) {
        $error = "Rol no válido.";
    } else {
        // Conexión a la base de datos (ajusta según tu configuración)
        $conexion = new mysqli('localhost', 'root', '', 'soporte_tecnico');
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Verificar si el usuario ya existe
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = ? OR correo = ?");
        $stmt->bind_param('ss', $nuevo_usuario, $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "El nombre de usuario o correo electrónico ya existe.";
            $stmt->close();
            $conexion->close();
        } else {
            $stmt->close();
            // Insertar nuevo usuario con contraseña hasheada
            $hash = password_hash($nueva_contrasena, PASSWORD_BCRYPT);
            $stmt = $conexion->prepare("INSERT INTO usuarios (usuario, correo, contrasena, rol) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $nuevo_usuario, $correo, $hash, $rol);
            if ($stmt->execute()) {
                $mensaje = "Usuario registrado correctamente.";
            } else {
                $error = "Error al registrar el usuario.";
            }
            $stmt->close();
            $conexion->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Usuario / Administrador</title>
  <style>
    body {
      background: #222;
      color: #fff;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      padding: 20px;
    }
    .container {
      background: #fff;
      color: #222;
      padding: 30px 25px;
      border-radius: 12px;
      box-shadow: 0 0 18px rgba(0,0,0,0.4);
      width: 360px;
      max-width: 100%;
    }
    h2 {
      color: #007bff;
      text-align: center;
      margin-bottom: 20px;
      font-weight: bold;
    }
    label {
      display: block;
      margin-top: 12px;
      margin-bottom: 6px;
      font-weight: 600;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 16px;
      box-sizing: border-box;
    }
    button {
      width: 100%;
      margin-top: 20px;
      padding: 12px;
      background: #007bff;
      border: none;
      color: white;
      font-size: 17px;
      border-radius: 7px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s ease;
    }
    button:hover {
      background: #0056b3;
    }
    .mensaje {
      margin-top: 15px;
      padding: 10px;
      border-radius: 6px;
      font-weight: 600;
      text-align: center;
    }
    .mensaje.exito {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }
    .mensaje.error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
    .logout {
      display: block;
      margin-top: 25px;
      text-align: center;
      color: #007bff;
      text-decoration: none;
      font-size: 15px;
    }
    .logout:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Registrar Usuario / Administrador</h2>
    <form method="post" action="">
      <label for="nuevo_usuario">Nombre de usuario:</label>
      <input type="text" id="nuevo_usuario" name="nuevo_usuario" required />

      <label for="correo">Correo electrónico:</label>
      <input type="email" id="correo" name="correo" required />

      <label for="nueva_contrasena">Contraseña:</label>
      <input type="password" id="nueva_contrasena" name="nueva_contrasena" required />

      <label for="confirmar_contrasena">Confirmar contraseña:</label>
      <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required />

      <label for="rol">Rol:</label>
      <select id="rol" name="rol" required>
        <option value="">-- Seleccione un rol --</option>
        <option value="usuario">Usuario</option>
        <option value="admin">Administrador</option>
      </select>

      <button type="submit">Registrar</button>
    </form>

    <?php if ($mensaje): ?>
      <div class="mensaje exito"><?= htmlspecialchars($mensaje) ?></div>
    <?php elseif ($error): ?>
      <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <a href="logout.php" class="logout">Cerrar sesión</a>
  </div>
</body>
</html>
