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
	$permisos = Page::header("Presentaciones", "presentaciones");
	
  if(!empty($_POST)){
    $action = $_POST['action'];
    if ( $action != "Buscar" ){
    	$presentacion = $_POST['txtpresentacion'];
	    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    try{
		    if ( Validator::letras( $presentacion ) ){
			    if ( $action == "Agregar" ){
			    	if ( ! Validator::permiso_agregar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
					else {
				        $sql = "INSERT INTO presentaciones (presentacion) values(?)";            
				        $stmt = $PDO->prepare($sql);
				        $exito = $stmt->execute(array ( $presentacion ) );
				        $PDO = null;
				        //Ejecutar procedimiento para bitacora ='}'			        
				        Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 14 , 1, $sql ) );
				    }
			    }
			    else if ( $action == "Editar" ){
			    	$id_presentacion = $_POST['id_presentacion'];
			    	if ( Validator::numero( $id_presentacion ) ){
			    		if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
						else {
					        $consulta = "update presentaciones set presentacion=? where id_presentacion=?";
					        $stmt = $PDO->prepare($consulta);
					        $exito = $stmt->execute(array ( $presentacion, $id_presentacion ) );
					        $PDO = null;
					        Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 14 , 2, $consulta ) );
					    }
				    }
				    else $error[] = "Id no valido.";
			    }
			}
			else $error_data = "Error, por favor revise los campos señalados.";
			( ! ( Validator::letras( $presentacion ) ) ) ? $error[] = "Presentación: seleccione una presentación." : "";
		}
		catch( Exception $Exception ){
	        if($Exception->getCode() == 23000)
	        {
	        	$error[] = "Presentacion ya existente, por favor ingrese otra.";
	        }
	        else $error[] = $Exception->getMessage();
		}
	}
  }
    
		            				$palabra = '';
		            				if ( isset($action) && $action == "Agregar" ) $palabra = "añadida";
		            				else $palabra = "editada";
		            				print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Presentación '.$palabra.' con exito.</div>' : "" );
		            				print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
		            				if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
		            			?>
		            			<div class="col-sm-4 col-md-4 col-lg-4 no_padding">
									<div class="col-sm-12 col-md-12 col-lg-12">
										<label class="">Presentación</label>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
										<input type="hidden" name="id_presentacion" id="id_presentacion" />
										<input class="form-control <?php print( ( isset($er_presentacion) ) ? "$er_presentacion": ""); ?>" id="txtpresentacion" type="text" class="validate" name="txtpresentacion" placeholder="Ingrese aquí..."/>
									</div>
								</div>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button id="btn_presentacion" type="submit" name="action" value="Agregar" class="btn btn-primary size">
									        <span class="glyphicon glyphicon-plus"></span>
									    </button>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button id="btn-c_presentacion" type="button" class="btn btn-danger size">
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
										<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe la presentación..."/>
									</div>
								</div>
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
									            <th class="col-sm-8 col-md-8 col-lg-8">Presentacion</th>
									            <th class="col-sm-4 col-md-4 col-lg-4">Acciones</th>
									        </tr>
									    </thead>
									    <tbody>
										<?php
											require("../sql/conexion.php");
											$consulta = "SELECT * FROM presentaciones";
											if( isset( $_POST['txtBuscar'] ) != "" && Validator::letras( $_POST['txtBuscar'] ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " where presentacion LIKE '%$busqueda%' order by presentacion ASC";
							    			}
							    			else $consulta = $consulta . " order by presentacion ASC";
											$productos = ""; //Arreglo de datos
											foreach($PDO->query($consulta) as $datos){
												$productos .= "<tr>";
													$productos .= "<td class='presentacion'>$datos[presentacion]</td>";
													$productos .= '<td class="text-center"><a id_presentacion="'.$datos['id_presentacion'].'" class="up glyphicon glyphicon-edit padding_right_ico icono_tamano" onclick="$(this).e_presentacion();"></a><a href="eliminar_presentacion?id='.base64_encode( $datos['id_presentacion'] ).'" class="glyphicon glyphicon-remove-circle icono_tamano"></a></td>';
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