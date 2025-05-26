<?php
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Cambia 'soporte_tecnico' por el nombre correcto de tu base de datos
    $conexion = new mysqli('localhost', 'root', '', 'soporte_tecnico');

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("SELECT usuario, contrasena, rol FROM usuarios WHERE usuario=? LIMIT 1");
    $stmt->bind_param('s', $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($db_usuario, $db_contrasena, $db_rol);
        $stmt->fetch();
        if (password_verify($contrasena, $db_contrasena) && $db_rol === 'admin') {
            $_SESSION['usuario'] = $db_usuario;
            $_SESSION['rol'] = $db_rol;
            header('Location: registrar_usuario.php');
            exit;
        } else {
            $error = "Usuario o contraseña incorrectos, o no es administrador.";
        }
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
    $stmt->close();
    $conexion->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Administrador</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(120deg, #007bff 0%, #6dd5ed 100%);
      font-family: 'Roboto', Arial, sans-serif;
      min-height: 100vh;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-container {
      background: #fff;
      padding: 38px 32px 28px 32px;
      border-radius: 18px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.18);
      width: 360px;
      max-width: 95vw;
      display: flex;
      flex-direction: column;
      align-items: center;
      animation: aparecer 0.8s cubic-bezier(.42,0,.58,1) both;
    }
    @keyframes aparecer {
      from { opacity: 0; transform: translateY(40px);}
      to { opacity: 1; transform: translateY(0);}
    }
    .login-container h2 {
      color: #007bff;
      margin-bottom: 22px;
      font-weight: 700;
      letter-spacing: 1px;
      font-size: 2rem;
    }
    .login-container label {
      display: block;
      margin-top: 15px;
      margin-bottom: 6px;
      font-weight: 500;
      color: #333;
      letter-spacing: 0.5px;
    }
    .login-container input[type="text"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 10px;
      border-radius: 7px;
      border: 1px solid #bdbdbd;
      margin-bottom: 6px;
      font-size: 16px;
      background: #f7fafd;
      transition: border-color 0.2s;
    }
    .login-container input[type="text"]:focus,
    .login-container input[type="password"]:focus {
      border-color: #007bff;
      outline: none;
      background: #eef6fb;
    }
    .login-container button[type="submit"] {
      width: 100%;
      padding: 11px;
      background: linear-gradient(90deg, #007bff 60%, #00c6ff 100%);
      border: none;
      color: white;
      font-size: 17px;
      border-radius: 7px;
      cursor: pointer;
      margin-top: 18px;
      font-weight: 700;
      box-shadow: 0 2px 6px rgba(0,123,255,0.07);
      transition: background 0.3s, transform 0.2s;
    }
    .login-container button[type="submit"]:hover {
      background: linear-gradient(90deg, #0056b3 60%, #00aaff 100%);
      transform: translateY(-2px) scale(1.03);
    }
    .mensaje-error {
      color: #d32f2f;
      background: #fff3f3;
      border: 1px solid #fbc2c4;
      border-radius: 6px;
      text-align: center;
      margin-top: 18px;
      padding: 8px 6px;
      min-height: 24px;
      font-size: 15px;
      width: 100%;
      box-sizing: border-box;
      animation: shake 0.35s cubic-bezier(.36,.07,.19,.97) both;
    }
    @keyframes shake {
      10%, 90% { transform: translateX(-1px);}
      20%, 80% { transform: translateX(2px);}
      30%, 50%, 70% { transform: translateX(-4px);}
      40%, 60% { transform: translateX(4px);}
    }
    .volver {
      display: block;
      text-align: center;
      margin-top: 22px;
      color: #007bff;
      text-decoration: none;
      font-size: 15px;
      transition: color 0.2s;
    }
    .volver:hover {
      color: #0056b3;
      text-decoration: underline;
    }
    .avatar-admin {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: linear-gradient(135deg, #007bff 60%, #00c6ff 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 17px;
      box-shadow: 0 2px 8px rgba(0,123,255,0.12);
    }
    .avatar-admin svg {
      width: 40px;
      height: 40px;
      fill: #fff;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="avatar-admin">
      <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8zm0 2c-3.31 0-10 1.67-10 5v3h20v-3c0-3.33-6.69-5-10-5z"/></svg>
    </div>
    <h2>Administrador</h2>
    <form action="" method="post" autocomplete="off">
      <label for="usuario">Usuario</label>
      <input type="text" id="usuario" name="usuario" required autofocus />

      <label for="contrasena">Contraseña</label>
      <input type="password" id="contrasena" name="contrasena" required />

      <button type="submit">Entrar</button>
    </form>
    <?php if ($error): ?>
      <div class="mensaje-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <a href="index.html" class="volver">← Volver al inicio</a>
  </div>
</body>
</html>
