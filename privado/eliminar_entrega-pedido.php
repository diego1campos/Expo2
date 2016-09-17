<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
    require("../lib/validator.php");//Validar
    require("../lib/database.php");
    require("../lib/page-privado.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    $permisos = Page::header("Eliminar entrega", "entregar_pedidos");
	$id = null;
	$cosa = 'este pedido de la lista por entregar del empleado';
	$titulo = 'Entregas de pedidos';
	$pag_cancelar = 'entregar_pedidos-admin';
    if( !empty( $_GET['id'] ) ){
        $id = base64_decode( $_GET['id'] );
    }
    if( $id == null || ! Validator::numero( $id ) ) {
        header("location: entregar_pedidos-admin");
        exit();
    }
	if( !empty( $_POST ) ){
        if ( ! Validator::permiso_eliminar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
        else {
    		require("../sql/conexion.php");
    		try{
    			$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            	$consulta = "delete from entregar_pedidos where id_pedido=?;";
                Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 8 , 3, $consulta ) );
            	$stmt = $PDO->prepare($consulta);
            	$stmt->execute( array ($id) );
            	//Ahora cambio de estado el pedido en 0 :D
            	$consulta = "update pedidos set estado = 0 where id_pedido=?;";
            	$stmt = $PDO->prepare($consulta);
            	$stmt->execute( array ($id) );
                Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 11 , 2, $consulta ) );
            	$PDO = null;
    			header("location: entregar_pedidos-admin");
    		}
    		catch( PDOException $Exception ) {
    		    echo $Exception->getMessage( );
    		}
        }
	}
?>
<?php include 'inc/eliminar.php'; ?>