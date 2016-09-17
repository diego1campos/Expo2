<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
	//Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page-privado.php");
	//Por el antiguo metodo de conectar con la base :)
	require("../sql/conexion.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Categorias", "categorias");

  if(!empty($_POST)){
    $action = $_POST['action'];
    if ( $action != "Buscar" ){
    	$categoria = $_POST['txtcategoria'];
    	$imagen = $_FILES['pro_img_url'];
		$imagen_antigua = $_POST['imagen_antigua'];
	    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	   	try{
   		   	if ( Validator::letras( $categoria ) ){
   			    if ( $imagen['name'] == null && $action == "Editar" ){
   			    	$id_categoria = $_POST['id_categoria'];
   			    	if ( Validator::numero( $id_categoria ) ){
   			    		if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
						else {
	   				        $sql = "update categorias set categoria=? where id_categoria=?";
	   				        $stmt = $PDO->prepare($sql);
	   				        $exito = $stmt->execute(array ( $categoria, $id_categoria ) );
	   				        $PDO = null;
				        	Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 1 , 2, $sql ) );
						}
   				    }
   			    	else $error[] = "Id no valido.";
   			    }
   			    else{
			        //Validacion de logo ='DD
			        if ( $imagen['name'] != null ){
			        	if($imagen['type'] == "image/jpeg" || $imagen['type'] == "image/png" || $imagen['type'] == "image/x-icon" || $imagen['type'] == "image/gif"){
				        	$info_imagen = getimagesize( $imagen['tmp_name'] );
				        	$ancho_imagen = $info_imagen[0];
							$alto_imagen = $info_imagen[1];
							if ( $ancho_imagen >= 450 && $alto_imagen >= 450){
								if ( $action == 'Editar' ) unlink("$imagen_antigua"); //Función para eliminar la imagen anterior.
								$nuevo_id = uniqid(); //Esto sirve para darle un nombre único a cada archivo de imagen.
						        $nombre_archivo = $imagen['tmp_name'];
						        $imagen_categoria = $nuevo_id.".png";
						        $destino = "../img/categorias/$imagen_categoria";
						        move_uploaded_file($nombre_archivo, $destino); //Función para subir archivos al servidor.
						        //Si esta editando o agregando ='DDD
						        if ( $action == "Agregar" ){
				   			    	if ( ! Validator::permiso_agregar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
									else {
					   			        $sql = "INSERT INTO categorias(categoria, imagen_categoria) values(?, ?)";            
					   			        $stmt = $PDO->prepare($sql);
					   			        $exito = $stmt->execute(array ( $categoria, $imagen_categoria ) );
					   			        $PDO = null;
					   			        Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 1 , 1, $sql ) );
					   			    }
				   			    }
						        if ( $action == "Editar" ){
								    $id_categoria = $_POST['id_categoria'];
				   			    	if ( Validator::numero( $id_categoria ) ){
				   			    		if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
										else {
					   				        $sql = "update categorias set categoria=?, imagen_categoria = ? where id_categoria=?";
					   				        $stmt = $PDO->prepare($sql);
					   				        $exito = $stmt->execute(array ( $categoria, $imagen_categoria, $id_categoria ) );
					   				        $PDO = null;
								        	Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 1 , 2, $sql ) );
										}
				   				    }
				   			    	else $error[] = "Id no valido.";
							    }
							}
							else $error[] = "La dimensión de la imagen no es valida 450x450.";
						}
						else $error[] = "El tipo de imagen no es valido.";
			    	}
			    	else $error[] = "Debe seleccionar una imagen.";
			    }
   			}
   			else $error_data = "Error, por favor revise los campos señalados.";
   			( ! ( Validator::letras( $categoria ) ) ) ? $error[] = "Categoria: solo se permiten letras." : "";
   		}
   		catch( Exception $Exception )
   		{
			if($Exception->getCode() == 23000)
	        {
	        	$error[] = "Categoria ya existente, por favor ingrese otra.";
	        }
	        else $error[] = $Exception->getMessage();
		}
	}
  }
  
		            				$palabra = '';
		            				if ( isset($action) && $action == "Agregar" ) $palabra = "añadida";
		            				else $palabra = "editada";
		            				print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Categoria '.$palabra.' con exito.</div>' : "" );
		            				print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
		            				if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
		            			?> 
		            			<div class="col-sm-6 col-md-6 col-lg-6 no_padding">
									<div class="col-sm-12 col-md-12 col-lg-12">
										<label for="url_pro">Imagen</label>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
										<img src="../img/logo.png" class="img-responsive" name="pro_img" id="pro_img"/>
										<input type="hidden" name="imagen_antigua" id="imagen_antigua" />
									</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
										<br>
										<input name="pro_img_url" id="pro_img_url" type="file"/>
									</div>
								</div>
		            			<div class="col-sm-5 col-md-5 col-lg-5 no_padding">
									<div class="col-sm-12 col-md-12 col-lg-12">
										<label class="">Categoria</label>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
										<input type="hidden" name="id_categoria" id="id_categoria" />
										<input class="form-control <?php print( ( isset($er_categoria) ) ? "$er_categoria": ""); ?>" id="txtcategoria" type="text" class="validate" name="txtcategoria" placeholder="Ingrese aquí..."/>
									</div>
								</div>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button id="btn_categoria" type="submit" name="action" value="Agregar" class="btn btn-primary size">
									        <span class="glyphicon glyphicon-plus"></span>
									    </button>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button id="btn-c_categoria" type="button" class="btn btn-danger size">
									        <span class="glyphicon glyphicon-remove"></span>
									    </button>
									    <br>
									    <br>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
		    		<div class="col-xs-12">
		        		<div class="box">
		        			<div class="box-body">
		        				<br>
								<div class="col-sm-8 col-md-8 col-lg-8">
									<div class="input-group">
										<span class="input-group-addon no_padding_input-group"><button type="submit" name="action" value="Buscar" class="glyphicon glyphicon-search nobtn padding_input-group"></button></span>
										<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe la categoria..."/>
									</div>
								</div>
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
									            <th class="col-sm-6 col-md-6 col-lg-6">Categoria</th>
									            <th class="col-sm-3 col-md-3 col-lg-3">Imagen</th>
									            <th class="col-sm-3 col-md-3 col-lg-3">Acciones</th>
									        </tr>
									    </thead>
									    <tbody>
										<?php
											require("../sql/conexion.php");
											$consulta = "SELECT * FROM categorias";
											if( isset( $_POST['txtBuscar'] ) != "" && Validator::letras( $_POST['txtBuscar'] ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " where categoria LIKE '%$busqueda%' order by categoria ASC";
							    			}
							    			else $consulta = $consulta . " order by categoria ASC";
											$productos = ""; //Arreglo de datos
											foreach($PDO->query($consulta) as $datos){
												$productos .= "<tr>";
													$productos .= "<td><img src='../img/categorias/$datos[imagen_categoria]' class='img-responsive'></td>";
													$productos .= "<td class='categoria'>$datos[categoria]</td>";
													$productos .= '<td class="text-center"><a id_categoria="'.$datos['id_categoria'].'" class="glyphicon glyphicon-edit padding_right_ico icono_tamano up" onclick="$(this).e_categoria();"></a><a href="eliminar_categoria?id='.base64_encode($datos['id_categoria']).'" class="glyphicon glyphicon-remove-circle icono_tamano"></a></td>';
												$productos .= "</tr>";
											}
											print($productos);
											$PDO = null;
										?>
										</tbody>
									</table>
								</div>
							</div>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>