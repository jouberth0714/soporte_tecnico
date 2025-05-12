<?php

// Datos de conexión a la base de datos
$servername = "localhost"; // Reemplaza con tu servidor
$username = "root"; // Reemplaza con tu usuario de base de datos
$password = ""; // Reemplaza con tu contraseña de base de datos
$dbname = "soporte_tecnico"; // Reemplaza con el nombre de tu base de datos


// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $tarjetaMadreMarca = $_POST["tarjetaMadre"];
    $serialTarjetaMadre = $_POST["serialTarjetaMadre"];
    $fuentePoderMarca = $_POST["fuentePoder"];
    $serialFuentePoder = $_POST["serialFuentePoder"];
    $tarjetaVideoMarca = $_POST["tarjetaVideo"];
    $serialTarjetaVideo = $_POST["serialTarjetaVideo"];
    $tarjetaRedMarca = $_POST["tarjetaRed"];
    $serialTarjetaRed = $_POST["serialTarjetaRed"];
    $memoriaRamMarca = $_POST["memoriaRam"];
    $serialMemoriaRam = $_POST["serialMemoriaRam"];
    $capacidadMemoriaRam = $_POST["capacidadMemoriaRam"];
    $discoDuroMarca = $_POST["discoDuro"];
    $serialDiscoDuro = $_POST["serialDiscoDuro"];
    $capacidadDiscoDuro = $_POST["capacidadDiscoDuro"];
    $observaciones = $_POST["observaciones"];

    // Preparar la consulta SQL
    $sql = "INSERT INTO componentes (
        tarjeta_madre_marca, serial_tarjeta_madre,
        fuente_poder_marca, serial_fuente_poder,
        tarjeta_video_marca, serial_tarjeta_video,
        tarjeta_red_marca, serial_tarjeta_red,
        memoria_ram_marca, serial_memoria_ram, capacidad_memoria_ram,
        disco_duro_marca, serial_disco_duro, capacidad_disco_duro,
        observaciones, fecha_registro
    ) VALUES (
        '$tarjetaMadreMarca', '$serialTarjetaMadre',
        '$fuentePoderMarca', '$serialFuentePoder',
        '$tarjetaVideoMarca', '$serialTarjetaVideo',
        '$tarjetaRedMarca', '$serialTarjetaRed',
        '$memoriaRamMarca', '$serialMemoriaRam', '$capacidadMemoriaRam',
        '$discoDuroMarca', '$serialDiscoDuro', '$capacidadDiscoDuro',
        '$observaciones', NOW()
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Registro guardado exitosamente";
    } else {
        echo "Error al guardar el registro: " . $conn->error;
    }
}

$conn->close();

?>