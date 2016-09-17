<?php
require("../sql/conexion.php");//Lo ocupo por el lastinsertid :)
require("../lib/database.php");
require("../lib/validator.php");
require("../lib/page.php");
ob_start();
Page::header("Registrar");

//Funcion para actualizar las variables de sesion :D
function actualizar_datos ( $nombres_cliente, $apellidos_cliente, $imagen_cliente ){
  $_SESSION['nombre_cliente'] = $nombres_cliente." ".$apellidos_cliente;
  if ( $imagen_cliente != null ) $_SESSION['img_cliente'] = $imagen_cliente;
}
//Funcion para actualizar las variables de sesion :D

function insertar_direcciones( $exito, $id_cliente ){
  //if ( $exito == null ) $exito = 1;
  if ( isset( $_POST['direcciones'] ) ){
    /*direcciones*/
    if ( isset( $_POST['direcciones'] ) ){
      //Comprobar las direcciones TODAS
      $i = 0;//Lo ocupo para eliminar los espacios en blanco
      foreach ( $_POST['direcciones'] as $direccion ){
        if ( $direccion == "" ) unset( $_POST['direcciones'][$i] );//Elimino las direcciones en blanco :)
        else if ( ! Validator::numeros_letras( $direccion ) ) $direccion_invalida = true;
        $i++;
      }
      //Insertar las direcciones, TODAS...Como la variable se crea con una sola vez que pase, no importa si al siguiente no le pone el valor de true ;)
      try{
        if ( $exito == 1 && ! isset( $direccion_invalida ) ){
          foreach ( $_POST['direcciones'] as $direccion ) $exito = Database::executeRow( 'insert into direcciones ( id_cliente, direccion ) values( ?, ? );' , array( ( ( isset( $_SESSION['id_cliente'] ) ) ? $_SESSION['id_cliente'] : $id_cliente ), $direccion ) );
        }
      }
      catch( Exception $Exception ){
        if ( $Exception->getCode() == 23000 ){
          $error[] = "Direccion ingresada ya existente.";
          $direccion_invalida = true;
        }
      }
    }
   /*direcciones*/
  }
  if ( isset( $direccion_invalida ) ) return 0;
  else return $exito;
}

