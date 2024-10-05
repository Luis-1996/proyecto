<?php
session_start();

if (!empty($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = intval($_GET["id"]);

    include('core/conexion_bd.php');
    include_once("services/services.php");

    if (!$conexion) {
        die('<div class="bad">Error en la conexión a la base de datos</div>');
    }

    $sql1 = Servicios::EliminarUsuarios($id, $conexion);
    $sql2 = Servicios::EliminarDatos($id, $conexion);

    if ($sql1 && $sql2) {
        header("Location: inicio.php?id_usuario=" . $_SESSION['k_id_usuarios']);
        exit(); 
    } else {
        echo '<div class="bad">Error al eliminar el usuario</div>';
    }
} else {
    echo '<div class="bad">ID no válido</div>';
}
