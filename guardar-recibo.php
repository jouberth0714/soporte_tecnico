<?php

// Activar la visualización de errores para ayudar en la depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Parámetros de conexión
$host = 'localhost';
$usuario = 'root';
$password = '';
$basededatos = 'soporte_tecnico';

// Crear conexión
$conn = new mysqli($host, $usuario, $password, $basededatos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error . "<br>Por favor, verifica que MySQL esté corriendo en Laragon y que los datos de conexión sean correctos.");
}

// Recibir datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST["date"] ?? '';
    $ficha = $_POST["record-number"] ?? '';
    $usuario = $_POST["user-name"] ?? '';
    $extension_telefono = $_POST["extension-phone"] ?? '';
    $perifericos = isset($_POST["peripherals"]) ? implode(', ', $_POST["peripherals"]) : '';
    $componentes = $_POST["components"] ?? '';
    $otros = $_POST["others"] ?? '';
    $serial_fmo = $_POST["serial-number"] ?? '';
    $fmo_asignado = $_POST["assigned-fmo"] ?? '';
    $gestion = $_POST["management"] ?? '';
    $falla = $_POST["failure"] ?? '';
    $asignado_a = $_POST["assigned-to"] ?? '';
    $solicitud_st = $_POST["st-request-number"] ?? '';
    $solicitud_daet = $_POST["daet-request-number"] ?? '';
    $entregado_por = $_POST["delivered-by"] ?? '';

    // Manejo de la imagen (ejemplo básico)
    $imagen_nombre = $_FILES["image"]["name"] ?? '';
    $imagen_tmp = $_FILES["image"]["tmp_name"] ?? '';
    $imagen_contenido = null;

    if ($imagen_tmp) {
        $imagen_contenido = file_get_contents($imagen_tmp);
    }

    // Nombre de la tabla para el recibo de periféricos y componentes
    $nombreTablaRecibo = 'recibo_perifericos';

    // Preparar la consulta SQL para insertar el recibo
    $sql = "INSERT INTO `" . $nombreTablaRecibo . "` (fecha, ficha, usuario, extension_telefono, perifericos, componentes, otros, serial_fmo, fmo_asignado, gestion, falla, asignado_a, solicitud_st, solicitud_daet, entregado_por, imagen_nombre, imagen_contenido) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincular los parámetros
        $stmt->bind_param('sssssssssssssssss', $fecha, $ficha, $usuario, $extension_telefono, $perifericos, $componentes, $otros, $serial_fmo, $fmo_asignado, $gestion, $falla, $asignado_a, $solicitud_st, $solicitud_daet, $entregado_por, $imagen_nombre, $imagen_contenido);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            // **Mensaje de éxito más detallado**
            $insert_id = $conn->insert_id;
            $mensaje = "Recibo guardado exitosamente. ID del registro: " . $insert_id;
            header("Location: Recibo de Periféricos y Componentes.html?mensaje=" . urlencode($mensaje));
            exit();
        } else {
            // **Mensaje de error más detallado**
            $error = "Error al guardar el recibo: (" . $stmt->errno . ") " . $stmt->error;
            header("Location: Recibo de Periféricos y Componentes.html?error=" . urlencode($error));
            exit();
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        // **Mensaje de error al preparar la consulta**
        $error = "Error al preparar la consulta SQL: " . $conn->error;
        header("Location: Recibo de Periféricos y Componentes.html?error=" . urlencode($error));
        exit();
    }
} else {
    echo "Acceso no autorizado.";
}

// Cerrar la conexión
$conn->close();

?>