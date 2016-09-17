<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
	ob_start();
	//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	//require("../lib/validator.php");
	//!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
	require("../lib/page-privado.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	//Page::header("Valores");
  	$permisos = Page::header("Valores", "valores");
  if(!empty($_POST)){
  	try{
	    $action = $_POST['action'];
	    if ( $action != "Buscar" ){
	    	$valor = $_POST['txtvalor'];
		    $descripcion = $_POST['txtdescripcion'];
		    $id_valor = $_POST['id_valor'];
		    require("../sql/conexion.php");
		    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		   	//Validar
		   	require("../lib/validator.php");
		   	if ( Validator::numeros_letras( $valor ) && Validator::numeros_letras( $descripcion )  ){
			    if ( $action == "Agregar" ){
			    	if ( ! Validator::permiso_agregar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
			    	else
			    	{
				        $sql = "INSERT INTO valores(valor,descripcion) values(?, ?)";            
				        $stmt = $PDO->prepare($sql);
				        $exito = $stmt->execute(array ($valor, $descripcion ) );
				        //Ejecutar procedimiento para bitacora ='}'
			            $con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
			        	$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 20 , 1, $sql ) );
				        //if ( $stmt == 1 ) call inserta_bitacora ( $_SESSION['id_empleado'] , 12, 1, $consulta );
				        $PDO = null;
			 	   }
				}
			    else if ( $action == "Editar" ){
			    	$id_valor = $_POST['id_valor'];
			    	if ( Validator::numero( $id_valor ) ){
			    		if ( ! Validator::permiso_modificar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
			    		else
			    		{
							$sql = "update valores set valor=?, descripcion=? where id_valor=?";
							$stmt = $PDO->prepare($sql);
							$exito = $stmt->execute(array ( $valor, $descripcion, $id_valor ) );
							//Ejecutar procedimiento para bitacora ='}'
							$con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
							$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 20 , 2, $sql ) );
							// if ( $stmt == 1 ) call inserta_bitacora ( $_SESSION['id_empleado'] , 12, 2, $consulta );
							$PDO = null;
			    		}
				 
				    }
			    	else $error[] = "Id no valido.";
			    }
			}
			else $error_data = "Error, por favor revise los campos señalados.";
			( ! ( Validator::numeros_letras( $valor ) ) ) ? $error[] = "Valor: Solo se permiten numeros y letras." : "";
			( ! ( Validator::numeros_letras( $descripcion ) ) ) ? $error[] = "Descripción: Solo se permiten numeros y letras." : "";
		}
	}
	catch( Exception $Exception )
	{
		if($Exception->getCode() == 23000){
		$error[] = "Valor ya existente, por favor ingrese una diferente.";
		} 
		else $error[] = $Exception->getMessage();
	}
  }
  	$palabra = '';
	if ( isset($action) && $action == "Agregar" ) $palabra = "añadido";
	else $palabra = "editado";
	print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Valor '.$palabra.' con exito.</div>' : "" );
	print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
	if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
?>

		            		<div class="box-body">
		            		<?php
		            				$palabra = '';
		            				if ( isset($action) && $action == "Agregar" ) $palabra = "añadida";
		            			
		            			?> 
		            			<div class="col-sm-12 col-md-4 col-lg-4 no_padding margenpreguntas">
		            			<input type="hidden" name="id_valor" id="id_valor" />
									<div class="col-sm-12 col-md-12 col-lg-4 margentitulopreguntas">
										<label class="colorpregunta">Valor:</label>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-11 margenpreguntas" >
										<input type="hidden" name=""/>
										<input class="form-control <?php print( ( isset($er_pregunta) ) ? "$er_pregunta": ""); ?>" id="txtvalor" type="text" class="validate" name="txtvalor" placeholder="Ingrese la pregunta..." required />
									</div>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-3 no_padding margenpreguntas">
									<div class="col-sm-12 col-md-12 col-lg-5 margentitulopreguntas">
										<label class="colorpregunta">Descripcion:</label>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-8 margenpreguntas" >
										<input type="hidden" name=""/>
										<textarea id="txtdescripcion" class="form-control col-lg-1 <?php print( ( isset($er_respuesta) ) ? "$er_respuesta": ""); ?>" rows="4" id="comment" name="txtdescripcion" placeholder="Ingrese la respuesta" required ></textarea>
									</div>
								</div>

									<div class="col-xs-6 col-sm-6 col-md-2 col-md-offset-0 col-lg-2 ">
										<br>
										<button id="btn_valor" type="submit" name="action" value="Agregar" class="btn btn-primary size">
									        <span class="glyphicon glyphicon-plus"></span>
									    </button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-2 col-md-offset-0 col-lg-2">
										<br>
										<button id="btncancelarV" type="button" class="btn btn-danger size">
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
										<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe el valor..."/>
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
										$consulta = "SELECT * from valores";      
										if( isset( $_POST['txtBuscar'] ) != "" && Validator::letras( $_POST['txtBuscar'] ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " WHERE valor LIKE '%$busqueda%' order by valor ASC";
							    			}
							    			else $consulta = $consulta . " order by valor ASC";
										$tabla="";
										foreach ($PDO->query($consulta) as $datos) 
										{

									    $tabla.="<tbody id='lista_productos'>";
									    $tabla.="<tr>";
									    $tabla.="<td><div class='valor'>$datos[valor]</div></td>";
									    $tabla.="<td><div class='descripcion'>$datos[descripcion]</div></td>";
									    $tabla.="<td>";
									    $tabla.="<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-offset-3'>";
									    $tabla.="	<div class='col-xs-6 col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-2 col-lg-4 col-lg-offset-0'>";
	  									$tabla.="		<a id_valor='$datos[id_valor]'  onclick='javascript: $(this).e_valor();'><span class='glyphicon glyphicon-edit funcionesdatos'></span></a>";
	  									$tabla.="	</div>";
										$tabla.="	<div class='col-xs-6 col-sm-2 col-sm-offset-3 col-md-1 col-md-offset-2 col-lg-4 col-lg-offset-0'>";
	  									$tabla.="		<a href='eliminar_valor?id=".base64_encode($datos['id_valor'])."'><span class='glyphicon glyphicon-remove funcionesdatos'></span></a>";
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