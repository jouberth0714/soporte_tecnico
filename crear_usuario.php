<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}

require 'conexion.php';

$usuario = trim($_POST['usuario'] ?? '');
$contrasena = $_POST['contrasena'] ?? '';
$rol = $_POST['rol'] ?? 'usuario';

if (!$usuario || !$contrasena || !in_array($rol, ['admin', 'usuario'])) {
    header("Location: admin.php?error=Datos+inválidos");
    exit;
}

// Verificar que no exista el usuario
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    header("Location: admin.php?error=El+usuario+ya+existe");
    exit;
}

$hash = password_hash($contrasena, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO usuarios (usuario, contrasena, rol) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $usuario, $hash, $rol);

if ($stmt->execute()) {
    header("Location: admin.php?msg=Usuario+creado+correctamente");
} else {
    header("Location: admin.php?error=Error+al+crear+usuario");
}
exit;
?>
