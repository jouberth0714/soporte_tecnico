<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "soporte_tecnico";
$tablename = "equipos de recibo";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Variables para reutilizar en el botón PDF
$campo = $valor = "";

if (isset($_GET['campo']) && isset($_GET['valor']) && !empty($_GET['campo']) && !empty($_GET['valor'])) {
    $campo = $conn->real_escape_string($_GET['campo']);
    $valor = $conn->real_escape_string($_GET['valor']);

    $campos_permitidos = ['id', 'nombre_equipo', 'serial'];
    if (in_array($campo, $campos_permitidos)) {
        $sql = "SELECT id, nombre_equipo, serial FROM `$tablename` WHERE $campo LIKE '%$valor%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Resultados de la Búsqueda:</h2>";
            echo "<table border='1' cellpadding='5' cellspacing='0'>";
            echo "<thead><tr><th>ID</th><th>Nombre del Equipo</th><th>Serial</th></tr></thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"] . "</td><td>" . htmlspecialchars($row["nombre_equipo"]) . "</td><td>" . htmlspecialchars($row["serial"]) . "</td></tr>";
            }
            echo "</tbody></table>";

            // Botón para generar PDF
            echo "<br><form action='generar_pdf.php' method='get' target='_blank'>";
            echo "<input type='hidden' name='campo' value='" . htmlspecialchars($campo, ENT_QUOTES) . "'>";
            echo "<input type='hidden' name='valor' value='" . htmlspecialchars($valor, ENT_QUOTES) . "'>";
            echo "<button type='submit'>Imprimir PDF</button>";
            echo "</form>";

        } else {
            echo "<p>No se encontraron resultados para su búsqueda.</p>";
        }
    } else {
        echo "<p>Campo de búsqueda no válido.</p>";
    }
} else {
    echo "<p>Por favor, seleccione un campo y un valor para buscar.</p>";
}

$conn->close();
?>
