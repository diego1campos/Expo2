<?php
  //Se establece todas las clases o funciones necesarias ='D'
  require("../lib/database.php");
  require("../lib/validator.php");
  //
  session_start();
  //sprint( session_id() );

  //funcion iniciar sesion
  function iniciar_sesion( $data ){
    $click_login = "INICIO SESION y para que no me diga que se ignorara el session de abajo :D";
    
    /*tiempo sesion---Guardamos la fecha y hora actual en la variable de sesion :D*/
    $_SESSION["ultimoAcceso_mc"] = date("Y-m-d H:i:s");
    /*tiempo sesion*/
    $_SESSION['id_empleado'] = $data['id_empleado'];
    $_SESSION['nombre_empleado'] = $data['nombres_empleado']." ".$data['apellidos_empleado'];
    $_SESSION['img_empleado'] = $data['img_empleado'];
    $_SESSION['id_tipo_usuario'] = $data['id_tipo_usuario'];
    //Actualizo el campo de estado_sesion a la variable id de la sesion por que va a iniciar sesion
    $exito = Database::executeRow( 'update empleados set estado_sesion=? where id_empleado = ?;', array( session_id(), $_SESSION['id_empleado'] ) );
    if ( $exito == 1 ){
      header("location: index");
      exit();
    }
  }
  //funcion iniciar sesion

  if ( isset( $_SESSION['nombre_empleado'] ) ) header("location: index");

  if ( isset( $_POST['no'] ) ){
    $data = Database::getRow( "SELECT * FROM empleados WHERE usuario=?;", array( $_SESSION['usuario'] ) );
    iniciar_sesion( $data );
    exit();
  }

  //Para saber si hay usuarios o no
  $num_usu = Database::getRow( "select count( id_empleado ) count from empleados;", null );

  if( !empty($_POST) && $num_usu['count'] != 0 ){
      if ( isset($_POST['usuario']) ) $alias = $_POST['usuario'];
      if ( isset($_POST['clave']) ) $clave = $_POST['clave'];
      if( isset($_POST['clave']) && isset( $_POST['usuario'] ) && $alias != "" && $clave != "" && Validator::numeros_letras($alias) && Validator::numeros_letras($clave) ){
          try{
              $sql = "SELECT * FROM empleados WHERE usuario=?";
              $data = Database::getRow( $sql, array($alias) );
              if( $data != null ){
                  $hash = $data['clave'];
                  if( password_verify( $clave, $hash) ) {
                  //if ( $clave == $hash ){
                    if( $data['estado_sesion'] == '0' ||  $data['estado_sesion'] == session_id() ){
                      iniciar_sesion( $data );
                      exit();
                    }
                    else{//Por si acaso xd -->if ( $data['estado_sesion'] != session_id() ) 
                      if ( Validator::numeros_letras($_POST['usuario']) ) $_SESSION['usuario'] = $_POST['usuario'];
                      else $error[] = "Usuario ingresado invalido.";
                      $sesion_ini = "si";
                      print("<script>$('#login-modal').modal({show: 'false'});</script>");
                    }
                  }
                  else $error[] = "La contraseña es incorrecta.";
              }
              else $error[] = "Usuario no encontrado.";
          }
          catch( Exception $Exception ){
              $error[] = $Exception->getMessage( );
          }
      }
      if ( isset($_POST['usuario']) && ! Validator::numeros_letras($_POST['usuario']) ) $error[] = "Usuario ingresado invalido.";
      if ( isset($_POST['clave']) && ! Validator::numeros_letras($_POST['clave']) ) $error[] = "Contraseña ingresada invalida.";
  }
  else if ( !empty($_POST) ) {
    try{
      //Campos del formulario.
      $tipo_usuario = $_POST['tipo_usuario'];
      $nombre_empleado = $_POST['nombre_empleado'];
      $apellido_empleado = $_POST['apellido_empleado'];
      $documento_empleado = $_POST['documento_empleado'];
      $correo_empleado = $_POST['correo_empleado'];
      $usuario_empleado = $_POST['usuario_empleado'];
      $id_pregunta = $_POST['id_pregunta'];
      $respuesta_empleado = $_POST['respuesta_empleado'];
      $imagen = $_FILES['archivo'];
      $fecha_nacimiento = $_POST['fecha_nacimiento'];
      

      if( $imagen['name'] != null )
      {

            if($imagen['type'] == "image/jpeg" || $imagen['type'] == "image/png" || $imagen['type'] == "image/x-icon" || $imagen['type'] == "image/gif")
            {
              $info_imagen = getimagesize($imagen['tmp_name']);
              $ancho_imagen = $info_imagen[0]; 
              $alto_imagen = $info_imagen[1];
              if ( $ancho_imagen >= 500 && $alto_imagen >= 500)
              {
                $nuevo_id = uniqid(); //Esto sirve para darle un nombre único a cada archivo de imagen.
                $nombre_archivo = $imagen['tmp_name'];
                $imagen_empleado = $nuevo_id.".png";
                $destino = "../img/empleados/$imagen_empleado";
                move_uploaded_file($nombre_archivo, $destino); //Función para subir archivos al servidor.
                  
                  //Validar campos :D
                if (Validator::numero( $tipo_usuario ) && Validator::letras( $nombre_empleado )
                 && Validator::letras( $apellido_empleado ) && Validator::dui( $documento_empleado )
                 && Validator::correo($correo_empleado ) && Validator::numeros_letras( $usuario_empleado )
                 && Validator::letras( $respuesta_empleado ) && Validator::numero( $id_pregunta )
                 && Validator::fecha( $fecha_nacimiento )
                 ){
                  if ( $_POST['clave1'] != null || $_POST['clave2'] != null ){
                    if ( Validator::numeros_letras( $_POST['clave1'] ) && Validator::numeros_letras( $_POST['clave2'] ) ){
                      if ( ( strtotime( date("Y-m-d") ) - strtotime($fecha_nacimiento) ) >= 568080000 ){
                        $clave1 = $_POST['clave1'];
                        $clave2  = $_POST['clave2'];
                        if($clave1==$clave2){
                          if (strlen($clave1) >= 8 ) {
                            if ($clave2!=$usuario_empleado) {
                               $clave_empleado = password_hash($clave2, PASSWORD_DEFAULT);
                               $respuesta2 = password_hash($respuesta_empleado, PASSWORD_DEFAULT);
                               Database::executeRow( "INSERT INTO empleados(id_tipo_usuario, nombres_empleado, apellidos_empleado, n_documento, correo, usuario, clave, id_pregunta, respuesta, img_empleado, estado_sesion, fecha_registro, fecha_nacimiento) values(?,?,?,?,?,?,?,?,?,?,0, '" . date("Y-m-d H:i:s") . "', ?)", array($tipo_usuario, $nombre_empleado, $apellido_empleado, $documento_empleado, $correo_empleado, $usuario_empleado, $clave_empleado, $id_pregunta, $respuesta2, $imagen_empleado, $fecha_nacimiento) );
                               header("location: index");
                            }
                            else $error_data = "La contraseña no puede ser igual al nombre de usuario";
                          }
                          else $error[] = "La longitud de la contraseña debe ser mayor a 8 caracteres.";
                        }
                        else $error[] = "Las contraseñas no coinciden.";
                      }
                      else $error[] = "Debe ser mayor de edad (más de 18 años).";
                      ( ! ( Validator::fecha( $fecha_nacimiento ) ) ) ? $er_fecha = "error_data" : "";
                    }
                    ( ! ( Validator::numeros_letras( $clave1 ) ) ) ? $er_clave1 = "error_data" : "";
                    ( ! ( Validator::numeros_letras( $clave2 ) ) ) ? $er_clave2 = "error_data" : "";
                  }
                }
                  
                
                else $error_data = "Error, por favor revise los campos señalados.";

                ( ! ( Validator::numero( $id_pregunta ) ) ) ? $er_pregunta = "error_data" : "";
                
                ( ! ( Validator::letras( $nombre_empleado ) ) ) ? $er_nombre = "error_data" : "";
                
                ( ! ( Validator::letras( $apellido_empleado ) ) ) ? $er_apellido = "error_data" : "";

                ( ! ( Validator::dui( $documento_empleado ) ) ) ? $er_dui = "error_data" : "";
                  
                ( ! ( Validator::correo( $correo_empleado ) ) ) ? $er_correo = "error_data" : "";
                  
                ( ! ( Validator::numeros_letras( $usuario_empleado ) ) ) ? $er_usuario = "error_data" : "";

                ( ! ( Validator::letras( $respuesta_empleado ) ) ) ? $er_respuesta = "error_data" : "";
                
                ( ! ( Validator::numero( $tipo_usuario ) ) ) ? $ertipo_usuario = "error_data" : "";

              }

              else throw new Exception("La dimensión de la imagen no es valida.");
            }
            else throw new Exception("El tipo de imagen no es valido.");

        }
      } 

    catch( Exception $Exception ) {
      if($Exception->getCode() == 23000) $error[] = "Dato duplicado";
      else $error[] = $Exception->getMessage();
    }
  }

  //if ( ! isset( $_POST['olvide'] ) ) $error[] = "Debe de ingresar un usuario.";

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php print( ( $num_usu['count'] == 0 ) ? "Registrar primer usuario" : 'ISADELI | Log in' ); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../publico/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
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

