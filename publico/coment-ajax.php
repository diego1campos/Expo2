<?php
  	if(!empty($_POST)){
	  	require ('../lib/validator.php');
    	if ( Validator::numero( trim($_POST['id_producto']) ) ){
    		if ( Validator::numeros_letras( trim($_POST['comentario']) ) ){//Quiza haga un comentario de validacionx d
				try{
					session_start();
					require ('../lib/database.php');
					//Comprobamos ha comprado este producto :)
					$consulta = "select cantidad_producto FROM `detalles_pedidos` inner join img_productos on img_productos.id_img_producto = detalles_pedidos.id_img_producto inner join productos on productos.id_producto = img_productos.id_producto inner join pedidos on pedidos.id_pedido = detalles_pedidos.id_pedido inner join direcciones on direcciones.id_direccion = pedidos.id_direccion inner join clientes on clientes.id_cliente = direcciones.id_cliente WHERE productos.id_producto = ? and clientes.id_cliente = ?;";
        			$exis_compra = Database::getRow( $consulta, array( $_POST['id_producto'], $_SESSION['id_cliente'] ) );
					//Si es nula entonces comparo con el otro, que seria pedidos_local :D
        			$consulta = "select cantidad_producto FROM `detalles_pedidos_local` inner join img_productos on img_productos.id_img_producto = detalles_pedidos_local.id_img_producto inner join productos on productos.id_producto = img_productos.id_producto inner join pedidos_local on pedidos_local.id_pedido_local = detalles_pedidos_local.id_pedido_local WHERE productos.id_producto = ? and id_cliente = ?;";
        			if ( $exis_compra == null ) $exis_compra = Database::getRow( $consulta, array( $_POST['id_producto'], $_SESSION['id_cliente'] ) );

					if ( $exis_compra != null ){
					    $sql = "insert into comentarios_productos (id_cliente, id_producto, estado_comentario, comentario_producto, fecha_ingreso) values(?,?,?,?,?)";
					    $exito = Database::executeRow( $sql , array ( $_SESSION['id_cliente'], $_POST['id_producto'], 0, $_POST['comentario'], date("Y-m-d H:i:s") ) );
					    echo json_encode( $exito );
					}
					else echo json_encode( "Debe comprar el producto para realizar un comentario.");
				}
				catch( PDOException $Exception ) {
				    echo json_encode( $Exception->getMessage( ) );
				}
			}
			else echo json_encode("Comentario invalido, solo se permiten letras y numeros.");
		}
		else echo json_encode("Id del producto invalido.");
  	}
?>