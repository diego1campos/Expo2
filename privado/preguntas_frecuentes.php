<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
	ob_start();
	//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	require("../lib/validator.php");
	//!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
	require("../lib/page-privado.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	//Page::header("Preguntas frecuentes");
  	$permisos = Page::header("Preguntas frecuentes", "preguntas_frecuentes");
  if(!empty($_POST)){
  	try{
	    $action = $_POST['action'];
	    if ( $action != "Buscar" ){
	    	$pregunta = $_POST['txtpregunta'];
		    $respuesta = $_POST['txtrespuesta'];
		    $id_pregunta = $_POST['id_pregunta'];
		    require("../sql/conexion.php");
		    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		   	//Validar
		 
		   	if ( Validator::preguntas( $pregunta ) && Validator::numeros_letras( $respuesta )  )
		   	{
			    if ( $action == "Agregar" ){
			    	if ( ! Validator::permiso_agregar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
			    	else
			    	{
				        $sql = "INSERT INTO preguntas_frecuentes(pregunta,respuesta) values(?, ?)";            
				        $stmt = $PDO->prepare($sql);
				        $exito = $stmt->execute(array ($pregunta, $respuesta ) );
				        //Ejecutar procedimiento para bitacora ='}'
			            $con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
			        	$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 13 , 1, $sql ) );
				        //if ( $stmt == 1 ) call inserta_bitacora ( $_SESSION['id_empleado'] , 12, 1, $consulta );
				        $PDO = null;
			    	}
			    }
			    else if ( $action == "Editar" ){
			    	$id_pregunta = $_POST['id_pregunta'];
			    	if ( Validator::numero( $id_pregunta ) )
			    	{
			    		if ( ! Validator::permiso_modificar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
			    		else
			    		{
							$sql = "update preguntas_frecuentes set pregunta=?, respuesta=? where id_pregunta_frecuente=?";
							$stmt = $PDO->prepare($sql);
							$exito = $stmt->execute(array ( $pregunta, $respuesta, $id_pregunta ) );
							//Ejecutar procedimiento para bitacora ='}'
							$con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
							$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 13 , 2, $sql ) );
							// if ( $stmt == 1 ) call inserta_bitacora ( $_SESSION['id_empleado'] , 12, 2, $consulta );
							$PDO = null;
			    		}
				  
				    }
			    	else $error[] = "Id no valido.";
			    }
			}
			else $error_data = "Error, por favor revise los campos señalados.";
		    	
			( ! ( Validator::preguntas( $pregunta ) ) ) ? $error[] = "Pregunta: Solo se permiten numeros, letras y signos de interrogación." : "";
			( ! ( Validator::numeros_letras( $respuesta ) ) ) ? $error[] = "Respuesta: Solo se permiten numeros y letras." : "";
		}
	}
	catch( Exception $Exception )
	{
		if($Exception->getCode() == 23000){
		$error[] = "Pregunta o Respuesta ya existente, por favor ingrese una diferente.";
		} 
		else $error[] = $Exception->getMessage();
	}
  }
	
	$palabra = '';
	if ( isset($action) && $action == "Agregar" ) $palabra = "añadida";
	else $palabra = "editada";
	print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Pregunta '.$palabra.' con exito.</div>' : "" );
	print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
	if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
  
?>

		            		<div class="box-body">
		            	
		            			<div class="col-sm-12 col-md-4 col-lg-4 no_padding margenpreguntas">
		            			<input type="hidden" name="id_pregunta" id="id_pregunta" />
									<div class="col-sm-12 col-md-12 col-lg-4 margentitulopreguntas">
										<label class="colorpregunta">Pregunta:</label>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-11 margenpreguntas" >
										<input type="hidden" name="id_categoria"/>
										<input class="form-control <?php print( ( isset($er_pregunta) ) ? "$er_pregunta": ""); ?>" id="txtpregunta" type="text" class="validate" name="txtpregunta" placeholder="Ingrese la pregunta..."/>
									</div>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-3 no_padding margenpreguntas">
									<div class="col-sm-12 col-md-12 col-lg-5 margentitulopreguntas">
										<label class="colorpregunta">Respuesta:</label>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margenpreguntas" >
										<input type="hidden" name="id_categoria"/>
										<textarea id="txtrespuesta" class="form-control col-lg-1 <?php print( ( isset($er_respuesta) ) ? "$er_respuesta": ""); ?>" rows="4" id="comment" name="txtrespuesta" placeholder="Ingrese la respuesta" autocomplete="off" ></textarea>
									</div>
								</div>

									<div class="col-xs-6 col-sm-6 col-md-2 col-md-offset-0 col-lg-2 ">
										<br>
										<button id="btn_preguntas_frecuentes" type="submit" name="action" value="Agregar" class="btn btn-primary size">
									        <span class="glyphicon glyphicon-plus"></span>
									    </button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-2 col-md-offset-0 col-lg-2">
										<br>
										<button id="btncancelarP" type="button" class="btn btn-danger size">
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
								            <th class="col-sm-3 col-md-3 col-lg-3">Pregunta</th>
								            <th class="col-sm-3 col-md-3 col-lg-3">Respuesta</th>
								            <th class="col-sm-3 col-md-3 col-lg-3">Acciones</th>
								        </tr>
								    </thead>
								    <?php
									    require("../sql/conexion.php");
										$consulta = "SELECT * from preguntas_frecuentes"; 
										if( isset( $_POST['txtBuscar'] ) != "" && Validator::preguntas( $_POST['txtBuscar'] ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " WHERE pregunta LIKE '%$busqueda%' order by pregunta ASC";
							    			}
							    			else $consulta = $consulta . " order by pregunta ASC";         
										$tabla="";
										foreach ($PDO->query($consulta) as $datos) 
										{

									    $tabla.="<tbody id='lista_productos'>";
									    $tabla.="<tr>";
									    $tabla.="<td><div class='pregunta'>$datos[pregunta]</div></td>";
									    $tabla.="<td><div class='respuesta'>$datos[respuesta]</div></td>";
									    $tabla.="<td>";
									    $tabla.="<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-offset-3'>";
									    $tabla.="	<div class='col-xs-6 col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-2 col-lg-4 col-lg-offset-0'>";
	  									$tabla.="		<a id_pregunta_frecuente='$datos[id_pregunta_frecuente]' onclick='javascript: $(this).e_pregunta_frecuentes();'><span class='glyphicon glyphicon-edit funcionesdatos'></span></a>";
	  									$tabla.="	</div>";
										$tabla.="	<div class='col-xs-6 col-sm-2 col-sm-offset-3 col-md-1 col-md-offset-2 col-lg-4 col-lg-offset-0'>";
	  									$tabla.="		<a href='eliminar_preguntas_frecuentes?id=".base64_encode($datos['id_pregunta_frecuente'])."'><span class='glyphicon glyphicon-remove funcionesdatos'></span></a>";
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