<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "soporte_tecnico");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Validar datos recibidos
$usuario = $conexion->real_escape_string($_POST['usuario'] ?? '');
$contrasena = $_POST['contrasena'] ?? '';

if (empty($usuario) || empty($contrasena)) {
    header("Location: index.html?error=Debe+rellenar+todos+los+campos");
    exit();
}

// Cambia 'usuarios' por el nombre correcto de tu tabla
$sql = "SELECT * FROM usuarios WHERE usuario = ? LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $row = $resultado->fetch_assoc();

    // Si la contraseña está hasheada en la base de datos, usa password_verify
    if (password_verify($contrasena, $row['contrasena'])) {
        $_SESSION['usuario'] = $row['usuario'];
        $_SESSION['rol'] = $row['rol'];
        $_SESSION['validado'] = true;

        // Redirigir según el rol
        if ($row['rol'] === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        header("Location: index.html?error=Contraseña+incorrecta");
        exit();
    }
} else {
    header("Location: index.html?error=Usuario+no+encontrado");
    exit();
}
?>
