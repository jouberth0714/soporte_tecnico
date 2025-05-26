<?php
// --- editar.php ---
$host = "localhost";
$user = "root";
$pass = "";
$db = "soporte_tecnico";
$tabla = "recibo_equipos";

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    die("Error de conexión: " . $mysqli->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) die("ID no válido.");

$sql = "SELECT * FROM `$tabla` WHERE id = $id";
$result = $mysqli->query($sql);
if (!$result || $result->num_rows == 0) die("Registro no encontrado.");
$row = $result->fetch_assoc();

// Estos son los componentes, periféricos y aplicativos seleccionados (de la BDD)
$componentes_seleccionados = isset($row['componentes']) ? explode(',', $row['componentes']) : [];
$perifericos_seleccionados = isset($row['perifericos']) ? explode(',', $row['perifericos']) : [];
// Cambiado de $aplicaciones a $aplicativos_seleccionados para mayor claridad
$aplicativos_seleccionados = isset($row['aplicativos']) ? explode(',', $row['aplicativos']) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Recibo de Equipos</title>
    <link rel="stylesheet" href="styles_recibo_equipos.css">
</head>
<body>
    <header class="header">
        <div class="logo-container">
            <img src="imagenes/fmo logo.png" alt="Logotipo de la Empresa" class="logo">
        </div>
        <h1 class="title">Recibo de equipos</h1>
    </header>

    <nav class="menu">
        <ul>
            <li><a href="index.html">Inicio</a></li>
            <li><a href="componentes.html">Componentes</a></li>
            <li><a href="Recibo de equipos .html">Recibo de equipos</a></li>
            <li><a href="Recibo de Periféricos y Componentes.html">Recibo de Periféricos y Componentes</a></li>
            <li><a href="generate-report.html">Generar Reporte</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Editar Recibo de Equipos</h1>
        <form action="actualizar_recibo.php" method="POST" class="recibo-form">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo htmlspecialchars($row['fecha']); ?>">
            </div>
            <div class="form-group">
                <label for="ficha">Ficha:</label>
                <input type="text" id="ficha" name="ficha" value="<?php echo htmlspecialchars($row['ficha']); ?>">
            </div>
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($row['usuario']); ?>">
            </div>
            <div class="form-group">
                <label for="clave">Clave:</label>
                <input type="text" id="clave" name="clave" value="<?php echo htmlspecialchars($row['clave']); ?>">
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>">
            </div>
            <div class="form-group">
                <label for="ext-tel">Ext./Tel.:</label>
                <input type="text" id="ext-tel" name="ext_tel" value="<?php echo htmlspecialchars($row['ext_tel']); ?>">
            </div>
            <div class="form-group form-group-radio">
                <label>Respaldo:</label>
                <label><input type="radio" name="respaldo" value="si" <?php if($row['respaldo']=='si') echo 'checked'; ?>> Sí</label>
                <label><input type="radio" name="respaldo" value="no" <?php if($row['respaldo']=='no') echo 'checked'; ?>> No</label>
            </div>
            <div class="form-group">
                <label for="gcia-dpto">Gcia./Dpto.:</label>
                <input type="text" id="gcia-dpto" name="gcia_dpto" value="<?php echo htmlspecialchars($row['gcia_dpto']); ?>">
            </div>
            <div class="form-group">
                <label for="daet">Solicitud DAET:</label>
                <input type="text" id="daet" name="daet" value="<?php echo htmlspecialchars($row['daet']); ?>">
            </div>
            <div class="form-group">
                <label for="equipo">Equipo:</label>
                <input type="text" id="equipo" name="equipo" value="<?php echo htmlspecialchars($row['equipo']); ?>">
            </div>
            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($row['marca']); ?>">
            </div>
            <div class="form-group">
                <label for="falla">Falla:</label>
                <input type="text" id="falla" name="falla" value="<?php echo htmlspecialchars($row['falla']); ?>">
            </div>
            <fieldset class="fieldset" style="grid-column: 1 / -1;">
                <legend>Componentes:</legend>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
                    <?php
                    $componentes_opciones = [
                        'memoria-ram' => 'Memoria RAM',
                        'procesador' => 'Procesador',
                        'fan-cooler' => 'Fan Cooler',
                        'tarjeta-video' => 'Tarjetade Video',
                        'disco-duro' => 'Disco Duro',
                        'tarjeta-red' => 'Tarjetade Red',
                        'fuente-poder' => 'Fuente de Poder',
                        'canaimita' => 'Canaima'
                    ];
                    foreach ($componentes_opciones as $valor => $texto) {
                        // Usar $componentes_seleccionados para el 'checked'
                        echo '<label><input type="checkbox" name="componentes[]" value="'.$valor.'" '.(in_array($valor, $componentes_seleccionados)?'checked':'').'> '.$texto.'</label>';
                    }
                    ?>
                </div>
            </fieldset>
            <fieldset class="fieldset" style="grid-column: 1 / -1;">
                <legend>Equipo incluye:</legend>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
                    <?php
                    $perifericos_opciones = [
                        'monitor' => 'Monitor',
                        'mouse' => 'Mouse',
                        'teclado' => 'Teclado',
                        'regulador' => 'Regulador'
                    ];
                    foreach ($perifericos_opciones as $valor => $texto) {
                        // Usar $perifericos_seleccionados para el 'checked'
                        echo '<label><input type="checkbox" name="perifericos[]" value="'.$valor.'" '.(in_array($valor, $perifericos_seleccionados)?'checked':'').'> '.$texto.'</label>';
                    }
                    ?>
                </div>
            </fieldset>
            <fieldset class="fieldset" style="grid-column: 1 / -1;">
                <legend>Aplicativos:</legend>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
                    <?php
                    // Renombrado a $aplicativos_opciones para evitar conflicto de nombres
                    $aplicativos_opciones = [
                        'siquel' => 'Siquel',
                        'sap' => 'SAP',
                        'autocad' => 'AutoCAD',
                        'project' => 'Project'
                    ];
                    foreach ($aplicativos_opciones as $valor => $texto) {
                        // ¡IMPORTANTE! Aquí se usa $aplicativos_seleccionados (los de la BDD)
                        echo '<label><input type="checkbox" name="aplicativos[]" value="'.$valor.'" '.(in_array($valor, $aplicativos_seleccionados)?'checked':'').'> '.$texto.'</label>';
                    }
                    ?>
                </div>
            </fieldset>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="otra-aplicacion">Otra Aplicación:</label>
                <input type="text" id="otra-aplicacion" name="otra_aplicacion" value="<?php echo htmlspecialchars($row['otra_aplicacion']); ?>">
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="carpeta_red">Carpeta de Red:</label>
                <input type="text" id="carpeta_red" name="carpeta_red" value="<?php echo htmlspecialchars($row['carpeta_red']); ?>">
            </div>
            <div class="form-group form-group-full" style="grid-column: 1 / -1;">
                <label for="observacion">Observación:</label>
                <textarea id="observacion" name="observacion"><?php echo htmlspecialchars($row['observacion']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="asignado">Asignado A:</label>
                <input type="text" id="asignado" name="asignado" value="<?php echo htmlspecialchars($row['asignado']); ?>">
            </div>
            <div class="form-group">
                <label for="estatus">Estatus:</label>
                <input type="text" id="estatus" name="estatus" value="<?php echo htmlspecialchars($row['estatus']); ?>">
            </div>
            <div class="form-group">
                <label for="entregado">Entregado Por:</label>
                <input type="text" id="entregado" name="entregado" value="<?php echo htmlspecialchars($row['entregado']); ?>">
            </div>
        <form action="actualizar_componente.php" method="POST">
    <input type="hidden" name="id" value="...">
    <input type="text" name="id" value="...">
    <button type="submit">Guardar Cambios</button>
</form>
    </div>
</body>
</html>