if(!empty($_POST))
{
  //$action = $_POST['action'];
  //try{
  //Campos del formulario
  @$nombres_cliente = $_POST['nombres_cliente'];
  @$apellidos_cliente = $_POST['apellidos_cliente'];
  @$usuario = $_POST['usuario'];
  @$correo = $_POST['correo'];  
  @$id_pregunta = $_POST['id_pregunta'];
  @$respuesta = $_POST['respuesta'];
  @$imagen_nueva = $_FILES['pro_img_url'];//Imagen
  @$imagen_actual = $_POST['imagen_actual'];
  //$cap = $_POST['cap'];
  //echo $respuesta . "+" . $id_pregunta . "+" .$correo  . "+" . $clave1 . "+" . "+" . "+" . "+" . "+";

  @( $_POST['clave1'] != null && ! ( Validator::numeros_letras( $_POST['clave1'] ) ) ) ? $error[] = "Contraseña: solo se permiten numeros y letras." : "";
  @( $_POST['clave2'] != null && ! ( Validator::numeros_letras( $_POST['clave2'] ) ) ) ? $error[] = "Confirmar contraseña: solo se permiten numeros y letras." : "";
  if($imagen_nueva['name'] != null)
  {
    if($imagen_nueva['type'] == "image/jpeg" || $imagen_nueva['type'] == "image/png" || $imagen_nueva['type'] == "image/x-icon" || $imagen_nueva['type'] == "image/gif")
    {
      $info_imagen = getimagesize($imagen_nueva['tmp_name']);
      $ancho_imagen = $info_imagen[0]; 
      $alto_imagen = $info_imagen[1];
      //if ( $ancho_imagen >= 150 && $alto_imagen >= 150){
      $nuevo_id = uniqid(); //Esto sirve para darle un nombre único a cada archivo de imagen.
      $nombre_archivo = $imagen_nueva['tmp_name'];
      $imagen_cliente = $nuevo_id.".png";
      $destino = "../img/clientes/$imagen_cliente";
      if ( isset( $imagen_actual) ) unlink("../img/clientes/$imagen_actual");//Función para eliminar la imagen anterior.
      move_uploaded_file($nombre_archivo, $destino); //Función para subir archivos al servidor.

      if ( Validator::letras( $nombres_cliente ) &&  Validator::letras( $apellidos_cliente ) && Validator::correo($correo ) )
      {
        if ( isset( $_SESSION['id_cliente'] ) || ( Validator::numeros_letras( $usuario ) && Validator::numeros_letras( $respuesta ) && Validator::numero( $id_pregunta ) ) )
        {
          try
          {
            //if( ( isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response'] ) || isset( $_SESSION['id_cliente'] ) )
            //{
            if ( $_POST['clave1'] != null || $_POST['clave2'] != null )
            {
              if ( Validator::numeros_letras( $_POST['clave1'] ) && Validator::numeros_letras( $_POST['clave2'] ) )
              {
                $clave1 = $_POST['clave1'];
                $clave2  = $_POST['clave2'];
                if ($clave1 == $clave2 )
                {
                  if ( strlen($clave1) >= 8 ) 
                  {
                    if ( ! isset( $usuario ) ){
                      $datos_cliente = Database::getRow( "select usuario from clientes where id_cliente = ?;", array( $_SESSION['id_cliente'] ) );
                      $usuario = $datos_cliente['usuario'];
                    }
                    if ( $clave2 != $usuario ) 
                    {
                      $clave = password_hash($clave1, PASSWORD_DEFAULT);
                      $respuesta_encriptada = password_hash($respuesta, PASSWORD_DEFAULT);
                      if ( isset( $_SESSION['id_cliente'] ) )
                      {
                        $consulta = "UPDATE clientes set nombres_cliente = ?, apellidos_cliente = ?, clave = ?, correo = ?, img_cliente = ? where id_cliente = ?";
                        $exito = Database::executeRow( $consulta, array( $nombres_cliente, $apellidos_cliente, $clave, $correo, $imagen_cliente, $_SESSION['id_cliente'] ) );
                        $exito = insertar_direcciones( $exito, null );
                        actualizar_datos( $nombres_cliente, $apellidos_cliente, $imagen_cliente );//Actualizar datos :D
                        if ($exito == 1 ) header("location: index");
                      }
                      else
                      {
                        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "INSERT INTO clientes(nombres_cliente, apellidos_cliente, usuario, clave, correo, id_pregunta, respuesta, img_cliente, estado_sesion) values(?, ?, ?, ?, ?, ?, ?, ?, 0)";
                        $stmt = $PDO->prepare( $sql );
                        $exito = $stmt->execute( array( $nombres_cliente, $apellidos_cliente, $usuario, $clave, $correo, $id_pregunta, $respuesta_encriptada, $imagen_cliente) );
                        $exito = insertar_direcciones( $exito, $PDO->lastInsertId() );
                        if ($exito == 1 ) header("location: index");
                      }
                    }
                    else
                    {
                      $error[] = "La Contraseña no puede ser igual al nombre de usuario";
                    }
                  }
                  else
                  {
                    $error[] = "La longitud de la contraseña debe ser mayor a 8 caracteres.";
                  }
                }
                else $error[] = "Las contraseñas no coinciden.";
              }
            }
            else
            {
              $consulta = "UPDATE clientes set nombres_cliente = ?, apellidos_cliente = ?,  correo = ?, img_cliente = ? where id_cliente = ?";
              $exito = Database::executeRow( $consulta, array( $nombres_cliente, $apellidos_cliente, $correo, $imagen_cliente, $_SESSION['id_cliente'] ) );
              $exito = insertar_direcciones( $exito, null );
              actualizar_datos( $nombres_cliente, $apellidos_cliente, $imagen_cliente );//Actualizar datos :D
              if ($exito == 1 ) header("location: index");
            }
            //}
            //else $error[] = "Debe de ser humano para realizar esta accion.";
          }
          catch( PDOException $Exception ) 
          {
              $error[] = $Exception->getMessage( );
              if($Exception->getCode() == 23000)
              {
                $error[] = "Usuario ya existente, por favor ingrese otro.";
              }
          }
        }
      }
      else $error_data = "Error, por favor revise los campos señalados.";

      if ( isset($id_pregunta) ) ( ! ( Validator::numero( $id_pregunta ) ) ) ? $error[] = "Pregunta de seguridad: seleccione una pregunta de seguridad." : "";
      
      if ( isset($nombres_cliente) ) ( ! ( Validator::letras( $nombres_cliente ) ) ) ? $error[] = "Nombres: solo se permiten letras." : "";
  
      if ( isset($apellidos_cliente) ) ( ! ( Validator::letras( $apellidos_cliente ) ) ) ? $error[] = "Apellidos: solo se permiten letras." : "";
        
      if ( isset($correo) ) ( ! ( Validator::correo( $correo ) ) ) ? $error[] = "Correo: ingrese un correo valido, ejemplo: ejemplo@hotmail.com" : "";
        
      if ( isset($usuario) ) ( ! ( Validator::numeros_letras( $usuario ) ) ) ? $error[] = "Usuario: solo se permiten numeros y letras." : "";

      if ( isset($respuesta) ) ( ! ( Validator::numeros_letras( $respuesta ) ) ) ? $error[] = "Respuesta: solo se permiten numeros y letras." : "";

      //if ( isset($cap) ) ( ! ( Validator::numeros_letras( $cap ) ) ) ? $error[] = "Captcha: debe de ." : "";
      
    } //Fin de validacion de tipo de imagen.
    else $error[] = "Tipo de imagen incorrecta.";
  } //Fin de validacion de selección de imagen.
  else {
    if ( isset( $_SESSION['id_cliente'] ) )
    {
      if ( Validator::letras( $nombres_cliente ) &&  Validator::letras( $apellidos_cliente ) && Validator::correo($correo ) )
      {
        if ( $_POST['clave1'] != null || $_POST['clave2'] != null ){
  
          if ( Validator::numeros_letras( $_POST['clave1'] ) && Validator::numeros_letras( $_POST['clave2'] ) ){
            $clave1 = $_POST['clave1'];
            $clave2  = $_POST['clave2'];
            if($clave1==$clave2 )
            {
              if (strlen($clave1) >= 8 ) {
                $datos_cliente = Database::getRow( "select usuario from clientes where id_cliente = ?;", array( $_SESSION['id_cliente'] ) );
                $usuario = $datos_cliente['usuario'];//Para que sea diferente al ingresado en la base :D
                if ( $clave2 != $usuario ) {
                   $clave = password_hash($clave1, PASSWORD_DEFAULT);
                  $consulta = "UPDATE clientes set nombres_cliente = ?, apellidos_cliente = ?, clave = ?, correo = ? where id_cliente = ?";
                  $exito = Database::executeRow( $consulta, array( $nombres_cliente, $apellidos_cliente, $clave, $correo, $_SESSION['id_cliente'] ) );
                  $exito = insertar_direcciones( $exito, null );
                  actualizar_datos( $nombres_cliente, $apellidos_cliente, null );//Actualizar datos :D
                  if ($exito == 1 ) header("location: index");
                  
                }
                else $error[] = "La Contraseña no puede ser igual al nombre de usuario";
              }
              else $error[] = "La longitud de la contraseña debe ser mayor a 8 caracteres.";
            }
            else $error[] = "Las contraseñas no coinciden.";
          }
        }   
        else{//Solo info sin imagen ni contra
          $consulta = "UPDATE clientes set nombres_cliente = ?, apellidos_cliente = ?, correo = ? where id_cliente = ?";
          $exito = Database::executeRow( $consulta, array( $nombres_cliente, $apellidos_cliente, $correo, $_SESSION['id_cliente'] ) );
          $exito = insertar_direcciones( $exito, null );
          actualizar_datos( $nombres_cliente, $apellidos_cliente, null );//Actualizar datos :D
          if ($exito == 1 ) header("location: index");
        }        
      }
      else $error_data = "Error, por favor revise los campos señalados.";
            
      if ( isset($nombres_cliente) ) ( ! ( Validator::letras( $nombres_cliente ) ) ) ? $error[] = "Nombres: solo se permiten letras." : "";
  
      if ( isset($apellidos_cliente) ) ( ! ( Validator::letras( $apellidos_cliente ) ) ) ? $error[] = "Apellidos: solo se permiten letras." : "";
          
      if ( isset($correo) ) ( ! ( Validator::correo( $correo ) ) ) ? $error[] = "Correo: ingrese un correo valido, ejemplo: ejemplo@hotmail.com" : "";
    }
    else $error[] = "Debe de seleccionar una imagen.";
  }
  
}
else
  {
    if ( isset( $_SESSION['id_cliente'] ) && (! isset( $_POST['action-clientes'] ) ) ){
      $consulta = "SELECT * from clientes where id_cliente = ?;";
      $imagenes = Database::getRow( $consulta, array( $_SESSION['id_cliente'] ) );
      $nombres_cliente = $imagenes['nombres_cliente'];
      $apellidos_cliente = $imagenes['apellidos_cliente'];
      $usuario = $imagenes['usuario'];
      $correo = $imagenes['correo'];
      $id_pregunta = $imagenes['id_pregunta'];
      $respuesta = $imagenes['respuesta'];
      $imagen_actual = $imagenes['img_cliente'];
    }
  } //Fin de comprobar formulario.
