<?php
//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
ob_start();
//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	require("../lib/validator.php");
	//!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
	require("../lib/page-privado.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	//Page::header("Imagenes indice");
  	$permisos = Page::header("Imagenes index", "index_imagenes");

	if(!empty($_POST)){
		try{
			$action = $_POST['action'];
			if ( $action != "Buscar" ){
				$imagen = $_FILES['pro_img_url'];
				$imagen_antigua = $_POST['imagen_antigua'];
			//	$id_presentacion = $_POST['id_presentacion'];
			}
			if($imagen['name'] == null && $action == 'Editar'){
				//Editae los datos ='DD
				require("../sql/conexion.php");
				$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$id_img_producto = $_POST['id_imagen'];
		        $sql = "update index_imagenes set imagen=? where id_imagen=?";//, tipo_imagen=?
		        //Ejecutar procedimiento para bitacora ='}'
		            $con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
		        	$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 21 , 2, $sql ) );
		        $stmt = $PDO->prepare($sql);
		        $stmt->execute(array($imagen) );
		        //if ( $stmt == 1 ) call inserta_bitacora ( $_SESSION['id_empleado'] , 10, 2, $consulta );
		        $PDO = null;
			}
			else{
		    	require("../sql/conexion.php");
		   
		        //Validacion de logo ='DD
		        if ( $imagen['name'] != null ){
		        	if($imagen['type'] == "image/jpeg" || $imagen['type'] == "image/png" || $imagen['type'] == "image/x-icon" || $imagen['type'] == "image/gif"){
			        	$info_imagen = getimagesize( $imagen['tmp_name'] );
			        	$ancho_imagen = $info_imagen[0];
						$alto_imagen = $info_imagen[1];
					
							if ( $action == 'Editar' ) unlink("$imagen_antigua"); //Función para eliminar la imagen anterior.
							$nuevo_id = uniqid(); //Esto sirve para darle un nombre único a cada archivo de imagen.
					        $nombre_archivo = $imagen['tmp_name'];
					        $imagen_producto = $nuevo_id.".png";
					        $destino = "../img/slider_index/$imagen_producto";
					        move_uploaded_file($nombre_archivo, $destino); //Función para subir archivos al servidor.
				    	
					        //Si esta editando o agregando ='DDD
					        if ( $action == "Agregar" ){//Agrego los datos ='DD
					        	if ( ! Validator::permiso_agregar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
					        	else
					        	{
									$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$sql = "INSERT INTO index_imagenes(imagen) values(?)"; 
									$stmt = $PDO->prepare($sql);
									$exito = $stmt->execute(array ($imagen_producto) );
									//Ejecutar procedimiento para bitacora ='}'
									$con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
									$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 21 , 1, $sql ) );
									$PDO = null;
									//header("location: productos.php");	
					        	}
				
						    }
					        else if ( $action == "Editar" ){
					        	if ( ! Validator::permiso_modificar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
						        else
						        {
									//Editae los datos ='DD
									$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$id_img_producto = $_POST['id_imagen'];
									//echo "<a>$id_red_social hola </a>";
									if ( Validator::numero( $id_img_producto ) ){
									$sql = "UPDATE index_imagenes set imagen=? where id_imagen=?";//, tipo_imagen=?
									$stmt = $PDO->prepare($sql);
									$exito = $stmt->execute(array ($imagen_producto, $id_img_producto ) );
									//Ejecutar procedimiento para bitacora ='}'
									$con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
									$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 21 , 2, $sql ) );
									$PDO = null;
									//header("location: productos.php");
						        }
						     else $error = "Id no valido.";
						    }
						    
					    }
				
					}
					else{
						$error[] = "El tipo de imagen no es valido.";
					}
		    	}
		    	else{
					$error[] = "Debe seleccionar una imagen.";
				}
		    }
		}
		catch( Exception $Exception ){
		$error = $Exception->getMessage();
	}
}

	$palabra = '';
	if ( isset($action) && $action == "Agregar" ) $palabra = "añadida";
	else $palabra = "editada";
	print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Imagen '.$palabra.' con exito.</div>' : "" );
	print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
	if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
?>

							<div class="box-body">		
										
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no_padding">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no_padding">
										<input type="hidden" id="id_imagen" name="id_imagen" />
										<!--Ya que ocupe javascript para obtener los datos xd, si no que solo los pase xd-->
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<img src="../img/logo.png" class="img-responsive imagen_index" name="pro_img" id="imagen_indexx"/>
											<input type="hidden" name="imagen_antigua" id="imagen_antigua" />
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-lg-offset-0">
											<br>
											<input name="pro_img_url" id="pro_img_url" type="file" required/>
										</div>
									</div>
								</div>
									<div class="col-xs-6 col-sm-6 col-md-3 col-md-offset-3 col-lg-3 col-lg-offset-3">
										<br>
										<button type="submit" name="action" class="btn btn-primary size" value="Agregar" id="btna_imagen">
									        <span class="glyphicon glyphicon-plus"></span>
									    </button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3  col-lg-offset-0">
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
				<div class="row">
		    		<div class="col-xs-12">
		        		<div class="box">
		        			<div class="box-body">
		        		
								
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
									            <th class="col-sm-6 col-md-6 col-lg-6">Imagen</th>
									            <th class="col-sm-3 col-md-3 col-lg-3">Accion</th>
									        </tr>
									    </thead>
									    <tbody>
											<?php
									    require("../sql/conexion.php");
										$consulta = "SELECT * from index_imagenes";      
										$tabla="";
										foreach ($PDO->query($consulta) as $datos) 
										{

									    $tabla.= "<tbody id='lista_productos'>";
									    $tabla.= "<tr>";
									    $tabla.="<div class='col-sm-12 col-md-12 col-lg-0 col-lg-offset-0'>";
									    $tabla.="<td width='0px'><img src='../img/slider_index/$datos[imagen]' alt='Error al cargar imagen' class='col-lg-offset-0 img-responsive imagen_index1'></td>";
									    $tabla.="</div>";
									    $tabla.="<td> ";
									    $tabla.="<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-offset-1 a'>";
									    $tabla.="<div class='col-xs-2 col-sm-4 col-md-5 col-lg-5>'";
										$tabla.="<a id_imagen='$datos[id_imagen]' onclick='javascript: $(this).e_imagen_index();'> <span class='glyphicon glyphicon-edit funcionesimagenesindex'></span></a>";
										$tabla.="</div>";
										$tabla.="<div class='col-xs-2 col-xs-offset-1 col-sm-4 col-sm-offset-3 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-1'>";
	  									$tabla.="<a href='eliminar_imagen_index?id=".base64_encode($datos['id_imagen'])."'> <span class='glyphicon glyphicon-remove funcionesimagenesindex'></span></a>";
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