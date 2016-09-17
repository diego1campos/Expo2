<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
	ob_start();
	//Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page-privado.php");
    $permisos = Page::header("Imagenes productos", "img_productos");

	try{
		$id = null;
	    if(!empty($_GET['id'])) {
	        $id = base64_decode($_GET['id']);
	    }
		if ( Validator::numero( $id ) && $id != null ){
			if( ! empty( $_POST ) ){
				require("../sql/conexion.php");
				$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$action = $_POST['action'];
				if ( $action != "Buscar" ){
					$imagen = $_FILES['pro_img_url'];
					$imagen_antigua = $_POST['imagen_antigua'];
					$id_presentacion = $_POST['id_presentacion'];
					$id_img_producto = $_POST['id_img_producto'];
				}
				if($imagen['name'] == null && $action == 'Editar'){
					//Editae los datos ='DD
				    if ( Validator::numero( $id_presentacion ) && Validator::imagen( $imagen_antigua ) ){
					    if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
        				else {
					        $sql = "update img_productos set id_presentacion=? where id_img_producto=?";//, tipo_imagen=?
					        $stmt = $PDO->prepare($sql);
					        $exito = $stmt->execute(array($id_presentacion, $id_img_producto) );
					        $PDO = null;
					        if ( $exito == 1 ) Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 10, 2, $sql ) );
					    }
				    }
				    if ( ! Validator::numero( $id_presentacion ) ){
				    	$error_data = "Error, por favor revise los campos señalados.";
				    	$error[] = "Presentación: seleccione una presentación.";
				    }
				    ( ! ( Validator::imagen( $imagen_antigua ) ) ) ? $error[] = "Imagen antigua invalida." : "" ;
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
						        $imagen_producto = $nuevo_id.".png";
						        $destino = "../img/productos/$imagen_producto";
						        move_uploaded_file($nombre_archivo, $destino); //Función para subir archivos al servidor.
						        //Si esta editando o agregando ='DDD
						        if ( $action == "Agregar" && Validator::numero( $id_presentacion ) ){//Agrego los datos ='DD
								    if ( ! Validator::permiso_agregar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
    								else {
								        $sql = "INSERT INTO img_productos ( id_producto, id_presentacion, imagen_producto ) values(?, ?, ?)";
								        $stmt = $PDO->prepare($sql);
								        $exito = $stmt->execute(array ( $id, $id_presentacion, $imagen_producto ) );
								        $PDO = null;
								        if ( $exito == 1 ) Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 10, 1, $sql ) );
								    }
							    }
							    else if ( $action == "Agregar" ) $error_data = "Error, por favor revise los campos señalados.";
						        if ( $action == "Editar" && Validator::numero( $id_img_producto ) && Validator::numero( $id_presentacion ) ){
								    if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
        							else {
								        //Editae los datos ='DD
								        $sql = "update img_productos set id_presentacion=?, imagen_producto=? where id_img_producto=?";//, tipo_imagen=?
								        $stmt = $PDO->prepare($sql);
								        $exito = $stmt->execute(array ( $id_presentacion, $imagen_producto, $id_img_producto ) );
								        $PDO = null;
								        if ( $exito == 1 ) Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 10, 2, $sql ) );
								    }
							    }
							    else if ( $action == "Editar" ){
							    	$error_data = "Error, por favor revise los campos señalados.";
								    ( ! ( Validator::numero( $id_img_producto ) ) ) ? $error[] = "Id de imagen invalida." : "";
							    }
							    ( ! ( Validator::numero( $id_presentacion ) ) ) ? $error[] = "Presentación: seleccione una presentación." : "";
							}
							else $error[] = "La dimensión de la imagen no es valida 450x450.";
						}
						else $error[] = "El tipo de imagen no es valido.";
			    	}
			    	else $error[] = "Debe seleccionar una imagen.";
			    }
			}
		}
		else header("location: productos");
	}
	catch( PDOException $Exception ) {
	    $error[] = $Exception->getMessage( );
	}

									$palabra = '';
		            				if ( isset($action) && $action == "Agregar" ) $palabra = "añadida";
		            				else $palabra = "editada";
		            				print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Imagen '.$palabra.' con exito.</div>' : "" );
		            				print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
		            				if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
		            			?>
								<div class="col-sm-8 col-md-8 col-lg-8 no_padding">
									<div class="col-sm-8 col-md-8 col-lg-8 no_padding">
										<input type="hidden" id="id_img_producto" name="id_img_producto" />
										<!--Ya que ocupe javascript para obtener los datos xd, si no que solo los pase xd-->
										<div class="col-sm-12 col-md-12 col-lg-12">
											<label for="url_pro">Imagen</label>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-12">
											<img src="../img/productos/logo.png" class="img-responsive" name="pro_img" id="pro_img"/>
											<input type="hidden" name="imagen_antigua" id="imagen_antigua" />
										</div>
										<div class="col-sm-12 col-md-12 col-lg-12">
											<br>
											<input name="pro_img_url" id="pro_img_url" type="file" required/>
										</div>
									</div>
									<div class="col-sm-4 col-md-4 col-lg-4 no_padding">
										<div class="col-sm-12 col-md-12 col-lg-12 ">
											<label for="id_presentacion">Presentacion</label>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-12">
											<select id="id_presentacion" name="id_presentacion" class="form-control <?php print( ( isset($er_presentacion) ) ? "$er_presentacion": ""); ?>">
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
								<div class="col-sm-4 col-md-4 col-lg-4">
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button type="submit" name="action" class="btn btn-primary size" value="Agregar" id="btna_imagen">
									        <span class="glyphicon glyphicon-plus"></span>
									    </button>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button type="button" class="btn btn-danger margin_top size" id="btn_cane_imagen">
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
										<input class="form-control" id="txtBuscar" type="text" class="validate" name="txtBuscar" placeholder="Escribe la presentación..."/>
									</div>
								</div>
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
									            <th class="col-sm-6 col-md-6 col-lg-6">Imagen</th>
									            <th class="col-sm-3 col-md-3 col-lg-3">Presentacion</th>
									            <th class="col-sm-3 col-md-3 col-lg-3">Accion</th>
									        </tr>
									    </thead>
									    <tbody>
											<?php
												require("../sql/conexion.php");
												$consulta = "SELECT id_img_producto, imagen_producto, presentacion from img_productos inner join presentaciones on presentaciones.id_presentacion = img_productos.id_presentacion where id_producto = $id and id_img_producto > (select min(id_img_producto) from img_productos where id_producto = $id )";
												if( isset( $_POST['txtBuscar'] ) != "" && Validator::letras( $_POST['txtBuscar'] ) ){
								    				$busqueda = $_POST['txtBuscar'];
								    				$consulta = $consulta . " where presentacion LIKE '%$busqueda%' order by id_img_producto ASC";
								    			}
								    			else $consulta = $consulta . " order by id_img_producto ASC;";
												$imagenes = ""; //Arreglo de datos No cambiara aunque fuera imagenes
												foreach($PDO->query($consulta) as $datos){
													$imagenes .= "<tr>";
														$imagenes .= "<td><img src='../img/productos/$datos[imagen_producto]' class='img-responsive'></td>";
														$imagenes .= "<td><label class='presentacion'>$datos[presentacion]</label></td>";
														$imagenes .= '<td class="text-center"><a id_img_producto="'.$datos['id_img_producto'].'" onclick="$(this).e_imagenes();" class="up glyphicon glyphicon-edit padding_right_ico icono_tamano"></a><a href="eliminar_imagen?id='.base64_encode($datos['id_img_producto']).'&producto='.base64_encode($id).'&imagen='.base64_encode($datos['imagen_producto']).'" class="glyphicon glyphicon-remove-circle icono_tamano"></a></td>';
													$imagenes .= "</tr>";
												}
												print($imagenes);
												$PDO = null;
											?>
										</tbody>
									</table>
								</div>
							</div>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>