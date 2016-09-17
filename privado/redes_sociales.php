<?php
//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
ob_start();
//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	require("../lib/validator.php");
	//!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
	require("../lib/page-privado.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	//Page::header("Redes Sociales");
  	$permisos = Page::header("Redes Sociales", "redes_sociales");
	
	if(!empty($_POST))
	{
		$action = $_POST['action'];
		if ( $action != "Buscar" )
		{
			$imagen = $_FILES['imagen'];
			$imagen_antigua = $_POST['imagen_antigua'];
			$direccion=$_POST["txtred"];
			$id_red_social = $_POST['id_red_social'];
			//	$id_presentacion = $_POST['id_presentacion'];

			//condicion de imagen
			if($imagen['name'] == null && $action == 'Editar')
			{
				//Editae los datos ='DD
				require("../sql/conexion.php");
			
				$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "update redes_sociales set url_red_social=? where id_red_social=?";//, tipo_imagen=?
				$stmt = $PDO->prepare($sql);
				$exito = $stmt->execute(array( $direccion,$id_red_social ) );
				//Ejecutar procedimiento para bitacora ='}'
		            $con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
		        	$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 16 , 2, $sql ) );
				//sif ( $stmt == 1 ) call inserta_bitacora ( $_SESSION['id_empleado'] , 15, 2, $consulta );
				//print($imagen_antigua);
				$PDO = null;
			}
			else
			{
			require("../sql/conexion.php");
			//Validacion de logo ='DDecho "lel";
			if ( $imagen['name'] != null )
			{
				if($imagen['type'] == "image/jpeg" || $imagen['type'] == "image/png" || $imagen['type'] == "image/x-icon" || $imagen['type'] == "image/gif")
				{
					$info_imagen = getimagesize( $imagen['tmp_name'] );
					$ancho_imagen = $info_imagen[0];
					$alto_imagen = $info_imagen[1];
					if ( $ancho_imagen == $alto_imagen && $ancho_imagen <=1200)
					{
						if ( $action == 'Editar' ) unlink("$imagen_antigua"); //Función para eliminar la imagen anterior.
						$nuevo_id = uniqid(); //Esto sirve para darle un nombre único a cada archivo de imagen.
						$nombre_archivo = $imagen['tmp_name'];
						$imagen_producto = $nuevo_id.".png";
						$destino = "../img/redes_sociales/$imagen_producto";
						move_uploaded_file($nombre_archivo, $destino); //Función para subir archivos al servidor.

						//Si esta editando o agregando ='DDD
						try
						{
							if ( $action == "Agregar" )
							{	//Agrego los datos ='DD
								if ( ! Validator::permiso_agregar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
								else
								{
									$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$sql = "INSERT INTO redes_sociales(logo_red_social,url_red_social) values(?,?)"; 
									$stmt = $PDO->prepare($sql);
									$exito = $stmt->execute(array ($imagen_producto,$direccion) );
									//Ejecutar procedimiento para bitacora ='}'
						            $con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
						        	$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 16 , 1, $sql ) );
									//if ( $stmt == 1 ) call inserta_bitacora ( $_SESSION['id_empleado'] , 15, 1, $consulta );
									$PDO = null;
									//header("location: productos.php");
								}
							}
							else if ( $action == "Editar" )
							{
								//Editae los datos ='DD
							
								$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								$id_red_social = $_POST['id_red_social'];
								if ( Validator::numero( $id_red_social ) )
								{
									if ( ! Validator::permiso_modificar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
									else
									{
										$sql = "UPDATE redes_sociales set logo_red_social=?, url_red_social=? where id_red_social=?";//, tipo_imagen=?
										$stmt = $PDO->prepare($sql);
										$exito = $stmt->execute(array ($imagen_producto,$direccion, $id_red_social ));
										//Ejecutar procedimiento para bitacora ='}'
										$con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
										$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 16 , 2, $sql ) );
										if ( $exito == 1 ) header("location: redes_sociales");
									//	$PDO = null;
									}
								}
								else $error_data = "Error, por favor revise los campos señalados.";
		    	
								( ! ( Validator::numero( $id_red_social ) ) ) ? $error[] = "ID no valido" : "";
							}
						}
						catch (Exception $Exception) 
						{
							if($Exception->getCode() == 23000){
		    				$error[] = "Red socal ya existente, por favor ingrese una diferente.";
							} 
							else $error[] = $Exception->getMessage();
							
						}
					}	
						else
						{
							$error[] = "La dimensión de la imagen no es valida 450x450.";
						}
					}
					else
					{
						$error[] = "El tipo de imagen no es valido.";
					}
			}
			else{
			$error[] = "Debe seleccionar una imagen.";
			}
		}
	}
}
	$palabra = '';
	if ( isset($action) && $action == "Agregar" ) $palabra = "añadida";
	else $palabra = "editada";
	print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Red social '.$palabra.' con exito.</div>' : "" );
	print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
	if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
