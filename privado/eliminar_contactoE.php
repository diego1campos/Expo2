<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
    require("../lib/validator.php");//Validar
    require("../lib/database.php");
    require("../lib/page-privado.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Eliminar contacto de empresa", "contactos_empresa");
    $id = null;
	if(!empty($_GET['id_contacto_empresa'])) $id = base64_decode( $_GET['id_contacto_empresa'] );
    if( $id == null || ! Validator::numero( $id ) ){
    	header("location: contacto_empresa");
    	exit();
	}
	$cosa = 'el contacto de empresa';
	$pag_cancelar = 'contacto_empresa';
	if(!empty($_POST)){
		if ( ! Validator::permiso_eliminar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
        else {
			require("../sql/conexion.php");
			try{
				$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        	$consulta = "delete from contactos_empresa where id_contacto_empresa=?;";
	        	$stmt = $PDO->prepare($consulta);
	        	$stmt->execute( array ( $id ) );
	        	$PDO = null;
		        //Ejecutar procedimiento para bitacora ='}'
	        	Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 3, 3, $consulta ) );
				header("location: contacto_empresa");
			}
			catch( PDOException $Exception ) {
			    $error = $Exception->getMessage( );
			}
		}
	}
?>
<?php include 'inc/eliminar.php'; ?>