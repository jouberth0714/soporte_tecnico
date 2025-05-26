<?php
// Configuración de la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db = "soporte_tecnico";
$tabla = "recibo_equipos";

// Conexión a la base de datos usando MySQLi
$mysqli = new mysqli($host, $user, $pass, $db);

// Verificar si hay errores de conexión
if ($mysqli->connect_errno) {
    // Si hay un error, terminar la ejecución y mostrar el mensaje de error
    die("Error de conexión: " . $mysqli->connect_error);
}

// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar y obtener el ID del registro a actualizar
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    if (!$id) {
        // Si el ID no es válido, terminar la ejecución
        die("ID no válido para actualizar.");
    }

    // Sanitizar y obtener los otros datos del formulario
    // Se usa real_escape_string para prevenir inyecciones SQL
    $fecha = $mysqli->real_escape_string($_POST['fecha']);
    $ficha = $mysqli->real_escape_string($_POST['ficha']);
    $usuario = $mysqli->real_escape_string($_POST['usuario']);
    $clave = $mysqli->real_escape_string($_POST['clave']);
    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $ext_tel = $mysqli->real_escape_string($_POST['ext_tel']);
    $respaldo = $mysqli->real_escape_string($_POST['respaldo']);
    $gcia_dpto = $mysqli->real_escape_string($_POST['gcia_dpto']);
    $daet = $mysqli->real_escape_string($_POST['daet']);
    // Tenías 'calle' en la consulta de búsqueda, pero 'st' en el formulario original.
    // Asumo que el campo en tu base de datos es 'st' como en el formulario de ingreso.
    // Si es 'calle', asegúrate de cambiar esto.
    $st = isset($_POST['st']) ? $mysqli->real_escape_string($_POST['st']) : '';
    $equipo = $mysqli->real_escape_string($_POST['equipo']);
    $marca = $mysqli->real_escape_string($_POST['marca']);
    $falla = $mysqli->real_escape_string($_POST['falla']);

    // Manejar los checkboxes para componentes, periféricos y aplicativos
    // Se convierte el array de checkboxes seleccionados en una cadena separada por comas
    $componentes = isset($_POST['componentes']) ? implode(',', array_map([$mysqli, 'real_escape_string'], $_POST['componentes'])) : '';
    $perifericos = isset($_POST['perifericos']) ? implode(',', array_map([$mysqli, 'real_escape_string'], $_POST['perifericos'])) : '';
    $aplicativos = isset($_POST['aplicativos']) ? implode(',', array_map([$mysqli, 'real_escape_string'], $_POST['aplicativos'])) : '';

    $otra_aplicacion = $mysqli->real_escape_string($_POST['otra_aplicacion']);
    
    // --- Campos AGREGADOS: carpeta_red y observacion ---
    $carpeta_red = isset($_POST['carpeta_red']) ? $mysqli->real_escape_string($_POST['carpeta_red']) : '';
    $observacion = isset($_POST['observacion']) ? $mysqli->real_escape_string($_POST['observacion']) : '';
    // --- Fin de campos AGREGADOS ---

    $asignado = $mysqli->real_escape_string($_POST['asignado']);
    $estatus = $mysqli->real_escape_string($_POST['estatus']);
    $entregado = $mysqli->real_escape_string($_POST['entregado']);
    $recibido = $mysqli->real_escape_string($_POST['recibido']);

    // Construir la consulta SQL para actualizar el registro
    // Se asegura que los nombres de las columnas coincidan con la tabla de la base de datos
    $sql = "UPDATE `$tabla` SET
                fecha = '$fecha',
                ficha = '$ficha',
                usuario = '$usuario',
                clave = '$clave',
                nombre = '$nombre',
                ext_tel = '$ext_tel',
                respaldo = '$respaldo',
                gcia_dpto = '$gcia_dpto',
                daet = '$daet',
                st = '$st',             
                equipo = '$equipo',
                marca = '$marca',
                falla = '$falla',
                componentes = '$componentes',
                perifericos = '$perifericos',
                aplicativos = '$aplicativos',
                otra_aplicacion = '$otra_aplicacion',
                carpeta_red = '$carpeta_red',   -- AGREGADO
                observacion = '$observacion',   -- AGREGADO
                asignado = '$asignado',
                estatus = '$estatus',
                entregado = '$entregado',
                recibido = '$recibido'
            WHERE id = $id";

    // Ejecutar la consulta SQL
    if ($mysqli->query($sql) === TRUE) {
        // Si la actualización fue exitosa, mostrar un mensaje y redirigir
        echo "¡Recibo actualizado exitosamente!";
        // Redirigir a la página principal con un estado de éxito
        header("Location: Recibo de equipos .html?status=success");
        exit(); // Es importante usar exit() después de header()
    } else {
        // Si hubo un error en la actualización, mostrar el mensaje de error
        echo "Error al actualizar el recibo: " . $mysqli->error;
    }

    // Cerrar la conexión a la base de datos
    $mysqli->close();
} else {
    // Si el acceso al script no fue a través de POST, mostrar un mensaje de acceso inválido
    echo "Acceso inválido al script.";
}
?>