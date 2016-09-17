<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
    require("../lib/validator.php");//Validar
    require("../lib/database.php");
    require("../lib/page-privado.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Eliminar existencias", "existencias");
	$id = null;
	$producto = null;
	$cosa = 'este registro de existencias';
	$titulo = 'Existencias';
    if( !empty( $_GET['id'] ) ) {
        $id = base64_decode( $_GET['id'] );
        $producto = base64_decode( $_GET['producto'] );
        $pag_cancelar = 'existencias?id='.$_GET['producto'];
    }
    if( $id == null || $producto == null || ! Validator::numero( $id ) || ! Validator::numero( $producto ) ) {
        header("location: productos");
        exit();
    }
	if(!empty($_POST)){
		if ( ! Validator::permiso_eliminar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
        else {
			require("../sql/conexion.php");
			try{
				$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        	$consulta = "delete from existencias where id_existencia=?;";
	        	$stmt = $PDO->prepare($consulta);
	        	$stmt->execute( array ( $id ) );
	        	$PDO = null;
	        	Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 9 , 3, $consulta ) );
				header("location: existencias?id=$producto");
			}
			catch( PDOException $Exception ) {
			    $error = $Exception->getMessage( );
			}
		}
	}
?>
<?php include 'inc/eliminar.php'; ?>