<?php
	$id = 1;
    if(!empty($_GET['id'])) {
        $id = $_GET['id'];
    }
    if($id == null) {
        header("location: consultar_cliente.php");
    }
    
	if(!empty($_POST))
	{
		//Post values
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$usuario = $_POST['usuario'];
		$telefono = $_POST['telefono'];
		$correo = $_POST['correo'];
		$direccion = $_POST['direccion'];

	}
	else
	{
		require("../sql/conexion.php");
		$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM clientes WHERE id_cliente = $id";
        $stmt = $PDO->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		$PDO = null;
		$nombre = $data['nombres_cliente'];
		$apellido = $data['apellidos_cliente'];
		$usuario = $data['usuario'];
		$telefono = $data['telefono'];
		$correo = $data['correo'];
		//$direccion = $data['direccion'];
		 //direccion
	    require("../sql/conexion.php");
		$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql1 = "SELECT * from direcciones where id_cliente = $id";
        $stmt1 = $PDO->prepare($sql1);
		$stmt1->execute();
		$data = $stmt1->fetch(PDO::FETCH_ASSOC);
		$PDO = null;
		$direccion = $data['direccion'];
	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Consulta cliente</title>

	<link rel="stylesheet" type="text/css" href="../publico/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="../publico/css/sweet-alert.css">
	<link rel="stylesheet" type="text/css" href="../publico/css/mainD.css" />
	<link rel="stylesheet" type="text/css" href="css/Gerardo.css" />
  	<link rel="stylesheet" type="text/css" href="../publico/css/font-awesome.min.css"><!-- Font Awesome -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"><!-- Ionicons -->
	<link rel="stylesheet" type="text/css" href="plugins/datatables/dataTables.bootstrap.css"><!-- Theme style -->
	<link rel="stylesheet" type="text/css" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/skin-red.min.css">
</head>
<body class="hold-transition skin-red sidebar-mini">

<?php include 'inc/menu.php'; ?>
<div class="wrapper ">
	<?php include 'inc/aside.php'; ?><!--Barra de menu sidebar-->
	<div class="content-wrapper margencc"><!-- Contenedor -->
		<section class="content-header">
	      <h1>Clientes</h1>
	    </section>
		<section class="content">
			<div class="container col-lg-12 ">
        		<div class="row centered-form">
        			<div class="col-xs-12 col-sm-8 col-md-4 col-lg-12">
        				<div class="panel panel-default">
			 				<div class="panel-body">
					    		<form role="form">
					    			<?php
										require("../sql/conexion.php");
										$consulta = "SELECT img_usuario from clientes where id_cliente= $id";

										$tabla = ""; //Arreglo de datos
										foreach($PDO->query($consulta) as $datos)
										{
										$tabla .= "<div class='col-lg-offset-5'>";
										$tabla .= " <img src='../publico/img/clientes/$datos[img_usuario]' alt='Error al cargar imagen' class='consultaclienteimagen img-circle'>";     
										$tabla .= "</div>";
										}
										print($tabla);
										$PDO = null;
									?>
					    			<div class="row margeninputs">
					    				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					    					<div class="form-group">
					    					<label for="">Nombre:</label>
					                			<input type="text" name="nombre" id="first_name" class="form-control input-sm " placeholder="Nombres" value="<?php print((isset($nombre) != "")?"$nombre":""); ?>">
					    					</div>
					    				</div>
					    				<div class="col-xs-6 col-sm-6 col-md-6">
					    					<div class="form-group">
					    						<label for="">Telefono:</label>
					    						<input type="text" name="telefono" id="last_name" class="form-control input-sm" placeholder="Usuario" value="<?php print((isset($telefono) != "")?"$telefono":""); ?>">
					    					</div>
					    				</div>
					    			</div>

					    			<div class="row margeninputs">
					    				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					    					<div class="form-group">
					    					<label for="">Apellidos:</label>
					                			<input type="text" name="apellido" id="first_name" class="form-control input-sm" placeholder="Apellidos" value="<?php print((isset($apellido) != "")?"$apellido":""); ?>">
					    					</div>
					    				</div>
					    				<div class="col-xs-6 col-sm-6 col-md-6">
					    					<div class="form-group">
					    						<label for="">Correo:</label>
					    						<input type="text" name="correo" id="last_name" class="form-control input-sm" placeholder="Contraseña" value="<?php print((isset($correo) != "")?"$correo":""); ?>">
					    					</div>
					    				</div>
					    			</div>

					    			<div class="row margeninputs">
					    			</div>
					    			<div class="row margeninputs">
					    				<div class="col-xs-6 col-sm-6 col-md-6">
					    					<div class="form-group">
					    						<label for="">Usuario:</label>
					    						<input type="text" name="usuario" id="usuario" class="form-control input-sm" placeholder="Fecha de nacimiento" value="<?php print((isset($usuario) != "")?"$usuario":""); ?>">
					    					</div>
					    				</div>
					    				<div class="col-xs-6 col-sm-6 col-md-6">
					    					<div class="form-group">
					    						<label for="">dirección:</label>
					    						<input type="text" name="direccion" id="direccion" class="form-control input-sm" placeholder="Fecha de nacimiento" value="<?php print((isset($direccion) != "")?"$direccion":""); ?>">
					    					</div>
					    				</div>
					    			</div>
					    			
					    			<a href="clientes.php"><input type="" value="close" class="btn btn-info btn-block"></a>
					    		
					    		</form>
			    			</div>
			    		</div>
	    			</div>
    			</div>
    		</div>
		</section><!--Conent ='DD-->
	</div><!--ConentWrapper ='DD-->
</div><!--Wrapper ='DD-->

<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>

<script src="../publico/js/bootstrap.min.js"></script>

<script src="dist/js/app.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.js"></script>

<script src="plugins/datatables/dataTables.bootstrap.js"></script>

<script src="../publico/js/mainD.js"></script>

</body>
</html>