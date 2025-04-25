<?php

// Parámetros de conexión (asegúrate de que coincidan con tu configuración)
$host = 'localhost';
$usuario = 'root';
$password = '';
$basededatos = 'soporte_tecnico';


// Crear conexión
$conexion = new mysqli($host, $usuario_db, $contrasena_db, $nombre_db);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST["new_username"];
    $new_password = $_POST["new_password"];
    $email = $_POST["email"];

    // *** ¡Aquí debes realizar validaciones y hashear la contraseña! ***
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Preparar la consulta SQL para la tabla 'crear_cuenta'
    $stmt = $conexion->prepare("INSERT INTO crear_cuenta (new_username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $new_username, $hashed_password, $email);

    if ($stmt->execute()) {
        echo "¡Cuenta creada exitosamente!";
        // Puedes redirigir a otra página aquí: header("Location: registro_exitoso.html");
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close();
}

$conexion->close();

    }

    $stmt->close();
}

$conexion->close();

?>