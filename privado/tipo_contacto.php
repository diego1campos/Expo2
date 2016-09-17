<?php

  ob_start();
  //Se establece todas las clases o funciones necesarias ='D'
  require("../lib/database.php");
  require("../lib/validator.php");
  //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
  require("../lib/page-privado.php");

    $permisos = Page::header("Tipo de contacto", "tipos_contactos");

if(!empty($_POST)){
  	try{
	    $action = $_POST['action'];
	    if ( $action != "Buscar" ){
	    	$tipo_contacto = $_POST['txtcontacto'];
		    require("../sql/conexion.php");
		    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		   	//Validar
		  
		   	if ( Validator::letras( $tipo_contacto ) ){
			    if ( $action == "Agregar" ){
			    	if ( ! Validator::permiso_agregar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
		    		else {
				        $sql = "INSERT INTO tipos_contactos(tipo_contacto) values(?)";            
				        $stmt = $PDO->prepare($sql);
				        $exito = $stmt->execute(array ( $tipo_contacto ) );
				        $PDO = null;
				        Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 18 , 1, $sql ) );
				    }
			    }
			    else if ( $action == "Editar" ){
			    	$id_tipo_contacto = $_POST['id_tipo_contacto'];
			    	if ( Validator::numero( $id_tipo_contacto ) ){
			    		if ( ! Validator::permiso_modificar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
						else {
					        $sql = "update tipos_contactos set tipo_contacto=? where id_tipo_contacto=?";
					        $stmt = $PDO->prepare($sql);
					        $exito = $stmt->execute(array ( $tipo_contacto, $id_tipo_contacto ) );
					        $PDO = null;
					        Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 18 , 2, $sql ) );
				    	}
				    }	
			    	else $error = "Id no valido.";
			    }
			}
			else $error_data = "Error, por favor revise los campos señalados.";
			( ! ( Validator::letras( $tipo_contacto ) ) ) ? $er_categoria = "error_data" : "";
		}
	}
	catch( Exception $Exception ) 
	{
		if($Exception->getCode() == 23000)
		{
			$error = "No se puede eliminar este registro porque esta siendo utilizado en otra tabla";
		}
		else
		{
			$error = $Exception->getMessage();
		}
	}		

}

	$palabra = '';
	if ( isset($action) && $action == "Agregar" ) $palabra = "añadida";
	else $palabra = "editada";
	print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Tipo de contacto '.$palabra.' con exito.</div>' : "" );
	print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
	print ( ( isset($error) ) ? '<div class="alert alert-danger" role="alert">'.$error.'</div>' : "" );
?> 
		            			<div class="col-sm-4 col-md-4 col-lg-4 no_padding">
									<div class="col-sm-12 col-md-12 col-lg-12">
										<label class="">Tipo de contacto</label>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
										<input type="hidden" name="id_tipo_contacto" id="id_tipo_contacto" />
										<input class="form-control <?php print( ( isset($er_categoria) ) ? "$er_categoria": ""); ?>" id="txtcontacto" type="text" class="validate" name="txtcontacto" placeholder="Ingrese aquí..."/>
									</div>
								</div>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button id="btn_Tcontacto" type="submit" name="action" value="Agregar" class="btn btn-primary size">
									        <span class="glyphicon glyphicon-plus"></span>
									    </button>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button id="btn-c_Tcontacto" type="button" class="btn btn-danger size">
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
										<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe el tipo de contacto..."/>
									</div>
								</div>
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
									            <th class="col-sm-8 col-md-8 col-lg-8">Tipo de contacto</th>
									            <th class="col-sm-4 col-md-4 col-lg-4">Acciones</th>
									        </tr>
									    </thead>
									    <tbody>
										<?php
											require("../sql/conexion.php");
											$consulta = "SELECT * FROM tipos_contactos";
											if( isset( $_POST['txtBuscar'] ) != "" && Validator::numeros_letras( $_POST['txtBuscar'] ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " where tipo_contacto LIKE '%$busqueda%' order by tipo_contacto ASC";
							    			}
							    			else $consulta = $consulta . " order by tipo_contacto ASC";
											$productos = ""; //Arreglo de datos
											foreach($PDO->query($consulta) as $datos){
												$productos .= "<tr>";
													$productos .= "<td class='tipo_contacto'>$datos[tipo_contacto]</td>";
													$productos .= '<td class="text-center"><a id_tipo_contacto="'.$datos['id_tipo_contacto'].'" class="glyphicon glyphicon-edit padding_right_ico icono_tamano up" onclick="$(this).e_Tcontacto();"></a><a href="eliminar_tcontacto?id='.$datos['id_tipo_contacto'].'" class="glyphicon glyphicon-remove-circle icono_tamano"></a></td>';
												$productos .= "</tr>";
											}
											print($productos);
											$PDO = null;
										?>
										</tbody>
									</table>
								</div>
							</div>
		        		</div>
		        	</div>
		        </div>
		    </form>
		</section><!--Conent ='DD-->
	</div><!--ConentWrapper ='DD-->
</div><!--Wrapper ='DD-->

<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>

<script src="../publico/js/bootstrap.min.js"></script>

<script src="dist/js/app.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>

<script src="plugins/datatables/dataTables.bootstrap.js"></script>

<script src="../publico/js/mainB.js"></script>

</body>
</html>