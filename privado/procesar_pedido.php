<?php 

session_start();
require("../lib/validator.php");

$id = base64_decode($_GET['id']);
if ( isset( $_GET['id'] ) && Validator::numero( $id ) ) {
		require("../sql/conexion.php");
		$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$consulta = "update pedidos set estado=1 where id_pedido=?";
		$stmt = $PDO->prepare($consulta);
		$exito = $stmt->execute(array($id));
		if ( $exito == 1 ) Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 11, 2, $consulta ) );
		
		//Ahora se ingresa el valor en entregar pedidos
		$consulta = "INSERT into entregar_pedidos (id_empleado, id_pedido, fecha_entrega) values (?,?,?)";
		$stmt = $PDO->prepare($consulta);
		$exito = $stmt->execute( array( $_SESSION['id_empleado'] , $id, date("Y-m-d H:i:s") ) );
		if ( $exito == 1 ) Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 8, 1, $consulta ) );

		header("location: pedidos");
}
else header("location: pedidos");




?>