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
  	$permisos = Page::header("Existencias", "existencias");
   
   if( !empty( $_GET['id'] ) && Validator::numero( base64_decode( $_GET['id'] ) ) ){
        $id_producto = base64_decode( $_GET['id'] );
        $consulta = "select * from productos where id_producto = ?";
        $data_producto = Database::getRow( $consulta, array( $id_producto ) );
	   if ( $data_producto != null ){//Si este id_producto _GET es valido de un producto

		  if ( !empty( $_POST ) ){
		    $action = $_POST['action'];
		    if ( $action != "Buscar" ){
			    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			   	try{
		   		   	if ( isset( $_POST['existencias'] ) && isset( $_POST['id_presentacion'] )  && Validator::numero( $_POST['id_presentacion'] ) && Validator::numero( $_POST['existencias'] ) && $_POST['existencias'] >= 1 ){
		   		   		$id_presentacion = $_POST['id_presentacion'];
		    			$existencias = $_POST['existencias'];
		   			    if ( $action == "Agregar" ){
		   			    	if ( ! Validator::permiso_agregar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
        					else {
			   			        $sql = "INSERT INTO existencias( id_producto, id_presentacion, existencias ) values(?, ?, ?)";            
			   			        $stmt = $PDO->prepare($sql);
			   			        $exito = $stmt->execute(array ( $id_producto, $id_presentacion, $existencias ) );
			   			        $PDO = null;
			   			        Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 9 , 1, $sql ) );
			   			    }
		   			    }
		   			    else if ( $action == "Editar" ){
		   			    	$id_existencia = $_POST['id_existencia'];
		   			    	if ( Validator::numero( $id_existencia ) ){
		   			    		if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
        						else {
			   				        $sql = "update existencias set id_producto=?, id_presentacion = ?, existencias=? where id_existencia=?";
			   				        $stmt = $PDO->prepare($sql);
			   				        $exito = $stmt->execute(array ( $id_producto, $id_presentacion, $existencias, $id_existencia ) );
			   				        $PDO = null;
			   				        Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 9 , 2, $sql ) );
			   				    }
		   				    }
		   			    	else $error[] = "Id existencia no valido.";
		   			    }
		   			}
		   			else $error_data = "Error, por favor revise los campos señalados.";
		   			( isset( $_POST['id_presentacion'] ) && ! ( Validator::numero( $_POST['id_presentacion'] ) ) ) ? $error[] = "Presentación: seleccione una presentación." : "";
		   			( isset( $_POST['existencias'] ) && ! ( Validator::numero( $_POST['existencias'] ) ) ) ? $error[] = "Existencias: solo se permite numeros." : "";
		   		}
		   		catch( Exception $Exception ){
		   			if ( $Exception->getCode() == 23000 ){
		   				$error[] = "Producto y presentación ya existente, por favor seleccione otra presentación u otro producto.";
		   			}
					else $error[] = $Exception->getMessage();
				}
			}
		  }
	   }
	   else header("location: productos");
   }
   else header("location: productos");
  
		            				$palabra = '';
		            				if ( isset($action) && $action == "Agregar" ) $palabra = "añadida";
		            				else $palabra = "editada";
		            				print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Existencia '.$palabra.' con exito.</div>' : "" );
		            				print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
		            				if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
		            			?>
		            			<div class="col-sm-6 col-md-6 col-lg-6 no_padding">
		            				<input type="hidden" name="id_existencia" id="id_existencia" />

		            				<div class="no_padding col-sm-8 col-md-8 col-lg-8">
										<div class="form-group col-sm-12 col-md-12 col-lg-12">
											<label for="existencias">Presentación</label>
											<select name="id_presentacion" id="id_presentacion" class="form-control">
									            <option value="" disabled selected>Seleccione la presentacion</option>
											<?php
												//todas las opciones de cambiar de color el producto =}
												$consulta = 'select * from presentaciones;';
												$presentaciones = Database::getRows($consulta, array( null ) );//Id_producto
												$oppresentaciones = "";//Arreglo para guardar los registros :D
												foreach ($presentaciones as $presentacion) {
									                    $oppresentaciones .= "<option value=$presentacion[id_presentacion]>$presentacion[presentacion]</option>";
												}
					  		$oppresentaciones .= "</select>";
												print( $oppresentaciones );//Imprimmos el resultado =}
											?>
										</div>
								    </div>
								    <div class="no_padding col-sm-4 col-md-4 col-lg-4">
								    	<div class="form-group col-sm-12 col-md-12 col-lg-12">
											<label for="existencias">Existencias</label>
											<input class="form-control <?php print( ( isset($existencias) ) ? "$existencias": ""); ?>" id="existencias" type="text" class="validate" name="existencias" placeholder="Ingrese aquí..."/>
										</div>
								    </div>
								</div>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button id="btn_existencias" type="submit" name="action" value="Agregar" class="btn btn-primary size">
									        <span class="glyphicon glyphicon-plus"></span>
									    </button>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button id="btn-c_existencias" type="button" class="btn btn-danger size">
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
										<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe el nombre de la presentación o nº existencia..."/>
									</div>
								</div>
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
									            <th class="col-sm-4 col-md-4 col-lg-4">Presentacion</th>
									            <th class="col-sm-4 col-md-4 col-lg-4">Existencias</th>
									            <th class="col-sm-4 col-md-4 col-lg-4">Acciones</th>
									        </tr>
									    </thead>
									    <tbody>
										<?php
											require("../sql/conexion.php");
											$consulta = "SELECT * FROM existencias inner join presentaciones on presentaciones.id_presentacion = existencias.id_presentacion where id_producto = $id_producto";
											if( isset( $_POST['txtBuscar'] ) != "" && Validator::numeros_letras( $_POST['txtBuscar'] ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " and (presentacion LIKE '%$busqueda%' or existencias LIKE '%$busqueda%') order by presentacion ASC";
							    			}
							    			else $consulta = $consulta . " order by presentacion ASC;";
											$productos = ""; //Arreglo de datos
											foreach( $PDO->query($consulta) as $datos ){
												$productos .= "<tr>";
													$productos .= '<td id_presentacion="'.$datos['id_presentacion'].'">'.$datos['presentacion'].'</td>';
													$productos .= '<td class="existencias">'. $datos['existencias'].'</td>';
													$productos .= '<td class="text-center"><a id_existencia="'.$datos['id_existencia'].'" class="glyphicon glyphicon-edit padding_right_ico icono_tamano" onclick="$(this).e_existencia();"></a><a href="eliminar_existencia?id='.base64_encode( $datos['id_existencia'] ).'&producto='.base64_encode( $id_producto ).'" class="glyphicon glyphicon-remove-circle icono_tamano"></a></td>';
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