?>
<div class="container">
  <br>
  <br><br>

<div class="row">

  <?php
    /*$palabra = '';
    if ( isset($action) && $action == "Agregar" ) $palabra = "añadida";*/
    print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
    if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
  ?>

    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
      <form role="form"  method="post" id="frmcaptcha" enctype="multipart/form-data"><!-- action="datos.php"-->
      <?php print( ( ( isset( $_SESSION['id_cliente'] ) ) ? '<h2>Actualizar datos<!--small></small--></h2>' : '<h2>¡Registrate! <small>Es gratis</small></h2>' ) ) ?>
      <hr class="colorgraph">
      <input name="imagen_actual" type="hidden" value='<?php print($imagen_actual); ?>'>

      <div class="row">
        <div class="col-sm-12  col-md-12 col-lg-12 ">
            <div class="form-group">
              <?php /*var_dump( $_POST );*/ ?>
              <label for="archivo">Imagen de perfil</label>
              <img src='<?php print( ( isset($imagen_actual) ) ? '../img/clientes/'.$imagen_actual : '../img/logo.png' ) ?>' class="img-responsive" id="pro_img"/>
              <BR>
                <input name="pro_img_url" type="file" id="pro_img_url"/>
            </div>
        </div>
      </div> 

      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
        <br>
          <div class="form-group">
            <input autocomplete="off" onpaste=";return false" type="text" name="nombres_cliente" id="nombres_cliente"  placeholder="Nombres" tabindex="1"
            class="form-control input-lg <?php print( ( isset($er_nombre) ) ? "$er_nombre": "");  ?>" value='<?php print(!empty($nombres_cliente)?$nombres_cliente:""); ?>'>
            <?php print(!empty($nombres_clienteError)?"<span class='help-block'>$nombres_clienteError</span>":""); ?>      
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
          <br>
          <div class="form-group">
            <input autocomplete="off" onpaste=";return false" type="text" name="apellidos_cliente" id="apellidos_cliente" placeholder="Apellidos" tabindex="2"
            class="form-control input-lg <?php print( ( isset($er_apellido) ) ? "$er_apellido": "");  ?>" value='<?php print(!empty($apellidos_cliente)?$apellidos_cliente:""); ?>'>
            <?php print(!empty($apellidos_clienteError)?"<span class='help-block'>$apellidos_clienteError</span>":""); ?> 
          </div>
        </div>
      </div>
      <div class="row">
        <?php if ( ! isset( $_SESSION['id_cliente'] ) ){ ?>
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="form-group">
            <input autocomplete="off" onpaste=";return false" type="text" name="usuario" id="usuario" placeholder="Nombre de usuario" tabindex="3"
            class="form-control input-lg <?php print( ( isset($er_usuario) ) ? "$er_usuario": "");  ?>" value='<?php print(!empty($usuario)?$usuario:""); ?>'>
            <?php print(!empty($usuario_clienteError)?"<span class='help-block'>$usuario_clienteError</span>":""); ?> 
          </div>
        </div>
      
        <?php } ?>
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="form-group">
            <input autocomplete="off" onpaste=";return false" type="text" name="correo" id="correo" placeholder="Email" tabindex="4"
            class="form-control input-lg <?php print( ( isset($er_correo) ) ? "$er_correo": "");  ?>" value='<?php print(!empty($correo)?$correo:""); ?>'>
            <?php print(!empty($correo_clienteError)?"<span class='help-block'>$correo_clienteError</span>":""); ?> 
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="form-group">
            <input autocomplete="off" onpaste=";return false" type="password" name="clave1" id="clave1"  placeholder="Contraseña" tabindex="5"
            class="form-control input-lg <?php print( ( isset($er_clave1) ) ? "$er_clave1": "");  ?>" value='<?php print(!empty($clave1)?$clave1:""); ?>'>
            <?php print(!empty($clave1_clienteError)?"<span class='help-block'>$clave1_clienteError</span>":""); ?> 
          </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="form-group">
            <input autocomplete="off" onpaste=";return false" type="password" name="clave2" id="clave2"  placeholder="Confirma tu contraseña" tabindex="6"
          class="form-control input-lg <?php print( ( isset($er_clave2) ) ? "$er_clave2": "");  ?>" value='<?php print(!empty($clave2)?$clave2:""); ?>'>
          <?php print(!empty($clave2_clienteError)?"<span class='help-block'>$clave2_clienteError</span>":""); ?> 
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
          <?php if ( ! isset( $_SESSION['id_cliente'] ) ){ ?>
            <div class="form-group">
                <select tabindex="7" id="id_pregunta" name="id_pregunta"  class="form-control select2 <?php print( ( isset($er_pregunta) ) ? "$er_pregunta": ""); ?>">
                  <option value="" disabled selected>Seleccione pregunta</option>
                  <?php
                    $sql="SELECT id_pregunta, pregunta FROM preguntas";
                    $preguntas = Database::getRows( $sql, array( null ));
                    foreach ($preguntas as $row) 
                    {
                      if (isset($id_pregunta) && $id_pregunta == $row["id_pregunta"])
                        {
                          echo "<option value ='$row[id_pregunta]' selected>$row[pregunta]</option>";
                        }
                        echo "<option value ='$row[id_pregunta]'>$row[pregunta]</option>";
                    }         
                  ?>
                </select>
            </div>
          <?php } ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
          <?php if ( ! isset( $_SESSION['id_cliente'] ) ){ ?>
            <div class="form-group">
              <input autocomplete="off" onpaste=";return false"  type="password" name="respuesta" id="respuesta" placeholder="Respuesta" tabindex="8" 
              class="form-control input-lg <?php print( ( isset($er_respuesta) ) ? "$er_respuesta": "");  ?>" value='<?php print(!empty($respuesta)?$respuesta:""); ?>'>
              <?php print(!empty($respuesta_clienteError)?"<span class='help-block'>$respuesta_clienteError</span>":""); ?> 
            </div>
          <?php } ?>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4">
          <?php if ( ! isset( $_SESSION['id_cliente'] ) ){ ?>
            <div class="form-group">
              <div class="g-recaptcha" data-sitekey="6LeJOyYTAAAAAP3geppx7jUV7NdOId_3ljAb7ZnC"></div>
            </div>
          <?php } ?>
        </div>
      </div>

      <!-- Modal direcciones -->
      <div class="modal fade" id="modal_direcciones" tabindex="15" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title black" id="myModalLabel">Direcciones</h4>
            </div>
            <div class="modal-body">
              <!--form role="form" method="post"-->
                <div id="div_direcciones">
                <?php
                  @$direc_base = Database::getRows( "select id_direccion, direccion from direcciones where id_cliente = ?;", array( $_SESSION['id_cliente'] ) );
                  $direcciones = "";
                  /*Cargando direcciones en la base*/
                  if ( $direc_base != null ){
                    foreach ( $direc_base as $direccion ) {
                      $direcciones .= '<div class="form-group">
                                        <div class="row">
                                          <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                            <input class="form-control" autocomplete="off" onpaste=";return false" value="' . $direccion['direccion'] . '" placeholder="Ingrese una dirección" />
                                          </div>
                                          <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                            <a id_direccion="'.$direccion['id_direccion'].'" class="glyphicon glyphicon-edit icono_tamano" onclick="$(this).e_direccion();"></a>
                                          </div>
                                          <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                            <a onclick="Mensaje( \'direcciones\', '.$direccion['id_direccion'].', null );" class="glyphicon glyphicon-remove-circle icono_tamano"></a>
                                          </div>
                                        </div>
                                      </div>';
                    }
                  }
                  /*Cargando direcciones en la base*/
                  
                  /*Cuando hay direcciones cargadas pero existio una especie de error :)*/
                  if ( isset( $_POST['direcciones'] ) ){
                    foreach ( $_POST['direcciones'] as $direccion ){
                      $direcciones .= '<div class="form-group"><div class="row"> <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10"><input class="form-control ' . ( ( ! Validator::numeros_letras( $direccion ) && $direccion != "" ) ? 'error_data' : "" ) . '" autocomplete="off" onpaste=";return false" name="direcciones[]" placeholder="Ingrese una dirección" value="'. $direccion .'" /></div><div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><a onclick="$(this).parents(\'.form-group\').fadeOut(); $(this).parents(\'.form-group\').remove();" class="glyphicon glyphicon-remove-circle icono_tamano"></a></div></div></div>';
                      if ( ! Validator::numeros_letras( $direccion ) && $direccion != "" )  $direccion_invalida = true;
                    }
                  }
                  /*Cuando hay direcciones cargadas pero existio una especie de error :)*/
                  
                  /*Solamente cargar un campo para agregar una direccion :)*/
                  else $direcciones .= '<div class="form-group"><div class="row"> <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10"><input class="form-control" autocomplete="off" onpaste=";return false" name="direcciones[]" placeholder="Ingrese una dirección" /></div><div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><a onclick="$(this).parents(\'.form-group\').fadeOut(); $(this).parents(\'.form-group\').remove();" class="glyphicon glyphicon-remove-circle icono_tamano"></a></div></div></div>';
                  print( ( ( isset( $direccion_invalida ) ) ? '<div class="alert alert-danger" role="alert">Solo se permiten numeros y letras.</div>' : '' ) . $direcciones );
                ?>
                </div>
              <!--/form-->
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <button type="button" id="mas_direcciones" class="btn btn-primary size">Más</button>
                </div>
              </div>
            </div>
        
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>

          </div>
        </div>
      </div>
      <!-- Modal direcciones -->
      
      <!-- direcciones -->
      <div class="divider-diego"></div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <a href="" class="<?php  print( ( isset( $direccion_invalida ) ) ? 'error_data' : "" ); ?>" data-toggle="modal" data-target="#modal_direcciones" style="color:black">Direcciones</a>
        </div>
      </div>
      <!-- direcciones -->

      <?php if ( ! isset( $_SESSION['id_cliente'] ) ){ ?>
        <div class="row">
          <div class="col-xs-4 col-sm-3 col-md-3">
            <span class="button-checkbox">
              <button type="button" class="btn" data-color="info" tabindex="9"> De Acuerdo</button>
                  <input type="checkbox" name="t_and_c" id="t_and_c" class="hidden" value="1">
            </span>
          </div>
          <div class="col-xs-8 col-sm-9 col-md-9">
             Lee los <a href="#" data-toggle="modal" data-target="#t_and_c_m">Terminos and Condiciones</a>  de la página. Tienes que estar de acuerdo para registrarte.
          </div>
        </div>
      <?php } ?>
      
      <hr class="colorgraph">
      <div class="row">
        <div class="col-xs-12 col-md-12"><input type="submit" name="action-clientes" value="<?php print( ( ( isset( $_SESSION['id_cliente'] ) ) ? 'Modificar' : 'Registrate' ) ); ?>" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
        <!--div class="col-xs-12 col-md-6"><a href="#" class="btn btn-success btn-block btn-lg">Iniciar Sesión</a></div-->
      </div>
    </form>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
      </div>
  
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</button>
      </div>

    </div>
  </div>
