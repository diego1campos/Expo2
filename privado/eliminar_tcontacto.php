<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
    require("../lib/validator.php");//Validar
    require("../lib/database.php");
    require("../lib/page-privado.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Eliminar tipo contacto", "tipos_contactos");
    $id = null;
	if(!empty($_GET['id_tipo_contacto'])) $id = base64_decode( $_GET['id_tipo_contacto'] );
    if( $id == null || ! Validator::numero( $id ) ){
    	header("location: tipo_contacto");
    	exit();
	}
	$cosa = 'el tipo de contacto';
	$pag_cancelar = 'tipo_contacto';
	if(!empty($_POST)){
		if ( ! Validator::permiso_eliminar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
        else {
			require("../sql/conexion.php");
			try{
				$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        	$consulta = "delete from tipos_contactos where id_tipo_contacto=?;";
	        	$stmt = $PDO->prepare($consulta);
	        	$stmt->execute( array ( $id ) );
	        	$PDO = null;
		        //Ejecutar procedimiento para bitacora ='}'
	        	Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 18, 3, $consulta ) );
				header("location: tipo_contacto");
			}
			catch( PDOException $Exception ) {
			    $error = $Exception->getMessage( );
			}
		}
	}
?>
