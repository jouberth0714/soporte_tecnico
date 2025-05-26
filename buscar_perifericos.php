<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Búsqueda en Recibo de Periféricos</title>
    <style>
       body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #f4f7fa;
    margin: 0;
    padding: 20px;
}
.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    padding: 10px 24px 10px 12px; /* Menos alto */
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    margin-bottom: 30px;
}

.home-btn {
    background: #007bff;
    color: #fff;
    padding: 6px 16px;      /* Menos padding = menos alto */
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.2s;
    font-size: 1rem;        /* Un poco más pequeño */
    display: flex;
    align-items: center;
    gap: 6px;
    border: none;
    outline: none;
    line-height: 1;
}
.home-btn:hover {
    background: #0056b3;
    color: #fff;
}

body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #f4f7fa;
    margin: 0;
    padding: 20px;
}
.contenedor {
    max-width: 95vw;
    margin: 40px auto;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    padding: 24px 20px;
}
.top-bar {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-bottom: 8px;
}
.btn-home {
    background-color: #007bff;
    color: white;
    padding: 10px 22px;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    font-size: 1rem;
    font-family: inherit;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    transition: background 0.3s;
    margin-right: 2px;
}
.btn-home:hover {
    background-color: #0056b3;
}
h2 {
    text-align: center;
    color: #007bff;
    margin-bottom: 28px;
}
.formulario {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 20px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
    max-width: 600px;
    margin: 20px auto;
}
label {
    font-weight: bold;
    color: #333;
}
select, input[type="text"], button {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 1rem;
    width: calc(100% - 22px);
}

/* Botón Buscar igual tamaño y estilo que .btn-home */
button {
    background-color: #007bff;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease;
    padding: 10px 22px;          /* Igual que .btn-home */
    border: none;
    border-radius: 4px;
    font-size: 1rem;             /* Igual que .btn-home */
    display: block;
    margin: 10px auto 0;         /* Centrado horizontal */
    width: fit-content;          /* Ajusta ancho al contenido */
    box-shadow: 0 2px 6px rgba(0,0,0,0.08); /* Igual que .btn-home */
}
button:hover {
    background-color: #0056b3;
}
.tabla-scroll {
    overflow-x: auto;
    margin-top: 20px;
}
table {
    border-collapse: collapse;
    width: 100%;
    background: #fff;
    font-size: 1rem;
}
th, td {
    padding: 10px 12px;
    border: 1px solid #e0e0e0;
    text-align: left;
    white-space: nowrap;
}
thead th {
    background: #007bff;
    color: #fff;
    position: sticky;
    top: 0;
    z-index: 2;
}
tbody tr:nth-child(even) {
    background: #f6faff;
}
tbody tr:hover {
    background: #e3f0ff;
}
.no-resultados {
    color: #dc3545;
    font-weight: bold;
}

    </style>
</head>
<body>
    <div class="contenedor">
         <header class="header">
        <div class="logo-container">
            <img src="imagenes/fmo logo.png" alt="Logotipo de la Empresa" class="logo">
        </div>
        <h1 class="title">Soporte Técnico</h1>
        <a href="generate-report.html" class="home-btn" title="Home">
            <i class="fas fa-home"></i> 🏠Volver
        </a>
    </header>
        <h2>Búsqueda en Recibo de Periféricos</h2>
        <div class="formulario">
            <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="campo">Buscar por:</label>
                <select id="campo" name="campo">
                    <option value="">Seleccionar campo</option>
                    <?php
                    $host = "localhost";
                    $usuario = "root";
                    $password = "";
                    $base_datos = "soporte_tecnico";
                    $tabla = "recibo_perifericos";

                    $mysqli = new mysqli($host, $usuario, $password, $base_datos);
                    if ($mysqli->connect_errno) {
                        echo "<option value=''>Error al conectar a la base de datos</option>";
                        $columnas = [];
                    } else {
                        $sql_columnas = "SHOW COLUMNS FROM `$tabla`";
                        $resultado_columnas = $mysqli->query($sql_columnas);
                        $columnas = [];
                        if ($resultado_columnas && $resultado_columnas->num_rows > 0) {
                            while ($fila_columna = $resultado_columnas->fetch_assoc()) {
                                $nombre_columna = htmlspecialchars($fila_columna['Field']);
                                // Excluir 'fecha' y 'id'
                                if ($nombre_columna !== 'fecha' && $nombre_columna !== 'id') {
                                    echo "<option value='" . $nombre_columna . "'>" . ucfirst(str_replace('_', ' ', $nombre_columna)) . "</option>";
                                    $columnas[] = $nombre_columna;
                                }
                            }
                        } else {
                            echo "<option value=''>No se encontraron campos</option>";
                        }
                    }
                    ?>
                </select>
                <label for="valor">Valor a buscar:</label>
                <input type="text" id="valor" name="valor" placeholder="Ingrese el valor a buscar">
                <button type="submit">Buscar</button>
            </form>
        </div>

        <div class='tabla-scroll'>
