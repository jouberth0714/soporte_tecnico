<?php
// --- editar_componente.php ---
$host = "localhost";
$user = "root";
$pass = "";
$db = "soporte_tecnico";
$tabla = "componentes"; // Asegúrate de que esta es tu tabla de componentes

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Obtener el ID del componente de la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) {
    die("ID de componente no válido.");
}

// Consultar la base de datos para obtener los datos del componente
$sql = "SELECT * FROM `$tabla` WHERE id = $id"; // Asumiendo 'id' es la clave primaria
$result = $mysqli->query($sql);

if (!$result || $result->num_rows == 0) {
    die("Componente no encontrado.");
}

$row = $result->fetch_assoc();
$mysqli->close(); // Cerrar la conexión después de obtener los datos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Componente</title>
    <link rel="stylesheet" href="componentes.css"> </head>
<body>
    <header class="header">
        <div class="logo-container">
            <img src="imagenes/fmo logo.png" alt="Logotipo de la Empresa" class="logo">
        </div>
        <h1 class="title">Editar Componente</h1>
    </header>

    <nav class="menu">
        <ul>
            <li><a href="index.html">Inicio</a></li>
            <li><a href="Recibo de equipos .html">Recibo de equipos</a></li>
            <li><a href="Recibo de Periféricos y Componentes.html">Recibo de Periféricos y Componentes</a></li>
            <li><a href="generate-report.html">Generar Reporte</a></li>
            <li><a href="componentes.php">Ver Componentes</a></li> </ul>
    </nav>

    <div class="form-container">
        <fieldset>
            <legend>Editar Componente</legend>
            <form action="actualizar_componente.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label for="identificacion">Identificación:</label>
                        <input type="text" id="identificacion" name="identificacion" placeholder="Identificación del equipo" value="<?php echo htmlspecialchars($row['identificacion'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tarjetaMadre">Tarjeta Madre:</label>
                        <input type="text" id="tarjetaMadre" name="tarjeta_madre_marca" placeholder="Marca" value="<?php echo htmlspecialchars($row['tarjeta_madre_marca'] ?? ''); ?>">
                        <input type="text" name="serial_tarjeta_madre" placeholder="Serial" value="<?php echo htmlspecialchars($row['serial_tarjeta_madre'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="fuentePoder">Fuente de Poder:</label>
                        <input type="text" id="fuentePoder" name="fuente_poder_marca" placeholder="Marca" value="<?php echo htmlspecialchars($row['fuente_poder_marca'] ?? ''); ?>">
                        <input type="text" name="serial_fuente_poder" placeholder="Serial" value="<?php echo htmlspecialchars($row['serial_fuente_poder'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="tarjetaVideo">Tarjeta de Video:</label>
                        <input type="text" id="tarjetaVideo" name="tarjeta_video_marca" placeholder="Marca" value="<?php echo htmlspecialchars($row['tarjeta_video_marca'] ?? ''); ?>">
                        <input type="text" name="tarjeta_de_video_en_serie" placeholder="Serial" value="<?php echo htmlspecialchars($row['tarjeta_de_video_en_serie'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="tarjetaRed">Tarjeta de Red:</label>
                        <input type="text" id="tarjetaRed" name="tarjeta_red_marca" placeholder="Marca" value="<?php echo htmlspecialchars($row['tarjeta_red_marca'] ?? ''); ?>">
                        <input type="text" name="tarjeta_de_serie_roja" placeholder="Serial" value="<?php echo htmlspecialchars($row['tarjeta_de_serie_roja'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="memoriaRam">Memoria RAM:</label>
                        <input type="text" id="memoriaRam" name="memoria_ram_marca" placeholder="Marca" value="<?php echo htmlspecialchars($row['memoria_ram_marca'] ?? ''); ?>">
                        <input type="text" name="memoria_ram_serie" placeholder="Serial" value="<?php echo htmlspecialchars($row['memoria_ram_serie'] ?? ''); ?>">
                        <input type="text" name="capacidad_memoria_ram" placeholder="Capacidad" value="<?php echo htmlspecialchars($row['capacidad_memoria_ram'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="discoDuro">Disco Duro:</label>
                        <input type="text" id="discoDuro" name="disco_duro_marca" placeholder="Marca" value="<?php echo htmlspecialchars($row['disco_duro_marca'] ?? ''); ?>">
                        <input type="text" name="disco_duro_serie" placeholder="Serial" value="<?php echo htmlspecialchars($row['disco_duro_serie'] ?? ''); ?>">
                        <input type="text" name="capacidad_disco_duro" placeholder="Capacidad" value="<?php echo htmlspecialchars($row['capacidad_disco_duro'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group" style="width: 100%;">
                        <label for="observaciones">Observaciones:</label>
                        <textarea id="observaciones" name="observaciones" rows="4"><?php echo htmlspecialchars($row['observaciones'] ?? ''); ?></textarea>
                    </div>
                </div>
                <button type="submit">Guardar Cambios</button>
            </form>
        </fieldset>
    </div>
</body>
</html>