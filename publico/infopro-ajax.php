<?php
  	if(!empty($_POST)){
	  	require ('../lib/validator.php');
	  	require ('../lib/database.php');
		if ( Validator::numero( trim($_POST['id_producto']) ) ){
			try{
				if ( $_POST['tipo_accion'] == 1 ){
					if ( Validator::numero( trim($_POST['id_presentacion']) ) ){
						//A mostrar todas las imegenes del mismo color :D
	        $consulta = "SELECT id_img_producto, imagen_producto FROM img_productos inner join presentaciones on presentaciones.id_presentacion = img_productos.id_presentacion WHERE img_productos.id_presentacion = ? and id_producto = ?";
	        $imagenes = Database::getRows( $consulta, array( $_POST['id_presentacion'], $_POST['id_producto'] ) );
			//Asignamos los datos =}
			$informacion = '<ol class="carousel-indicators" id="ci_infoart">';
								for ( $contar = 0; $contar < sizeof($imagenes) ; $contar++ ) {
									if ( $contar == 0 ) $informacion .= '<li data-target="#slider_info_art" data-slide-to="'.$contar.'" class="active"></li>';
									else $informacion .= '<li data-target="#slider_info_art" data-slide-to="'.$contar.'"></li>';
								}
			$informacion .= '</ol>
							<div class="carousel-inner">';
							$contar = 0;
							foreach ( $imagenes as $key ) {
							if ( $contar == 0 ){
									$informacion .= '<div class="item active">
														<img src="../img/productos/'.$key['imagen_producto'].'" alt="señor">
													</div>';
									$id_img = $key['id_img_producto'];
								}
			   else $informacion .= '<div class="item">
										<img src="../img/productos/'.$key['imagen_producto'].'" alt="señor">
									</div>';
								//Contador para saber si era active o no, la primera imagen xd
								$contar++;
							}
			$informacion .= '</div>';
						//
						//Compruebo si hay que cambiar el texto del boton añadircarrito o noxd
						$sql = "select id_img_producto, cantidad_producto from carrito where id_img_producto = ?";
				    	$id_exis = Database::getRow( $sql, array ( $id_img ) );
				    	( $id_exis['id_img_producto'] != null ) ? $añadido = 'Editar' : $añadido = 'Añadir al carrito';
				    	( $añadido == 'Editar' ) ? $cantidad = $id_exis['cantidad_producto'] : $cantidad = 1;
						//
						//Enviamos los datos =DD
					    $respuesta_exito = array(	0 => true,
					    							1 => $informacion,//Muestra las imagenes =}
					    							2 => $añadido,
					    							3 => $id_img,
					    							4 => $cantidad,
					    						);
					    echo json_encode( $respuesta_exito );
				    }
					else echo json_encode( "Id de presentacion invalida.");
				}
				else if ( $_POST['tipo_accion'] == 2 ){
					if ( Validator::decimal( trim( $_POST['calificacion'] ) ) && trim($_POST['calificacion']) >= 0.1 && trim($_POST['calificacion']) <= 5.0 ){
						session_start();
						//Comprobamos ha comprado este producto :)
						$consulta = "select cantidad_producto FROM `detalles_pedidos` inner join img_productos on img_productos.id_img_producto = detalles_pedidos.id_img_producto inner join productos on productos.id_producto = img_productos.id_producto inner join pedidos on pedidos.id_pedido = detalles_pedidos.id_pedido inner join direcciones on direcciones.id_direccion = pedidos.id_direccion inner join clientes on clientes.id_cliente = direcciones.id_cliente WHERE productos.id_producto = ? and clientes.id_cliente = ?;";
	        			$exis_compra = Database::getRow( $consulta, array( $_POST['id_producto'], $_SESSION['id_cliente'] ) );
						//Si es nula entonces comparo con el otro, que seria pedidos_local :D
	        			$consulta = "select cantidad_producto FROM `detalles_pedidos_local` inner join img_productos on img_productos.id_img_producto = detalles_pedidos_local.id_img_producto inner join productos on productos.id_producto = img_productos.id_producto inner join pedidos_local on pedidos_local.id_pedido_local = detalles_pedidos_local.id_pedido_local WHERE productos.id_producto = ? and id_cliente = ?;";
	        			if ( $exis_compra == null ) $exis_compra = Database::getRow( $consulta, array( $_POST['id_producto'], $_SESSION['id_cliente'] ) );

						if ( $exis_compra != null ){
							//Comprobamos si posee ya una calificacion ingresada :)
							$consulta = "SELECT id_calificacion_producto FROM calificacion_productos where id_producto = ? and id_cliente = ?;";
		        			$id_cali = Database::getRow( $consulta, array( $_POST['id_producto'], $_SESSION['id_cliente'] ) );
							//Enviamos los datos =DD
							if ( $id_cali['id_calificacion_producto'] != null ){
								$consulta = "update calificacion_productos set calificacion_producto = ?, fecha_ingreso = ? where id_calificacion_producto = ?;";
								$exito = Database::executeRow( $consulta, array( $_POST['calificacion'], date("Y-m-d H:i:s"), $id_cali['id_calificacion_producto'] ) );
								$cali_base = 'editada';
							}
							else{
								$consulta = "insert into calificacion_productos ( id_cliente, id_producto, calificacion_producto, fecha_ingreso ) values (?, ?, ?, ?);";
								$exito = Database::executeRow( $consulta, array( $_SESSION['id_cliente'], $_POST['id_producto'], $_POST['calificacion'], date("Y-m-d H:i:s") ) );
								$cali_base = 'añadida';
							}
							//Enviamos los datos =DD
						    $respuesta_exito = array(	0 => $exito,
						    							1 => $cali_base,//Muestra las imagenes =}
						    						);
						    echo json_encode( $respuesta_exito );
						}
						else echo json_encode( "Debe comprar el producto para realizar una calificación.");
					}
					else echo json_encode( "Calificación ingresada invalida.");
				}
			}
			catch( Exception $Exception ) {
			    echo json_encode( $Exception->getMessage( ) );
			}
		}
		else echo json_encode( "Id de producto invalido.");
  	}
?>