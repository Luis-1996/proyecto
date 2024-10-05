<?php
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

session_start();

if (!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = $usuario;
}
include('./core/conexion_bd.php');

$consulta = "SELECT * FROM usuarios where correo='$usuario' and pass='$contraseña'";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    $filass = mysqli_fetch_array($resultado);

    if ($filass) {

        $_SESSION['k_id_usuarios'] = $filass['id_usuario'];
        $_SESSION['k_usuario'] = $filass['correo'];
        $_SESSION['k_pass'] = $filass['pass'];
        $_SESSION['k_id_rol'] = $filass['id_rol'];

        if ($filass['id_rol'] == 1) {
            header("location: inicio.php?id_usuario=" . $filass['id_usuario']);
        } else if ($filass['id_rol'] == 2) {
            header("location: inicio.php?id_usuario=" . $filass['id_usuario']);
        } else if ($filass['id_rol'] == 3) {
            header("location: inicio.php?id_usuario=" . $filass['id_usuario']);
        } else {
            unset($_SESSION['k_id_usuarios']);
            unset($_SESSION['k_usuario']);
            unset($_SESSION['k_pass']);
            unset($_SESSION['k_id_rol']);
            header("location: index.php");
            echo "<div class='alert alert-warning'>No tienes un rol asignado, contacta con un administrador.</div>";
        }
    } else {
        header("location: index.php");
        echo "<div class='alert alert-danger'>Usuario no registrado.</div>";
    }

    mysqli_free_result($resultado);
} else {
    echo "Error en la consulta: " . mysqli_error($conexion);
}

mysqli_close($conexion);
