<?php

// Activar la visualización de errores para ayudar en la depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Parámetros de conexión a la base de datos
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
$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
$ficha = isset($_POST['ficha']) ? $_POST['ficha'] : '';
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
$clave = isset($_POST['clave']) ? $_POST['clave'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$ext_tel = isset($_POST['ext-tel']) ? $_POST['ext-tel'] : '';
$respaldo = isset($_POST['respaldo']) ? $_POST['respaldo'] : '';
$gcia_dpto = isset($_POST['gcia-dpto']) ? $_POST['gcia-dpto'] : '';
$daet = isset($_POST['daet']) ? $_POST['daet'] : '';
$st = isset($_POST['st']) ? $_POST['st'] : '';
$equipo = isset($_POST['equipo']) ? $_POST['equipo'] : '';
$marca = isset($_POST['marca']) ? $_POST['marca'] : '';
$falla = isset($_POST['falla']) ? $_POST['falla'] : '';
$componentes = isset($_POST['componentes']) ? implode(', ', $_POST['componentes']) : '';
$perifericos = isset($_POST['perifericos']) ? implode(', ', $_POST['perifericos']) : '';
$aplicativos = isset($_POST['aplicativos']) ? implode(', ', $_POST['aplicativos']) : '';
$otra_aplicacion = isset($_POST['otra-aplicacion']) ? $_POST['otra-aplicacion'] : '';
$carpeta_red = isset($_POST['carpeta-red']) ? $_POST['carpeta-red'] : '';
$observacion = isset($_POST['observacion']) ? $_POST['observacion'] : '';
$asignado = isset($_POST['asignado']) ? $_POST['asignado'] : '';
$estatus = isset($_POST['estatus']) ? $_POST['estatus'] : '';
$entregado = isset($_POST['entregado']) ? $_POST['entregado'] : '';
$recibido = isset($_POST['recibido']) ? $_POST['recibido'] : '';

// Nombre de la tabla para el recibo de equipos
$nombreTablaRecibo = 'recibo_equipos';

// Preparar la consulta SQL para insertar los datos del recibo
$sqlRecibo = "INSERT INTO " . $nombreTablaRecibo . " (fecha, ficha, usuario, clave, nombre, ext_tel, respaldo, gcia_dpto, daet, st, equipo, marca, falla, componentes, perifericos, aplicativos, otra_aplicacion, carpeta_red, observacion, asignado, estatus, entregado, recibido) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmtRecibo = $conn->prepare($sqlRecibo);

if ($stmtRecibo) {
    // Vincular los parámetros
    $stmtRecibo->bind_param("sssssssssssssssssssssss", $fecha, $ficha, $usuario, $clave, $nombre, $ext_tel, $respaldo, $gcia_dpto, $daet, $st, $equipo, $marca, $falla, $componentes, $perifericos, $aplicativos, $otra_aplicacion, $carpeta_red, $observacion, $asignado, $estatus, $entregado, $recibido);

    // Ejecutar la sentencia
    if ($stmtRecibo->execute()) {
        // Redirigir de vuelta a la página del formulario "Recibo de equipos .html" con un mensaje de éxito
        header("Location: Recibo de equipos .html?mensaje=Recibo guardado exitosamente");
        exit();
    } else {
        echo "Error al guardar el recibo: (" . $stmtRecibo->errno . ") " . $stmtRecibo->error . "<br>Por favor, verifica el nombre de la tabla ('" . $nombreTablaRecibo . "') y las columnas en tu base de datos.";
        // Puedes optar por redirigir también en caso de error para mostrar un mensaje en el formulario
        header("Location: Recibo de equipos .html?error=Error al guardar el recibo");
        exit();
    }

    // Cerrar la sentencia
    $stmtRecibo->close();
} else {
    echo "Error al preparar la consulta SQL para el recibo: " . $conn->error;
    // Redirigir en caso de error al preparar la consulta
    header("Location: Recibo de equipos .html?error=Error al preparar la consulta SQL");
    exit();
}

// Cerrar la conexión
$conn->close();

?>