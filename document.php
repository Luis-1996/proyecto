<?php
session_start();

if (isset($_SESSION['k_id_usuarios']) && in_array($_SESSION['k_id_rol'], [1, 2, 3])) {
    include('core/conexion_bd.php');
    include_once("services/services.php");

    $id = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;

    if ($_SESSION['k_id_usuarios'] == $id) {
        $user = Servicios::ObtenerDatos($id, $conexion);
        $usuario = mysqli_fetch_array($user);

        if (isset($usuario['foto'])) {
            $fotoBase64 = base64_encode($usuario['foto']);
        } else {
            $fotoBase64 = null;
        }

        $estado_usuario = isset($usuario['estado']) ? strtoupper($usuario['estado']) : 'DESCONOCIDO';
    } else {
        header("location: index.php");
        exit();
    }
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta
            content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
            name="viewport">
        <title>Documentaciones | UDC</title>

        <!-- Favicon-->
        <link rel="icon" href="images\fondo.ico" type="image/x-icon">

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
                        <!-- Notifications -->
                        <li class="dropdown">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle" data-toggle="dropdown"
                                role="button">
                                <i class="material-icons">notifications</i>
                                <span class="label-count">!</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">NOTIFICACIONES</li>
                                <li class="body">
                                    <ul class="menu">
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div
                                                    class="icon-circle bg-light-green">
                                                    <i
                                                        class="material-icons">person_add</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4>Nuevos Registros</h4>
                                                    <p>
                                                        <i
                                                            class="material-icons">access_time</i>
                                                        Pendiente
                                                    </p>
                                                </div>
                                            </a>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div
                                                    class="icon-circle bg-purple">
                                                    <i
                                                        class="material-icons">settings</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4>Actualizacion</h4>
                                                    <p>
                                                        <i
                                                            class="material-icons">access_time</i>
                                                        Ayer
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- #END# Notifications -->
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
                            <li>
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
                            <li class="active">
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
                            <li>
                                <a href="inicio.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">
                                    <i class="material-icons">home</i>
                                    <span>Inicio</span>
                                </a>
                            </li>
                            <li class="active">
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
                            <li>
                                <a href="inicio.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>">
                                    <i class="material-icons">home</i>
                                    <span>Inicio</span>
                                </a>
                            </li>
                            <li class="active">
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

        <section class="content">
            <div class="container-fluid">
                <div class="block-header">
                    <h2>DOCUMENTACIONES</h2>
                </div>
                <!-- Unordered List -->
                <div class="row clearfix">
                    <?php if ($estado_usuario == 'INSCRITO') { ?>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>CERTIFICADO DE INSCRIPCION</h2>
                                    <ul class="header-dropdown m-r--5">
                                        <li class="dropdown">
                                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="certificado.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>" target="_blank">Descargar</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="body">
                                    <ul>
                                        <img src="images/inscrito.png" width="95%" height="50%">
                                        <li>Descargue aquí su certificado de inscripción.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } elseif ($estado_usuario == 'MATRICULADO') { ?>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>CERTIFICADO DE MATRICULA</h2>
                                    <ul class="header-dropdown m-r--5">
                                        <li class="dropdown">
                                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="certificado.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>" target="_blank">Descargar</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="body">
                                    <ul>
                                        <img src="images/inscrito.png" width="95%" height="50%">
                                        <li>Descargue aquí su certificado de matrícula.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } elseif ($estado_usuario == 'GRADUADO') { ?>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>CERTIFICADO DE GRADUACION</h2>
                                    <ul class="header-dropdown m-r--5">
                                        <li class="dropdown">
                                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="certificado.php?id_usuario=<?php echo $_SESSION['k_id_usuarios']; ?>" target="_blank">Descargar</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="body">
                                    <ul>
                                        <img src="images/inscrito.png" width="95%" height="50%">
                                        <li>Descargue aquí su certificado de graduación.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>Estado no reconocido</h2>
                                </div>
                                <div class="body">
                                    <p>No se encontró un certificado disponible para el estado actual del usuario.</p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- #END# Unordered List -->
            </div>
        </section>

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

        <!-- Demo Js -->
        <script src="js/demo.js"></script>
    </body>

    </html>
<?php
} else {
    header("location: index.php");
    exit();
}
?>