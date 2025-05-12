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
        .contenedor {
            max-width: 95vw;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            padding: 24px 20px;
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
        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
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
            if (isset($mysqli) && !$mysqli->connect_errno && isset($_GET['campo']) && !empty($_GET['campo']) && isset($_GET['valor']) && !empty($_GET['valor'])) {
                $sql = "SELECT * FROM `$tabla`";
                $where_clause = "";

                $campo_busqueda = $mysqli->real_escape_string($_GET['campo']);
                $valor_busqueda = $mysqli->real_escape_string($_GET['valor']);
                $where_clause = "WHERE `$campo_busqueda` LIKE '%$valor_busqueda%'";
                $sql .= " " . $where_clause;

                $resultado = $mysqli->query($sql);

                if ($resultado && $resultado->num_rows > 0) {
                    echo "<table>";
                    echo "<thead><tr>";
                    foreach ($columnas as $columna) {
                        echo "<th>" . ucfirst(str_replace('_', ' ', htmlspecialchars($columna))) . "</th>";
                    }
                    echo "</tr></thead><tbody>";

                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($fila as $valor) {
                            echo "<td>" . htmlspecialchars($valor ?? '') . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p class='no-resultados'>No se encontraron resultados para el campo <strong>" . ucfirst(str_replace('_', ' ', htmlspecialchars($_GET['campo']))) . "</strong> con el valor <strong>" . htmlspecialchars($_GET['valor'] ?? '') . "</strong> en la tabla <strong>`$tabla`</strong>.</p>";
                }
                $mysqli->close();
            } elseif (isset($_GET['campo'])) {
                echo "<p class='no-resultados'>Por favor, ingrese un valor para buscar en el campo seleccionado.</p>";
            } else 
            ?>
        </div>
    </div>
</body>
</html>