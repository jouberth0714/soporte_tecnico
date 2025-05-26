<?php
// --- actualizar_componente.php ---

// Configuración de la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db = "soporte_tecnico";
$tabla = "componentes"; // Asegúrate de que esta es la tabla correcta en tu DB

// Conexión a la base de datos usando MySQLi
$mysqli = new mysqli($host, $user, $pass, $db);

// Verificar si hay errores de conexión
if ($mysqli->connect_errno) {
    // Si hay un error, termina la ejecución y muestra el mensaje de error
    die("Error de conexión: " . $mysqli->connect_error);
}

// Verifica si la solicitud es de tipo POST (es decir, si el formulario fue enviado)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar y obtener el ID de la fila del componente a actualizar (clave primaria original)
    $record_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    if (!$record_id) {
        die("ID de componente no válido para actualizar.");
    }

    // --- Manejo del campo 'id' (identificación del equipo) ---
    $equipment_identification_value_raw = trim($_POST['id'] ?? ''); // Obtener el valor del campo 'id_equipo' del formulario

    // Si el campo de identificación del equipo está vacío, lo tratamos como NULL para la DB
    // Si la columna 'id' en tu DB no permite NULL, esto causará un error.
    // Alternativamente, puedes asignarle 0 si 0 es un valor válido para identificación.
    if (empty($equipment_identification_value_raw) && strtolower($equipment_identification_value_raw) !== '0') {
        $equipment_identification_sql_value = "NULL"; // Se insertará NULL en la columna
    } else {
        // Si tiene un valor, lo limpiamos y lo usamos como string (o intval si es estrictamente numérico)
        // Para ser más flexible, lo dejamos como string escapado, MySQL convertirá si es necesario.
        $equipment_identification_sql_value = "'" . $mysqli->real_escape_string($equipment_identification_value_raw) . "'";
    }
    // --- Fin del manejo del campo 'id' ---


    // Sanitizar y obtener los demás datos del formulario
    // Asegúrate de que los nombres de $_POST[] coincidan con los 'name' de tus inputs en el HTML
    $tarjeta_madre_marca = $mysqli->real_escape_string($_POST['tarjetaMadre'] ?? '');
    $serial_tarjeta_madre = $mysqli->real_escape_string($_POST['serialTarjetaMadre'] ?? '');

    $fuente_poder_marca = $mysqli->real_escape_string($_POST['fuentePoder'] ?? '');
    $serial_fuente_poder = $mysqli->real_escape_string($_POST['serialFuentePoder'] ?? '');

    $tarjeta_video_marca = $mysqli->real_escape_string($_POST['tarjetaVideo'] ?? '');
    // Corregido: 'name' en HTML es 'serialTarjetaVideo'
    $serial_tarjeta_video = $mysqli->real_escape_string($_POST['serialTarjetaVideo'] ?? '');

    $tarjeta_red_marca = $mysqli->real_escape_string($_POST['tarjetaRed'] ?? '');
    // Corregido: 'name' en HTML es 'serialTarjetaRed'
    $serial_tarjeta_red = $mysqli->real_escape_string($_POST['serialTarjetaRed'] ?? '');

    $memoria_ram_marca = $mysqli->real_escape_string($_POST['memoriaRam'] ?? '');
    // Corregido: 'name' en HTML es 'serialMemoriaRam'
    $serial_memoria_ram = $mysqli->real_escape_string($_POST['serialMemoriaRam'] ?? '');
    $capacidad_memoria_ram = $mysqli->real_escape_string($_POST['capacidadMemoriaRam'] ?? '');

    $disco_duro_marca = $mysqli->real_escape_string($_POST['discoDuro'] ?? '');
    // Corregido: 'name' en HTML es 'serialDiscoDuro'
    $serial_disco_duro = $mysqli->real_escape_string($_POST['serialDiscoDuro'] ?? '');
    $capacidad_disco_duro = $mysqli->real_escape_string($_POST['capacidadDiscoDuro'] ?? '');

    $observaciones = $mysqli->real_escape_string($_POST['observaciones'] ?? '');

    // Construir la consulta SQL para actualizar el registro
    // Los nombres de las columnas en la consulta deben coincidir exactamente con los de tu tabla `componentes`
    $sql = "UPDATE `$tabla` SET
                `id` = $equipment_identification_sql_value, -- Aquí se usa el valor preparado (NULL o 'valor')
                tarjeta_madre_marca = '$tarjeta_madre_marca',
                serial_tarjeta_madre = '$serial_tarjeta_madre',
                fuente_poder_marca = '$fuente_poder_marca',
                serial_fuente_poder = '$serial_fuente_poder',
                tarjeta_video_marca = '$tarjeta_video_marca',
                serial_tarjeta_video = '$serial_tarjeta_video', -- Asegúrate que esta columna exista en tu DB
                tarjeta_red_marca = '$tarjeta_red_marca',
                serial_tarjeta_red = '$serial_tarjeta_red', -- Asegúrate que esta columna exista en tu DB
                memoria_ram_marca = '$memoria_ram_marca',
               serial_memoria_ram = '$serial_memoria_ram', -- Asegúrate que esta columna exista en tu DB
                capacidad_memoria_ram = '$capacidad_memoria_ram',
                disco_duro_marca = '$disco_duro_marca',
                serial_disco_duro = '$serial_disco_duro', -- Asegúrate que esta columna exista en tu DB
                capacidad_disco_duro = '$capacidad_disco_duro',
                observaciones = '$observaciones'
            WHERE id = $record_id"; // Este 'id' se refiere a la clave primaria ORIGINAL de la fila

    // Ejecutar la consulta SQL
    if ($mysqli->query($sql) === TRUE) {
        echo "¡Componente actualizado exitosamente!";
        // Redirige a la página de listado/búsqueda de componentes
        header("Location: componentes.html?status=success_update");
        exit(); // Es crucial llamar a exit() después de header() para asegurar la redirección
    } else {
        // Si hubo un error en la actualización, muestra el mensaje de error de MySQLi
        echo "Error al actualizar el componente: " . $mysqli->error;
    }

    // Cierra la conexión a la base de datos
    $mysqli->close();
} else {
    // Si el script es accedido directamente sin enviar el formulario POST
    echo "Acceso inválido al script. Por favor, envía el formulario de edición.";
}

?>