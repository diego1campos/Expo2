<?php
  	if(!empty($_POST)){
  		try{
  			require ('../lib/validator.php');
	    	if ( ! isset( $_POST['direccion'] ) && isset( $_POST['id_direccion'] ) ){
	    		if ( Validator::numero( trim($_POST['id_direccion']) ) ){
					require ('../lib/database.php');
					$exito = Database::executeRow( "delete from direcciones where id_direccion = ?;", array( $_POST['id_direccion'] ) );
					if ( $exito == 1 ) $exito = "eliminado";
					echo json_encode($exito);
				}
				else echo json_encode("Id de direccion invalida.");
	    	}
	    	else{
		    	if ( Validator::numeros_letras( trim( $_POST['direccion'] ) ) ){
		    		if ( isset( $_POST['id_direccion'] ) ){
			    		if ( Validator::numero( trim($_POST['id_direccion']) ) ){
							require ('../lib/database.php');
							$exito = Database::executeRow( "update direcciones set direccion = ? where id_direccion = ?;", array( $_POST['direccion'], $_POST['id_direccion'] ) );
							if ( $exito == 1 ) $exito = "actualizado";
							echo json_encode($exito);
						}
						else echo json_encode("Id de direccion invalida.");
					}
					else{
						session_start();
						require ('../sql/conexion.php');
						$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$stmt = $PDO->prepare( "insert into direcciones ( id_cliente, direccion ) values (?, ?);" );
						$exito = $stmt->execute( array( $_SESSION['id_cliente'], $_POST['direccion'] ) );
						if ( $exito == 1 ) $exito = $PDO->lastInsertId();
						echo json_encode($exito);
					}
				}
				else echo json_encode("Direccion invalida, solo se permiten numeros y letras.");
			}
		}
		catch( Exception $Exception ) {
		    echo json_encode( $Exception->getMessage( ) );
		}
  	}
?>