<!--Cuando hay un usuario en la base de datos :D-->
<?php 
  //Cuando no hay usuarios registrados :D
  if ( $num_usu['count'] == 0 ){ ?>
      <div class="col-xs-12 col-md-offset-1 col-md-10  col-lg-offset-1 col-lg-10">
        <form id="form_primer_usuario" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  <h1 align="center">Registrar primer usuario</h1>
                  <br>
                  <br>
                  <div class="col-sm-6 col-md-6 col-lg-6">
                    <?php if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' ); ?>
                    <div class="form-group">
                        <label for="">Nombres</label>
                        <input  onpaste=";return false" type="text" id="nombre_empleado" name="nombre_empleado" required='required' class="form-control vletras_esp <?php print( ( isset($er_nombre) ) ? "$er_nombre": "");  ?>" maxlength="50" autocomplete="off"  
                                    value='<?php print(!empty($nombre_empleado)?$nombre_empleado:""); ?>'>
                                    <?php print(!empty($nombre_empleadoError)?"<span class='help-block'>$nombre_empleadoError</span>":""); ?>
                    </div>

                    <div class="form-group">
                      <label for="">Apellidos</label>
                       <input onpaste=";return false" type="nombre" id="apellido_empleado" name="apellido_empleado" required='required'  class="form-control vletras_esp <?php print( ( isset($er_apellido) ) ? "$er_apellido": "");  ?>"  maxlength="100" autocomplete="off"  
                                   value='<?php print(!empty($apellido_empleado)?$apellido_empleado:""); ?>'>
                                  <?php print(!empty($apellido_empleadoError)?"<span class='help-block'>$apellido_empleadoError</span>":""); ?>
                    </div>

                    <div class="form-group">
                        <label for="id_pregunta">Pregunta</label>
                        <select id="id_pregunta" name="id_pregunta"  class="form-control select2 <?php print( ( isset($er_pregunta) ) ? "$er_pregunta": ""); ?>">
                            <option value="" disabled selected>Seleccione pregunta</option>
                            <?php
                              require("../sql/conexion.php");
                              $sql="SELECT id_pregunta, pregunta FROM preguntas";
                                        foreach ($PDO->query($sql) as $row) {
                                            echo "<option value ='$row[id_pregunta]'";
                                            if (isset($id_pregunta) && $id_pregunta == $row["id_pregunta"])
                                            {
                                                echo " selected";
                                            }
                                            echo ">";
                                            echo $row["pregunta"];
                                            echo "</option>";
                                        }
                             
                              $PDO = null;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tipo_usuario">Tipo de usuario</label>
                        
                        <select required id="tipo_usuario" name="tipo_usuario" class="form-control <?php print( ( isset($ertipo_usuario) ) ? "$ertipo_usuario": ""); ?>">
                            <option value="" disabled selected>Seleccione tipo de usuario</option>
                            <?php
                              require("../sql/conexion.php");
                              $sql="SELECT id_tipo_usuario, tipo_usuario FROM tipos_usuarios";
                                        foreach ($PDO->query($sql) as $row) {
                                            echo "<option value ='$row[id_tipo_usuario]'";
                                            if (isset($tipo_usuario) && $tipo_usuario == $row["id_tipo_usuario"])
                                            {
                                                echo " selected";
                                            }
                                            echo ">";
                                            echo $row["tipo_usuario"];
                                            echo "</option>";
                                        }
                              
                              $PDO = null;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                              <label for="Nombre">Respuesta</label>
                              <input  onpaste=";return false" id="respuesta_empleado" name="respuesta_empleado" required='required' class="form-control vletras_esp <?php print( ( isset($er_respuesta) ) ? "$er_respuesta": ""); ?>" maxlength="100" autocomplete="off"  
                                      value='<?php print(!empty($respuesta_empleado)?$respuesta_empleado:""); ?>' type="password">
                                      <?php print(!empty($respuesta_empleadoError)?"<span class='help-block'>$respuesta_empleadoError</span>":""); ?>
                            </div>
                      <div class="form-group">
                        <label  for="Nombre">Numero de Documento</label>
                        <input  onpaste=";return false" type="nombre" id="documento_empleado" name="documento_empleado" required='required'  class="form-control vnumeros <?php print( ( isset($er_dui) ) ? "$er_dui": ""); ?>" minlength="9" maxlength="9" autocomplete="off"  
                                value='<?php print(!empty($documento_empleado)?$documento_empleado:""); ?>'>
                                <?php print(!empty($documento_empleadoError)?"<span class='help-block'>$documento_empleadoError</span>":""); ?>
                      </div>
                      <div class="form-group">
                        <label for="Nombre">Correo</label>
                        <input  onpaste=";return false" type="" id="correo_empleado" name="correo_empleado" required='required' class="form-control <?php print( ( isset($er_correo) ) ? "$er_correo": ""); ?>" maxlength="100" autocomplete="off"  
                                value='<?php print(!empty($correo_empleado)?$correo_empleado:""); ?>'>
                                <?php print(!empty($documento_empleadoError)?"<span class='help-block'>$correo_empleadoError</span>":""); ?>
                      </div>
                      <div class="form-group">
                          <label for="Nombre">Usuario</label>
                          <input  onpaste=";return false" type="nombre" id="usuario_empleado" name="usuario_empleado" required='required'  class="form-control <?php print( ( isset($er_usuario) ) ? "$er_usuario": ""); ?> " maxlength="50" autocomplete="off"  
                                  value='<?php print(!empty($usuario_empleado)?$usuario_empleado:""); ?>'>
                                  <?php print(!empty($usuario_empleadoError)?"<span class='help-block'>$usuario_empleadoError</span>":""); ?>
                        </div>
                    </div>
                  <div class="col-sm-6 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label for="archivo">Imagen principal</label>
                        <img src="../img/logo.png" class="img-responsive" id="pro_img"/>
                        <BR>
                        <input name="archivo" type="file" required  id="pro_img_url"/>
                      </div>
                        
                        <br><br>
                            <div class="row">
                              <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                <label for="archivo">Contraseña</label>
                                  <input autocomplete="off" onpaste=";return false" type="password" name="clave1" id="clave1"  placeholder="Contraseña" tabindex="5"
                                  class="form-control input-lg <?php print( ( isset($er_clave1) ) ? "$er_nombre": "");  ?>" value='<?php print(!empty($clave1)?$clave1:""); ?>'>
                                  <?php print(!empty($clave1_empleadoError)?"<span class='help-block'>$clave1_empleadoError</span>":""); ?> 
                                </div>
                              </div>

                              <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                  <label for="archivo">Confirmar contraseña</label>
                                      <input autocomplete="off" onpaste=";return false" type="password" name="clave2" id="clave2"  placeholder="Confirma tu contraseña" tabindex="6"
                                    class="form-control input-lg <?php print( ( isset($er_clave2) ) ? "$er_nombre": "");  ?>" value='<?php print(!empty($clave2)?$clave2:""); ?>'>
                                    <?php print(!empty($clave2_empleadoError)?"<span class='help-block'>$clave2_empleadoError</span>":""); ?> 
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
  		                            <label for="archivo">Fecha de nacimiento</label>
  		                            <input autocomplete="off" onpaste=";return false" type="text" name="fecha_nacimiento" id="datetimepicker"  placeholder="Año-Mes-Día" tabindex="7" class="form-control input-lg <?php print( ( isset($er_fecha) ) ? "$er_fecha": "");  ?>" value='<?php print(!empty($fecha_nacimiento)?$fecha_nacimiento:""); ?>'> 
  	                           </div>
  	                         </div>
                            </div>
                      
                  </div>
                  </div>
                  <div class="box-body text-center">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                      <button type="submit" name="action" class="btn btn-primary btncolor margin_right fbtn fc-grid">
                          <span class="glyphicon glyphicon-plus"></span>
                      </button>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                      <button type="button" class="btn btn-danger fbtn fc-grid">
                          <span class="glyphicon glyphicon-remove"></span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
<?php }
      else{ ?>
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>ISA</b>DELI</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <!--?php if ( ! isset( $sesion_ini ) ) print( '<p class="login-box-msg">'.$sesion_ini.'</p>' ); ?-->
      <?php if ( ! isset( $sesion_ini ) ) print( '<h3 class="login-box-msg">Ingresa tus datos</h3>' ); ?>

      <form method="post" id="frmlogin">

        <div id="datos_recuperar">
          <?php if ( ! isset( $sesion_ini ) ){ ?>
              <div class="form-group has-feedback">
                <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario" autocomplete="off">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>            
              </div>
              <div class="form-group has-feedback">
                <input type="password" name="clave" class="form-control" placeholder="Contraseña" autocomplete="off">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
          <?php }
                else{ ?>
              <div class="form-group has-feedback">
                <h3>Tiene una sesión ya establecida en otro dispositivo. Si desconoce esta actividad, le sugerimos restaurar la contraseña.</h3>
                <h3>¿Desea restaurar la contraseña?</h3>
              </div>
          <?php } ?>
        </div>
        <div class="row">
          <!--Lo ocupo cuando envio el error por javascript, para no volver a reescribir el boton "btncontinuar" por que se elimna su codigo (bien raro xd), por que lo que hacia era un $('.row').html('blabla xd')-->
          <div id="mensaje_error">
            
          </div>
          <?php if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' ); ?>
          <!--div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> Remember Me
              </label>
            </div>
          </div-->
          <!-- /.col -->
          <?php if ( ! isset( $sesion_ini ) ){ ?>
              <div class="col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
                <button type="submit" id="btncontinuar" class="btn btn-primary btn-block btn-flat">Iniciar sesión</button>
              </div>
          <?php }
                else{ ?>
              <!--div class="row"-->
                <div class="col-xs-offset-0 col-xs-6 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-6">
                  <button id="btncontinuar" value="1" type="button" class="btn btn-primary btn-block btn-flat">Restaurar contraseña</button>
                </div>
                <div class="col-xs-offset-0 col-xs-6 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-6">
                  <button name="no" type="submit" class="btn btn-danger btn-block btn-flat">No</button>
                </div>
              <!--/div-->
          <?php } ?>
          <!-- /.col -->
        </div>
      </form>

      <!-- /.social-auth-links -->
      <br>
      <div class="ocultar">
        <?php if ( ! isset( $sesion_ini ) ) print( '<a href="#" id="olvide" >¿Olvidaste tu contraseña?</a><br>' ); ?>
      </div>
      <!--a href="register.html" class="text-center">Register a new membership</a-->

    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->
<?php } ?>

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
