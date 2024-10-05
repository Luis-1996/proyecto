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
    } else {
        header("location: index.php");
        exit();
    }
    $iniciales = Servicios::obtenerInicialesTipoIdentidad($usuario['tipo_id']);

?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Identificacion | UDC</title>

        <!-- Favicon-->
        <link rel="icon" href="../../fondo.ico" type="image/x-icon">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

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
                                                        <i class="material-icons">access_time</i>
                                                        Pendiente
                                                    </p>
                                                </div>
                                            </a>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-purple">
                                                    <i class="material-icons">settings</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4>Actualizacion</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i>
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
                            <li class="active">
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
                            <li class="active">
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
            <!-- #END# Right Sidebar -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="block-header">
                    <h2>ACTUALIZAR DATOS</h2>
                </div>
                <!-- Masked Input -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    DATOS PERSONALES
                                </h2>
                            </div>
                            <div class="body">
                                <form method="POST" action="editar.php" id="editForm" enctype="multipart/form-data">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <div class="col-md-4">
                                                <b>Nombres y Apellidos</b>
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="nombre-apellido" value="<?php echo htmlspecialchars($usuario['nombres_apellidos']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <b>Tipo De Documento</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">account_box</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" name="tipo-id[]">
                                                            <option disabled>Tipo De Documento</option>
                                                            <option value="TARJETA DE IDENTIDAD" <?php echo ($usuario['tipo_id'] == 'TARJETA DE IDENTIDAD') ? 'selected' : ''; ?>>Tarjeta De Identidad</option>
                                                            <option value="CEDULA DE CIUDADANIA" <?php echo ($usuario['tipo_id'] == 'CEDULA DE CIUDADANIA') ? 'selected' : ''; ?>>Cédula De Ciudadanía</option>
                                                            <option value="PASAPORTE" <?php echo ($usuario['tipo_id'] == 'PASAPORTE') ? 'selected' : ''; ?>>Pasaporte</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <b>Numero De Identificacion</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">account_box</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" class="form-control" name="numeroid" value="<?php echo htmlspecialchars($usuario['numero_id']); ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <b>Fecha De Nacimiento</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">date_range</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="date" class="form-control" name="fechan" value="<?php echo htmlspecialchars($usuario['fecha_n']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <b>Lugar De Nacimiento</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">room</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <select id="departamentos" class="form-control show-tick" name="departamentos[]" value="<?php echo htmlspecialchars($usuario['departamento'] == '') ? 'selected' : '' ?>" required>
                                                            <option disabled>Seleccione un departamento</option>
                                                            <option value="Amazonas">Amazonas</option>
                                                            <option value="Antioquia">Antioquia</option>
                                                            <option value="Arauca">Arauca</option>
                                                            <option value="Atlantico">Atlántico</option>
                                                            <option value="Bogotá">Bogotá</option>
                                                            <option value="Bolívar">Bolívar</option>
                                                            <option value="Boyacá" <>Boyacá</option>
                                                            <option value="Caldas" <>Caldas</option>
                                                            <option value="Caquetá">Caquetá</option>
                                                            <option value="Casanare">Casanare</option>
                                                            <option value="Cauca">Cauca</option>
                                                            <option value="Cesar">Cesar</option>
                                                            <option value="Chocó">Chocó</option>
                                                            <option value="Córdoba">Córdoba</option>
                                                            <option value="Cundinamarca">Cundinamarca</option>
                                                            <option value="Guainía">Guainía</option>
                                                            <option value="Guaviare">Guaviare</option>
                                                            <option value="Huila">Huila</option>
                                                            <option value="LaGuajira">La Guajira</option>
                                                            <option value="Magdalena">Magdalena</option>
                                                            <option value="Meta">Meta</option>
                                                            <option value="Nariño" <>Nariño</option>
                                                            <option value="NortedeSantander">Norte de Santander</option>
                                                            <option value="Putumayo">Putumayo</option>
                                                            <option value="Quindío">Quindío</option>
                                                            <option value="Risaralda">Risaralda</option>
                                                            <option value="SanAndrésyProvidencia">San Andrés y Providencia</option>
                                                            <option value="Santander">Santander</option>
                                                            <option value="Sucre">Sucre</option>
                                                            <option value="Tolima" <>Tolima</option>
                                                            <option value="ValledelCauca">Valle del Cauca</option>
                                                            <option value="Vaupés" <>Vaupés</option>
                                                            <option value="Vichada">Vichada</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <br>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                    </span>
                                                    <div class="form-line">
                                                        <select id="municipios" class="form-control show-tick" name="municipios[]" required></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Direccion De Residencia</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">home</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <b>Numero Celular</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">contact_phone</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="celular" value="<?php echo htmlspecialchars($usuario['celular']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Correo Electronico</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">mail</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Carrera Inscrita</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">bookmark</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="carrera[]" value="<?php echo htmlspecialchars($usuario['id_carrera']); ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Estado</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">info</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="estado" value="<?php echo htmlspecialchars($usuario['estado']); ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Foto De Perfil</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">photo</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/png, image/jpeg">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <input type="hidden" name="opt" value="0">
                                        <button type="submit" class="btn bg-green waves-effect">
                                            <i class="material-icons">save</i>
                                            <span>GUARDAR CAMBIOS</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    const id = document.querySelector('input[name="id"]').value;
                                    const numeroidField = document.querySelector('input[name="numeroid"]');

                                    fetch('check_if_editable.php?id=' + id)
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.editable === false) {
                                                numeroidField.setAttribute('readonly', true);
                                            } else {
                                                numeroidField.removeAttribute('readonly');
                                            }
                                        });
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <!-- #END# Masked Input -->
                <!-- #END# Input Slider -->
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const departamentos = document.getElementById('departamentos');
                const municipios = document.getElementById('municipios');

                // Datos de municipios para cada departamento
                const municipioData = {
                    Amazonas: [
                        "Leticia", "Puerto Nariño",
                    ],

                    Antioquia: [
                        "Abejorral", "Abriaquí", "Alejandría", "Amagá", "Amalfi", "Andes", "Angelópolis", "Angostura", "Anorí", "Anzá", "Apartadó", "Arboletes",
                        "Argelia", "Armenia", "Barbosa", "Belmira", "Bello", "Betania", "Betulia", "Briceño", "Buriticá", "Cáceres", "Caicedo", "Caldas", "Campamento",
                        "Cañasgordas", "Caracolí", "Caramanta", "Carepa", "Carolina del Príncipe", "Caucasia", "Chigorodó", "Cisneros", "Ciudad Bolívar", "Cocorná", "Concepción", "Concordia",
                        "Copacabana", "Dabeiba", "Donmatías", "Ebéjico", "El Bagre", "Entrerríos", "Envigado", "Fredonia", "Frontino", "Giraldo", "Girardota", "Gómez Plata", "Granada",
                        "Guadalupe", "Guarne", "Guatapé", "Heliconia", "Hispania", "Itagüí", "Jardín", "Jericó", "La Ceja", "La Estrella", "La Pintada", "La Unión", "Liborina",
                        "Maceo", "Marinilla", "Medellín", "Montebello", "Murindó", "Mutatá", "Nariño", "Necoclí", "Nechí", "Olaya", "Peñol", "Peque", "Pueblorrico", "Puerto Berrío",
                        "Puerto Nare", "Puerto Triunfo", "Remedios", "Retiro", "Rionegro", "Sabanalarga", "Sabaneta", "Salgar", "San Andrés de Cuerquía", "San Carlos", "San Francisco",
                        "San Jerónimo", "San José de la Montaña", "San Juan de Urabá", "San Luis", "San Pedro de los Milagros", "San Pedro de Urabá", "San Rafael", "San Roque", "San Vicente Ferrer", "Santa Bárbara",
                        "Santa Fe de Antioquia", "Santa Rosa de Osos", "Santuario", "Segovia", "Sonsón", "Sopetrán", "Támesis", "Tarazá", "Tarso", "Titiribí",
                        "Toledo", "Turbo", "Uramita", "Urrao", "Valdivia", "Valparaíso", "Vegachí", "Venecia", "Vigía del Fuerte", "Yalí", "Yarumal", "Yolombó", "Yondó", "Zaragoza"
                    ],
                    Arauca: ["Arauca", "Arauquita", "Cravo Norte", "Fortul", "Puerto Rondón", "Saravena", "Tame"],

                    Atlantico: ["Barranquilla", "Baranoa", "Campo de la Cruz", "Candelaria", "Galapa", "Juan de Acosta", "Luruaco", "Malambo", "Manatí", "Palmar de Varela",
                        "Piojó", "Polonuevo", "Ponedera", "Puerto Colombia", "Repelón", "Sabanagrande", "Sabanalarga", "Santa Lucía", "Santo Tomás", "Soledad",
                        "Suan", "Tubará", "Usiacurí"
                    ],

                    Bogotá: ["Bogotá D.C"],

                    Bolívar: ["Achí", "Altos del rosario", "Arenal", "Arjona", "Arroyohondo", "Barranco de loba", "Cartagena de Indias", "Calamar", "Cantagallo",
                        "Cicuco", "Córdoba", "Clemencia", "El carmen de bolívar", "El guamo", "El peñón", "Hatillo de la Loba", "Magangué", "Mahates", "Margarita",
                        "Maria la baja", "Montecristo", "Morales", "Pinillos", "Regidor", "Río viejo", "San Cristóbal", "San Estanislao", "San Fernando", "San Jacinto",
                        "San Jacinto del Cauca", "San Juan Nepomuceno", "San Martín de Loba ", "San Pablo", "Santa Catalina", "Santa Cruz de Mompox", "Santa Rosa ",
                        "Santa Rosa del Sur", "Simití", "Soplaviento", "Talaigua Nuevo", "Tiquisio", "Turbaco", "Turbana", "Villanueva", "Zambrano"
                    ],

                    Boyacá: ["Almeida", "Aquitania", "Arcabuco", "Belén", "Berbeo", "Betéitiva", "Boavita", "Briceño", "Buenavista", "Busbanzá", "Caldas",
                        "Campohermoso", "Cerinza", "Chinavita", "Chiquinquirá", "Chiscas", "Chita", "Chitaraque", "Chivatá", "Ciénega", "Cómbita", "Coper",
                        "Corrales", "Covarachía", "Cubará", "Cucaita", "Cuítiva", "Chíquiza", "Chivor", "Duitama",
                        "El Cocuy", "El Espino", "Firavitoba", "Floresta", "Gachantivá", "Gámeza", "Guacamayas", "Guateque", "Guayatá", "Güicán de la sierra", "Iza", "Jenesano", "Jericó", "Labranzagrande", "La Capilla ", "La Victoria ", "La Uvita", "Macanal", "Maripí", "Miraflores", "Mongua",
                        "Monguí", "Moniquirá", "Motavita", "Muzo", "Mobsa", "Nuevo Colón", "Oicatá", "Otanche", "Pachavita", "Páez", "Paipa", "Pajarito", "Panqueba",
                        "Pauna", "Paya", "Paz de Río", "Pesca", "Pisba", "Puerto Boyacá", "Quípama", "Ramiriquí", "Ráquira", "Rondón", "Saboyá", "Sáchica",
                        "Samacá", "San Eduardo", "San José de Pare", "San Luis de Gaceno", "San Mateo", " San Miguel de Sema", "San Pablo de Borbur", "Santana",
                        "Santa María", "Santa Rosa de Viterbo", "Santa Sofía", "Sativanorte", "Sativasur", "Siachoque", "Soatá", "Socotá", "Socha", "Sogamoso",
                        "Somondoco", "Sora", "Sotaquirá", "Soracá", "Susacón", "Sutamarchán",
                        "Sutatenza", "Tasco", "Tenza", "Tibaná", "Tibasosa", "Tinjacá", "Tipacoque", "Toca", "Togüí", "Tópaga", "Tota", "Tunja", "Tununguá",
                        "Turmequé", "Tuta", "Tutazá", "Úmbita", "Ventaquemada", "Villa de Leyva", "Viracachá", "Zetaquira"
                    ],


                    Caldas: ["Aguadas", "Anserma", "Aranzazu", "Belalcázar", "Chinchiná", "Filadelfia", "La dorada", "La Merced", "Manizales", "Manzanares",
                        "Marmato", "Marquetalia", "Marulanda", "Neira", "Norcasia", "Pácora", "Palestina", "Pensilvania", "Riosucio", "Risaralda", "Salamina",
                        "Samaná", "San José", "Supía", "Victoria", "Villamaría", "Viterbo"
                    ],

                    Caquetá: ["Albania", "Belén de los Andaquíes", "Cartagena del Chairá", "Curillo", "El Doncello", "El Paujíl", "Florencia",
                        "La Montañita", "Milán", "Morelia", "Puerto Rico", "San José del Fragua", "San Vicente del Caguán", "Solano", "Solita", "Valparaíso"
                    ],

                    Casanare: ["Aguazul", "Chámeza", "Hato", "Corozal", "La Salina", "Maní", "Monterrey", "Nunchía", "Orocué", "Paz de Ariporo",
                        "Pore", "Recetor", "Sabanalarga", "Sácama", "San Luis de Palenque", "Támara", "Tauramena", "Trinidad", "Villanueva", "Yopal"
                    ],

                    Cauca: ["Almaguer", "Argelia", "Balboa", "Bolívar", "Buenos Aires", "Cajibío", "Caldono", "Caloto", "Corinto",
                        "El Tambo", "Florencia", "Guachené", "Guapi", "Inzá", "Jambaló", "La Sierra", "La Vega", "López de Micay", "Mercaderes",
                        "Miranda", "Morales", "Padilla", "Páez", "Patía", "Piamonte", "Piendamó–Tunía", "Popayán", "Puerto", "Tejada",
                        "Puracé", "Rosas", "San Sebastián", "Santa Rosa", "Santander de Quilichao", "Silvia", "Sotará", "Paispamba", "Suárez", "Sucre",
                        "Timbío", "Timbiquí", "Toribío", "Totoró", "Villa Rica"
                    ],

                    Cesar: ["Aguachica", "Agustín", "Codazzi", "Astrea", "Becerril", "Bosconia", "Chimichagua", "Chiriguaná",
                        "Curumaní", "El Copey", "El Paso", "Gamarra", "González", "La Gloria", "La Jagua de Ibirico", "La Paz",
                        "Manaure", "Balcón del Cesar", "Pailitas", "Pelaya", "Pueblo Bello", "Río de Oro", "San Alberto", "San Diego", "San Martín", "Tamalameque", "Valledupar"
                    ],

                    Chocó: ["Acandí", "Alto Baudó", "Atrato", "Bagadó", "Bahía Solano", "Bajo Baudó", "Bojayá", "Carmen del Darién", "Cértegui", "Condoto",
                        "El Cantón del San Pablo", "El Carmen de Atrato", "El Litoral del San Juan", "Istmina", "Juradó", "Lloró", "Medio Atrato", "Medio Baudó", "Medio San Juan",
                        "Nóvita", "Nuquí", "Quibdó", "Río Iró", "Río Quito", "Riosucio", "San José del Palmar", "Sipí", "Tadó", "Unguía", "Unión Panamericana"
                    ],

                    Córdoba: ["Ayapel", "Buenavista", "Canalete", "Cereté", "Chimá", "Chinú", "Ciénaga de Oro", "Cotorra", "La Apartada", "Lorica", "Los Córdobas", "Momil",
                        "Montelíbano", "Montería", "Moñitos", "Planeta Rica", "Pueblo Nuevo", "Puerto Escondido", "Puerto Libertador", " Purísima de la Concepción", "Sahagún",
                        "San Andrés de Sotavento", "San Antero", "San Bernardo del Viento", "San Carlos", "San José de Uré", "San Pelayo", "Tierralta", "Tuchín", "Valencia"
                    ],

                    Cundinamarca: ["Agua de Dios", "Albán", "Anapoima", "Anolaima", "Apulo", "Arbeláez", "Beltrán", "Bituima", "BojacáCabrera", "Cachipay", "Cajicá", "Caparrapí",
                        "Cáqueza", "Carmen de Carupa", "Chaguaní", "Chía", "Chipaque", "Choachí", "Chocontá", "Cogua", "Cota", "Cucunubá", "El Colegio", "El Peñón", "El Rosal",
                        "Facatativá", "Fómeque", "Fosca", "Funza", "Fúquene", "Fusagasugá", "Gachalá", "Gachancipá", "Gachetá", "Gama", "Girardot", "Granada", "Guachetá",
                        "Guaduas", "Guasca", "Guataquí", "Guatavita", "Guayabal de Síquima", "Guayabetal", "Gutiérrez", "Jerusalén", "Junín", "La Calera",
                        "La Mesa", "La Palma", "La Peña", "La Vega", "Lenguazaque", "Machetá", "Madrid", "Manta", "Medina", "Mosquera", "Nariño", "Nemocón", "Nilo", "Nimaima",
                        "Nocaima", "Pacho", "Paime", "Pandi", "Paratebueno", "Pasca", "Puerto Salgar", "Pulí", "Quebradanegra", "Quetame", "Quipile", "Ricaurte", "San Antonio del Tequendama",
                        "San Bernardo", "San Cayetano", "San Francisco", "San Juan de Rioseco", "Sasaima", "Sesquilé", "Sibaté", "Silvania", "Simijaca", "Soacha", "Sopó", "Subachoque", "Suesca",
                        "Supatá", "Susa", "Sutatausa", "Tabio", "Tausa", "Tena", "Tenjo", "Tibacuy", "Tibirita", "Tocaima", "Tocancipá",
                        "Topaipí", "Ubalá", "Ubaque", "Une", "Utica", "Venecia", "Vergara", "Vianí", "Villa de San Diego de Ubaté", "Villagómez", "Villapinzón", "Villeta", "Viotá", "Yacopí", "Zipacón", "Zipaquirá"
                    ],

                    Guainía: ["Barranco Minas", "Inirida"],

                    Guaviare: ["Calamar", "El Retorno", "Miraflores", "San Jose del Guaviare"],

                    Huila: ["Acevedo", "Agrado", "Aipe", "Algeciras", "Altamira", "Baraya", "Campoalegre", "Colombia", "Elías", "Garzón", "Gigante", "Guadalupe", "Hobo", "Iquira",
                        "Isnos", "La Argentina", "La Plata", "Nátaga", "Neiva", "Oporapa", "Paicol", "Palermo", "Palestina", "Pital", "Pitalito", "Pivera", "Saladoblanco", "San Agustín",
                        "Santa María", "Suaza", "Tarqui", "Tello", "Teruel", "Tesalia", "Timaná", "Villavieja", "Yaguará"
                    ],

                    LaGuajira: ["Albania", "Barrancas", "Dibulla", "Distracción", "El Molino", "Fonseca", "Hatonuevo", "La Jagua del Pilar", "Maicao", "Manaure", "Riohacha",
                        "San Juan del Cesar", "Uribia", "Urumita", "Villanueva"
                    ],

                    Magdalena: ["Algarrobo", "Aracataca", "Ariguaní", "Cerro de San Antonio", "Chivolo", "Ciénaga", "Concordia", "El Banco", "El Piñón", "El retén", "Fundación", "Guamal", "Nueva Granada", "Pedraza", "Pijiño del Carmen", "Pivijay", "Plato", "Puebloviejo", "Remolino", "Sabanas de San Angel", "Salamina",
                        "San Sebastián de Buenavista", "San Zenón", "Santa Ana", "Santa Bárbara de Pinto",
                        "Santa Marta", "Sitionuevo", "Tenerife", "Zapayán", "Zona Bananera"
                    ],

                    Meta: ["Acacías", "Barranca de Upía", "Cabuyaro", "Castilla", "La Nueva", "Cubarral", "Cumaral", "El Calvario",
                        "El Castillo", "El Dorado", "Fuente de Oro", "Granada", "Guamal", "La Macarena", "Lejanías", "Mapiripán",
                        "Mesetas", "Puerto Concordia", "Puerto Gaitán", "Puerto Lleras", " Puerto López", "Puerto Rico", "Restrepo",
                        "San Carlos de Guaroa", "San Juan de Arama", "San Juanito", "San Martín", "Uribe", "Villavicencio", "Vistahermosa"
                    ],

                    Nariño: ["Albán", "Aldana", "Ancuya", "Arboleda", "Barbacoas", "Belén", "Buesaco", "Carlosama", "Chachagüí", "Colón", "Consacá", "Contadero", "Córdoba", "Cuaspud", "Cumbal",
                        "Cumbitar", "El Charco", "El Peñol", "El Rosario", "El Tablón de Gómez", "El Tambo", "Francisco", "Pizarro", "Funes", "Guachucal", "Guaitarilla", "Gualmatán",
                        "Iles", "Imués", "Ipiales", "La Cruz", "La Florida", "La Llanada", " La Tola", "La Unión", "Leiva", "Linares", "Los Andes", "Magüí", "Mallama", "Mosquera",
                        "Nariño", "Olaya Herrera", "Ospina", "Pasto", "Policarpa", "Potosí", "Providencia", "Puerres", "Pupiales", "Ricaurte", "Roberto", "Payán", "Samaniego",
                        "San Andrés de Tumaco", "San Bernardo", "San Lorenzo", "San Pablo", "San Pedro de Cartago", "Sandoná", "Santa Bárbara", "Santacruz",
                        "Sapuyes", "Taminango", "Tangua", "Túquerres", "Yacuanquer"
                    ],

                    NortedeSantander: ["Ábrego", "Arboledas", "Bochalema", "Bucarasica", "Cáchira", "Cácota", "Chinácota", "Chitagá", "Convención", "Cucutilla", "Durania", "El Carmen",
                        "El Tarra", "El Zulia", "Gramalote", "Hacarí", "Herrán", "La Esperanza", "La Playa", "Labateca", "Los Patios", "Lourdes", "Mutiscua", "Ocaña",
                        "Pamplona", "Pamplonita", "Puerto Santander", "Ragonvalia", "Salazar", "San Calixto", "San Cayetano", "San José de Cúcuta", "Santiago", "Sardinata", "Silos",
                        "Teorama", "Tibú", "Toledo", "Villa Caro", "Villa del Rosario"
                    ],

                    Putumayo: ["Colón", "Mocoa", "Orito", "Puerto Asís", "Puerto Caicedo", "Puerto Guzmán", "Puerto Leguízamo", "San Francisco", "San Miguel", "Santiago", "Sibundoy",
                        "Valle del Guamuez", "Villagarzón"
                    ],

                    Quindío: ["Armenia", "Buenavista", "Calarcá", "Circasia", "Córdoba", "Filandia", "Génova", "La Tebaida", "Montenegro", "Pijao", "Quimbaya", "Salento"],

                    Risaralda: ["Apía", "Balboa", "Belén de Umbría", "Dosquebradas", "Guática", "La Celia", "La Virginia", "Marsella", "Mistrató", "Pereira",
                        "Pueblo Rico", "Quinchía", "Santa Rosa de Cabal", "Santuario"
                    ],

                    SanAndrésyProvidencia: ["Providencia"],

                    Santander: ["Aguada", "Albania", "Aratoca", "Barbosa", "Barichara", "Barrancabermeja", "Betulia", "Bolívar", "Bucaramanga", "Cabrera", "California", "Capitanejo",
                        "Carcasí", "Cepitá", "Cerrito", "Charalá", "Charta", "Chima", "Chipatá", "Cimitarra", "Concepción", "Confines", "Contratación", "Coromoro", "Curití", "El Carmen de Chucurí",
                        "El Guacamayo", "El Peñón", "El Playón", "Encino", "Enciso", "Florián", "Floridablanca", "Galán", "Gámbita", "Girón", "Guaca", "Guadalupe", "Guapotá", "Guavatá", "Güepsa",
                        "Hato", "Jesús María", "Jordán", "La Belleza", "La Paz", "Landázuri", "Lebrija", "Los Santos", "Macaravita", "Málaga", "Matanza", "Mogotes", "Molagavita", "Ocamonte",
                        "Oiba", "Onzaga", "Palmar", "Palmas del Socorro", "Páramo", "Piedecuesta", "Pinchote", "Puente Nacional", "Puerto Parra", "Puerto Wilches", "Rionegro",
                        "Sabana de Torres", "San Andrés", "San Benito", "San Gil", "San Joaquín", "San José de Miranda", "San Miguel", "San Vicente de Chucurí", "Santa Bárbara", "Santa Helena del Opón",
                        "Simacota", "Socorro", "Suaita", "Sucre", "Suratá", "Tona", "Valle de San José", "Vélez", "Vetas", "Villanueva", "Zapatoca"
                    ],

                    Sucre: ["Buenavista", "Caimito", "Chalán", "Colosó", "Corozal", "Coveñas", "El Roble", "Galeras", "Guaranda", "La Unión", "Los Palmitos", "Majagual", "Morroa",
                        "Ovejas", "Palmito", "Sampués", "San Benito Abad", "San José de Toluviejo", "San Juan de Betulia", "San Luis de Sincé", "San Marcos", "San Onofre", "San Pedro", "Santiago de Tolú",
                        "Sincelejo", "Sucre"
                    ],

                    Tolima: ["Alpujarra", "Alvarado", "Ambalema", "Anzoátegui", "Armero", "Ataco", "Cajamarca", "Carmen de Apicalá", "Casabianca", "Chaparral", "Coello",
                        "Coyaima", "Cunday", "Dolores", "Espinal", "Falan", "Flandes", "Fresno", "Guamo", "Herveo", "Honda", "Ibagué", "Icononzo", "Lérida", "Líbano", "Melgar", "Murillo",
                        "Natagaima", "Ortega", "Palocabildo", "Piedras", "Planadas", "Prado", "Purificación", "Rioblanco", "Roncesvalles", "Rovira", "Saldaña", "San Antonio", "San Luis",
                        "San Sebastián de Mariquita", "Santa Isabel", "Suárez", "Valle de San Juan", "Venadillo", "Villahermosa", "Villarrica"
                    ],

                    ValledelCauca: ["Alcalá", "Andalucía", "Ansermanuevo", "Argelia", "Bolívar", "Buenaventura", "Bugalagrande", "Caicedonia", "Calima", "Candelaria", "Cartago", "Dagua",
                        "El Águila", "El Cairo", "El Cerrito", "El Dovio", "Florida", "Ginebra", "Guacarí", "Guadalajara de Buga", "Jamundí", "La Cumbre", "La Unión", "La Victoria",
                        "Obando", "Palmira", "Pradera", "Restrepo", "Riofrío", "Roldanillo", "San Pedro", "Santiago De Cali", "Sevilla", "Toro", "Trujillo", "Tuluá", "Ulloa", "Versalles",
                        "Vijes", "Yotoco", "Yumbo", "Zarzal"
                    ],

                    Vaupés: ["Carurú", "Mitu", "Taraira", ],

                    Vichada: ["Cumaribo", " La Primavera", "Puerto Carreño", "Santa Rolasia"]
                };

                // Event listener para actualizar municipios cuando cambie el departamento seleccionado
                departamentos.addEventListener('change', function() {
                    const selectedDepartment = departamentos.value;
                    const municipalityOptions = municipioData[selectedDepartment] || [];

                    // Limpia el select de municipios
                    municipios.innerHTML = '';

                    // Rellena el select de municipios con las opciones correspondientes
                    municipalityOptions.forEach(function(municipio) {
                        const option = document.createElement('option');
                        option.value = municipio;
                        option.textContent = municipio;
                        municipios.appendChild(option);
                    });
                });
            });
        </script>

    </body>

    </html>
<?php
} else {
    header("location: index.php");
    exit();
}
?>