<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "soporte_tecnico";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$error = "";
$usuario = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST["usuario"]);
    $contrasena = $_POST["contrasena"];

    // Preparar consulta para obtener el hash de la contraseña del usuario
    $stmt = $conn->prepare("SELECT id, contrasena FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hash_contrasena);
        $stmt->fetch();

        if (password_verify($contrasena, $hash_contrasena)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["usuario"] = $usuario;
            header("Location: Recibo de equipos .html"); // Cambia por tu página
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login - Soporte Técnico</title>
    <style>
        /* Reset básico */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4a90e2, #50e3c2);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 25px;
            color: #333;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 6px;
            font-weight: 600;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #4a90e2;
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4a90e2;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #357ABD;
        }

        .error {
            background-color: #ffdddd;
            border-left: 6px solid #f44336;
            color: #a94442;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        @media (max-width: 400px) {
            .login-container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" action="login.php" novalidate>
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" required autofocus value="<?php echo htmlspecialchars($usuario); ?>" />

            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" required />

            <input type="submit" value="Entrar" />
        </form>
    </div>
</body>
</html>
