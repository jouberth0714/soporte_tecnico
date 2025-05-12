<?php
// validar_usuario.php

// **Configuración de la base de datos**
$host = "localhost"; // Reemplaza con tu host de la base de datos
$usuario_db = "root"; // Reemplaza con tu nombre de usuario de la base de datos
$contrasena_db = ""; // Reemplaza con tu contraseña de la base de datos
$nombre_db = "soporte_tecnico"; // Asegúrate de que este sea el nombre correcto de tu base de datos

// **Nombre de la tabla de usuarios**
$tabla_usuarios = "usuarios"; // ¡Asegúrate de que este sea el nombre correcto de tu tabla de usuarios!

// Crear conexión a la base de datos
$conn = new mysqli($host, $usuario_db, $contrasena_db, $nombre_db);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("<p class='invalid'>Error al conectar a la base de datos: " . $conn->connect_error . "</p>");
}

// Procesar la solicitud POST del formulario de validación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta segura para buscar al usuario por nombre de usuario
    $stmt = $conn->prepare("SELECT id, username, password FROM $tabla_usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Verificar si la contraseña proporcionada coincide con la contraseña hasheada en la base de datos
        if (password_verify($password, $row["password"])) {
            echo "<p class='valid'>Usuario válido.</p>";
        } else {
            echo "<p class='invalid'>Contraseña incorrecta.</p>";
        }
    } else {
        echo "<p class='invalid'>Usuario no encontrado.</p>";
    }

    $stmt->close();
} else {
    echo "<p class='invalid'>Método de solicitud no válido.</p>";
}

// Cerrar la conexión a la base de datos
$conn->close();

?>