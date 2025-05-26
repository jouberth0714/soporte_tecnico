<?php
session_start();
require_once "config.php";

$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar usuario
    if (empty(trim($_POST["username"]))) {
        $username_err = "Por favor ingrese un usuario.";
    } else {
        $sql = "SELECT id FROM usuarios WHERE username = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $username_err = "Este usuario ya está en uso.";
            } else {
                $username = trim($_POST["username"]);
            }
            $stmt->close();
        }
    }

    // Validar email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Por favor ingrese un correo electrónico.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Formato de correo inválido.";
    } else {
        $sql = "SELECT id FROM usuarios WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = trim($_POST["email"]);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $email_err = "Este correo ya está registrado.";
            } else {
                $email = trim($_POST["email"]);
            }
            $stmt->close();
        }
    }

    // Validar contraseña
    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor ingrese una contraseña.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validar confirmación de contraseña
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Por favor confirme la contraseña.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password != $confirm_password) {
            $confirm_password_err = "Las contraseñas no coinciden.";
        }
    }

    // Insertar en base de datos si no hay errores
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $param_username, $param_email, $param_password);
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if ($stmt->execute()) {
                header("location: login.php");
                exit();
            } else {
                echo "Algo salió mal, intente de nuevo.";
            }
            $stmt->close();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Registro de Usuario</title>
<style>
body { font-family: Arial, sans-serif; background:#f4f4f4; }
.container { width: 400px; padding: 20px; background: #fff; margin: 50px auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
input[type=text], input[type=email], input[type=password] {
    width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 10px; box-sizing: border-box;
}
.error { color: red; font-size: 14px; }
button { padding: 10px; width: 100%; background: #007bff; color: white; border:none; border-radius: 4px; cursor: pointer; }
button:hover { background: #0056b3; }
</style>
</head>
<body>
<div class="container">
  <h2>Registro de Usuario</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label>Usuario</label>
    <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" />
    <span class="error"><?php echo $username_err; ?></span>

    <label>Correo Electrónico</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" />
    <span class="error"><?php echo $email_err; ?></span>

    <label>Contraseña</label>
    <input type="password" name="password" />
    <span class="error"><?php echo $password_err; ?></span>

    <label>Confirmar Contraseña</label>
    <input type="password" name="confirm_password" />
    <span class="error"><?php echo $confirm_password_err; ?></span>

    <button type="submit">Registrarse</button>
  </form>
  <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
</div>
</body>
</html>
