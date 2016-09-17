<?php
	require("../lib/database.php");
	require("../lib/page-privado.php");//Validar campos :D
	ob_start();
	$permisos = Page::header("Eliminar Entrega", "entrega");

	$id = null;
    if(!empty($_GET['id'])) 
    {
        $id = $_GET['id'];
    }

    if($id == null) 
    {
        header("location: entregas");
    }

	if(!empty($_POST))
	{

	    function mthEliminar($cod)
	    {
	    	require("../sql/conexion.php");
	        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $datos =$_GET['id'];
			$cod =base64_decode($datos);
	        $sql = "DELETE from horarios_entrega WHERE id_horario_entrega = ?";
	        $stmt = $PDO->prepare($sql);
	        $stmt->execute(array($cod));
	        $PDO = null;
	      	header("location: entregas");
		}
		mthEliminar($cod);
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Eliminar producto</title>
	<link href="css/mycss.css" rel="stylesheet">
</head>
<body>
	
	<form method="post" name="frmMenu" enctype="multipart/form-data" class="center-align">
		<fieldset>
			<h3>¿Eliminar Horario?</h3>
			<div class="row">
            	<input type="hidden" name="id" value="<?php print($id);?>"/>
            	<button class="btn btn-default" type="submit" name="action">
            		Si
			  	</button class="btn-default">
            	<a class="" href="preguntas_frecuentes.php">
            		No
            	</a>
        	</div>
		</fieldset>
	</form>
	<!--Import jQuery before materialize.js-->
	<script src="../js/jquery.js"></script>
	<script src="../js/myjs.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>