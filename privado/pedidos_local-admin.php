<?php
    //Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
	ob_start();//Definicion: Esta función activará el almacenamiento en búfer de la salida. Mientras dicho almacenamiento esté activo, no se enviará ninguna salida desde el script (aparte de cabeceras); en su lugar la salida se almacenará en un búfer interno.	
	//Desactivar errores no funciona :D
	//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	require("../lib/validator.php");
	//!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
	require("../lib/page-privado.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Pedidos local", "pedidos_local");
  	try{
	  	if ( isset( $_POST['id_pedido_local'] ) && Validator::numero( $_POST['id_pedido_local'] ) ){
	  		$consulta = "update pedidos_local set estado = 1, fecha_pedido = ? where id_pedido_local = ?;";
	  		$exito = Database::executeRow( $consulta, array( date("Y-m-d H:i:s"), $_POST['id_pedido_local'] ) );
	  		//Bitacora
	  		Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 21 , 2, $consulta ) );
	  	}
	  	else if ( isset( $_POST['id_pedido_local'] ) && ! Validator::numero( $_POST['id_pedido_local'] ) ) print ( '<div class="alert alert-danger" role="alert">Id de pedido invalido.</div>' );
	  	print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Operación exitosa.</div>' : "" );
	}
	catch( Exception $Exception ){
		print ( '<div class="alert alert-danger" role="alert">' . $Exception->getMessage() . '</div>' );
	}
?>
		            			<br>
		            			<div class="col-sm-8 col-md-8 col-lg-8">
									<div class="input-group">
										<span class="input-group-addon no_padding_input-group"><button type="submit" name="action" value="Buscar" class="glyphicon glyphicon-search nobtn padding_input-group"></button></span>
										<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe los nombres o apellidos del cliente, o el total a pagar..."/>
									</div>
								</div>
								<!--div class="col-sm-2 col-md-2 col-lg-2">
									<a href="agregar_producto.php">
										<button type="button" class="btn btn-primary size">
									        <span class="glyphicon glyphicon-plus"></span>
									    </button>
								    </a>
								</div-->
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
									            <th class="col-sm-3 col-md-3 col-lg-3">Apellidos cliente</th>
									            <th class="col-sm-3 col-md-3 col-lg-3">Nombres cliente</th>
									            <th class="col-sm-3 col-md-3 col-lg-3">Fecha ingreso</th>
									            <th class="col-sm-1 col-md-1 col-lg-1">Total(+cargo)</th>
									            <th class="col-sm-2 col-md-2 col-lg-2">Acciones</th>
									            <!--th class="col-sm-2 col-md-2 col-lg-2">Presentacion</th-->
									        </tr>
									    </thead>
									    <tbody>
										<?php
											$consulta = "SELECT nombres_cliente, apellidos_cliente, total, fecha_pedido, id_pedido_local, pedidos_local.id_pedido_local FROM pedidos_local inner join clientes on clientes.id_cliente = pedidos_local.id_cliente where estado = 0";
											if( isset( $_POST['txtBuscar'] ) != "" && ( Validator::letras( $_POST['txtBuscar'] ) || Validator::decimal( $_POST['txtBuscar'] ) ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " and ( apellidos_cliente LIKE '%$busqueda%' or nombres_cliente LIKE '%$busqueda%' or total LIKE '%$busqueda%' ) order by fecha_pedido ASC";
							    			}
							    			else $consulta = $consulta . " order by fecha_pedido ASC";
							    			$data_pedidos = Database::getRows( $consulta, array( $_SESSION['id_empleado'] ) );
											$pedidos = ""; //Arreglo de datos
											//if ( $data_pedidos != null ){
												foreach($data_pedidos as $datos){
													$pedidos .= "<tr>";
														//$pedidos .= "<td><img src='../img/productos/$datos[imagen_producto]' alt='$datos[nombre_producto]' class='img-responsive'></td>";
														$pedidos .= "<td>$datos[apellidos_cliente]</td>";
														$pedidos .= "<td>$datos[nombres_cliente]</td>";
														$pedidos .= "<td>$datos[fecha_pedido]</td>";
														$pedidos .= "<td>$$datos[total]</td>";
														$pedidos .= '<td class="text-center"><a href="eliminar_pedido-local?id=' . base64_encode($datos['id_pedido_local']) . '" class="icono_tamano glyphicon glyphicon-remove-circle padding_right_nojs"></a><a href="detalle_pedido-local?id='.base64_encode($datos['id_pedido_local']).'" class="icono_tamano glyphicon glyphicon-eye-open"></a></td>';
													$pedidos .= "</tr>";
												}
												print($pedidos);
											/*}
											else{
										  		header( "location: entregar_pedidos.php" );
										  		exit();
										  	}*/
										?>
										</tbody>
									</table>
								</div>
							</div>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>