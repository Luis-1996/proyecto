<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Iniciar Sesión | UDC</title>
    <link rel="icon" href="../../fondo.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="plugins/morrisjs/morris.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet">
    <link href="css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="login-page">
    <div class="login-box">
        <div class="card">
            <div class="body">
                <form id="sign_in" method="POST" action="validar.php">
                    <div class="msg">
                        <h4>UNIVERSIDAD DE CARTAGENA <br>Centro Tutorial Cereté</h4>
                        <img src="images/fondo.png" width="160px" height="130px">
                        <h3>Iniciar Sesión</h3>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="usuario" id="usuario" placeholder="Correo institucional" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="contraseña" id="contra" placeholder="Contraseña" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-orange">
                            <label for="rememberme">Recuerdame</label>
                        </div>
                        <div class="col-xs-4">
                            <input class="btn btn-block bg-orange waves-effect" type="submit" value="INGRESAR">
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6 align-right">
                            <a href="forgot-password.php">Olvide mi contraseña</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>
    <script src="../../plugins/node-waves/waves.js"></script>
    <script src="../../plugins/jquery-validation/jquery.validate.js"></script>
    <script src="../../js/admin.js"></script>
    <script src="../../js/pages/examples/forgot-password.js"></script>
</body>

</html>