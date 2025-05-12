<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Búsqueda en Componentes</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f7fa;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        .contenedor {
            max-width: 95vw;
            margin-top: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            padding: 24px 20px;
            text-align: center;
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        .formulario {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        select, input[type="text"], button {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1rem;
            width: calc(100% - 22px);
            max-width: 300px;
        }
        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
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
            min-width: 1200px;
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
        <h2>Búsqueda en Tabla Componentes</h2>
        <div class="formulario">
            <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="campo">Buscar por campo:</label>
                <select id="campo" name="campo">
                    <?php
                    $host = "localhost";
                    $usuario = "root";
                    $password = "";
                    $base_datos = "soporte_tecnico";

                    $mysqli = new mysqli($host, $usuario, $password, $base_datos);

                    if ($mysqli->connect_errno) {
                        echo "<option value=''>Error al conectar a la base de datos</option>";
                    } else {
                        $sql_columnas = "SHOW COLUMNS FROM `componentes`";
                        $resultado_columnas = $mysqli->query($sql_columnas);

                        if ($resultado_columnas && $resultado_columnas->num_rows > 0) {
                            echo "<option value=''>Seleccionar campo</option>";
                            while ($fila_columna = $resultado_columnas->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($fila_columna['Field']) . "'>" . htmlspecialchars($fila_columna['Field']) . "</option>";
                            }
                        } else {
                            echo "<option value=''>No se encontraron campos</option>";
                        }
                        $mysqli->close();
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
            $host = "localhost";
            $usuario = "root";
            $password = "";
            $base_datos = "soporte_tecnico";

            $mysqli = new mysqli($host, $usuario, $password, $base_datos);

            if ($mysqli->connect_errno) {
                echo "<div class='no-resultados'>Error al conectar a la base de datos.</div>";
            } else {
                if (isset($_GET['campo']) && !empty($_GET['campo']) && isset($_GET['valor']) && !empty($_GET['valor'])) {
                    $campo_busqueda = $mysqli->real_escape_string($_GET['campo']);
                    $valor_busqueda = $mysqli->real_escape_string($_GET['valor']);

                    $sql_busqueda = "SELECT * FROM `componentes` WHERE `$campo_busqueda` LIKE '%$valor_busqueda%'";
                    $resultado_busqueda = $mysqli->query($sql_busqueda);

                    if ($resultado_busqueda && $resultado_busqueda->num_rows > 0) {
                        echo "<table><thead><tr>";
                        $campos_busqueda = $resultado_busqueda->fetch_fields();
                        foreach ($campos_busqueda as $campo) {
                            echo "<th>" . htmlspecialchars($campo->name) . "</th>";
                        }
                        echo "</tr></thead><tbody>";
                        while ($fila_busqueda = $resultado_busqueda->fetch_assoc()) {
                            echo "<tr>";
                            foreach ($fila_busqueda as $valor_celda) {
                                echo "<td>" . htmlspecialchars($valor_celda) . "</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</tbody></table>";
                    } else {
                        echo "<p class='no-resultados'>No se encontraron resultados para el campo <strong>" . htmlspecialchars($_GET['campo']) . "</strong> con el valor <strong>" . htmlspecialchars($_GET['valor']) . "</strong>.</p>";
                    }
                    $resultado_busqueda->free();
                } else {
                    echo "<p>Selecciona un campo y un valor para realizar la búsqueda.</p>";
                }
                $mysqli->close();
            }
            ?>
        </div>
    </div>
</body>
</html>