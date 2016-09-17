<?php
//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
ob_start();
//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	require("../lib/validator.php");
	//!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
	require("../lib/page-privado.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	//Page::header("Editar logo");
  	$permisos = Page::header("Editar logo", "datos");
	$id = null;
	if(!empty($_GET['id'])) 
	{
		$id = $_GET['id'];
	}
	if($id == null) 
	{
	// header("location: productos.php");
	}
	if(!empty($_POST))
	{
		$action = $_POST['action'];
		if ( $action != "Buscar" )
		{
			$imagen = $_FILES['imagen'];
			$imagen_antigua = $_POST['imagen_antigua'];
			//	$id_presentacion = $_POST['id_presentacion'];
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
						if ( $action == 'Editar' ) 
						$nuevo_id = 'logo'; //Esto sirve para darle un nombre único a cada archivo de imagen.
						$nombre_archivo = $imagen['tmp_name'];
						$imagen_producto = $nuevo_id.".png";
						$destino = "../img/$imagen_producto";
						move_uploaded_file($nombre_archivo, $destino); //Función para subir archivos al servidor.

						//Si esta editando o agregando ='DDD
						try
						{
							if ( $action == "Agregar" )
							{	
							$error[] = "Seleccione una imagen para cambiar el logo";
							}
							else if ( $action == "Editar" )
							{
								//Editae los datos ='DD
								
								$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								$id_red_social = $_POST['id_red_social'];
								if ( Validator::numero( $id_red_social ) )
								{
									//echo "<a>$id_red_social hola </a>";
									if ( ! Validator::permiso_modificar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
									else
									{
										$sql = "UPDATE datos set logo=?  where id_dato=?";//, tipo_imagen=?
										$stmt = $PDO->prepare($sql);
										$exito = $stmt->execute(array ($imagen_producto,$id_red_social ));
										//Ejecutar procedimiento para bitacora ='}'
										$con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
										$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 4 , 2, $sql ) );
										//if ( $stmt == 1 ) call inserta_bitacora ( $_SESSION['id_empleado'] , 15, 2, $consulta );
										$PDO = null;
									}
									//header("location: productos.php");
								}
								else $error[] = "Seleccione el logo a editar" ;
							}


						}
						catch (Exception $Exception) 
						{
							$error[] = $Exception->getMessage();
						} 
					}else	
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
			$error[] = "Debe seleccionar una imagen para editar el logo.";
			}
		}
	}
	$palabra = '';
	if ( isset($action) && $action == "Agregar" ) $palabra = "añadido";
	else $palabra = "editado";
	print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Logo '.$palabra.' con exito.</div>' : "" );
	print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
	if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
?>


		            		<div class="box-body">
		          			 	<div class="col-xs-5 col-xs-offset-4 col-sm-4 col-sm-offset-0 col-md-2 col-md-offset-0 col-lg-2 col-lg-offset-0">
                                    <img src="../img/logo.png" alt="Error al cargar imagen" class="margenimagenRR margenimagenR imagen_red img-responsive" id="	">
                                    	<input type="hidden" name="imagen_antigua" id="imagen_antigua" />
                                </div>
		            			<div class="col-xs-12 col-sm-9 col-sm-offset-0 col-md-8 col-lg-6  no_padding margenredes">
									<input type="hidden" name="id_red_social" id="id_red_social" />
									<div class="file-field input-field buscarimagen">
		                                <div id="Rbtnimagen" class="margenred btn grey darken-3 col-xs-offset-3  col-xs-12  col-lg-12 col-lg-offset-1 col-md-2 col-md-offset-0 col-sm-12 col-sm-offset-0">
		                                    <input name="imagen" type="file" id="pro_img_url"/>
		                                </div>
	                            	</div>
								</div>

									<div class="col-xs-offset-2  col-xs-7 col-sm-offset-0 col-sm-4 col-md-2 col-md-offset-0 col-lg-2 col-lg-offset-0">
										<br>
										<button id="btn_redes" type="submit" name="action" value="Editar" class="btn btn-primary size col-xs-12 col-sm-10 col-sm-offset-0 col-md-12 col-lg-12 col-lg-offset-0">
									        <span class="glyphicon glyphicon-edit"></span>
									    </button>
									</div>
									<div class="col-xs-offset-2 col-sm-offset-0  col-xs-7 col-sm-4 col-md-2 col-md-offset-0 col-lg-2 col-lg-offset-0">
										<br>
										<button id="" type="button" class="btn btn-danger size col-xs-12 col-sm-12 col-sm-offset-0 col-md-12 col-lg-12">
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
	        		
						<?php
			            require("../sql/conexion.php");
			            if(isset($_GET['txtbuscar_red']) != "")
			            {
			                $buscar = $_GET['txtbuscar_red'];
			                $consulta = "SELECT logo_red_social,url_red_social FROM redes_sociales WHERE url_red_social LIKE '%$buscar%'";
			            }
			            else
			            {
			                $consulta = "SELECT logo_red_social,url_red_social FROM redes_sociales";
			            }
			            ?>

						<!--consulta de redes-->
						<div class="box-body table-responsive">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<table class="table table-bordered table-hover conf_tabla">
								    <thead>
								        <tr>
								            <th class="col-sm-3 col-md-3 col-lg-3 s">Icono</th>
								            <th class="col-sm-3 col-md-3 col-lg-3 s">Nombre</th>
								            <th class="col-sm-3 col-md-3 col-lg-3 s">Funciones</th>
								        </tr>
								    </thead>
								    <?php
									    require("../sql/conexion.php");
										$consulta = "SELECT * from datos";      
										$tabla="";
										foreach ($PDO->query($consulta) as $datos) 
										{

									    $tabla.= "<tbody id='lista_productos'>";
									    $tabla.= "<tr>";
									    $tabla.="<div class='col-sm-12 col-md-12 col-lg-12 col-lg-offset-2'>";
									    $tabla.="<td width='0px'><img src='../img/$datos[logo]' alt='Error al cargar imagen' class='iconoredes img-responsive'></td>";
									    //$tabla.="<input type='hidden' name='imagen_antigua' id='imagen_antigua' />";
									    $tabla.="</div>";
									    $tabla.="<td><div class='linkredes colorredes'>$datos[logo] </div></td>";
									    $tabla.="<td> ";
									    $tabla.="<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-offset-1'>";
									    $tabla.="<div class='col-xs-5 col-sm-4 col-md-5 col-lg-5>'";
										$tabla.="<a id_red_social='$datos[id_dato]' onclick='javascript: $(this).e_redes();'><span class='glyphicon glyphicon-pencil funcionesredes'></span></a>";
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