<?php
// Definir las columnas a mostrar y sus nombres amigables, en el orden de la imagen
$columnas_formulario = [
    "ficha" => "Ficha",
    "fecha" => "Fecha",
    "usuario" => "Usuario",
    "extension_telefono" => "Extensión telefónica",
    "perifericos" => "Periféricos",
    "componentes" => "Componentes",
    "otros" => "Otros",
    "serial_fmo" => "Serial FMO",
    "fmo_asignado" => "FMO asignado",
    "gestion" => "Gestión",
    "falla" => "Falla",
    "asignado_a" => "Asignado a",
    "solicitud_st" => "Solicitud S.T.",
    "solicitud_daet" => "Solicitud DAET",
    "entregado_por" => "Entregado por",
    "imagen_nombre" => "Imagen"
];

$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "soporte_tecnico";
$tabla = "recibo_perifericos";
$mysqli = new mysqli($host, $usuario, $password, $base_datos);

if ($mysqli->connect_errno) {
    echo "<p class='no-resultados'>Error al conectar a la base de datos.</p>";
} elseif (isset($_GET['campo']) && !empty($_GET['campo']) && isset($_GET['valor']) && !empty($_GET['valor'])) {
    $campo_busqueda = $mysqli->real_escape_string($_GET['campo']);
    $valor_busqueda = $mysqli->real_escape_string($_GET['valor']);
    $sql = "SELECT * FROM `$tabla` WHERE `$campo_busqueda` LIKE '%$valor_busqueda%'";
    $resultado = $mysqli->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        echo "<table>";
        echo "<thead><tr>";
        foreach ($columnas_formulario as $columna => $nombre_amigable) {
            echo "<th>" . htmlspecialchars($nombre_amigable) . "</th>";
        }
        echo "</tr></thead><tbody>";

        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            foreach ($columnas_formulario as $columna => $nombre_amigable) {
                // Si el campo es tipo JSON (como 'perifericos'), decodifica y muestra como lista
                if ($columna === 'perifericos' && !empty($fila[$columna])) {
                    $perifericos = json_decode($fila[$columna], true);
                    if (is_array($perifericos)) {
                        echo "<td>" . htmlspecialchars(implode(', ', $perifericos)) . "</td>";
                    } else {
                        echo "<td>" . htmlspecialchars($fila[$columna]) . "</td>";
                    }
                } elseif ($columna === 'imagen_nombre') {
                    // Busca el campo imagen_contenido para mostrar la miniatura
                    if (!empty($fila['imagen_contenido'])) {
                        $imgData = base64_encode($fila['imagen_contenido']);
                        echo "<td>
                            <img src='data:image/jpeg;base64,{$imgData}' alt='Imagen' style='max-width:60px; max-height:60px; border-radius:4px; box-shadow:0 2px 6px rgba(0,0,0,0.15);cursor:pointer;' onclick=\"mostrarModal('data:image/jpeg;base64,{$imgData}')\" />
                        </td>";
                    } else {
                        echo "<td></td>";
                    }
                } else {
                    echo "<td>" . htmlspecialchars($fila[$columna] ?? '') . "</td>";
                }
            }
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p class='no-resultados'>No se encontraron resultados para el campo <strong>" . ucfirst(str_replace('_', ' ', htmlspecialchars($_GET['campo']))) . "</strong> con el valor <strong>" . htmlspecialchars($_GET['valor'] ?? '') . "</strong> en la tabla <strong>$tabla</strong>.</p>";
    }
    $mysqli->close();
} elseif (isset($_GET['campo'])) {
    echo "<p class='no-resultados'>Por favor, ingrese un valor para buscar en el campo seleccionado.</p>";
}
?>
        </div>
        <!-- Modal para mostrar la imagen en grande -->
        <div id="modalImagen" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.7); align-items:center; justify-content:center;">
            <span onclick="cerrarModal()" style="position:absolute; top:30px; right:40px; color:#fff; font-size:2rem; cursor:pointer;">&times;</span>
            <img id="imgModal" src="" style="max-width:90vw; max-height:90vh; margin:auto; display:block; border-radius:8px; box-shadow:0 8px 32px rgba(0,0,0,0.6);" />
        </div>
        <script>
        function mostrarModal(src) {
            document.getElementById('imgModal').src = src;
            document.getElementById('modalImagen').style.display = 'flex';
        }
        function cerrarModal() {
            document.getElementById('modalImagen').style.display = 'none';
            document.getElementById('imgModal').src = '';
        }
        // Cerrar modal al hacer click fuera de la imagen
        document.getElementById('modalImagen').onclick = function(e) {
            if(e.target === this) cerrarModal();
        };
        </script>
    </div>
</body>
</html>
