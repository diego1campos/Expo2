<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
    require("../lib/validator.php");//Validar
    require("../lib/database.php");
    require("../lib/page-privado.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Eliminar producto", "productos");
	$id = null;
	$cosa = 'producto';
	$titulo = 'Productos';
	$pag_cancelar = 'productos';
    if(!empty($_GET['id'])) {
        $id = base64_decode( $_GET['id'] );
    }
    if($id == null || ! Validator::numero( $id ) ) {
        header("location: productos");
        exit();
    }
	if(!empty($_POST)){
		if ( ! Validator::permiso_eliminar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
        else {
			require("../sql/conexion.php");
			try{
				$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        	$consulta = "delete from productos where id_producto=?;";
	        	$stmt = $PDO->prepare($consulta);
	        	$exito = $stmt->execute( array ( $id ) );
	        	$PDO = null;
	        	if ( $exito == 1 ){
	        		Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 15, 3, $consulta ) );
					header("location: productos");
				}
			}
			catch( PDOException $Exception ) {
			    $error = $Exception->getMessage( );
			}
		}
	}
?>
<?php include 'inc/eliminar.php'; ?>