<?php
include("core/conexion_bd.php");
include_once("services/services.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST["id"];
    $nombre_apellido = $_POST["nombre-apellido"];
    $tipo_id = $_POST["tipo-id"];
    $numero_id = $_POST["numeroid"];
    $fecha_n = $_POST["fechan"];
    $departamentos = $_POST["departamentos"];
    $municipios = $_POST["municipios"];
    $direccion = $_POST["direccion"];
    $celular = $_POST["celular"];
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : ''; 
    $opt = isset($_POST["opt"]) ? $_POST["opt"] : ''; 


    if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] == UPLOAD_ERR_OK) {
        $avatar = file_get_contents($_FILES["avatar"]["tmp_name"]);
        $avatar = mysqli_real_escape_string($conexion, $avatar);
        $sqlAvatar = ", foto = '$avatar'";
    } else {
        $sqlAvatar = ''; 
    }

    if (!empty($id)) {
        $tipo_id = is_array($tipo_id) ? $tipo_id[0] : $tipo_id;
        $departamentos = is_array($departamentos) ? $departamentos[0] : $departamentos;
        $municipios = is_array($municipios) ? $municipios[0] : $municipios;

        $user = Servicios::ObtenerDatos($id, $conexion);
        $usuario = mysqli_fetch_array($user);

        if ($usuario == null) {
            Servicios::agregarDatos($id, $nombre_apellido, $tipo_id, $numero_id, $fecha_n, $departamentos, $municipios, $direccion, $celular, $correo, $avatar, $conexion);
        } else {
            Servicios::EditarUsuario($id, $nombre_apellido, $tipo_id, $numero_id, $fecha_n, $departamentos, $municipios, $direccion, $celular, $correo, $sqlAvatar, $conexion);
        }

        $redirectUrl = "update.php?id_usuario=" . $id;
        header("Location: $redirectUrl");
        exit(); 
    }
}
