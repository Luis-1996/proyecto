<?php
session_start();

if (!empty($_GET["id_anuncio"]) && is_numeric($_GET["id_anuncio"])) {
    $id = intval($_GET["id_anuncio"]);

    include('core/conexion_bd.php');
    include_once("services/services.php");

    if (!$conexion) {
        die('<div class="bad">Error en la conexión a la base de datos</div>');
    }

    $resultado = Servicios::Eliminaranuncio($id, $conexion);

    if ($resultado) {
        header("Location: anuncios.php?id_usuario=" . $_SESSION['k_id_usuarios']);
        exit();
    } else {
        echo '<div class="bad">Error al eliminar el anuncio</div>';
    }
} else {
    echo '<div class="bad">ID no válido</div>';
}
