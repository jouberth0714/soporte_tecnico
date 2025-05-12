<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Búsqueda de Recibo de Equipos</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f7fa;
            margin: 0;
            padding: 20px;
        }
        .contenedor {
         
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            padding: 30px;
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        .formulario {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
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
        <h2>Búsqueda de Recibo de Equipos</h2>
        <div class="formulario">
            <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="campo">Buscar por:</label>
                <select id="campo" name="campo">
                    <option value="">Seleccionar campo</option>
                    <option value="fecha">Fecha</option>
                    <option value="equipo">Equipo</option>
                    <option value="marca">Marca</option>
                </select>
                <label for="valor">Valor a buscar:</label>
                <input type="text" id="valor" name="valor" placeholder="Ingrese el valor a buscar">
                <button type="submit">Buscar</button>
            </form>
        </div>

        <?php
        $host = "localhost";
        $usuario = "root";
        $password = "";
        $base_datos = "soporte_tecnico";
        $tabla = "recibo_equipos"; // Nombre correcto de la tabla

        $mysqli = new mysqli($host, $usuario, $password, $base_datos);
        if ($mysqli->connect_errno) {
            die("Error de conexión: " . $mysqli->connect_error);
        }

        if (isset($_GET['campo']) && !empty($_GET['campo']) && isset($_GET['valor']) && !empty($_GET['valor'])) {
            $campo_busqueda = $mysqli->real_escape_string($_GET['campo']);
            $valor_busqueda = $mysqli->real_escape_string($_GET['valor']);

            $sql = "SELECT * FROM `$tabla` WHERE `$campo_busqueda` LIKE '%$valor_busqueda%'";
            $resultado = $mysqli->query($sql);

            echo "<div class='tabla-scroll'>";
            if ($resultado && $resultado->num_rows > 0) {
                echo "<table>";
                echo "<thead><tr>
                    <th>identificacion</th>
                    <th>fecha</th>
                    <th>ficha</th>
                    <th>usuario</th>
                    <th>clave</th>
                    <th>nombre</th>
                    <th>ext_tel</th>
                    <th>respaldo</th>
                    <th>gcia_dpto</th>
                    <th>daet</th>
                    <th>calle</th>
                    <th>equipo</th>
                    <th>marca</th>
                    <th>falla</th>
                    <th>componentes</th>
                    <th>perifericos</th>
                    <th>aplicaciones</th>
                    <th>otra_aplicacion</th>
                    <th>carpeta roja</th>
                    <th>observación</th>
                    <th>Asignado</th>
                    <th>estatus</th>
                    <th>entregado</th>
                    <th>recibido</th>
                    <th>fecha_registro</th>
                </tr></thead><tbody>";
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . (isset($fila['identificacion']) ? htmlspecialchars($fila['identificacion']) : '') . "</td>";
                    echo "<td>" . (isset($fila['fecha']) ? htmlspecialchars($fila['fecha']) : '') . "</td>";
                    echo "<td>" . (isset($fila['ficha']) ? htmlspecialchars($fila['ficha']) : '') . "</td>";
                    echo "<td>" . (isset($fila['usuario']) ? htmlspecialchars($fila['usuario']) : '') . "</td>";
                    echo "<td>" . (isset($fila['clave']) ? htmlspecialchars($fila['clave']) : '') . "</td>";
                    echo "<td>" . (isset($fila['nombre']) ? htmlspecialchars($fila['nombre']) : '') . "</td>";
                    echo "<td>" . (isset($fila['ext_tel']) ? htmlspecialchars($fila['ext_tel']) : '') . "</td>";
                    echo "<td>" . (isset($fila['respaldo']) ? htmlspecialchars($fila['respaldo']) : '') . "</td>";
                    echo "<td>" . (isset($fila['gcia_dpto']) ? htmlspecialchars($fila['gcia_dpto']) : '') . "</td>";
                    echo "<td>" . (isset($fila['daet']) ? htmlspecialchars($fila['daet']) : '') . "</td>";
                    echo "<td>" . (isset($fila['calle']) ? htmlspecialchars($fila['calle']) : '') . "</td>";
                    echo "<td>" . (isset($fila['equipo']) ? htmlspecialchars($fila['equipo']) : '') . "</td>";
                    echo "<td>" . (isset($fila['marca']) ? htmlspecialchars($fila['marca']) : '') . "</td>";
                    echo "<td>" . (isset($fila['falla']) ? htmlspecialchars($fila['falla']) : '') . "</td>";
                    echo "<td>" . (isset($fila['componentes']) ? htmlspecialchars($fila['componentes']) : '') . "</td>";
                    echo "<td>" . (isset($fila['perifericos']) ? htmlspecialchars($fila['perifericos']) : '') . "</td>";
                    echo "<td>" . (isset($fila['aplicaciones']) ? htmlspecialchars($fila['aplicaciones']) : '') . "</td>";
                    echo "<td>" . (isset($fila['otra_aplicacion']) ? htmlspecialchars($fila['otra_aplicacion']) : '') . "</td>";
                    echo "<td>" . (isset($fila['carpeta roja']) ? htmlspecialchars($fila['carpeta roja']) : '') . "</td>";
                    echo "<td>" . (isset($fila['observación']) ? htmlspecialchars($fila['observación']) : '') . "</td>";
                    echo "<td>" . (isset($fila['Asignado']) ? htmlspecialchars($fila['Asignado']) : '') . "</td>";
                    echo "<td>" . (isset($fila['estatus']) ? htmlspecialchars($fila['estatus']) : '') . "</td>";
                    echo "<td>" . (isset($fila['entregado']) ? htmlspecialchars($fila['entregado']) : '') . "</td>";
                    echo "<td>" . (isset($fila['recibido']) ? htmlspecialchars($fila['recibido']) : '') . "</td>";
                    echo "<td>" . (isset($fila['fecha_registro']) ? htmlspecialchars($fila['fecha_registro']) : '') . "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='no-resultados'>No se encontraron resultados para el campo <strong>" . htmlspecialchars($_GET['campo']) . "</strong> con el valor <strong>" . htmlspecialchars($_GET['valor']) . "</strong> en la tabla <strong>`recibo_equipos`</strong>.</p>";
            }
            echo "</div>"; // tabla-scroll
        } else 

        $mysqli->close();
        ?>
    </div>
</body>
</html>