<?php
  	if(!empty($_POST)){
	  	require ('../lib/validator.php');
	  	require ('../lib/database.php');
	  	if ( isset( $_POST['fecha_pedido'] ) && Validator::fecha( trim( $_POST['fecha_pedido'] ) ) ){
			$fecha = trim( $_POST['fecha_pedido'] );
			//Ahora se convierte a numero el dia encontrado, segun la fecha con "w"--- se le suma 1 por que domingo comienza con 0... sabado termina con 6... y asi no lo estamos trabajando :D
			$dia = 1 + date( "w", mktime( 0, 0, 0, substr( $fecha, -5, 2 ), substr( $fecha, -2 ), substr( $fecha, -10, 4 ) ) );
			//Porcedemos a encontrar los horarios en tal dia de la semana ='DD
			$horarios = Database::getRows( "select id_horario_entrega, hora_inicial, hora_final from horarios_entrega where dia = ?;", array( $dia ) );
			$horarios_entrega = "";
			foreach ( $horarios as $key ) {
				$horarios_entrega .= '<option value="' . $key['id_horario_entrega'] . '">' . $key['hora_inicial'] . ' a ' . $key['hora_final'] . '</option>';
			}
			//Si no hay horarios ='D
			if ( $horarios == null ) $horarios_entrega = '<option >No poseemos horario para este dia.</option>';
			echo json_encode( array( 0 => true,
									 1 => $horarios_entrega
									)
							);
		}

	    else if ( isset( $_POST['id_img_producto'] ) && Validator::numero( trim( $_POST['id_img_producto'] ) ) ){
	    	if ( Validator::numero( trim($_POST['id_presentacion']) ) ){
	    		try{
	    			//Obtenemos el id del producto de la imagen seleccioanda
				    $sql = "select id_producto from img_productos where id_img_producto = ?";
				    $datos = Database::getRow( $sql, array ( $_POST['id_img_producto'] ) );
				    session_start();
				    //EN TODO SE OCUPAN ^U^
				    //
				    //
		    		if ( $_POST['tipo_accion'] == '2' ){
		    			//Ahora obtenemos la imagen, con el id_producto y presentacion especificado =}
		    			$sql = "select id_img_producto, imagen_producto from img_productos where id_presentacion = ? and id_producto = ?;";
						$exito = Database::getRow( $sql, array ( $_POST['id_presentacion'], $datos['id_producto'] ) );

						//Obtenemos las existencias del producto en la base
					    $sql = "select existencias from existencias where id_presentacion = ? and id_producto = ?;";
					    $r_existencia = Database::getRow( $sql, array ( $_POST['id_presentacion'], $datos['id_producto'] ) );

						//Obtenemos la cantidad de la imagen o producto actual :)
						$sql = "select cantidad_producto from carrito where id_img_producto = ? and id_cliente = ?;";
					    $r_cantidad = Database::getRow( $sql, array ( $_POST['id_img_producto'], $_SESSION['id_cliente'] ) );

					    //rarrrr!!!  xd Hacemos aqui la comprobacion si el color es aceptable ( si no se repite en carrito )
				//------Actualizamos la tabla carrito con el nuevo id de la imagen =}
					    $sql = "update carrito set id_img_producto = ? where id_img_producto = ? and id_cliente = ?;";
					    $exito_modificar = Database::executeRow( $sql, array ( $exito['id_img_producto'], $_POST['id_img_producto'], $_SESSION['id_cliente'] ) );

					    if ( $r_cantidad['cantidad_producto'] == null ){
					    	echo json_encode( $_POST['id_img_producto'] );
					    	exit();
					    }
	    				$sql = "select id_presentacion from img_productos where id_img_producto = ?;";
				    	$id_col_imagen_antigua = Database::getRow( $sql, array ( $_POST['id_img_producto'] ) );
				    	if ( ! ( $id_col_imagen_antigua['id_presentacion'] == $_POST['id_presentacion'] ) ){//Si esto es verdadero (no he seleccionado el mismo color que esta en carrito ) hace eso :)
			    			if ( $r_existencia['existencias'] >= $r_cantidad['cantidad_producto'] ){
			    				//Actualizamos las existencias de la anterior imagen =}

			    				//Obtengo las actuales existencias, id de este color(antiguo)
			    				$sql = "select existencias, id_existencia from existencias where id_presentacion = ? and id_producto = ?;";
						    	$anti_existencia = Database::getRow( $sql, array ( $id_col_imagen_antigua['id_presentacion'], $datos['id_producto'] ) );

			    				//Actualizo las existencias es decir: (pasando las antigua cantidad que le pertenecia a existencias)
			    				$sql = "update existencias set existencias = ? where id_existencia = ?";
						    	if ( $exito_modificar == 1 ) $exito_modificar = Database::executeRow( $sql, array ( ( $anti_existencia['existencias'] + $r_cantidad['cantidad_producto'] ), $anti_existencia['id_existencia'] ) );

							    //Si logre actualizar el id en elcarrito Actualizo las existencias del nuevo id (la cantidad que tengo se la tengo que restar al nuevo id)
			    				$sql = "update existencias set existencias = ? where id_presentacion = ? and id_producto = ?;";
						    	if ( $exito_modificar == 1 ) $exito_modificar = Database::executeRow( $sql, array ( ( $r_existencia['existencias'] - $r_cantidad['cantidad_producto'] ), $_POST['id_presentacion'], $datos['id_producto'] ) );

							    $respuesta_exito = array(0 => $exito['imagen_producto'],
							    						 1 => $exito_modificar,
							    						 2 => $exito['id_img_producto']
							    						 );
							    echo json_encode( $respuesta_exito );
							}
							else{
								//Vuelvo a como estaba la tabla carrito :D
								//Actualizamos la tabla carrito con el nuevo id de la imagen =}
							    $sql = "update carrito set id_img_producto = ? where id_img_producto = ? and id_cliente = ?;";
							    $exito_modificar = Database::executeRow( $sql, array ( $_POST['id_img_producto'], $exito['id_img_producto'], $_SESSION['id_cliente'] ) );
								//
								$respuesta_exito = array(0 => "Existencias insuficientes en esta presentacion ($r_existencia[existencias]).",
														 1 => 555
							    						 );//Sera mi error: volver al color anterior combobox xd
							    echo json_encode( $respuesta_exito );
							}
						}
						else{
							$respuesta_exito = array(0 => 1,
						    						 );
						    echo json_encode( $respuesta_exito );
						}
					}
		    		else if ( $_POST['tipo_accion'] == '1' || $_POST['tipo_accion'] == '3' ){
					    //Obtenemos las existencias del producto en la base
					    $sql = "select existencias from existencias where id_presentacion = ? and id_producto = ?;";
					    $r_existencia = Database::getRow( $sql, array ( $_POST['id_presentacion'], $datos['id_producto'] ) );
						//Obtenemos la cantidad antes ingreada :)
						$sql = "select cantidad_producto from carrito where id_img_producto = ? and id_cliente = ?;";
					    $r_cantidad = Database::getRow( $sql, array ( $_POST['id_img_producto'], $_SESSION['id_cliente'] ) );
						//
						if ( $_POST['tipo_accion'] == '1' ){
					    	if ( Validator::numero( trim( $_POST['cantidad'] ) ) && trim( $_POST['cantidad'] ) >= 1 ){
						    	if ( ( $r_existencia['existencias'] + $r_cantidad['cantidad_producto'] ) >= $_POST['cantidad'] ){
						    		//Esto se ejecuta en ambos por que se debe actualizar las esistencias :D
		    				    	$sql = "update existencias set existencias = ? where id_presentacion = ? and id_producto = ?;";
		    					    $exito = Database::executeRow( $sql, array ( ( ( $r_existencia['existencias'] + $r_cantidad['cantidad_producto'] ) - $_POST['cantidad'] ), $_POST['id_presentacion'], $datos['id_producto'] ) );
		    					    
		    					    //Este se ejecuta cuando se hace desde la pagina compras :D
			    					if ( isset( $_POST['btnacarrito'] ) ){/*Si lo esta haciendo desde la pagina infoproducto :D ------------*/
			    					    //Todo bien :D
		    					    	$sql = "select id_img_producto from carrito where id_img_producto = ? and id_cliente = ?;";
		    					    	$id_exis = Database::getRow( $sql, array ( $_POST['id_img_producto'], $_SESSION['id_cliente'] ) );
			    					    if ( $id_exis['id_img_producto'] != null ){
				    					    $sql = "update carrito set cantidad_producto = ? where id_img_producto = ? and id_cliente = ?;";
				    					    //Si logre actualizar en existencias, si no, no xd
				    					    if ( $exito == 1 ) $exito = Database::executeRow( $sql, array ( $_POST['cantidad'], $_POST['id_img_producto'], $_SESSION['id_cliente'] ) );
				    					    if ( $exito == 1 ) $exito = "actualizo";
					    				    echo json_encode( $exito );
			    					    }
			    					    else{
			    					    	$sql = "insert into carrito ( id_cliente, id_img_producto, cantidad_producto ) values ( ?, ?, ? )";
				    					    //Si logre actualizar en existencias, si no, no xd
				    					    if ( $exito == 1 ) $exito = Database::executeRow( $sql, array ( $_SESSION['id_cliente'], $_POST['id_img_producto'], $_POST['cantidad'] ) );
				    					    if ( $exito == 1 ) $exito = "añadio";
					    				    echo json_encode($exito);
					    				}
				    				}
			    					else{
		    					    	//Ahora actualizo carrito :D
			    					    $sql = "update carrito set cantidad_producto = ? where id_img_producto = ? and id_cliente = ?;";
				    					if ( $exito == 1 ) $exito = Database::executeRow( $sql, array ( $_POST['cantidad'], $_POST['id_img_producto'], $_SESSION['id_cliente'] ) );
				    					echo json_encode( $exito );//Tiro true xd
					    			}
			    				}
			    				else echo json_encode( "Lo sentimos, solo poseemos " . ( $r_existencia['existencias'] + $r_cantidad['cantidad_producto'] ) . " existencias de este producto y presentacion." );
							}
							else echo json_encode( "Cantidad ingresada invalida." );
						}
						else if ( $_POST['tipo_accion'] == '3' ){
							$sql = "delete from carrito where id_img_producto = ? and id_cliente = ?;";
						    $exito_eliminar = Database::executeRow( $sql, array ( $_POST['id_img_producto'], $_SESSION['id_cliente'] ) );
						    //
						    //Si fue exitoso el eliminar actualizamos, //Le Sumarsela a existencias nuevamente xd si no :P
						    $sql = "update existencias set existencias = ? where id_presentacion = ? and id_producto = ?;";
						    if ( $exito_eliminar == 1 ) $exito_eliminar = Database::executeRow( $sql, array ( ( $r_existencia['existencias'] + $r_cantidad['cantidad_producto'] ), $_POST['id_presentacion'], $datos['id_producto'] ) );
						    $respuesta_exito = array( 0 => $exito_eliminar,
						    						 );
						    echo json_encode( $respuesta_exito );
						}
					}
				}
				catch( Exception $Exception ) {
					if ( $Exception->getCode() == 23000 ) echo json_encode( $Exception->getCode() );
				    else echo json_encode( $Exception->getMessage() );
				}
			}
			else echo json_encode( "Id de color invalido." );
		}
		else echo json_encode( "Id de imagen invalido.");
  	}
