<?php
include("./core/conexion_bd.php");
include_once("./services/services.php");

if (!empty($_POST["registrar"])) {
    if (!empty($_POST["nombres_apellidos"]) && !empty($_POST["correo"]) && !empty($_POST["id_rol"]) && !empty($_POST["id_carrera"]) && !empty($_POST["pass"]) && !empty($_POST["estado"])) {

        $nombres_apellidos = trim($_POST["nombres_apellidos"]);
        $correo = trim($_POST["correo"]);
        $id_rol = intval($_POST["id_rol"]);
        $id_carrera = trim($_POST["id_carrera"]);
        $pass = trim($_POST["pass"]);
        $estado = trim($_POST["estado"]);
        $fecha_registro = date("Y-m-d H:i:s");
        $notificacion = 1;

        $resultado = Servicios::agregarUsuarios($nombres_apellidos, $correo, $id_rol, $id_carrera, $pass, $estado, $fecha_registro, $notificacion, $conexion);

        if ($resultado) {
            $id_usuario = mysqli_insert_id($conexion);

            $resultado_datos = Servicios::AgregarID($nombres_apellidos, $correo, $id_carrera, $id_usuario, $id_rol, $estado, $conexion);

            if ($resultado_datos) {
                echo '<div class="alert alert-success">Usuario registrado correctamente</div>';
            } else {
                echo '<div class="alert alert-danger">Error al agregar datos adicionales del usuario</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Error al registrar usuario</div>';
        }
    } else {
        echo '<div class="alert alert-warning">Por favor complete todos los campos!</div>';
    }
}
