<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
	ob_start();
	require("../lib/validator.php");//Validar
	require("../lib/database.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page-privado.php");
    $permisos = Page::header("Eliminar redes", "redes_sociales");
    $id = null;
	if(!empty($_GET['id'])) $id = base64_decode($_GET['id']);
    if( $id == null || ! Validator::numero( $id ) ) header("location: redes_sociales");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}

	$cosa = 'la red social';
	$pag_cancelar = 'redes_sociales';
	if(!empty($_POST)){
		require("../sql/conexion.php");
		if ( ! Validator::permiso_eliminar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
		else{
		try{
			$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        	$consulta = "delete from redes_sociales where id_red_social=?;";
        	$stmt = $PDO->prepare($consulta);
        	$stmt->execute( array ( $id ) );
        	//Ejecutar procedimiento para bitacora ='}'
	        $consulta = "call inserta_bitacora( $_SESSION[id_empleado], 16, 3,'".$consulta."');";
	        $stmt = $PDO->prepare($consulta);
	        $stmt->execute();//array(null)
	        //Ejecutar procedimiento para bitacora ='}'
        	$PDO = null;
			header("location: redes_sociales");
		}
		catch( PDOException $Exception ) {
		    $error = $Exception->getMessage( );
		}
	}
	}
?>
<?php include 'inc/eliminar.php'; ?>