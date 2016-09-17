<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
    require("../lib/validator.php");//Validar
    require("../lib/database.php");
    require("../lib/page-privado.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    $permisos = Page::header("Eliminar pedido local", "pedidos_local");
	$id = null;
	$cosa = 'este pedido';
	$titulo = 'Pedidos local';
	$pag_cancelar = 'pedidos_local-admin';
    if( !empty( $_GET['id'] ) ){
        $id = base64_decode( $_GET['id'] );
    }
    if( $id == null || ! Validator::numero( $id ) ) ) {
        header("location: pedidos_local-admin");
        exit();
    }
	if( !empty( $_POST ) ){
        if ( ! Validator::permiso_eliminar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
        else {
    		require("../sql/conexion.php");
    		try{
    			$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            	$consulta = "delete from detalles_pedidos_local where id_pedido_local=?;";
            	$stmt = $PDO->prepare($consulta);
            	$stmt->execute( array ($id) );
            	//bitacora de este xd
            	Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 22 , 3, $consulta ) );
            	//Ahora cambio de estado el pedido en 0 :D
            	$consulta = "delete from pedidos_local where id_pedido_local=?;";
            	$stmt = $PDO->prepare($consulta);
            	$stmt->execute( array ($id) );
            	$PDO = null;
            	Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 21 , 3, $consulta ) );
    			header("location: pedidos_local-admin");
    		}
    		catch( PDOException $Exception ) {
    		    echo $Exception->getMessage( );
    		}
        }
	}
?>
<?php include 'inc/eliminar.php'; ?>