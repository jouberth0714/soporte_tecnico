<?php
// Datos de conexión a la base de datos (asegúrate de que sean correctos)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "soporte_tecnico";
$tablename = "equipos de recibo"; // Asegúrate de que este sea el nombre correcto de tu tabla

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Verificar si se recibieron los parámetros de búsqueda
if (isset($_GET['campo']) && isset($_GET['valor']) && !empty($_GET['campo']) && !empty($_GET['valor'])) {
    $campo = $conn->real_escape_string($_GET['campo']);
    $valor = $conn->real_escape_string($_GET['valor']);

    // Validar el campo para evitar inyecciones SQL (lista blanca de campos permitidos)
    $campos_permitidos = ['id', 'nombre_equipo', 'serial']; // Agrega aquí todos los campos por los que quieres permitir la búsqueda
    if (in_array($campo, $campos_permitidos)) {
        // Consulta SQL para buscar en el campo especificado
        $sql = "SELECT id, nombre_equipo, serial FROM $tablename WHERE $campo LIKE '%$valor%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Resultados de la Búsqueda:</h2>";
            echo "<table>";
            echo "<thead><tr><th>ID</th><th>Nombre del Equipo</th><th>Serial</th></tr></thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"] . "</td><td>" . htmlspecialchars($row["nombre_equipo"]) . "</td><td>" . htmlspecialchars($row["serial"]) . "</td></tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No se encontraron resultados para su búsqueda.</p>";
        }
    } else {
        echo "<p>Campo de búsqueda no válido.</p>";
    }
} else {
    echo "<p>Por favor, seleccione un campo y un valor para buscar.</p>";
}

// Cerrar la conexión
$conn->close();
?>