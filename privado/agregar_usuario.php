<?php
  $error = ""; //xd
  if(!empty($_POST)){
    require("../sql/conexion.php");
    $id_categoria = $_POST['id_categoria'];
    $nombre_producto = $_POST['nombre_producto'];
    $precio_producto = $_POST['precio_producto'];
    $existencias = $_POST['existencias'];
    $descripcion = $_POST['descrip'];
    $imagen = $_FILES['pro_img_url'];//Imagen
    $estado = $_POST['estado'];//Estado 1 es habilitado y 0 es inha
    $id_presentacion = $_POST['id_presentacion'];
    $consulta = "select * from productos where nombre_producto = '$nombre_producto' and id_categoria = $id_categoria;";
    //$stmt = $PDO->prepare($consulta);
    $existe = "";
    foreach($PDO->query($consulta) as $resultado){
    $existe = array(
      0 => $resultado['nombre_producto']
      );
    }
    if ( json_encode($existe) == '""' ){
      echo json_encode($existe);
      if( $imagen['name'] != null ){
        //Imagen ='}}'
        if($imagen['type'] == "image/jpeg" || $imagen['type'] == "image/png" || $imagen['type'] == "image/x-icon" || $imagen['type'] == "image/gif"){
          $info_imagen = getimagesize($imagen['tmp_name']);
          $ancho_imagen = $info_imagen[0]; 
          $alto_imagen = $info_imagen[1];
          if ( $ancho_imagen >= 350 && $alto_imagen >= 350){
            $nuevo_id = uniqid(); //Esto sirve para darle un nombre único a cada archivo de imagen.
            $nombre_archivo = $imagen['tmp_name'];
            $imagen_producto = $nuevo_id.".png";
            $destino = "../img/productos/$imagen_producto";
            move_uploaded_file($nombre_archivo, $destino); //Función para subir archivos al servidor.*/
                //Ahora hago el ingreso de los datos a la base :P ='DD
            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $consulta = "insert into productos (nombre_producto, precio_producto, id_categoria, existencias, descripcion, estado) values (?, ?, ?, ?, ?, ?);";
            $stmt = $PDO->prepare($consulta);
            $stmt->execute(array ($nombre_producto, $precio_producto, $id_categoria, $existencias, $descripcion, $estado ) );
            $id_producto = $PDO->lastInsertId();
            //Insertamos la imagen ='}}
            $consulta = "insert into img_productos (id_producto, id_presentacion, imagen_producto, tipo_imagen) values (?, ?, ?, ?);";
            $stmt = $PDO->prepare($consulta);
            $stmt->execute(array($id_producto, $id_presentacion, $imagen_producto, 1) );//"1"Ya que siempre se añadira la principal aqui ='}
            $PDO = null;
            header("location: productos.php");
          }
          else $error = "La dimensión de la imagen no es valida.";
        }
        else $error = "El tipo de imagen no es valido.";        
      }
      else $error = "Debe seleccionar una imagen principal.";       
    }
    else $error = "Este producto ya ha sido ingresado.";
  }
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Agregar Clientes</title>

	<link rel="stylesheet" type="text/css" href="../publico/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="../publico/css/sweet-alert.css">
	<link rel="stylesheet" type="text/css" href="../publico/css/mainD.css" />
  	<link rel="stylesheet" type="text/css" href="../publico/css/font-awesome.min.css"><!-- Font Awesome -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"><!-- Ionicons -->
	<link rel="stylesheet" type="text/css" href="plugins/datatables/dataTables.bootstrap.css"><!-- Theme style -->
	<link rel="stylesheet" type="text/css" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/skin-red.min.css">
</head>
<body class="hold-transition skin-red sidebar-mini">


<div class="wrapper">
	<div class="content-wrapper"><!-- Contenedor -->
		<section class="content-header">
	      <h1>Registrate</h1>
	    </section>
		<section class="content">
	      	<div class="row">
	    		<div class="col-xs-12">
	        		<div class="box">
	            		<form id="frmagrepro" method="post" enctype="multipart/form-data" name="frmagrepro">
	            			<div class="box-body">	            			
							    <div class="col-sm-6 col-md-6 col-lg-6">
							     	<div class="form-group">
							        	<label for="">Nombres</label>
							        	<input onpaste=";return false" name="nombre_producto" length="100" maxlenght="100" class="form-control vletras_esp" type="text" value="<?php print((isset($nombre_producto) != "")?"$nombre_producto":""); ?>" required />
							      	</div>
							      	<div class="form-group">
							        	<label for="">Apellidos</label>
							        	<input onpaste=";return false" name="precio_producto" class="form-control" value="<?php print((isset($precio_producto) != "")?"$precio_producto":""); ?>" required  />
							      	</div>
							      	<div class="form-group">
							        	<label for="">Usuario</label>
							        	<input onpaste=";return false" name="precio_producto" class="form-control" value="<?php print((isset($precio_producto) != "")?"$precio_producto":""); ?>" required  />
							      	</div>
							      	<div class="form-group">
							        	<label for="">Contraseña</label>
							        	<input onpaste=";return false" name="precio_producto" class="form-control" value="<?php print((isset($precio_producto) != "")?"$precio_producto":""); ?>" required  />
							      	</div>
							      	<div class="form-group">
							        	<label for="">Confirmar contraseña</label>
							        	<input onpaste=";return false" name="precio_producto" class="form-control" value="<?php print((isset($precio_producto) != "")?"$precio_producto":""); ?>" required  />
							      	</div>
							      	<div class="form-group">
								        <label for="existencias">Correo</label>
								        <input id="existencias" value="<?php print((isset($existencias) != "")?"$existencias":""); ?>" onpaste=";return false" max="10000" min="1" name="existencias" class="form-control vnumeros" type="text"  required />
							      	</div>
							    </div>
							    <div class="col-sm-6 col-md-6 col-lg-6">
							        <div class="form-group col-lg-12 col-lg-offset-2">
							        	<label for=""></label>
								        <img src="../img/productos/logo.png" class="img-responsive" id="pro_img"/>
								        <BR>
						          		<input name="pro_img_url" id="pro_img_url" type="file" required/>
						          	</div>
						          	<div class="form-group">
									    <label for="id_presentacion">Pregunta</label>
									    <select id="id_presentacion" name="id_presentacion" class="form-control">
							            	<option value="" disabled selected>Respuesta</option>
							            	<?php
								                require("../sql/conexion.php");
								                $consulta = "SELECT * FROM presentaciones order by presentacion";
								                $opciones = ""; //Arreglo de datos
								                foreach($PDO->query($consulta) as $datos)
								                {
								                  $opciones .= "<option value='$datos[id_presentacion]'";
								                  if(isset($id_presentacion) == $datos['id_presentacion']){
								                      $opciones .= " selected";
								                  }
								                  $opciones .= ">$datos[presentacion]</option>";
								                }
								                print($opciones);
								                $PDO = null;
							            	?>
							          	</select>
							        </div>
							        	<div class="form-group">
								        <label for="existencias">Respuesta</label>
								        <input id="existencias" value="<?php print((isset($existencias) != "")?"$existencias":""); ?>" onpaste=";return false" max="10000" min="1" name="existencias" class="form-control vnumeros" type="text"  required />
							      	</div>
							    </div>
							</div>
							<div class="box-body text-center">
							    <button type="submit" name="action" class="btn btn-primary margin_right fbtn">
							        <span class="">Registrate</span>
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

<script src="plugins/datatables/jquery.dataTables.js"></script>

<script src="plugins/datatables/dataTables.bootstrap.js"></script>

<script src="../publico/js/mainD.js"></script>

</body>
</html>