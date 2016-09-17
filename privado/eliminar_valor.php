<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
	ob_start();
	require("../lib/validator.php");//Validar
	require("../lib/database.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page-privado.php");
    $permisos = Page::header("Valores", "valores");
    $id = null;
	if(!empty($_GET['id'])) $id = base64_decode($_GET['id']);
    if( $id == null || ! Validator::numero( $id ) ) header("location: valores");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
   
	$cosa = 'este valor';
	$pag_cancelar = 'valores';	
	if(!empty($_POST)){
		require("../sql/conexion.php");
		if ( ! Validator::permiso_eliminar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
		else{
		try{
			$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        	$consulta = "delete from valores where id_valor=?;";
        	$stmt = $PDO->prepare($consulta);
        	$stmt->execute( array ( $id ) );
        	//Ejecutar procedimiento para bitacora ='}'
	        $consulta = "call inserta_bitacora( $_SESSION[id_empleado], 20, 3,'".$consulta."');";
	        $stmt = $PDO->prepare($consulta);
	        $stmt->execute();//array(null)
	        //Ejecutar procedimiento para bitacora ='}'
        	$PDO = null;
			header("location: valores");
		}
		catch( PDOException $Exception ) {
		    $error = $Exception->getMessage( );
		}
	}
	}
?>
<?php include 'inc/eliminar.php'; ?>


