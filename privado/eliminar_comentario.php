<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
    require("../lib/validator.php");//Validar
    require("../lib/database.php");
    require("../lib/page-privado.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Eliminar comentario", "comentarios_productos");
	$id = null;
	$cosa = 'comentario';
	$titulo = 'Comentarios';
	$pag_cancelar = 'comentarios';
    if(!empty($_GET['id'])) {
        $id = base64_decode( $_GET['id'] );
    }
    if($id == null || ! Validator::numero( $id ) ) {
        header("location: comentarios");
        exit();
    }
	if(!empty($_POST)){
        if ( ! Validator::permiso_eliminar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
        else {
            require("../sql/conexion.php");
            try{
                $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $consulta = "delete from comentarios_productos where id_comentario=?;";
                $stmt = $PDO->prepare($consulta);
                $stmt->execute( array ( $id ) );
                $PDO = null;
                Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 24, 3, $consulta ) );
                header("location: comentarios");
            }
            catch( PDOException $Exception ) {
                $error = $Exception->getMessage( );
            }
        }
	}
?>
<?php include 'inc/eliminar.php'; ?>