?>
            		<div class="box-body">
        	
        			 	<div class="col-xs-5 col-xs-offset-4 col-sm-4 col-sm-offset-0 col-md-2 col-md-offset-0 col-lg-2 col-lg-offset-0">
                            <img src="../img/logo.png" alt="Error al cargar imagen" class="margenimagenRR margenimagenR imagen_red img-responsive" >
                            	<input type="hidden" name="imagen_antigua" id="imagen_antigua" />
                        </div>
            			<div class="col-xs-12 col-sm-9 col-sm-offset-0 col-md-8 col-lg-6  no_padding margenredes">
							<div class="col-xs-3 col-xs-offset-2 col-sm-offset-0 col-sm-1 col-md-offset-1 col-md-2 col-lg-2 col-lg-offset-1 redestitulo">
								<label class="colorredes margenred">Link:</label>
							</div>
							<div class="col-xs-offset-2 col-xs-10 col-sm-offset-0 col-sm-12  col-md-8 col-md-offset-0 col-lg-8 agregarred" >
								<input type="hidden" name="id_red_social" id="id_red_social" />
								<input class="form-control margenred" id="txtred" type="text" class="validate" name="txtred" placeholder="Ingrese aquí..." /> 
							</div>
							<div class="file-field input-field buscarimagen">
                                <div id="Rbtnimagen" class="margenred btn grey darken-3 col-xs-offset-2 col-xs-12  col-lg-12 col-lg-offset-1 col-md-2 col-md-offset-0 col-sm-12 col-sm-offset-0">
                                    <input name="imagen" type="file" id="pro_img_url"/>
                                </div>
                        	</div>
						</div>

							<div class="col-xs-offset-2  col-xs-7 col-sm-offset-3 col-sm-4 col-md-2 col-md-offset-0 col-lg-2 col-lg-offset-0">
								<br>
								<button id="btn_redes" type="submit" name="action" value="Agregar" class="btn btn-primary size col-xs-12 col-sm-10 col-sm-offset-0 col-md-12 col-lg-12 col-lg-offset-0">
							        <span class="glyphicon glyphicon-plus"></span>
							    </button>
							</div>
							<div class="col-xs-offset-2 col-sm-offset-0  col-xs-7 col-sm-4 col-md-2 col-md-offset-0 col-lg-2 col-lg-offset-0">
								<br>
								<button id="btn-c_redes" type="button" class="btn btn-danger size col-xs-12 col-sm-12 col-sm-offset-0 col-md-12 col-lg-12">
							        <span class="glyphicon glyphicon-ban-circle"></span>
							    </button>
							    <br>
							    <br>
							</div>
						</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-xs-offset-0 col-md-12 col-md-offset-0 col-lg-0 col-lg-offset-0">
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
				

				<!--consulta de redes-->
				<div class="box-body table-responsive">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<table class="table table-bordered table-hover conf_tabla">
						    <thead>
						        <tr>
						            <th class="col-sm-3 col-md-3 col-lg-3 s">Icono</th>
						            <th class="col-sm-3 col-md-3 col-lg-3 s">Link</th>
						            <th class="col-sm-3 col-md-3 col-lg-3 s">Funciones</th>
						        </tr>
						    </thead>
						    <?php
							    require("../sql/conexion.php");
								$consulta = "SELECT * from redes_sociales";  
								if( isset( $_POST['txtBuscar'] ) != "" && Validator::numeros_letras( $_POST['txtBuscar'] ) ){
					    				$busqueda = $_POST['txtBuscar'];
					    				$consulta = $consulta . " WHERE url_red_social LIKE '%$busqueda%' order by url_red_social ASC";
					    			}
					    			else $consulta = $consulta . " order by url_red_social ASC";    
								$tabla="";
								foreach ($PDO->query($consulta) as $datos) 
								{

							    $tabla.= "<tbody id='lista_productos'>";
							    $tabla.= "<tr>";
							    $tabla.="<div class='col-sm-12 col-md-12 col-lg-12 col-lg-offset-2'>";
							    $tabla.="<td width='0px'><img src='../img/redes_sociales/$datos[logo_red_social]' alt='Error al cargar imagen' class='iconoredes img-responsive'></td>";
							    //$tabla.="<input type='hidden' name='imagen_antigua' id='imagen_antigua' />";
							    $tabla.="</div>";
							    $tabla.="<td><div class='linkredes colorredes'>$datos[url_red_social] </div></td>";
							    $tabla.="<td> ";
							    $tabla.="<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-offset-1'>";
							    $tabla.="<div class='col-xs-5 col-sm-4 col-md-5 col-lg-5>'";
								$tabla.="<a id_red_social='$datos[id_red_social]' onclick='javascript: $(this).e_redes();'><span class='glyphicon glyphicon-edit funcionesredes'></span></a>";
								$tabla.="</div>";
								$tabla.="<div class='col-xs-6 col-sm-4 col-sm-offset-3 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-1'>";
  								$tabla.="<a href='eliminar_redes?id=".base64_encode($datos['id_red_social'])."'> <span class='glyphicon glyphicon-remove funcionesredes'></span></a>";
  								$tabla.="</div>";
  								$tabla.="</div>'";
  								$tabla.="</td>";
							    $tabla.="</tr>";
								}
								print($tabla);
								$PDO = null;
							?>
							</tbody>
						</table>
					</div>
				</div>
    		</div>
    	</div>
    </div>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>