<?php
include_once("services/services.php");

$id_usuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;
$response = array();

if ($id_usuario > 0 && isset($conexion)) {
    $result = Servicios::ObtenerUsuarios($id_usuario, $conexion);
    if ($row = mysqli_fetch_assoc($result)) {
        $response = $row;
    }
}

echo json_encode($response);
