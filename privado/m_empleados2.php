<?php
  $id = null;
    if(!empty($_GET['id_empleado'])) {
        $id = $_GET['id_empleado'];
    }
    if($id == null) {
        header("location: empleados.php");
    }
  if(!empty($_POST)){
    $error = ""; //xd
    $tipo_usuario = $_POST['tipo_usuario'];
    $nombre_empleado = $_POST['nombre_empleado'];
    $apellido_empleado = $_POST['apellido_empleado'];
    $documento_empleado = $_POST['documento_empleado'];
    $correo_empleado = $_POST['correo_empleado'];

    
    $imagen_nueva = $_FILES['pro_img_url'];//Imagen
    $imagen_antigua = $_POST['imagen_antigua'];
    $id_img = $_POST['id_img'];
   
    //
    require("../sql/conexion.php");
    if($imagen_nueva['name'] != null){
        if($imagen_nueva['type'] == "image/jpeg" || $imagen_nueva['type'] == "image/png" || $imagen_nueva['type'] == "image/x-icon" || $imagen_nueva['type'] == "image/gif"){
            $info_imagen = getimagesize($imagen_nueva['tmp_name']);
            $ancho_imagen = $info_imagen[0]; 
        $alto_imagen = $info_imagen[1];
        if ( $ancho_imagen >= 150 && $alto_imagen >= 150){
          unlink("../img/empleados/$imagen_antigua"); //Función para eliminar la imagen anterior.
          //
          $nuevo_id = uniqid(); //Esto sirve para darle un nombre único a cada archivo de imagen.
              $nombre_archivo = $imagen_nueva['tmp_name'];
              $imagen_empleados = $nuevo_id.".png";
              $destino = "../img/empleados/$imagen_empleados";
              move_uploaded_file($nombre_archivo, $destino); //Función para subir archivos al servidor.
              //Validamos :P
              require("../lib/validator.php");
              if (Validator::numero( $tipo_usuario ) && Validator::letras( $nombre_empleado )
              && Validator::letras( $apellido_empleado ) && Validator::dui( $documento_empleado )
              && Validator::correo($correo_empleado ) ){
                //Modificamos el producto
                $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $consulta = "update empleados set tipo_usuario=?, nombre_empleado = ?, apellido_empleado = ? , documento_empleado = ?, correo_empleado = ?  img_empleado=? where id_producto = ?;";
                $stmt = $PDO->prepare($consulta);
                $stmt->execute(array($tipo_usuario, $nombre_empleado, $apellido_empleado, $documento_empleado, $correo_empleado, $imagen_empleados, $id));
                
                header("location: empleados.php");
                $PDO = null;
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
      
  }
  else{
        require("../sql/conexion.php");
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT id_tipo_usuario, nombres_empleado, apellidos_empleado, n_documento, correo FROM empleados WHERE id_empleado =$id";
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    //
    $tipo_usuario = $data['id_tipo_usuario'];
    $nombre_empleado = $data['nombres_empleado'];
    $apellido_empleado = $data['apellidos_empleado'];
    $documento_empleado = $data['n_documento'];
    $correo_empleado = $data['correo'];


      //Selecciono la imagen principal
      //$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT img_empleado FROM empleados where id_empleado = $id";
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    //
   
      $imagen_producto = $data['img_empleado'];
      $PDO = null;
  }
?><!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Editar producto</title>

  <link rel="stylesheet" type="text/css" href="../publico/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="../publico/css/sweet-alert.css">
  <link rel="stylesheet" type="text/css" href="../publico/css/mainD.css" />
    <link rel="stylesheet" type="text/css" href="../publico/css/font-awesome.min.css"><!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="../publico/css/ionicons.min.css"><!-- Ionicons -->
  <link rel="stylesheet" type="text/css" href="plugins/datatables/dataTables.bootstrap.css"><!-- Theme style -->
  <link rel="stylesheet" type="text/css" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/skin-red.min.css">
</head>
<body class="hold-transition skin-red sidebar-mini">

<?php include 'inc/menu.php'; ?>
<div class="wrapper">
  <?php include 'inc/aside.php'; ?><!--Barra de menu sidebar-->
  <div class="content-wrapper"><!-- Contenedor -->
    <section class="content-header">
        <h1>Editar producto</h1>
      </section>
    <section class="content">
          <div class="row">
          <div class="col-xs-12">
              <div class="box">
                  <form id="form_agrepro" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                      <?php
                        print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
                        print ( ( isset($error) ) ? '<div class="alert alert-danger" role="alert">'.$error.'</div>' : "" );
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
                        <label for="existencias">Dui</label>
                        <input onpaste=";return false" name="existencias" class="form-control vnumeros <?php print( ( isset($er_dui) ) ? "$er_dui": ""); ?>" type="text"  required value="<?php print($documento_empleado); ?>" />
                      </div>
                      <div class="form-group">
                        <label for="descrip">Correo</label>
                        <textarea id="correo_empleado" name="correo_empleado" class="form-control texarea <?php print( ( isset($er_correo) ) ? "$er_correo": ""); ?>" type="text" required="required"><?php print($correo_empleado); ?></textarea>
                      </div>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label for="">Imagen principal</label>
                        <img src="../img/empleados/<?php print($imagen_producto); ?>" class="img-responsive" id="pro_img"/>
                        <BR>
                          <input type="hidden" name="imagen_antigua" value="<?php print($imagen_producto);?>"/>
                    <input type="hidden" name="id_img" value="<?php print($id_img);?>"/>
                    <input name="pro_img_url" id="pro_img_url" type="file"/>
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