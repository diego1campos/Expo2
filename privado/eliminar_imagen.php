<?php
    //Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
    require("../lib/validator.php");//Validar
    require("../lib/database.php");
    require("../lib/page-privado.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    $permisos = Page::header("Eliminar imagen", "img_productos");
	$id = null;
	$producto = null;
	$imagen = null;
	$cosa = 'imagen';
	$titulo = 'Imagenes';
    if(!empty($_GET['id'])) {
        $id = base64_decode( $_GET['id'] );
        $pag_cancelar = 'img_pro?id='.$_GET['producto'];
        $producto = base64_decode( $_GET['producto'] );
        $imagen = base64_decode( $_GET['imagen'] );
    }
    if( $id == null || $producto == null || ! Validator::numero( $id ) || ! Validator::numero( $producto ) ) {
        header("location: productos");
        exit();
    }
	if(!empty($_POST)){
        if ( ! Validator::permiso_eliminar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
        else {
    		require("../sql/conexion.php");
    		try{
    			$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            	$consulta = "delete from img_productos where id_img_producto=?;";
            	$stmt = $PDO->prepare($consulta);
            	$exito = $stmt->execute( array ( $id ) );
            	if ( $exito == true ){
            		unlink("../img/productos/$imagen"); //Función para eliminar la imagen.
                    //Ejecutar procedimiento para bitacora ='}'
                    Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 10 , 3, $consulta ) );
            	}
            	header("location: img_pro?id=$_GET[producto]");
            	$PDO = null;
    		}
    		catch( PDOException $Exception ) {
    		    $error = $Exception->getMessage();
    		}
        }
	}
?>
<?php include 'inc/eliminar.php'; ?>