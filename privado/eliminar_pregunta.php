<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
    require("../lib/validator.php");//Validar
    require("../lib/database.php");
    require("../lib/page-privado.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Eliminar pregunta de seguridad", "preguntas");
    $id = null;
	if(!empty($_GET['id_preguntas'])) $id = base64_decode( $_GET['id_preguntas'] );
    if( $id == null || ! Validator::numero( $id ) ){
    	header("location: preguntas");
    	exit();
	}
	$cosa = 'la pregunta';
	$pag_cancelar = 'preguntas';
	if(!empty($_POST)){
		if ( ! Validator::permiso_eliminar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
        else {
			require("../sql/conexion.php");
			try{
				$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        	$consulta = "delete from preguntas where id_preguntas=?;";
	        	$stmt = $PDO->prepare($consulta);
	        	$stmt->execute( array ( $id ) );
	        	$PDO = null;
		        //Ejecutar procedimiento para bitacora ='}'
	        	Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 12, 3, $consulta ) );
				header("location: preguntas");
			}
			catch( PDOException $Exception ) {
			    $error = $Exception->getMessage( );
			}
		}
	}
?>
<?php include 'inc/eliminar.php'; ?>