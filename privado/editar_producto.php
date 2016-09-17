<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
	ob_start();//Definicion: Esta función activará el almacenamiento en búfer de la salida. Mientras dicho almacenamiento esté activo, no se enviará ninguna salida desde el script (aparte de cabeceras); en su lugar la salida se almacenará en un búfer interno.	
	//Desactivar errores no funciona :D
	//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	require("../lib/validator.php");
	//!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
	require("../lib/page-privado.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Editar producto", "productos");
	try{
		$id = null;
	    if(!empty($_GET['id'])) $id = base64_decode( $_GET['id'] );
	    //Por el antiguo metodo de conectar con la base :)
	    require("../sql/conexion.php");

		if ( Validator::numero( $id ) && $id != null ){
			if(!empty($_POST)){
				$id_categoria = $_POST['id_categoria'];
			    $nombre_producto = $_POST['nombre_producto'];
			    $precio_producto = $_POST['precio_producto'];
			    $descripcion = $_POST['descripcion'];
			    $estado = $_POST['estado'];//Estado 1 es habilitado y 0 es inha
			    //Imagen
			    $imagen_nueva = $_FILES['pro_img_url'];//Imagen
			    $imagen_antigua = $_POST['imagen_antigua'];
				$id_img = $_POST['id_img'];
				$id_presentacion = $_POST['id_presentacion'];
				//
				if($imagen_nueva['name'] != null){
			    	if($imagen_nueva['type'] == "image/jpeg" || $imagen_nueva['type'] == "image/png" || $imagen_nueva['type'] == "image/x-icon" || $imagen_nueva['type'] == "image/gif"){
			        	$info_imagen = getimagesize($imagen_nueva['tmp_name']);
			        	$ancho_imagen = $info_imagen[0]; 
						$alto_imagen = $info_imagen[1];
						if ( $ancho_imagen >= 150 && $alto_imagen >= 150){
							//
							$nuevo_id = uniqid(); //Esto sirve para darle un nombre único a cada archivo de imagen.
					        $nombre_archivo = $imagen_nueva['tmp_name'];
					        $imagen_producto = $nuevo_id.".png";
					        $destino = "../img/productos/$imagen_producto";
					        if ( Validator::numero( $id_categoria ) && Validator::letras( $nombre_producto )
					      	 && Validator::decimal( $precio_producto )
					      	 && Validator::numeros_letras( $descripcion )
					      	 && ( $estado == 1 || $estado == 0 ) && Validator::numero( $id_presentacion ) ){
					      	 	if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
        						else {
							        //Modificamos el producto
							        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$consulta_pro = "update productos set nombre_producto = ?, precio_producto = ? , id_categoria = ?, estado = ?, descripcion = ? where id_producto = ?;";
									$stmt = $PDO->prepare($consulta_pro);
									$exito = $stmt->execute(array ( $nombre_producto, $precio_producto, $id_categoria, $estado, $descripcion, $id ) );
							        //
									//Actualizamos la imagen ='}}
									$consulta_img = "update img_productos set id_presentacion=?, imagen_producto=? where id_img_producto= ?;";
									$stmt = $PDO->prepare($consulta_img);
									$exito1 = $stmt->execute(array ( $id_presentacion, $imagen_producto, $id_img ) );
									if ( $exito == 1 && $exito1 == 1 ){
										header("location: productos");
										unlink("../img/productos/$imagen_antigua"); //Función para eliminar la imagen anterior.
										move_uploaded_file($nombre_archivo, $destino); //Función para subir archivos al servidor.
										//Ejecutar procedimiento para bitacora ='}'
				        				Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 15, 2, $consulta_pro ) );
				        				Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 10, 2, $consulta_img ) );
				        			}
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
			    else{
			    	
			    	if ( Validator::numero( $id_categoria ) && Validator::letras( $nombre_producto )
			      	 && Validator::decimal( $precio_producto )
			      	 && Validator::numeros_letras( $descripcion ) && Validator::numeros_letras( $id_presentacion )
			      	 && ( $estado == 1 || $estado == 0 ) && Validator::numero( $id_presentacion ) ){
			    		//Modificamos =D
				    	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$consulta_pro = "update productos set nombre_producto = ?, precio_producto = ? , id_categoria = ?,  estado = ?,  descripcion = ? where id_producto = ?;";
						$stmt = $PDO->prepare($consulta_pro);
						$exito = $stmt->execute(array ( $nombre_producto, $precio_producto, $id_categoria, $estado, $descripcion, $id ) );
						//Modificar la presentacion por si acaso xd
						$consulta_img = "update img_productos set id_presentacion=? where id_img_producto= ?;";
						$stmt = $PDO->prepare($consulta_img);
						$exito1 = $stmt->execute(array( $id_presentacion, $id_img ) );
						if ( $exito == 1 && $exito1 == 1 ){
							//Ejecutar procedimiento para bitacora ='}'
	        				$exito = Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 15, 2, $consulta_pro ) );
	        				$exito = Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 10, 2, $consulta_img ) );
							if  ( $exito == 1 ) header("location: productos");
			        	}
			    	}
					else $error_data = "Por favor revise los campos señalados.";
			    	
			    	( ! ( Validator::numero( $id_presentacion ) ) ) ? $error[] = "Presentacion: seleccione un estado." : "";

			    	( ! ( $estado == 1 || $estado == 0 ) ) ? $error[] = "Estado: seleccione un estado." : "";
			    	
			    	( ! ( Validator::numeros_letras( $descripcion ) ) ) ? $error[] = "Descripcion: solo se permiten numeros y letras." : "";
			        
			        ( ! ( Validator::decimal( $precio_producto ) && $precio_producto > 0 ) ) ? $error[] = "Precio: debe de ser decimal o entero." : "";
			        
			        ( ! ( Validator::letras( $nombre_producto ) ) ) ? $error[] = "Nombre: solo se permiten letras." : "";
				    
				    ( ! ( Validator::numero( $id_categoria ) ) ) ? $error[] = "Categoria: seleccione una categoria." : "";
			    }
			}
			else{
				$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		        $sql = "SELECT * FROM productos WHERE id_producto = $id";
		        $stmt = $PDO->prepare($sql);
				$stmt->execute();
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				//Aqui se valida si el numero de id, posee registro, si no lo redirecciona a la paguina anterior :D
				if ( $data == "" ) header("location: productos");
				//
				$nombre_producto = $data['nombre_producto'];
			    $precio_producto = $data['precio_producto'];
			    $id_categoria = $data['id_categoria'];
			    $estado = $data['estado'];
			    $descripcion = $data['descripcion'];
			    //Selecciono la imagen principal
			    //$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		        $sql = "SELECT min(id_img_producto), imagen_producto, id_presentacion FROM img_productos where id_producto = $id";
		        $stmt = $PDO->prepare($sql);
				$stmt->execute();
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				//
				$id_img = $data['min(id_img_producto)'];
			    $imagen_producto = $data['imagen_producto'];
			    $id_presentacion = $data['id_presentacion'];
			    $PDO = null;
			}
		}
		else header("location: productos");
	}
	catch( PDOException $Exception ) {
	    if($Exception->getCode() == 23000){
        	$error[] = "Producto ya existente (nombre del producto y categoria ya ingresada), por favor ingrese otro.";
        }
        else $error[] = $Exception->getMessage();
	}

	
		            				print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
		            				if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
		            			?>	            			
							    <div class="col-sm-6 col-md-6 col-lg-6">
							     	<div class="form-group">
							        	<label for="">Nombre</label>
							        	<input onpaste=";return false" name="nombre_producto" class="form-control vletras_esp <?php print( ( isset($er_nombre_producto) ) ? "$er_nombre_producto": ""); ?>" type="text" required value="<?php print($nombre_producto); ?>" />
							      	</div>
							      	<div class="form-group">
							        	<label for="">Precio</label>
							        	<input onpaste=";return false" name="precio_producto" class="form-control vnumeros <?php print( ( isset($er_precio_producto) ) ? "$er_precio_producto": ""); ?>" type="text" required value="<?php print($precio_producto); ?>" />
							      	</div>
							     	<div class="form-group">
								        <label for="">Categoria</label>
								        <select name="id_categoria" class="form-control <?php print( ( isset($er_id_categoria) ) ? "$er_id_categoria": ""); ?>">
								          	<option value="" disabled selected>Seleccione categoria</option>
								            <?php
								              $consulta = Database::getRows( "SELECT * FROM categorias order by categoria", null );
								              $opciones = ""; //Arreglo de datos
								              foreach( $consulta as $datos){
								                $opciones .= "<option value='$datos[id_categoria]'";
								                if( $id_categoria == $datos['id_categoria']){
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
								        <textarea id="descrip" name="descripcion" class="form-control texarea <?php print( ( isset($er_descripcion) ) ? "$er_descripcion": ""); ?>" type="text" required="required"><?php print($descripcion); ?></textarea>
							      	</div>
							      	<div class="form-group">
						          		<label>Estado</label>
						          		<p class="<?php print( ( isset($er_estado) ) ? "$er_estado": ""); ?>" >
							            <input class="with-gap" name="estado" type="radio" id="activo" value="1" <?php print($estado == 1?"checked":""); ?> />
							            <label for="activo">Habilitado</label>
							            <input class="with-gap" name="estado" type="radio" id="inactivo" value="0" <?php print($estado == 0?"checked":""); ?> />
							            <label for="inactivo">Inhabilitado</label>
						          		</p>
						        	</div>						          	
							    </div>
							    <div class="col-sm-6 col-md-6 col-lg-6">
							        <div class="form-group">
							        	<label for="">Imagen principal</label>
								        <img src="../img/productos/<?php print($imagen_producto); ?>" class="img-responsive" id="pro_img"/>
								        <BR>
						          		<input type="hidden" name="imagen_antigua" value="<?php print($imagen_producto);?>"/>
										<input type="hidden" name="id_img" value="<?php print($id_img);?>"/>
										<input name="pro_img_url" id="pro_img_url" type="file"/>
						          	</div>
						          	<div class="form-group">
									    <label for="id_presentacion">Presentacion</label>
									    <select id="id_presentacion" name="id_presentacion" class="form-control <?php print( ( isset($er_presentacion) ) ? "$er_presentacion": ""); ?>">
							            	<option value="" disabled selected>Seleccione la presentacion</option>
							            	<?php
								                $consulta = Database::getRows( "SELECT * FROM presentaciones order by presentacion" , null );
								                $opciones = ""; //Arreglo de datos
								                foreach( $consulta as $datos)
								                {
								                  $opciones .= "<option value='$datos[id_presentacion]'";
								                  if( $id_presentacion == $datos['id_presentacion']){
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
							        <span class="glyphicon glyphicon-edit"></span>
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