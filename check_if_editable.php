<?php
include("core/conexion_bd.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM datos WHERE id_usuario = '$id'";
    $result = mysqli_query($conexion, $query);

    if ($row = mysqli_fetch_assoc($result)) {

        $editable = empty($row['numero_id']) ? true : false;
        echo json_encode(['editable' => $editable]);
    } else {
        echo json_encode(['editable' => true]);
    }
}