?>

<?php
/*--- por si acaso =}

if ( $_POST['tipo_accion'] == '1' ){
	if ( Validator::numero( trim( $_POST['cantidad'] ) ) && trim( $_POST['cantidad'] ) >= 1 ){
    	if ( ( $r_existencia['existencias'] + $r_cantidad['cantidad_producto'] ) >= $_POST['cantidad'] ){
	    	$sql = "update existencias set existencias = " . ( ( $r_existencia['existencias'] + $r_cantidad['cantidad_producto'] ) - $_POST['cantidad'] ) . " where id_color = ? and id_producto = ?";
		    $exito = Database::executeRow( $sql, array ( $_POST['id_color'], $datos['id_producto'] ) );
		    
		    if ( isset( $_POST['sub_tipo_acccion'] ) && Validator::numero( trim( $_POST['sub_tipo_acccion'] ) ) && $_POST['sub_tipo_acccion'] == 2 ){
		    	session_start();
		    	//
		    	//Ahora comprobamos si ya fue añadido
		    	$sql = "select id_img_producto from carrito where id_img_producto = ?";
		    	$id_exis = Database::executeRow( $sql, array ( $_POST['id_color'], $datos['id_producto'] ) );
		    	if ( $id_exis['id_img_producto'] != null ){
			    	$sql = "insert into carrito ( id_cliente, id_img_producto, cantidad_producto ) values ( ?, ?, ? )";
				    /*Si logre actualizar en existencias, si no, no xd
				    if ( $exito == 1 ) $exito = Database::executeRow( $sql, array ( $_SESSION['id_cliente'], $_POST['id_img_producto'], $_POST['cantidad'] ) );
				    echo json_encode($exito);
				}
				else $actua = "ok";
		    }
		    else if ( ! isset( $_POST['sub_tipo_acccion'] ) || isset( $actua ) ){
			    $sql = "update carrito set cantidad_producto = ? where id_img_producto = ? ";
			    /*Si logre actualizar en existencias, si no, no xd
			    if ( $exito == 1 ) $exito = Database::executeRow( $sql, array ( $_POST['cantidad'], $_POST['id_img_producto'] ) );
			    echo json_encode($exito);
			}
		}
		else echo json_encode( "Lo sentimos, solo poseemos " . ( $r_existencia['existencias'] + $r_cantidad['cantidad_producto'] ) . " existencias de este artículo y color." );
	}
	else echo json_encode( "Cantidad ingresada invalida." );
}
*/
?>