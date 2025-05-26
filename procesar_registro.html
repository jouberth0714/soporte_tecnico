<?php

// Activar la visualización de errores para ayudar en la depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Parámetros de conexión (ajustados según tu configuración de Laragon)
$host = 'localhost';
$usuario = 'root';
$password = '';
$basededatos = 'soporte_tecnico';

// Nombre de la tabla
$nombreTabla = 'usuarios';

// Crear conexión
$conn = new mysqli($host, $usuario, $password, $basededatos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error . "<br>Por favor, verifica que MySQL esté corriendo en Laragon y que los datos de conexión sean correctos.");
}

// Recibir datos del formulario
if (isset($_POST["new_username"]) && isset($_POST["new_password"]) && isset($_POST["confirm_password"]) && isset($_POST["email"])) {
    $new_username = trim($_POST["new_username"]); // Limpiar espacios en blanco
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    $email = trim($_POST["email"]); // Limpiar espacios en blanco

    // Validaciones
    if (empty($new_username) || empty($new_password) || empty($confirm_password) || empty($email)) {
        echo "Todos los campos son obligatorios. <a href='crear_cuenta.html'>Volver</a>";
        exit();
    }

    if ($new_password !== $confirm_password) {
        echo "Las contraseñas no coinciden. Por favor, inténtalo de nuevo. <a href='crear_cuenta.html'>Volver</a>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "El formato del correo electrónico no es válido. <a href='crear_cuenta.html'>Volver</a>";
        exit();
    }

    // Verificar si el usuario o el correo electrónico ya existen
    $check_sql = "SELECT username, email FROM " . $nombreTabla . " WHERE username = ? OR email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $new_username, $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "El nombre de usuario o el correo electrónico ya existen. Por favor, elige otro. <a href='crear_cuenta.html'>Volver</a>";
        $check_stmt->close();
        exit();
    }
    $check_stmt->close();

    // Encriptar la contraseña
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Preparar la consulta SQL para insertar el nuevo usuario
    $sql = "INSERT INTO " . $nombreTabla . " (username, password, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincular los parámetros
        $stmt->bind_param("sss", $new_username, $hashed_password, $email);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            // Redireccionar a index.html después de un registro exitoso
            header("Location: index.html");
            exit(); // Asegúrate de detener la ejecución del script después de la redirección
        } else {
            echo "Error al crear la cuenta: (" . $stmt->errno . ") " . $stmt->error . "<br>Por favor, verifica el nombre de la tabla ('" . $nombreTabla . "') y las columnas (username, password, email) en tu base de datos.";
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo "Error al preparar la consulta SQL: " . $conn->error;
    }
} else {
    echo "No se recibieron todos los datos del formulario. Por favor, asegúrate de que todos los campos estén llenos. <a href='crear_cuenta.html'>Volver</a>";
}

// Cerrar la conexión
$conn->close();

?>