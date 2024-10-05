<?php
session_start();
include("core/conexion_bd.php");
date_default_timezone_set('America/Bogota');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $nombres_apellidos = $_POST["nombres_apellidos"];
    $correo = $_POST["correo"];
    $fotop= $_POST["fotop"];
    $comentarios = $_POST["comentarios"];
    $fecha_actual = date('Y-m-d H:i:s');
    $avatar = !empty($avatar) ? $avatar : null;

    if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] == UPLOAD_ERR_OK) {
        $avatar = base64_encode(file_get_contents($_FILES["avatar"]["tmp_name"]));
    } elseif (empty($fotop)) {
        $avatar = null;
    }

    $consulta = "INSERT INTO anuncios (id_usuario, nombres_apellidos, correo, fotop, anuncio, foto, fecha) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $consulta);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sssssss', $id, $nombres_apellidos, $correo, $fotop, $comentarios, $avatar, $fecha_actual);

        if (mysqli_stmt_execute($stmt)) {
            $redirectUrl = "anuncios.php?id_usuario=" . urlencode($id);
            header("Location: $redirectUrl");
            exit();
        } else {
            echo "Error al ejecutar la consulta: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error al preparar la consulta: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
}
