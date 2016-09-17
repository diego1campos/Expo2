<?php
  	if(!empty($_POST)){
	  	require ('../lib/validator.php');
	  	require ('../lib/database.php');
	    if ( Validator::numero( trim($_POST['cantidad']) ) ){
	    	if ( Validator::numero( trim($_POST['id_img_producto']) ) ){
				try{
				    $sql = "update carrito set cantidad_producto = ? where id_img_producto = ?";
				    $exito = Database::executeRow( $sql, array ( $_POST['cantidad'], $_POST['id_img_producto'] ) );
				    echo $exito;
				}
				catch( Exception $Exception ) {
				    echo $Exception->getMessage( );
				}
			}
			else echo "Cantidad ingresada invalida.";
		}
		else echo "Id de imagen invalido.";
  	}
?>