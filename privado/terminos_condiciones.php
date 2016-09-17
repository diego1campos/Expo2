<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
	ob_start();
	//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	require("../lib/validator.php");
	//!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
	require("../lib/page-privado.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	//Page::header("Terminos y condiciones");
  	$permisos = Page::header("Terminos y condiciones", "terminos_condiciones");
  if(!empty($_POST)){
  	try{
	    $action = $_POST['action'];
	    if ( $action != "Buscar" ){
	    	$termino = $_POST['txttermino'];
		    $descripcion = $_POST['txtdescripcion'];
		    $id_termino = $_POST['id_termino'];
		    require("../sql/conexion.php");
		    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		   	//Validar
		  
		   	if ( Validator::numeros_letras( $termino ) && Validator::numeros_letras( $descripcion )  ){
			    if ( $action == "Agregar" ){
			    	if ( ! Validator::permiso_agregar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
			    	else
			    	{
						$sql = "INSERT INTO terminos_condiciones(termino,descripcion) values(?, ?)";            
						$stmt = $PDO->prepare($sql);
						$exito = $stmt->execute(array ($termino, $descripcion ) );
						//Ejecutar procedimiento para bitacora ='}'
						$con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
						$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 17 , 1, $sql ) );
						//if ( $stmt == 1 ) call inserta_bitacora ( $_SESSION['id_empleado'] , 12, 1, $consulta );
						$PDO = null;
			    	}
			     
			    }
			    else if ( $action == "Editar" ){
			    	$id_termino = $_POST['id_termino'];
			    	if ( Validator::numero( $id_termino ) ){
		    		  	if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
		    		  	else
		    		  	{
							$sql = "update terminos_condiciones set termino=?, descripcion=? where id_termino_condicion=?";
							$stmt = $PDO->prepare($sql);
							$exito = $stmt->execute(array ( $termino, $descripcion, $id_termino ) );
							//Ejecutar procedimiento para bitacora ='}'
							$con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
							$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 17 , 2, $sql ) );
							// if ( $stmt == 1 ) call inserta_bitacora ( $_SESSION['id_empleado'] , 12, 2, $consulta );
							$PDO = null;
			 	   		}
				}
			    	else $error[] = "Id no valido.";
			    }
			}
			else $error_data = "Error, por favor revise los campos señalados.";
		  	( ! ( Validator::numeros_letras( $termino ) ) ) ? $error[] = "Termino: Solo se permiten numeros y letras." : "";
			( ! ( Validator::numeros_letras( $descripcion ) ) ) ? $error[] = "Descripción: Solo se permiten numeros y letras." : "";
		}
	}
	catch( Exception $Exception )
	{
		if($Exception->getCode() == 23000){
		$error[] = "Termino y descripción ya existente, por favor ingrese uno diferente.";
		} 
		else $error[] = $Exception->getMessage();
		
	}
  }
  	$palabra = '';
	if ( isset($action) && $action == "Agregar" ) $palabra = "añadido";
	else $palabra = "editado";
	print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Termino '.$palabra.' con exito.</div>' : "" );
	print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
	if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
?>

		            		<div class="box-body">
		            	
		            			<div class="col-sm-12 col-md-4 col-lg-4 no_padding margenpreguntas">
		            			<input type="hidden" name="id_termino" id="id_termino" />
									<div class="col-sm-12 col-md-12 col-lg-4 margentitulopreguntas">
										<label class="colorpregunta">Termino:</label>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-11 margenpreguntas" >
										<input type="hidden" name="id_categoria"/>
										<input class="form-control <?php print( ( isset($er_pregunta) ) ? "$er_pregunta": ""); ?>" id="txttermino" type="text" class="validate" name="txttermino" placeholder="Ingrese la pregunta..."  required />
									</div>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-3 no_padding margenpreguntas">
									<div class="col-sm-12 col-md-12 col-lg-5 margentitulopreguntas">
										<label class="colorpregunta">descripción:</label>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-8 margenpreguntas" >
										<input type="hidden" name="id_categoria"/>
										<textarea id="txtdescripcion" class="form-control col-lg-1 <?php print( ( isset($er_respuesta) ) ? "$er_respuesta": ""); ?>" rows="4" id="comment" name="txtdescripcion" placeholder="Ingrese la respuesta" required></textarea>
									</div>
								</div>

									<div class="col-xs-6 col-sm-6 col-md-2 col-md-offset-0 col-lg-2 ">
										<br>
										<button id="btn_termino" type="submit" name="action" value="Agregar" class="btn btn-primary size">
									        <span class="glyphicon glyphicon-plus"></span>
									    </button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-2 col-md-offset-0 col-lg-2">
										<br>
										<button id="btncancelarTC" type="button" class="btn btn-danger size">
									        <span class="glyphicon glyphicon-ban-circle"></span>
									    </button>
									    <br>
									    <br>
							
						
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
								<table class="table table-bordered table-hover" id="tabla_productos">
								    <thead>
								        <tr>
								            <th class="col-sm-3 col-md-3 col-lg-3">Termino</th>
								            <th class="col-sm-3 col-md-3 col-lg-3">Descripción</th>
								            <th class="col-sm-3 col-md-3 col-lg-3">Acciones</th>
								        </tr>
								    </thead>
								    <?php
									    require("../sql/conexion.php");
										$consulta = "SELECT * from terminos_condiciones"; 
										if( isset( $_POST['txtBuscar'] ) != "" && Validator::numeros_letras( $_POST['txtBuscar'] ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " WHERE termino LIKE '%$busqueda%' order by termino ASC";
							    			}
							    			else $consulta = $consulta . " order by termino ASC";     
										$tabla="";
										foreach ($PDO->query($consulta) as $datos) 
										{

									    $tabla.="<tbody id='lista_productos'>";
									    $tabla.="<tr>";
									    $tabla.="<td><div class='terminos'>$datos[termino]</div></td>";
									    $tabla.="<td><div class='descripcion'>$datos[descripcion]</div></td>";
									    $tabla.="<td>";
									    $tabla.="<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-offset-3'>";
									    $tabla.="	<div class='col-xs-6 col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-2 col-lg-4 col-lg-offset-0'>";
	  									$tabla.="		<a id_termino_condicion='$datos[id_termino_condicion]'  onclick='javascript: $(this).e_termino_condicion();'><span class='glyphicon glyphicon-edit funcionesdatos'></span></a>";
	  									$tabla.="	</div>";
										$tabla.="	<div class='col-xs-6 col-sm-2 col-sm-offset-3 col-md-1 col-md-offset-2 col-lg-4 col-lg-offset-0'>";
	  									$tabla.="		<a href='eliminar_terminos?id=".base64_encode($datos['id_termino_condicion'])."'><span class='glyphicon glyphicon-remove funcionesdatos'></span></a>";
	  									$tabla.="	</div>";
	  									$tabla.="</div>";
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