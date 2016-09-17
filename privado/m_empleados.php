<?php
  require("../sql/conexion.php");
  require("../lib/validator.php");
  require("../lib/database.php");
  //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
  require("../lib/page-privado.php");
  
  ob_start();
  $permisos = Page::header("Modificar empleado", "empleados" );
  $id = null;
  if ( ! empty($_GET['id_empleado']) ) {
      $id = base64_decode($_GET['id_empleado']);
  }
  if( $id == null || ( ! Validator::numero( $id ) && $id != 'editar' ) ) {
      header("location: empleados");
      exit();
  }

  function actualizar_datos ( $nombre_empleado, $apellido_empleado, $imagen_empleado, $id_tipo_usuario ){
    $_SESSION['nombre_empleado'] = $nombre_empleado." ".$apellido_empleado;
    if ( $imagen_empleado != null ) $_SESSION['img_empleado'] = $imagen_empleado;
    $_SESSION['id_tipo_usuario'] = $id_tipo_usuario;
  }
  
  if(!empty($_POST))
  {
    
    $tipo_usuario = $_POST['tipo_usuario'];
    $nombre_empleado = $_POST['nombre_empleado'];
    $apellido_empleado = $_POST['apellido_empleado'];
    $documento_empleado = $_POST['documento_empleado'];
    $correo_empleado = $_POST['correo_empleado'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $imagen_nueva = $_FILES['pro_img_url'];//Imagen
    $imagen_antigua = $_POST['imagen_actual'];

    if ( isset($_POST['clave1']) ) @( ! ( Validator::numeros_letras( $_POST['clave1'] ) ) ) ? $er_clave1 = "error_data" : "";

    if ( isset($_POST['clave2']) ) @( ! ( Validator::numeros_letras( $_POST['clave2'] ) ) ) ? $er_clave2 = "error_data" : "";
   
    //
    require("../sql/conexion.php");
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($imagen_nueva['name'] != null)
    {
      if($imagen_nueva['type'] == "image/jpeg" || $imagen_nueva['type'] == "image/png" || $imagen_nueva['type'] == "image/x-icon" || $imagen_nueva['type'] == "image/gif"){
        $info_imagen = getimagesize($imagen_nueva['tmp_name']);
        $ancho_imagen = $info_imagen[0]; 
        $alto_imagen = $info_imagen[1];
        if ( $ancho_imagen >= 150 && $alto_imagen >= 150)
        {
          $nuevo_id = uniqid(); //Esto sirve para darle un nombre único a cada archivo de imagen.
          $nombre_archivo = $imagen_nueva['tmp_name'];
          $imagen_empleado = $nuevo_id.".png";
          $destino = "../img/empleados/$imagen_empleado";
          unlink("../img/empleados/$imagen_antigua");//Función para eliminar la imagen anterior.
          move_uploaded_file($nombre_archivo, $destino); //Función para subir archivos al servidor.
          //Validamos :P
       
          if (Validator::numero( $tipo_usuario ) && Validator::letras( $nombre_empleado )
          && Validator::letras( $apellido_empleado ) && Validator::dui( $documento_empleado )
          && Validator::correo($correo_empleado ) )
          {
            if ( ( strtotime( date("Y-m-d") ) - strtotime($fecha_nacimiento) ) >= 568080000 ){
              if ( $_POST['clave1'] != null || $_POST['clave2'] != null ){

                if ( Validator::numeros_letras( $_POST['clave1'] ) && Validator::numeros_letras( $_POST['clave2'] ) ){
                  $clave1 = $_POST['clave1'];
                  $clave2  = $_POST['clave2'];
                  if($clave1==$clave2 )
                  {
                    if (strlen($clave1) >= 8 ) {
                      if ($clave2!=$usuario_empleado) {
                         $clave = password_hash($clave1, PASSWORD_DEFAULT);
                         $respuesta = password_hash($respuesta, PASSWORD_DEFAULT);
                        if ( ! Validator::permiso_modificar( $permisos ) || ! $id == 'editar' ) $error = "No tiene permisos para realizar esta accion.";
                        else {//Todo
                          $consulta = "UPDATE empleados SET id_tipo_usuario = ?, nombres_empleado = ?, apellidos_empleado = ?, n_documento = ?, correo = ?, clave=?, img_empleado=?, fecha_nacimiento=? where id_empleado = ?";
                          $stmt = $PDO->prepare($consulta);
                          $stmt->execute(array($tipo_usuario, $nombre_empleado, $apellido_empleado, $documento_empleado, $correo_empleado, $clave,$imagen_empleado, $fecha_nacimiento, ( ($id == 'editar') ? $_SESSION['id_empleado'] : $id ) ) );
                        
                          header("location: empleados ");
                          $PDO = null;
                          if ($id == 'editar') actualizar_datos( $nombre_empleado, $apellido_empleado, $imagen_empleado, $tipo_usuario );
                        }
                      }
                    }
                  }  
                }
              }
              else{
                if ( ! Validator::permiso_modificar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
                else{//Info con imagen sin clave
                  $consulta = "UPDATE empleados SET id_tipo_usuario = ?, nombres_empleado = ?, apellidos_empleado = ?, n_documento = ?, correo = ?, img_empleado=?, fecha_nacimiento=?  where id_empleado = ?";
                  $stmt = $PDO->prepare($consulta);
                  $stmt->execute(array($tipo_usuario, $nombre_empleado, $apellido_empleado, $documento_empleado, $correo_empleado,$imagen_empleado, $fecha_nacimiento, ( ($id == 'editar') ? $_SESSION['id_empleado'] : $id ) ) );
                  header("location: empleados ");
                  $PDO = null;
                  if ($id == 'editar') actualizar_datos( $nombre_empleado, $apellido_empleado, $imagen_empleado, $tipo_usuario );
                }
              }
            }
            else{
              ( isset($error) ) ? $error .= "Debe tener mas de 18 años" : $error = "Debe tener mas de 18 años";
            }
          }
          else $error_data = "Error, por favor revise los campos señalados.";
                
            ( ! ( Validator::letras( $nombre_empleado ) ) ) ? $er_nombre = "error_data" : "";
        
            ( ! ( Validator::letras( $apellido_empleado ) ) ) ? $er_apellido = "error_data" : "";

            ( ! ( Validator::dui( $documento_empleado ) ) ) ? $er_dui = "error_data" : "";
          
            ( ! ( Validator::correo( $correo_empleado ) ) ) ? $er_correo = "error_data" : "";
            
            ( ! ( Validator::numero( $tipo_usuario ) ) ) ? $ertipo_usuario = "error_data" : "";
        }
        else $error = "La dimensión de la imagen no es valida.";
      }
      else $error = "El tipo de imagen no es valido.";        
    }
    else{

      if (Validator::numero( $tipo_usuario ) && Validator::letras( $nombre_empleado )
          && Validator::letras( $apellido_empleado ) && Validator::dui( $documento_empleado )
          && Validator::correo($correo_empleado ) )
          {
            if ( $_POST['clave1'] != null || $_POST['clave2'] != null ){

              if ( Validator::numeros_letras( $_POST['clave1'] ) && Validator::numeros_letras( $_POST['clave2'] ) ){
                $clave1 = $_POST['clave1'];
                $clave2  = $_POST['clave2'];
                if($clave1==$clave2 )
                {
                  if (strlen($clave1) >= 8 ) {
                    if ($clave2!=$usuario_empleado) {
                       $clave = password_hash($clave1, PASSWORD_DEFAULT);
                       $respuesta = password_hash($respuesta, PASSWORD_DEFAULT);
                      if ( ! Validator::permiso_modificar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
                      else {//Info con clave sin imagen
                        $consulta = "UPDATE empleados SET id_tipo_usuario = ?, nombres_empleado = ?, apellidos_empleado = ?, n_documento = ?, correo = ?, clave=?, fecha_nacimiento=? where id_empleado = ?";
                        $stmt = $PDO->prepare($consulta);
                        $stmt->execute(array($tipo_usuario, $nombre_empleado, $apellido_empleado, $documento_empleado, $correo_empleado,$clave, $fecha_nacimiento, ( ($id == 'editar') ? $_SESSION['id_empleado'] : $id ) ) );
                        header("location: empleados ");
                        $PDO = null;
                        if ($id == 'editar') actualizar_datos( $nombre_empleado, $apellido_empleado, null, $tipo_usuario );
                      }
                    }
                  }
                }  
              }
            }   
            else{//Solo info sin imagen ni contra
              if ( ! Validator::permiso_modificar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
              else{
                $consulta = "UPDATE empleados SET id_tipo_usuario = ?, nombres_empleado = ?, apellidos_empleado = ?, n_documento = ?, correo = ?, fecha_nacimiento=? where id_empleado = ?";
                $stmt = $PDO->prepare($consulta);
                $stmt->execute(array($tipo_usuario, $nombre_empleado, $apellido_empleado, $documento_empleado, $correo_empleado,$fecha_nacimiento, ( ($id == 'editar') ? $_SESSION['id_empleado'] : $id ) ) );
                header("location: empleados ");
                $PDO = null;
                if ($id == 'editar') actualizar_datos( $nombre_empleado, $apellido_empleado, null, $tipo_usuario );
              }
            }        
          }
          else $error_data = "Error, por favor revise los campos señalados.";
                
            ( ! ( Validator::letras( $nombre_empleado ) ) ) ? $er_nombre = "error_data" : "";
        
            ( ! ( Validator::letras( $apellido_empleado ) ) ) ? $er_apellido = "error_data" : "";

            ( ! ( Validator::dui( $documento_empleado ) ) ) ? $er_dui = "error_data" : "";
          
            ( ! ( Validator::correo( $correo_empleado ) ) ) ? $er_correo = "error_data" : "";
            
            ( ! ( Validator::numero( $tipo_usuario ) ) ) ? $ertipo_usuario = "error_data" : "";
    }
  }
  else{
    require("../sql/conexion.php");
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT id_tipo_usuario, nombres_empleado, apellidos_empleado, n_documento, correo, img_empleado FROM empleados WHERE id_empleado = ?;";
    $stmt = $PDO->prepare($sql);
    if ( $id != 'editar' ) $stmt->execute( array ( $id ) );
    else $stmt->execute( array ( $_SESSION['id_empleado'] ) );
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    //
    $tipo_usuario = $data['id_tipo_usuario'];
    $nombre_empleado = $data['nombres_empleado'];
    $apellido_empleado = $data['apellidos_empleado'];
    $documento_empleado = $data['n_documento'];
    $correo_empleado = $data['correo'];
    $imagen_empleado = $data['img_empleado'];
    $PDO = null;
  }

  print ((isset($error_data)) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
  print ((isset($error)) ? '<div class="alert alert-danger" role="alert">'.$error.'</div>' : "" );
?>                    
                  <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input onpaste=";return false" name="nombre_empleado" class="form-control vletras_esp <?php print( ( isset($er_nombre) ) ? "$er_nombre": ""); ?>" type="text" required value="<?php print($nombre_empleado); ?>" />
                      </div>
                      <div class="form-group">
                        <label for="">apellido</label>
                        <input onpaste=";return false" name="apellido_empleado" class="form-control vnumeros <?php print( ( isset($er_apellido) ) ? "$er_apellido": ""); ?>" type="text" required value="<?php print($apellido_empleado); ?>" />
                      </div>
                    <div class="form-group">
                        <label for="">Tipo usuario</label>
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
                        <label for="documento_empleado">Dui</label>
                        <input onpaste=";return false" name="documento_empleado" class="form-control vnumeros <?php print( ( isset($er_dui) ) ? "$er_dui": ""); ?>" type="text"  required value="<?php print($documento_empleado); ?>" />
                      </div>
                      <div class="form-group">
                        <label for="descrip">Correo</label>
                        <textarea id="correo_empleado" name="correo_empleado" class="form-control texarea <?php print( ( isset($er_correo) ) ? "$er_correo": ""); ?>" type="text" required="required"><?php print($correo_empleado); ?></textarea>
                      </div>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label for="">Imagen principal</label>
                        <img src="../img/empleados/<?php print($imagen_empleado); ?>" class="img-responsive" id="pro_img"/>
                          <input type="hidden" name="imagen_actual" value="<?php print($imagen_empleado); ?>"/>
                          <input name="pro_img_url" id="pro_img_url" type="file"/>
                      </div> 
                 

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
                              <input autocomplete="off" onpaste=";return false" type="text" name="fecha_nacimiento" id="datetimepicker"  placeholder="Año-Mes-Día" tabindex="7"
                            class="form-control input-lg <?php print( ( isset($er_fecha) ) ? "$er_fecha": "");  ?>" value='<?php print(!empty($fecha_nacimiento)?$fecha_nacimiento:""); ?>'>
                            <?php print(!empty($fecha_empleadoError)?"<span class='help-block'>$fecha_empleadoError</span>":""); ?> 
                        </div>
                      </div>
                  </div>
              </div>
              <div class="box-body text-center">
                  <button type="submit" name="action" class="btn btn-primary btncolor margin_right fbtn">
                      <span class="glyphicon glyphicon-edit"></span>
                  </button>
                  <button type="button" class="btn btn-danger fbtn">
                      <span class="">Cancelar</span>
                  </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section><!--Conent ='DD-->
  </div><!--ConentWrapper ='DD-->
</div><!--Wrapper ='DD-->

<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>

<script src="../publico/js/bootstrap.min.js"></script>

<script src="dist/js/app.min.js"></script>

<script src="../publico/js/mainB.js"></script>

</body>
</html>