</div>
</div>
<br>
<br>

<!--script src="js/jquery-2.2.3.min.js"></script>

<script src="js/bootstrap.min.js"></script-->



<script>
        /*$(document).ready(function(e) {
        // Capturamos el evento submit del formulario
        $("#frmcaptcha").submit(function(e) {
            $respuesta=false; // Suponemos por defecto que la validación será erronea
            // Realizamos llamada en AJAX
            $.ajax({
            url:"vrfcaptcha.php",  // script al que le enviamos los datos
            type:"POST",           // método de envío POST
            dataType:"json",       // la respuesta será en formato JSON
            data:$("#frmcaptcha").serialize(), // Datos que se envían (campos del formulario)
            async:false,     // Llamada síncrona para que el código no continúe hasta obtener la respuesta
            success:         // Si se ha podido realizar la comunicación
                function(msg){
                   $respuesta=msg.success; // Obtenemos el valor de estado de la validación
                   if($respuesta) {     // La validación ha sido correcta
                    // Eliminamos del formulario el campo que contiene los parámetros de validación
                    $("#g-recaptcha-response","#frmcaptcha").remove();
                   } else {
                    alert('Fallo de validación'); 
                    // Mostramos mensaje
                   } 
            },
            error:  // En caso de error de comunicación mostraremos mensaje de aviso con el error
                function (xhr, ajaxOptions, thrownError){
                    alert('Url: '+this.url+'\n\r’+’Error: '+thrownError);
                }  
            }); // Final de la llamada en AJAX
            // Si la respuesta es true continuará el evento submit, de lo contrario será cancelado
            return $respuesta;
            });
        });
  </script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php Page::footer(); ?>
