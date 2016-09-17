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
  	$permisos = Page::header("Entregas de pedido", "entregar_pedidos");
  	try{
	  	if ( isset( $_POST['id_entrega_pedido'] ) && Validator::numero( $_POST['id_entrega_pedido'] ) ){
	  		if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
			else {
		  		$consulta = "update entregar_pedidos set estado = 1, fecha_entrega = ? where id_entrega_pedido = ?;";
		  		$exito = Database::executeRow( $consulta, array( date("Y-m-d H:i:s"), $_POST['id_entrega_pedido'] ) );
		  		if ( $exito == 1 ) Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 8, 2, $consulta ) );
		  	}
	  	}
	  	else if ( isset( $_POST['id_entrega_pedido'] ) && ! Validator::numero( $_POST['id_entrega_pedido'] ) ) print ( '<div class="alert alert-danger" role="alert">Id de entrega invalido.</div>' );
	  	print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Operación exitosa.</div>' : "" );
	}
	catch( Exception $Exception ){
		$error[] = $Exception->getMessage( );
	}
								if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' ); ?>
		            			<br>
		            			<div class="col-sm-8 col-md-8 col-lg-8">
									<div class="input-group">
										<span class="input-group-addon no_padding_input-group"><button type="submit" name="action" value="Buscar" class="glyphicon glyphicon-search nobtn padding_input-group"></button></span>
										<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe los nombres o apellidos del cliente, o el total a pagar..."/>
									</div>
								</div>
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
									            <th class="col-sm-4 col-md-4 col-lg-4">Nombre del cliente</th>
									            <th class="col-sm-1 col-md-1 col-lg-1">Fecha entrega</th>
									            <th class="col-sm-2 col-md-2 col-lg-2">Horario entrega</th>
									            <th class="col-sm-3 col-md-3 col-lg-3">Direccion</th>
									            <th class="col-sm-1 col-md-1 col-lg-1">Total (+cargo)</th>
									            <th class="col-sm-2 col-md-2 col-lg-2">Acciones</th>
									            <!--th class="col-sm-2 col-md-2 col-lg-2">Presentacion</th-->
									        </tr>
									    </thead>
									    <tbody>
										<?php
											$consulta = "SELECT nombres_cliente, apellidos_cliente, total, fecha_pedido, id_entrega_pedido, pedidos.id_pedido, hora_inicial, hora_final, direccion FROM ( ( (`entregar_pedidos` inner join pedidos on pedidos.id_pedido = entregar_pedidos.id_pedido) inner join direcciones on direcciones.id_direccion = pedidos.id_direccion ) inner join clientes on clientes.id_cliente = direcciones.id_cliente) inner join horarios_entrega on horarios_entrega.id_horario_entrega = pedidos.id_horario_entrega where entregar_pedidos.estado = 0 and id_empleado = ?";
											if( isset( $_POST['txtBuscar'] ) != "" && ( Validator::letras( $_POST['txtBuscar'] ) || Validator::decimal( $_POST['txtBuscar'] ) ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " and ( apellidos_cliente LIKE '%$busqueda%' or nombres_cliente LIKE '%$busqueda%' or total LIKE '%$busqueda%' ) order by fecha_entrega ASC";
							    			}
							    			else $consulta = $consulta . " order by fecha_entrega ASC";
							    			$data_pedidos = Database::getRows( $consulta, array( $_SESSION['id_empleado'] ) );
											$pedidos = ""; //Arreglo de datos
											//if ( $data_pedidos != null ){
												foreach($data_pedidos as $datos){
													$pedidos .= "<tr>";
														//$pedidos .= "<td><img src='../img/productos/$datos[imagen_producto]' alt='$datos[nombre_producto]' class='img-responsive'></td>";
														$pedidos .= "<td>$datos[apellidos_cliente], $datos[nombres_cliente]</td>";
														$pedidos .= "<td>$datos[fecha_pedido]</td>";
														$pedidos .= "<td>$datos[hora_inicial] a $datos[hora_final]</td>";
														$pedidos .= "<td>$datos[direccion]</td>";
														$pedidos .= "<td>$$datos[total]</td>";
														$pedidos .= '<td class="text-center"><button type="submit" name="id_entrega_pedido" value="' . $datos['id_entrega_pedido'] . '" class="nobtn-trans"><a class="icono_tamano glyphicon padding_right_nojs glyphicon-check"></a></button><a href="detalle_pedido?id='.base64_encode( $datos['id_pedido'] ).'" class="icono_tamano glyphicon glyphicon-eye-open"></a></td>';
													$pedidos .= "</tr>";
												}
												print($pedidos);
										?>
										</tbody>
									</table>
								</div>
							</div>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>