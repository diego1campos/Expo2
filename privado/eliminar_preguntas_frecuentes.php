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
    if( $id == null || ! Validator::numero( $id ) ) header("location: preguntas_frecuentes");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}

	$cosa = 'esta pregunta';
	$pag_cancelar = 'preguntas_frecuentes';
	if(!empty($_POST)){
		require("../sql/conexion.php");
		if ( ! Validator::permiso_eliminar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
		try{
			$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        	$consulta = "delete from preguntas_frecuentes where id_pregunta_frecuente=?;";
        	$stmt = $PDO->prepare($consulta);
        	$stmt->execute( array ( $id ) );
        	//Ejecutar procedimiento para bitacora ='}'
	        $consulta = "call inserta_bitacora( $_SESSION[id_empleado], 13, 3,'".$consulta."');";
	        $stmt = $PDO->prepare($consulta);
	        $stmt->execute();//array(null)
	        //Ejecutar procedimiento para bitacora ='}'
        	$PDO = null;
			header("location: preguntas_frecuentes");
		}
		catch( PDOException $Exception ) {
		    echo $Exception->getMessage( );
		}
	}
?>

<?php include 'inc/eliminar.php'; ?>