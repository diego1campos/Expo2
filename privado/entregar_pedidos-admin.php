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
  	$permisos = Page::header("Entregas de pedidos", "entregar_pedidos");
  	/*try{
	  	if ( isset( $_POST['id_entrega_pedido'] ) && Validator::numero( $_POST['id_entrega_pedido'] ) ){
	  		$consulta = "update entregar_pedidos set estado = 1, fecha_entrega = ? where id_entrega_pedido = ?;";
	  		$exito = Database::executeRow( $consulta, array( date("Y-m-d H:i:s"), $_POST['id_entrega_pedido'] ) );
	  	}
	  	else if ( isset( $_POST['id_entrega_pedido'] ) && ! Validator::numero( $_POST['id_entrega_pedido'] ) ) print ( '<div class="alert alert-danger" role="alert">Id de entrega invalido.</div>' );
	  	print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Operación exitosa.</div>' : "" );
	}
	catch( Exception $Exception ){
		print ( '<div class="alert alert-danger" role="alert">' . $error[] = $Exception->getMessage() . '</div>' );
	}*/
?>
		            			<br>
		            			<div class="col-sm-8 col-md-8 col-lg-8">
									<div class="input-group">
										<span class="input-group-addon no_padding_input-group"><button type="submit" name="action" value="Buscar" class="glyphicon glyphicon-search nobtn padding_input-group"></button></span>
										<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe los nombres o apellidos del empleado, o el total a pagar..."/>
									</div>
								</div>
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
									            <th class="col-sm-3 col-md-3 col-lg-3">Apellidos empleado</th>
									            <th class="col-sm-3 col-md-3 col-lg-3">Nombres empleado</th>
									            <th class="col-sm-3 col-md-3 col-lg-3">Fecha ingreso</th>
									            <th class="col-sm-1 col-md-1 col-lg-1">Total(+cargo)</th>
									            <th class="col-sm-2 col-md-2 col-lg-2">Acciones</th>
									            <!--th class="col-sm-2 col-md-2 col-lg-2">Presentacion</th-->
									        </tr>
									    </thead>
									    <tbody>
										<?php
											$consulta = "SELECT nombres_empleado, apellidos_empleado, total, fecha_entrega, id_entrega_pedido, pedidos.id_pedido FROM (`entregar_pedidos` inner join pedidos on pedidos.id_pedido = entregar_pedidos.id_pedido) inner join empleados on empleados.id_empleado = entregar_pedidos.id_empleado where entregar_pedidos.estado = 0";
											if( isset( $_POST['txtBuscar'] ) != "" && ( Validator::letras( $_POST['txtBuscar'] ) || Validator::decimal( $_POST['txtBuscar'] ) ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " and ( nombres_empleado LIKE '%$busqueda%' or apellidos_empleado LIKE '%$busqueda%' or total LIKE '%$busqueda%' ) order by fecha_entrega ASC";
							    			}
							    			else $consulta = $consulta . " order by fecha_entrega ASC";
							    			$data_pedidos = Database::getRows( $consulta, array( $_SESSION['id_empleado'] ) );
											$pedidos = ""; //Arreglo de datos
											//if ( $data_pedidos != null ){
												foreach($data_pedidos as $datos){
													$pedidos .= "<tr>";
														//$pedidos .= "<td><img src='../img/productos/$datos[imagen_producto]' alt='$datos[nombre_producto]' class='img-responsive'></td>";
														$pedidos .= "<td>$datos[apellidos_empleado]</td>";
														$pedidos .= "<td>$datos[nombres_empleado]</td>";
														$pedidos .= "<td>$datos[fecha_entrega]</td>";
														$pedidos .= "<td>$$datos[total]</td>";
														$pedidos .= '<td class="text-center"><a href="eliminar_entrega-pedido?id=' . base64_encode( $datos['id_pedido'] ) . '" class="icono_tamano glyphicon glyphicon-remove-circle padding_right_nojs"></a><a href="detalle_pedido?id='.base64_encode( $datos['id_pedido'] ).'" class="icono_tamano glyphicon glyphicon-eye-open"></a></td>';
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