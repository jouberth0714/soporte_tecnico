<?php
session_start();

$response = array();

if (isset($_SESSION["nombre_usuario"])) {
    $response["nombre"] = $_SESSION["nombre_usuario"];
} else {
    $response["nombre"] = null;
}

header('Content-Type: application/json');
echo json_encode($response);
?>