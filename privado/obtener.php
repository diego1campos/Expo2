<?php  

	require("../sql/conexion.php");
	
	//INCLUIS LA CLASE DE CONEXION
	//if ($_POST['sql'] == 3) {
		$id = $_POST['id'];
		//LA CONSULTA PARA LOS PERMISOS

		$sql = "SELECT * FROM tipos_usuarios WHERE id_tipo_usuario=?";
		$stmt = $PDO->prepare($sql);
	    $stmt->execute(array($id));
		while ($datos = $stmt->fetch(PDO::FETCH_BOTH)) {
			//EN LOS CORCHTES VAN LOS NOMBRE DE LOS CAMPOS QUE DEVULVE LA CONSULTA
			$valores = array(
				0 => $datos['tipo_usuario'],
				1 => $datos['calificacion_productos'],
				2 => $datos['categorias'],
				3 => $datos['clientes'],
				4 => $datos['comentarios_productos'],
				5 => $datos['contactos_empresa'],
				6 => $datos['datos'],
				7 => $datos['detalles_pedidos'],
				8 => $datos['detalles_pedidos_local'],
				9 => $datos['direcciones'],
				10 => $datos['empleados'],
				11 => $datos['entregar_pedidos'],
				12 => $datos['existencias'],
				13 => $datos['horarios_entrega'],
				14 => $datos['index_imagenes'],
				15 => $datos['img_productos'],
				16 => $datos['pedidos'],
				17 => $datos['pedidos_local'],
				18 => $datos['preguntas'],
				19 => $datos['preguntas_frecuentes'],
				20 => $datos['presentaciones'],
				21 => $datos['productos'],
				22 => $datos['redes_sociales'],
				23 => $datos['terminos_condiciones'],
				24 => $datos['tipos_contactos'],
				25 => $datos['tipos_usuarios'],
				26 => $datos['valores'],
				27 => $datos['backup']
			);
		}
		echo json_encode($valores);
		//SE LE CAMBIAS POR LA VARIABLE DE CONEXION
		$PDO = null;
	//}
?>