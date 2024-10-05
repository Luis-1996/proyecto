<?php
session_start();

include("core/conexion_bd.php"); 
include("services/services.php"); 

$noticacion = 0;

$sql1 = Servicios::Marcarnotificacion($noticacion, $conexion);

if ($sql1) {
    header("Location: inicio.php?id_usuario=" . urlencode($_SESSION['k_id_usuarios']));
    exit();
} else {
    echo "<div class='alert alert-danger'>Error al modificar el usuario!</div>";
}

mysqli_close($conexion);
