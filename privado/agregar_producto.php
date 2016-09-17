<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
	ob_start();
	//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	require("../lib/validator.php");
	//!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
	require("../lib/page-privado.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Agregar producto", "productos");
  if(!empty($_POST)){
    //Por el antiguo metodo de conectar con la base :)
	require("../sql/conexion.php");
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try{
	    $id_categoria = $_POST['id_categoria'];
	    $nombre_producto = $_POST['nombre_producto'];
	    $precio_producto = $_POST['precio_producto'];
	    $descripcion = $_POST['descrip'];
	    $imagen = $_FILES['pro_img_url'];//Imagen
	    $estado = $_POST['estado'];//Estado 1 es habilitado y 0 es inha
	    $id_presentacion = $_POST['id_presentacion'];
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
			    if ( Validator::numero( $id_categoria ) && Validator::letras( $nombre_producto )
		      	 && Validator::decimal( $precio_producto )
		      	 && Validator::numeros_letras( $descripcion ) && Validator::numeros_letras( $id_presentacion )
		      	 && ( $estado == 1 || $estado == 0 ) && Validator::numero( $id_presentacion ) ){
		      	 	if ( ! Validator::permiso_agregar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
					else {
			      	 	//Ahora hago el ingreso de los datos a la base :P ='DD
			            $consulta_pro = "insert into productos (nombre_producto, precio_producto, id_categoria, descripcion, estado, vistas) values ( ?, ?, ?, ?, ?, 0 );";
			            $stmt = $PDO->prepare($consulta_pro);
			            $stmt->execute(array ($nombre_producto, $precio_producto, $id_categoria, $descripcion, $estado ) );
			            $id_producto = $PDO->lastInsertId();
			            //Insertamos la imagen ='}}
			            $consulta_img = "insert into img_productos (id_producto, id_presentacion, imagen_producto) values (?, ?, ?);";
			            $stmt = $PDO->prepare($consulta_img);
			            $exito = $stmt->execute(array($id_producto, $id_presentacion, $imagen_producto) );//"1"Ya que siempre se añadira la principal aqui ='}
			            move_uploaded_file($nombre_archivo, $destino); //Función para subir archivos al servidor.
			            //Ejecutar procedimiento para bitacora ='}'
			        	$exito = Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 15 , 1, $consulta_pro ) );
			        	$exito = Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 10 , 1, $consulta_img ) );
			            if ( $exito == 1 ) header("location: productos");
			        }
				}
		    	else $error_data = "Error, por favor revise los campos señalados.";
		    	
				( ! ( Validator::numero( $id_presentacion ) ) ) ? $error[] = "Presentacion: seleccione un estado." : "";

		    	( ! ( $estado == 1 || $estado == 0 ) ) ? $error[] = "Estado: seleccione un estado." : "";
		    	
		    	( ! ( Validator::numeros_letras( $descripcion ) ) ) ? $error[] = "Descripcion: solo se permiten numeros y letras." : "";
		        
		        ( ! ( Validator::decimal( $precio_producto ) && $precio_producto > 0 ) ) ? $error[] = "Precio: debe de ser decimal o entero." : "";
		        
		        ( ! ( Validator::letras( $nombre_producto ) ) ) ? $error[] = "Nombre: solo se permiten letras." : "";
			    
			    ( ! ( Validator::numero( $id_categoria ) ) ) ? $error[] = "Categoria: seleccione una categoria." : "";

		      }
		      else $error[] = "La dimensión de la imagen no es valida.";
		    }
		    else $error[] = "El tipo de imagen no es valido.";
		  }
		  else $error[] = "Debe seleccionar una imagen.";
	}
	catch( Exception $Exception ) {    	
    	if($Exception->getCode() == 23000){
        	$error[] = "Producto ya existente (nombre del producto y categoria ya ingresada), por favor ingrese otro.";
        }
        else $error[] = $Exception->getMessage();
	}
  }
  
		            				print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
		            				if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
		            			?>
							    <div class="col-sm-6 col-md-6 col-lg-6">
							     	<div class="form-group">
							        	<label for="">Nombre</label>
							        	<input onpaste=";return false" name="nombre_producto" length="100" maxlenght="100" class="form-control vletras_esp <?php print( ( isset($er_nombre_producto) ) ? "$er_nombre_producto": ""); ?>" type="text" value="<?php print((isset($nombre_producto) != "")?"$nombre_producto":""); ?>" required />
							      	</div>
							      	<div class="form-group">
							        	<label for="">Precio</label>
							        	<input onpaste=";return false" name="precio_producto" class="form-control <?php print( ( isset($er_precio_producto) ) ? "$er_precio_producto": ""); ?>" value="<?php print((isset($precio_producto) != "")?"$precio_producto":""); ?>" required />
							      	</div>
							     	<div class="form-group">
								        <label for="">Categoria</label>
								        <select required name="id_categoria" class="form-control <?php print( ( isset($er_id_categoria) ) ? "$er_id_categoria": ""); ?>">
								          	<option value="" disabled selected>Seleccione categoria</option>
								            <?php
								              require("../sql/conexion.php");
								              $consulta = "SELECT * FROM categorias order by categoria";
								              $opciones = ""; //Arreglo de datos
								              foreach($PDO->query($consulta) as $datos){
								                $opciones .= "<option value='$datos[id_categoria]'";
								                if(isset($id_categoria) == $datos['id_categoria']){
								                    $opciones .= " selected";
								                }
								                $opciones .= ">$datos[categoria]</option>";
								              }
								              print($opciones);
								              $PDO = null;
								            ?>
								        </select>
								    </div>
							      	<div class="form-group">
								        <label for="descrip">Descripcion</label>
								        <textarea id="descrip" name="descrip" class="form-control resize <?php print( ( isset($er_descripcion) ) ? "$er_descripcion": ""); ?>" type="text" required ><?php print((isset($descripcion) != "")?"$descripcion":""); ?></textarea>
							      	</div>
							      	<div class="form-group">
						          		<label>Estado</label>
						          		<p class="<?php print( ( isset($er_estado) ) ? "$er_estado": ""); ?>">
							            <input class="with-gap" name="estado" type="radio" id="activo" value="1" <?php print(isset($estado) && $estado == 1 || !isset($estado)?"checked":""); ?> />
							            <label for="activo">Habilitado</label>
							            <input class="with-gap" name="estado" type="radio" id="inactivo" value="0" <?php print(isset($estado) && $estado == 0 || !isset($estado)?"checked":""); ?> />
							            <label for="inactivo">Inhabilitado</label>
						          		</p>
						        	</div>
							    </div>
							    <div class="col-sm-6 col-md-6 col-lg-6">
							        <div class="form-group">
							        	<label for="">Imagen principal</label>
								        <img src="../img/logo.png" class="img-responsive" id="pro_img"/>
								        <BR>
						          		<input name="pro_img_url" id="pro_img_url" type="file" required />
						          	</div>
						        	<div class="form-group">
									    <label for="id_presentacion">Presentacion</label>
									    <select required id="id_presentacion" name="id_presentacion" class="form-control <?php print( ( isset($er_presentacion) ) ? "$er_presentacion": ""); ?>">
							            	<option value="" disabled selected>Seleccione la presentacion</option>
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
							    </div>
							</div>
							<div class="box-body text-center">
							    <button type="submit" name="action" class="btn btn-primary margin_right fbtn">
							        <span class="glyphicon glyphicon-plus"></span>
							    </button>
							    <a href="productos" class="btn btn-danger fbtn">
							        <span class="glyphicon glyphicon-remove"></span>
							    </a>
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