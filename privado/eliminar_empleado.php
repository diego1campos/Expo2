<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
    require("../lib/validator.php");//Validar
    require("../lib/database.php");
    require("../lib/page-privado.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Eliminar empleados", "empleados");
    $id = null;
	if(!empty($_GET['id_empleado'])) $id = base64_decode( $_GET['id_empleado'] );
    if( $id == null || ! Validator::numero( $id ) ){
    	header("location: empleados");
    	exit();
	}
	$cosa = 'empleados';
	$pag_cancelar = 'empleados';
	if(!empty($_POST)){
		if ( ! Validator::permiso_eliminar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
        else {
			require("../sql/conexion.php");
			try{
				$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        	$consulta = "delete from empleados where id_empleado=?";
	        	$stmt = $PDO->prepare($consulta);
	        	$stmt->execute( array ( $id ) );
	        	$PDO = null;
		        //Ejecutar procedimiento para bitacora ='}'
	        	Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 7, 3, $consulta ) );
				header("location: empleados");
			}
			catch( PDOException $Exception ) {
			    $error = $Exception->getMessage( );
			}
		}
	}
?>
<?php include 'inc/eliminar.php'; ?>