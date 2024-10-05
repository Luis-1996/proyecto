<?php
session_start();

if (isset($_SESSION['k_id_usuarios']) && in_array($_SESSION['k_id_rol'], [1, 2, 3])) {
    include('core/conexion_bd.php');
    include_once("services/services.php");

    $id = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;

    if ($_SESSION['k_id_usuarios'] == $id) {
        $user = Servicios::ObtenerDatos($id, $conexion);
        $anuncio = Servicios::ObtenerAnuncios($id, $conexion);
        $usuario = mysqli_fetch_array($user);
        $anun = mysqli_fetch_array($anuncio);

        if (isset($usuario['foto'])) {
            $fotoBase64 = base64_encode($usuario['foto']);
        } else {
            $fotoBase64 = null;
        }

        if (isset($anun['foto'])) {
            $fotop = base64_encode($anun['foto']);
        } else {
            $fotop = null;
        }

        if (isset($anun['foto'])) {
            $fotop = base64_encode($anun['foto']);
        } else {
            $fotop = null;
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
    <link rel="stylesheet" href="static/css/style2.css">

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

    <!-- You can choose a theme from css/themes instead of get all themes -->
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
                <a class="navbar-brand" href="inicio.php">UNIVERSIDAD DE CARTAGENA - CENTRO TUTORIAL CERETE</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count">!</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICACIONES</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">person_add</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>Nuevos Registros</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> Pendiente
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-purple">
                                                <i class="material-icons">settings</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>Actualizacion</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> Ayer
                                                </p>
                                            </div>
                                        </a>
                                    </li>
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
                        <li class="active">
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
                        <li>
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
                        &copy; 2024 <a href="javascript:void(0);">UDC -
                            Centro Tutorial Cerete</a>.
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
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-9">
                    <div class="card card-about-me">
                        <div class="header">
                            <h2>PUBLICAR UN ANUNCIO</h2>
                        </div>
                        <div class="body">
                            <form method="POST" action="publicar.php" enctype="multipart/form-data">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">note_add</i>
                                    </span>
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
                                    <input type="hidden" name="nombres_apellidos" value="<?php echo htmlspecialchars($usuario['nombres_apellidos']); ?>">
                                    <input type="hidden" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>">
                                    <img src="data:image/jpeg;base64,<?php echo $fotoBase64; ?>" alt="user" width="76" height="76" hidden>
                                    <input type="hidden" name="fotop" value="<?php echo htmlspecialchars($fotoBase64); ?>">

                                    <div class="form-line">
                                        <input class="form-control" name="comentarios">
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">insert_photo</i>
                                    </span>
                                    <div class="form-line">

                                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/png, image/jpeg">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p style="color: red;">*El tamaño máximo permitido es de 1MB.</p>
                                </div>
                                <button class="btn btn-block btn-lg bg-green waves-effect" type="submit">PUBLICAR</button>
                            </form>

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
                                                        <div class="media-right">
                                                            <button class="eliminarboton" data-type="confirm">
                                                                <a href="eliminaranuncio.php?id_anuncio=<?php echo htmlspecialchars($anun['id_anuncio']); ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este anuncio?');">
                                                                    <i class="material-icons">clear</i>
                                                                </a>
                                                            </button>
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