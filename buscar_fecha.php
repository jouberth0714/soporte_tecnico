<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Búsqueda de Recibo de Equipos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f7fa;
            margin: 0;
            padding: 20px;
        }
        .contenedor {
            margin: 0 auto;
            max-width: 1100px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            padding: 30px 24px 32px 24px;
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 28px;
        }
        .formulario {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 24px 20px 18px 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            max-width: 400px;
            margin: 0 auto 28px auto;
        }
        .formulario form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .campo-form {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        label {
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }
        select, input[type="text"], input[type="date"] {
            padding: 9px 12px;
            border: 1px solid #bfc9d1;
            border-radius: 4px;
            font-size: 1rem;
            background: #fff;
            transition: border 0.2s;
        }
        select:focus, input[type="text"]:focus, input[type="date"]:focus {
            border: 1.5px solid #007bff;
            outline: none;
        }
        button[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
            padding: 10px 22px;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: bold;
            margin: 10px auto 0 auto;
            display: block;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        button[type="submit"]:hover {
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
            text-transform: lowercase;
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
            margin-top: 20px;
        }
        .edit-btn {
            background: #ffc107;
            color: #222;
            padding: 6px 14px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .edit-btn:hover {
            background: #e0a800;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h2>Búsqueda de Recibo de Equipos</h2>
        <div class="formulario">
            <form method="GET" action="">
                <div class="campo-form">
                    <label for="campo">Buscar por:</label>
                    <select id="campo" name="campo">
                        <option value="">Seleccionar campo</option>
                        <option value="id">id</option>
                        <option value="fecha">fecha</option>
                        <option value="ficha">ficha</option>
                        <option value="usuario">usuario</option>
                        <option value="estatus">estatus</option>
                        <option value="observacion">observacion</option> </select>
                </div>
                <div class="campo-form">
                    <label for="valor">Valor a buscar:</label>
                    <input type="text" id="valor" name="valor" placeholder="Ingrese el valor a buscar">
                </div>
                <button type="submit"><i class="fas fa-search"></i> Buscar</button>
            </form>
        </div>

        <?php
        // Configuración de la base de datos
        $host = "localhost";
        $usuario = "root";
        $password = "";
        $base_datos = "soporte_tecnico";
        $tabla = "recibo_equipos";

        $mysqli = new mysqli($host, $usuario, $password, $base_datos);
        if ($mysqli->connect_errno) {
            die("Error de conexión: " . $mysqli->connect_error);
        }

        if (isset($_GET['campo']) && !empty($_GET['campo']) && isset($_GET['valor']) && $_GET['valor'] !== "") {
            $campo_busqueda = $mysqli->real_escape_string($_GET['campo']);
            $valor_busqueda = $mysqli->real_escape_string($_GET['valor']);

            // Si el campo es fecha o id, buscar exacto, si no, LIKE
            if ($campo_busqueda === "fecha" || $campo_busqueda === "id") {
                $sql = "SELECT * FROM `$tabla` WHERE `$campo_busqueda` = '$valor_busqueda'";
            } else {
                $sql = "SELECT * FROM `$tabla` WHERE `$campo_busqueda` LIKE '%$valor_busqueda%'";
            }
            $resultado = $mysqli->query($sql);
            echo "<div class='tabla-scroll'>";
            if ($resultado && $resultado->num_rows > 0) {
                echo "<table>";
                echo "<thead><tr>
                    <th>id</th>
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
                    <th>aplicativos</th>
                    <th>otra_aplicacion</th>
                    <th>carpeta red</th>
                    <th>observacion</th>
                    <th>asignado</th>
                    <th>estatus</th>
                    <th>entregado</th>
                    <th>recibido</th>
                    <th>fecha_registro</th>
                    <th>Acciones</th>
                </tr></thead><tbody>";
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . (isset($fila['id']) ? htmlspecialchars($fila['id']) : '') . "</td>";
                    echo "<td>" . (isset($fila['fecha']) ? htmlspecialchars($fila['fecha']) : '') . "</td>";
                    echo "<td>" . (isset($fila['ficha']) ? htmlspecialchars($fila['ficha']) : '') . "</td>";
                    echo "<td>" . (isset($fila['usuario']) ? htmlspecialchars($fila['usuario']) : '') . "</td>";
                    echo "<td>" . (isset($fila['clave']) ? htmlspecialchars($fila['clave']) : '') . "</td>";
                    echo "<td>" . (isset($fila['nombre']) ? htmlspecialchars($fila['nombre']) : '') . "</td>";
                    echo "<td>" . (isset($fila['ext_tel']) ? htmlspecialchars($fila['ext_tel']) : '') . "</td>";
                    echo "<td>" . (isset($fila['respaldo']) ? htmlspecialchars($fila['respaldo']) : '') . "</td>";
                    echo "<td>" . (isset($fila['gcia_dpto']) ? htmlspecialchars($fila['gcia_dpto']) : '') . "</td>";
                    echo "<td>" . (isset($fila['daet']) ? htmlspecialchars($fila['daet']) : '') . "</td>";
                    echo "<td>" . (isset($fila['calle']) ? htmlspecialchars($fila['calle']) : '') . "</td>"; // 'calle' en tu código, 'st' en el anterior. Asegúrate de que coincida con tu DB.
                    echo "<td>" . (isset($fila['equipo']) ? htmlspecialchars($fila['equipo']) : '') . "</td>";
                    echo "<td>" . (isset($fila['marca']) ? htmlspecialchars($fila['marca']) : '') . "</td>";
                    echo "<td>" . (isset($fila['falla']) ? htmlspecialchars($fila['falla']) : '') . "</td>";
                    echo "<td>" . (isset($fila['componentes']) ? htmlspecialchars($fila['componentes']) : '') . "</td>";
                    echo "<td>" . (isset($fila['perifericos']) ? htmlspecialchars($fila['perifericos']) : '') . "</td>";
                    echo "<td>" . (isset($fila['aplicativos']) ? htmlspecialchars($fila['aplicativos']) : '') . "</td>";
                    echo "<td>" . (isset($fila['otra_aplicacion']) ? htmlspecialchars($fila['otra_aplicacion']) : '') . "</td>";
                    echo "<td>" . (isset($fila['carpeta_red']) ? htmlspecialchars($fila['carpeta_red']) : '') . "</td>";
                    echo "<td>" . (isset($fila['observacion']) ? htmlspecialchars($fila['observacion']) : '') . "</td>"; // Esto ya está aquí
                    echo "<td>" . (isset($fila['asignado']) ? htmlspecialchars($fila['asignado']) : '') . "</td>";
                    echo "<td>" . (isset($fila['estatus']) ? htmlspecialchars($fila['estatus']) : '') . "</td>";
                    echo "<td>" . (isset($fila['entregado']) ? htmlspecialchars($fila['entregado']) : '') . "</td>";
                    echo "<td>" . (isset($fila['recibido']) ? htmlspecialchars($fila['recibido']) : '') . "</td>";
                    echo "<td>" . (isset($fila['fecha_registro']) ? htmlspecialchars($fila['fecha_registro']) : '') . "</td>";
                    // Botón Editar con el valor correcto
                    echo "<td>";
                    if (!empty($fila['id'])) {
                        echo "<a href='editar.php?id=" . urlencode($fila['id']) . "' class='edit-btn'>
                                <i class='fas fa-edit'></i> Editar
                            </a>";
                    } else {
                        echo "-";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='no-resultados'>No se encontraron resultados para el campo <strong>" . htmlspecialchars($_GET['campo']) . "</strong> con el valor <strong>" . htmlspecialchars($_GET['valor']) . "</strong>.</p>";
            }
            echo "</div>"; // tabla-scroll
        }
        ?>
    </div>
</body>
</html>
