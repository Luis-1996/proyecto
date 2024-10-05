<?php
session_start();

if (isset($_SESSION['k_id_usuarios']) && in_array($_SESSION['k_id_rol'], [1, 2, 3])) {
    include('core/conexion_bd.php');
    include_once("services/services.php");

    $id = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;

    if ($_SESSION['k_id_usuarios'] == $id && $id > 0) {
        $user = Servicios::ObtenerDatos($id, $conexion);

        if ($user && mysqli_num_rows($user) > 0) {
            $usuario = mysqli_fetch_array($user);

            if (isset($usuario['foto'])) {
                $fotoBase64 = base64_encode($usuario['foto']);
            } else {
                $fotoBase64 = null;
            }
        } else {
            echo "No se encontraron datos para el usuario especificado.";
            exit();
        }
    } else {
        header("location: index.php");
        exit();
    }
} else {
    header("location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Inicio | UDC</title>
    <!-- Favicon-->
    <link rel="icon" href="fondo.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!--  You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-red">
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="inicio.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">UNIVERSIDAD DE CARTAGENA - CENTRO TUTORIAL CERETE</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <?php
                        include("services/reg.php")
                        ?>
                        <a href="javascript:void(0);"  class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <?php if ($nuevos_registros > 0): ?>
                                <span class="label-count"><?php echo $nuevos_registros; ?></span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICACIONES</li>
                            <li class="body">
                                <?php
                                include("core/conexion_bd.php");

                                $query = "SELECT COUNT(*) AS nuevos_registros FROM usuarios WHERE notificacion = 1";
                                $result = mysqli_query($conexion, $query);
                                $nuevos_registros = 0;

                                if ($result) {
                                    $row = mysqli_fetch_assoc($result);
                                    $nuevos_registros = $row['nuevos_registros'];
                                }
                                ?>

                                <ul class="menu">
                                    <?php if ($nuevos_registros > 0): ?>
                                        <li>
                                            <a href="marcar_notificaciones.php">
                                                <div class="icon-circle bg-light-green">
                                                    <i class="material-icons">person_add</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4>Nuevos Registros</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> Se registraron <?php echo $nuevos_registros; ?> nuevos usuarios
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-light-green">
                                                    <i class="material-icons">check</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4>No hay notificaciones</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> Por ahora
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                    <!-- #END# Tasks -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <?php if ($_SESSION['k_id_rol'] != '3') { ?>
                <div class="user-info">
                    <div class="image">
                        <?php if ($fotoBase64 != null) { ?>
                            <img src="data:image/jpeg;base64,<?php echo $fotoBase64; ?>" alt="user" width="76" height="76">
                        <?php } else { ?>
                            <img src="images/user.png" width="76" height="76" alt="User" />
                        <?php } ?>
                    </div>
                    <div class="info-container">
                        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $usuario['nombres_apellidos']; ?>
                        </div>
                        <div class="email">
                            <?php echo $usuario['correo']; ?>
                        </div>
                    </div>
                </div>
                <!-- #User Info -->
                <!-- Menu -->
                <div class="menu">
                    <ul class="list">
                        <li class="header">Menu Principal</li>
                        <li class="active">
                            <?php if ($_SESSION['k_id_rol'] == '1') { ?>
                                <a href="inicio.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">
                                    <i class="material-icons">home</i>
                                    <span>Inicio</span>
                                </a>
                        </li>
                        <li>
                            <a href="profile.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">
                                <i class="material-icons">person</i>
                                <span>Perfil</span>
                            </a>
                        </li>
                        <li>
                            <a href="document.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">
                                <i class="material-icons">article</i>
                                <span>Documentaciones</span>
                            </a>
                        </li>
                        <li>
                            <a href="identification.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">
                                <i class="material-icons">assignment_ind</i>
                                <span>Identificacion</span>
                            </a>
                        </li>
                        <li>
                            <a href="update.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">
                                <i class="material-icons">edit_document</i>
                                <span>Actualizar Datos</span>
                            </a>
                        </li>
                        <li>
                            <a href="anuncios.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">
                                <i class="material-icons">new_releases</i>
                                <span>Anuncios</span>
                            </a>
                        </li>
                    <?php } else if ($_SESSION['k_id_rol'] == '2') { ?>
                        <li class="active">
                            <a href="inicio.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">
                                <i class="material-icons">home</i>
                                <span>Inicio</span>
                            </a>
                        </li>
                        <li>
                            <a href="document.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">
                                <i class="material-icons">article</i>
                                <span>Documentaciones</span>
                            </a>
                        </li>
                        <li>
                            <a href="identification.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">
                                <i class="material-icons">assignment_ind</i>
                                <span>Identificacion</span>
                            </a>
                        </li>
                        <li>
                            <a href="update.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">
                                <i class="material-icons">edit_document</i>
                                <span>Actualizar Datos</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="active">
                            <a href="inicio.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">
                                <i class="material-icons">home</i>
                                <span>Inicio</span>
                            </a>
                        </li>
                        <li>
                            <a href="document.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">
                                <i class="material-icons">article</i>
                                <span>Documentaciones</span>
                            </a>
                        </li>
                    <?php } ?>
                    </ul>
                </div>
                <!-- #Menu -->
                <!-- Footer -->
                <div class="legal">
                    <div class="copyright">
                        &copy; 2024 <a href="javascript:void(0);">UDC - Centro Tutorial Cerete</a>.
                    </div>
                    <div class="version">
                        <b>Version: </b> 1.0.5
                    </div>
                </div>
                <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li><a href="index.php"><i class="material-icons">input</i> Salir</a></li>
            </ul>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>
    <?php if ($_SESSION['k_id_rol'] == '1') { ?>
        <section class="content">
            <div class="container-fluid">
                <div class="block-header">
                    <h2>DASHBOARD - ADMINISTRADOR</h2>
                </div>

                <!-- Widgets -->
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-pink hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">person_add</i>
                            </div>
                            <div class="content">
                                <div class="text">TOTAL USUARIOS</div>
                                <?php
                                $sql = "SELECT COUNT(*) AS total_registros FROM usuarios";
                                $result = $conexion->query($sql);

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $total_registros = $row['total_registros'];

                                ?>
                                    <div class="number count-to" data-from="0" data-to="<?php echo $total_registros; ?>" data-speed="1000" data-fresh-interval="2"></div>
                                <?php
                                } else {
                                    echo "Error en la consulta: " . $conexion->error;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-cyan hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">playlist_add_check</i>
                            </div>
                            <div class="content">
                                <div class="text">TOTAL INSCRITOS</div>
                                <?php
                                $sql = "SELECT COUNT(*) AS total_estado_1 FROM usuarios WHERE estado = 'INSCRITO'";
                                $result = $conexion->query($sql);

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $total_estado_1 = $row['total_estado_1']; ?>

                                    <div class="number count-to" data-from="0" data-to="<?php echo $total_estado_1; ?>" data-speed="1000" data-fresh-interval="2"></div>
                                <?php
                                } else {
                                    echo "Error en la consulta: " . $conexion->error;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-light-green hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">local_library</i>
                            </div>
                            <div class="content">
                                <div class="text">TOTAL MATRICULADOS</div>
                                <?php
                                $sql = "SELECT COUNT(*) AS total_estado_2 FROM usuarios WHERE estado = 'MATRICULADO'";
                                $result = $conexion->query($sql);

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $total_estado_2 = $row['total_estado_2']; ?>

                                    <div class="number count-to" data-from="0" data-to="<?php echo $total_estado_2; ?>" data-speed="1000" data-fresh-interval="2"></div>
                                <?php
                                } else {
                                    echo "Error en la consulta: " . $conexion->error;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-orange hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">school</i>
                            </div>
                            <div class="content">
                                <div class="text">USUARIOS GRADUADOS</div>
                                <?php
                                $sql = "SELECT COUNT(*) AS total_estado_3 FROM usuarios WHERE estado = 'GRADUADO'";
                                $result = $conexion->query($sql);

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $total_estado_3 = $row['total_estado_3']; ?>

                                    <div class="number count-to" data-from="0" data-to="<?php echo $total_estado_3; ?>" data-speed="1000" data-fresh-interval="2"></div>
                                <?php
                                } else {
                                    echo "Error en la consulta: " . $conexion->error;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Widgets -->
                <!-- CPU Usage -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    USUARIOS REGISTRADOS
                                </h2>
                                <ul class="header-dropdown m-r--1">
                                    <li class="dropdown">
                                        <button type="button" data-color="green" class="btn bg-teal waves-effect" data-toggle="modal" data-target="#smallModal">NUEVO USUARIO</button>
                                    </li>
                                </ul>

                                <?php
                                include "nuevo_registro.php";
                                ?>
                            </div>
                            <div class="body">
                                <div class="table-responsive">
                                    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Buscar por nombres y apellidos" class="form-control" />
                                    <table id="userTable" class="table table-hover dashboard-task-infos">
                                        <thead class="linea1">
                                            <tr>
                                                <th scope="col">N.id</th>
                                                <th scope="col">Nombres y Apellidos</th>
                                                <th scope="col">Correo Institucional</th>
                                                <th scope="col">Rol</th>
                                                <th scope="col">Carrera</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col">Contraseña</th>
                                                <th scope="col">Editar - Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = Servicios::ObtenerTusuarios($conexion);
                                            while ($fila = mysqli_fetch_assoc($result)) :
                                                $matricula = Servicios::ObtenerDatos($fila['id_usuario'], $conexion);
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($fila['id_usuario']); ?></td>
                                                    <td><?php echo htmlspecialchars($fila['nombres_apellidos']); ?></td>
                                                    <td><?php echo htmlspecialchars($fila['correo']); ?></td>
                                                    <td><?php echo htmlspecialchars($fila['id_rol']); ?></td>
                                                    <td><?php echo htmlspecialchars($fila['id_carrera']); ?></td>
                                                    <td><?php echo htmlspecialchars($fila['estado']); ?></td>
                                                    <td><?php echo htmlspecialchars($fila['pass']); ?></td>
                                                    <td>
                                                        <button type="button" class="btn bg-green waves-effect" data-toggle="modal" data-target="#defaultModal" onclick="agregaform('<?php echo htmlspecialchars($fila['id_usuario']); ?>')">
                                                            <i class="material-icons">edit</i>
                                                        </button>

                                                        <button class="btn bg-deep-orange waves-effect" data-type="confirm">
                                                            <a href="eliminar.php?id=<?php echo htmlspecialchars($fila['id_usuario']); ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?');">
                                                                <i class="material-icons">delete</i>
                                                            </a>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                    <script>
                                        function filterTable() {
                                            var input = document.getElementById("searchInput");
                                            var filter = input.value.toLowerCase();

                                            var table = document.getElementById("userTable");
                                            var rows = table.getElementsByTagName("tr");

                                            for (var i = 1; i < rows.length; i++) {
                                                var td = rows[i].getElementsByTagName("td")[1];
                                                if (td) {
                                                    var textValue = td.textContent || td.innerText;
                                                    if (textValue.toLowerCase().indexOf(filter) > -1) {
                                                        rows[i].style.display = "";
                                                    } else {
                                                        rows[i].style.display = "none";
                                                    }
                                                }
                                            }
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    include_once("services/services.php");

                    $id_edit = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;

                    $datos = null;
                    if ($id_edit > 0 && isset($conexion)) {
                        $obUser = Servicios::ObtenerUsuarios($id_edit, $conexion);
                        $datos = mysqli_fetch_array($obUser);
                    }
                ?>

                <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="defaultModalLabel">EDITAR DATOS DEL USUARIO</h4>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="modificado.php">
                                    <input type="hidden" name="id" id="user_id">

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="nombres_apellidos" id="nombres_apellidos" required autofocus>
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">email</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="email" class="form-control" name="correo" id="correo" required>
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">supervisor_account</i>
                                        </span>
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="id_rol" id="id_rol" required>
                                                <option disabled selected>Rol del usuario</option>
                                                <option value="1">Administrador</option>
                                                <option value="2">Estudiante</option>
                                                <option value="3">Egresado</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">bookmark</i>
                                        </span>
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="id_carrera" id="id_carrera" required>
                                                <option disabled selected>Carrera universitaria</option>
                                                <option value="ADMINISTRACIÓN DE EMPRESAS">Administración de empresas</option>
                                                <option value="ADMINISTRACIÓN FINANCIERA">Administración financiera</option>
                                                <option value="ADMINISTRACIÓN DE SERVICIOS DE SALUD">Administración de servicios de salud</option>
                                                <option value="ADMINISTRACIÓN PUBLICA (Ciclos propedéuticos)">Administración publica (Ciclos propedéuticos)</option>
                                                <option value="INGENIERÍA DE SOFTWARE">Ingeniería de software</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">update</i>
                                        </span>
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="estado" id="estado" required>
                                                <option disabled selected>Estado del usuario</option>
                                                <option value="INSCRITO">Inscrito</option>
                                                <option value="MATRICULADO">Matriculado</option>
                                                <option value="GRADUADO">Graduado</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">lock</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" minlength="6" name="pass" id="pass" required>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-link waves-effect" name="guardar" value="ACTUALIZAR DATOS">
                                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function agregaform(id) {
                        fetch('get_user_data.php?id_usuario=' + id)
                            .then(response => response.json())
                            .then(data => {
                                if (data) {
                                    document.getElementById('user_id').value = data.id_usuario;
                                    document.getElementById('nombres_apellidos').value = data.nombres_apellidos;
                                    document.getElementById('correo').value = data.correo;
                                    document.getElementById('id_rol').value = data.id_rol;
                                    document.getElementById('id_carrera').value = data.id_carrera;
                                    document.getElementById('estado').value = data.estado;
                                    document.getElementById('pass').value = data.pass;
                                }
                            });
                    }
                </script>
            </div>
            </div>
            </div>
            <div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="smallModalLabel">REGISTRAR NUEVO USUARIO</h4>
                        </div>
                        <div class="modal-body">
                            <form id="registroForm" method="POST" action="">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">person</i>
                                    </span>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="nombres_apellidos" placeholder="Nombres y apellidos" required autofocus>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">email</i>
                                    </span>
                                    <div class="form-line">
                                        <input type="email" class="form-control" name="correo" placeholder="Correo institucional" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">supervisor_account</i>
                                    </span>
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="id_rol" id="id_rol">
                                            <option disabled selected>Rol del usuario</option>
                                            <option value="1">Administrador</option>
                                            <option value="2">Estudiante</option>
                                            <option value="3">Egresado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">bookmark</i>
                                    </span>
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="id_carrera" id="id_carrera">
                                            <option disabled selected>Carrera universitaria</option>
                                            <option value="ADMINISTRACIÓN DE EMPRESAS">Administración de empresas</option>
                                            <option value="ADMINISTRACIÓN FINANCIERA">Administración financiera</option>
                                            <option value="ADMINISTRACIÓN DE SERVICIOS DE SALUD">Administración de servicios de salud</option>
                                            <option value="ADMINISTRACIÓN PUBLICA (Ciclos propedéuticos)">Administración publica (Ciclos propedéuticos)</option>
                                            <option value="INGENIERÍA DE SOFTWARE">Ingeniería de software</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">lock</i>
                                    </span>
                                    <div class="form-line">
                                        <input type="password" class="form-control" name="pass" minlength="6" placeholder="Contraseña" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">update</i>
                                    </span>
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="estado" id="estado">
                                            <option disabled selected>Estado del usuario</option>
                                            <option value="INSCRITO">Inscrito</option>
                                            <option value="MATRICULADO">Matriculado</option>
                                            <option value="GRADUADO">Graduado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-link waves-effect" name="registrar" value="REGISTRAR USUARIO">
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    <?php } else { ?>
        <section class="content">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-3">
                        <div class="card profile-card">
                            <div class="profile-header">&nbsp;</div>
                            <div class="profile-body">
                                <?php if ($_SESSION['k_id_rol'] != '3') { ?>
                                    <div class="image-area">
                                        <?php if ($fotoBase64 != null) { ?>
                                            <img src="data:image/jpeg;base64,<?php echo $fotoBase64; ?>" width="130" height="130" alt="AdminBSB - Profile Image" />
                                        <?php } else { ?>
                                            <img src="images/user.png" width="76" height="76" alt="User" />
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <div class="content-area">
                                    <h3><?php echo !empty($usuario['nombres_apellidos']) ? $usuario['nombres_apellidos'] : 'Campo vacío'; ?></h3>
                                    <p><?php
                                        switch ($usuario['id_carrera']) {
                                            case "ADMINISTRACIÓN DE EMPRESAS":
                                                echo 'Administración de Empresas';
                                                break;
                                            case "ADMINISTRACIÓN FINANCIERA":
                                                echo 'Administración Financiera';
                                                break;
                                            case "ADMINISTRACIÓN DE SERVICIOS DE SALUD":
                                                echo 'Administración de Servicios de la Salud';
                                                break;
                                            case "ADMINISTRACIÓN PÚBLICA (Ciclos Propedéuticos)":
                                                echo 'Administración Pública (Ciclos Propedéuticos)';
                                                break;
                                            case "INGENIERÍA DE SOFTWARE":
                                                echo 'Ingeniería de Software';
                                                break;
                                            default:
                                                echo 'Desconocida';
                                                break;
                                        }
                                        ?></p>
                                    <p><?php
                                        switch ($usuario['id_rol']) {
                                            case "1":
                                                echo 'Administrador';
                                                break;
                                            case "2":
                                                echo 'Estudiante';
                                                break;
                                            default:
                                                echo 'Egresado';
                                                break;
                                        }
                                        ?></p>
                                </div>
                            </div>
                            <div class="profile-footer">
                                <ul>
                                    <li>
                                        <span>Tipo De Id.</span>
                                        <span><?php echo !empty($usuario['tipo_id']) ? $usuario['tipo_id'] : 'Sin tipo ID'; ?></span>
                                    </li>
                                    <li>
                                        <span>Numero ID.</span>
                                        <span><?php echo !empty($usuario['numero_id']) ? $usuario['numero_id'] : 'Sin numero ID'; ?></span>
                                    </li>
                            </div>
                        </div>

                        <div class="card card-about-me">
                            <div class="header">
                                <h2>INFORMACION PERSONAL</h2>
                            </div>
                            <div class="body">
                                <ul>
                                    <li>
                                        <div class="title">
                                            <i
                                                class="material-icons">calendar_today</i>
                                            Fecha De Nacimiento
                                        </div>
                                        <div class="content">
                                            <?php echo !empty($usuario['fecha_n']) ? $usuario['fecha_n'] : 'Sin fecha'; ?>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">
                                            <i
                                                class="material-icons">map</i>
                                            Lugar De Nacimiento
                                        </div>
                                        <div class="content">
                                            <?php echo (!empty($usuario['municipio']) && !empty($usuario['departamento'])) ? $usuario['municipio'] . ' - ' . $usuario['departamento'] : 'Sin departamento - municipio'; ?>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">
                                            <i
                                                class="material-icons">location_on</i>
                                            Direccion de residencia
                                        </div>
                                        <div class="content">
                                            <?php echo !empty($usuario['direccion']) ? $usuario['direccion'] : 'Sin direccion'; ?>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">
                                            <i
                                                class="material-icons">phone</i>
                                            Contacto
                                        </div>
                                        <div class="content">
                                            <?php echo !empty($usuario['celular']) ? $usuario['celular'] : 'Sin numero celular'; ?>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-9">
                        <div class="card">
                            <div class="body">
                                <div>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Anuncios</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="home">
                                            <?php
                                            $anuncio = mysqli_query($conexion, "SELECT * FROM anuncios ORDER BY fecha DESC");
                                            while ($anun = mysqli_fetch_assoc($anuncio)) { ?>
                                                <div class="panel panel-default panel-post">
                                                    <div class="panel-heading">
                                                        <div class="media">
                                                            <div class="media-left">
                                                                <a href="#">
                                                                    <?php if ($anun['fotop']): ?>
                                                                        <img src="data:image/jpeg;base64,<?php echo htmlspecialchars($anun['fotop']); ?>" alt="Foto" width="40" height="45" />
                                                                    <?php else: ?>
                                                                        <p>No hay foto disponible</p>
                                                                    <?php endif; ?>
                                                                </a>
                                                            </div>
                                                            <div class="media-body">
                                                                <h4 class="media-heading">
                                                                    <a href="#"><?php echo htmlspecialchars($anun['nombres_apellidos']); ?></a>
                                                                </h4>
                                                                <?php
                                                                $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $anun['fecha']);
                                                                $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
                                                                $formatter->setPattern('EEEE d \'de\' MMMM \'de\' yyyy');
                                                                $fecha_formateada = $formatter->format($fecha);
                                                                ?>
                                                                <?php echo ucfirst($fecha_formateada); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="post">
                                                            <div class="post-heading">
                                                                <p><?php echo htmlspecialchars($anun['anuncio']); ?></p>
                                                            </div>
                                                            <div class="post-content">
                                                                <img src="data:image/jpeg;base64,<?php echo htmlspecialchars($anun['foto']); ?>" class="img-responsive" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="../../plugins/bootstrap-notify/bootstrap-notify.js"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/morrisjs/morris.js"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="plugins/bootstrap-notify/bootstrap-notify.js"></script>

    <!-- ChartJs -->
    <script src="plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="plugins/flot-charts/jquery.flot.js"></script>
    <script src="plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/index.js"></script>
    <script src="js/pages/ui/notifications.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
</body>

</html>
<?php } else {
                header("location: index.php");
            } ?>