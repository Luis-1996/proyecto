<?php
include("core/conexion_bd.php");

session_start();

if (!empty($_POST["guardar"])) {
    if (!empty($_POST["nombres_apellidos"]) && !empty($_POST["pass"])) {
        include_once("services/services.php");

        $id_usuario = $_POST["id"];
        $nombres_apellidos = $_POST["nombres_apellidos"];
        $correo = $_POST["correo"];
        $id_rol = $_POST["id_rol"];
        $id_carrera = $_POST["id_carrera"];
        $pass = $_POST["pass"];
        $estado = $_POST["estado"];

        $sql = Servicios::EditarUsuarios($conexion, $id_usuario, $nombres_apellidos, $correo, $id_rol, $id_carrera, $pass, $estado);

        if ($sql) {
            header("Location: inicio.php?id_usuario=" . $_SESSION['k_id_usuarios']);
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error al modificar el usuario!</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Campos vacíos</div>";
    }
}
