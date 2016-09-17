<?php
	ob_start();
	//Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page-privado.php");
	//Por el antiguo metodo de conectar con la base :)
	require("../sql/conexion.php");

	$permisos = Page::header("Preguntas de seguridad", "preguntas");

  if(!empty($_POST)){
    $action = $_POST['action'];
    if ( $action != "Buscar" ){
    	$pregunta = $_POST['txtpregunta'];
	    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    try{
		   	if ( Validator::letras( $pregunta ) ){
			    if ( $action == "Agregar" ){
			    	if ( ! Validator::permiso_agregar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
					else {
				        $sql = "INSERT INTO preguntas(pregunta) values(?)";            
				        $stmt = $PDO->prepare($sql);
				        $exito = $stmt->execute(array ( $pregunta ) );
				        $PDO = null;
				        if ( $exito == 1 ) Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 12, 1, $sql ) );
				    }
			    }
			    else if ( $action == "Editar" ){
			    	$id_pregunta = $_POST['id_pregunta'];
			    	if ( Validator::numero( $id_pregunta ) ){
			    		if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
						else {
					        $sql = "update preguntas set pregunta=? where id_pregunta=?";
					        $stmt = $PDO->prepare($sql);
					        $exito = $stmt->execute(array ( $pregunta, $id_pregunta ) );
					        $PDO = null;
					        if ( $exito == 1 ) Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 12, 2, $sql ) );
					    }
				    }
			    	else $error[] = "Id no valido.";
			    }
			}
			else $error_data = "Error, por favor revise los campos señalados.";
			( ! ( Validator::letras( $pregunta ) ) ) ? $error[] = "Pregunta: solo se permiten letras" : "";
		}
		catch( Exception $Exception ){
   			if ( $Exception->getCode() == 23000 ){
   				$error[] = "Pregunta ya existente, por favor ingrese otra.";
   			}
			else $error[] = $Exception->getMessage();
		}
	}
  }

		            				$palabra = '';
		            				if ( isset($action) && $action == "Agregar" ) $palabra = "añadida";
		            				else $palabra = "editada";
		            				print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Pregunta '.$palabra.' con exito.</div>' : "" );
		            				print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
		            				if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
		            			?> 
		            			<div class="col-sm-4 col-md-4 col-lg-4 no_padding">
									<div class="col-sm-12 col-md-12 col-lg-12">
										<label class="">Pregunta</label>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
										<input type="hidden" name="id_pregunta" id="id_pregunta" />
										<input class="form-control <?php print( ( isset($er_categoria) ) ? "$er_categoria": ""); ?>" id="txtpregunta" type="text" class="validate" name="txtpregunta" placeholder="Ingrese aquí..."/>
									</div>
								</div>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button id="btn_pregunta" type="submit" name="action" value="Agregar" class="btn btn-primary size">
									        <span class="glyphicon glyphicon-plus"></span>
									    </button>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button id="btn-c_pregunta" type="button" class="btn btn-danger size">
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
									            <th class="col-sm-8 col-md-8 col-lg-8">Preguntas</th>
									            <th class="col-sm-4 col-md-4 col-lg-4">Acciones</th>
									        </tr>
									    </thead>
									    <tbody>
										<?php
											require("../sql/conexion.php");
											$consulta = "SELECT * FROM preguntas";
											if( isset( $_POST['txtBuscar'] ) != "" && Validator::letras( $_POST['txtBuscar'] ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " where pregunta LIKE '%$busqueda%' order by pregunta ASC";
							    			}
							    			else $consulta = $consulta . " order by pregunta ASC";
											$productos = ""; //Arreglo de datos
											foreach($PDO->query($consulta) as $datos){
												$productos .= "<tr>";
													$productos .= "<td class='pregunta'>$datos[pregunta]</td>";
													$productos .= '<td class="text-center"><a id_pregunta="'.$datos['id_pregunta'].'" class="glyphicon glyphicon-edit padding_right_ico icono_tamano up" onclick="$(this).e_pregunta();"></a><a href="eliminar_pregunta?id='.$datos['id_pregunta'] .'" class="glyphicon glyphicon-remove-circle icono_tamano"></a></td>';
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