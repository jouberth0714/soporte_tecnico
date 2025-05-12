<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "soporte_tecnico";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    die("Error de conexión: " . $conn->connect_error);
}
$conn->set_charset("utf8");

// Cambia los campos y la tabla por los de tu tabla de equipos
$sql = "SELECT 
    id, fecha, ficha, usuario, tipo_equipo, marca, modelo, serial, estado, observaciones
    FROM recibo_equipos";

$result = $conn->query($sql);

$reporte = "ID\tFecha\tFicha\tUsuario\tTipo Equipo\tMarca\tModelo\tSerial\tEstado\tObservaciones\n";
$reporte .= str_repeat("-", 120) . "\n";

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reporte .= 
            $row["id"] . "\t" .
            $row["fecha"] . "\t" .
            $row["ficha"] . "\t" .
            $row["usuario"] . "\t" .
            $row["tipo_equipo"] . "\t" .
            $row["marca"] . "\t" .
            $row["modelo"] . "\t" .
            $row["serial"] . "\t" .
            $row["estado"] . "\t" .
            $row["observaciones"] . "\n";
    }
} else {
    $reporte .= "No se encontraron registros.\n";
}
$conn->close();

header('Content-Type: text/plain; charset=utf-8');
echo $reporte;
?>
