<?php
		//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
    require("../lib/validator.php");//Validar
    require("../lib/database.php");
    require("../lib/page-privado.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Eliminar backup", "backup");
    $id = null;
	if(!empty($_GET['id'])) $id = base64_decode( $_GET['id'] );
  if( $id == null || ! Validator::respaldo( $id ) ){
    	header("location: backup");
    	exit();
	}
	$cosa = 'el backup';
	$pag_cancelar = 'backup';
	if(!empty($_POST)){
		if ( ! Validator::permiso_eliminar( $permisos ) ) $error = "No tiene permisos para realizar esta acción.";
    else {
			try{
				shell_exec( "rm -f '/var/www/sitio.com/backups/".$id."'" );
				header("location: backup");
			}
			catch( PDOException $Exception ) {
			    $error = $Exception->getMessage( );
			}
		}
	}
?>
<?php include 'inc/eliminar.php'; ?>