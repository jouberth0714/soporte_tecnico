<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Componentes de Equipos</title>
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
    max-width: 400px; /* reducido de 600px a 400px */
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
.formulario button {
    background-color: #007bff;
    color: white;
    padding: 10px 22px;          /* mismo padding que .btn-home */
    border: none;
    border-radius: 4px;
    font-size: 1rem;             /* mismo tamaño de fuente */
    font-family: inherit;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    transition: background 0.3s;
    cursor: pointer;
    font-weight: bold;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin: 0 auto;              /* para centrarlo horizontalmente */
    text-decoration: none;
    width: fit-content;          /* ajusta el ancho al contenido */
}

.formulario button:hover {
    background-color: #0056b3;
    color: #fff;
}
        
        /* Tabla con scroll horizontal */
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
            text-align: center;
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
        <h2>Componentes de Equipos</h2>
        <form class="formulario" method="GET" action="">
            <label for="campo">Buscar por:</label>
            <select id="campo" name="campo" required>
                <option value="">Seleccionar campo</option>
                <?php
                // Campos y nombres amigables
                $columnas_orden = [
                    "identificacion"            => "Identificación",
                    "tarjeta_madre_marca"       => "Marca Tarjeta Madre",
                    "serial_tarjeta_madre"      => "Serial Tarjeta Madre",
                    "fuente_poder_marca"        => "Marca Fuente Poder",
                    "serial_fuente_poder"       => "Serial Fuente Poder",
                    "tarjeta_video_marca"       => "Marca Tarjeta Video",
                    "tarjeta_de_video_en_serie" => "Serial Tarjeta Video",
                    "tarjeta_red_marca"         => "Marca Tarjeta Red",
                    "tarjeta_de_serie_roja"     => "Serial Tarjeta Red",
                    "memoria_ram_marca"         => "Marca Memoria RAM",
                    "memoria_ram_serie"         => "Serial Memoria RAM",
                    "capacidad_memoria_ram"     => "Capacidad Memoria RAM",
                    "disco_duro_marca"          => "Marca Disco Duro",
                    "disco_duro_serie"          => "Serial Disco Duro",
                    "capacidad_disco_duro"      => "Capacidad Disco Duro"
                ];
                foreach ($columnas_orden as $col => $amigable) {
                    $selected = (isset($_GET['campo']) && $_GET['campo'] == $col) ? 'selected' : '';
                    echo "<option value=\"$col\" $selected>" . htmlspecialchars($amigable) . "</option>";
                }
                ?>
            </select>
            <label for="valor">Valor:</label>
            <input type="text" id="valor" name="valor" placeholder="Ingrese el valor a buscar" value="<?php echo isset($_GET['valor']) ? htmlspecialchars($_GET['valor']) : ''; ?>" required />
            <button type="submit">Buscar</button>
        </form>
        <div class="tabla-scroll">
            <table>
                <thead>
                    <tr>
                        <?php
                        foreach ($columnas_orden as $amigable) {
                            echo "<th>" . htmlspecialchars($amigable) . "</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (
                    isset($_GET['campo']) && !empty($_GET['campo']) &&
                    isset($_GET['valor']) && $_GET['valor'] !== ''
                ) {
                    $host = "localhost";
                    $usuario = "root";
                    $password = "";
                    $base_datos = "soporte_tecnico";
                    $tabla = "componentes";

                    $mysqli = new mysqli($host, $usuario, $password, $base_datos);

                    if ($mysqli->connect_errno) {
                        echo "<tr><td colspan='" . count($columnas_orden) . "' class='no-resultados'>Error al conectar a la base de datos.</td></tr>";
                    } else {
                        $campo = $mysqli->real_escape_string($_GET['campo']);
                        $valor = $mysqli->real_escape_string($_GET['valor']);
                        $sql = "SELECT * FROM `$tabla` WHERE `$campo` LIKE '%$valor%'";
                        $resultado = $mysqli->query($sql);

                        if ($resultado && $resultado->num_rows > 0) {
                            while ($fila = $resultado->fetch_assoc()) {
                                echo "<tr>";
                                foreach ($columnas_orden as $col => $amigable) {
                                    echo "<td>" . htmlspecialchars($fila[$col] ?? '') . "</td>";
                                }
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='" . count($columnas_orden) . "' class='no-resultados'>No se encontraron resultados.</td></tr>";
                        }
                        $mysqli->close();
                    }
                } else {
                    echo "<tr><td colspan='" . count($columnas_orden) . "' class='no-resultados'>Por favor, realice una búsqueda.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
