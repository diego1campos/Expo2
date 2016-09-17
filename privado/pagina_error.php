<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title<?php print( ( isset( $_GET['error'] ) && base64_decode( $_GET['error'] ) == 1 ) ? "Error 404" : "Error 403" ); ?>
  </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../publico/css/bootstrap.min.css">
    <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <link rel="stylesheet" href="../publico/css/sweet-alert.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>ISA</b>DELI</a>
    </div>
  </div>
  <div class="container-fluid" align="center">
    <h1><?php print ( ( isset( $_GET['error'] ) && base64_decode( $_GET['error'] ) == 1 ) ? 'Dirección de pagina invalida' : "No tiene permisos para realizar esta accion." ); ?> <small><a href="starter">Inicio</a></small> </h1>
  </div>
  <!-- /.login-box -->

<!-- jQuery 2.2.0 -->
<script src="../publico/js/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<!--script src="plugins/iCheck/icheck.min.js"></script-->

<script src="../publico/js/mainB.js"></script>
<script src="../publico/js/sweet-alert.js"></script>
</body>
</html>