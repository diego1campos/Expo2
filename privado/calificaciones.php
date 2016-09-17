<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Calificaciones</title>

	<link rel="stylesheet" type="text/css" href="../publico/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="../publico/css/sweet-alert.css">
	<link rel="stylesheet" type="text/css" href="../publico/css/mainD.css" />
  	<link rel="stylesheet" type="text/css" href="../publico/css/font-awesome.min.css"><!-- Font Awesome -->
	<link rel="stylesheet" type="text/css" href="../publico/css/ionicons.min.css"><!-- Ionicons -->
	<link rel="stylesheet" type="text/css" href="plugins/datatables/dataTables.bootstrap.css"><!-- Theme style -->
	<link rel="stylesheet" type="text/css" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/skin-red.min.css">
</head>
<body class="hold-transition skin-red sidebar-mini">

<?php include 'inc/menu.php'; ?>
<div class="wrapper">
	<?php include 'inc/aside.php'; ?><!--Barra de menu sidebar-->
	<div class="content-wrapper"><!-- Contenedor -->
		<section class="content-header">
	      <h1>Calificaciones</h1>
	    </section>
		<section class="content">
	        <form name="frmpresentacion" method="post" enctype="multipart/form-data">
				<div class="row">
		    		<div class="col-xs-12">
		        		<div class="box">
		        			<div class="box-body">
		        				<br>
								<div class="col-sm-8 col-md-8 col-lg-8">
									<div class="input-group">
										<span class="input-group-addon no_padding_input-group"><button type="submit" name="action" value="Buscar" class="glyphicon glyphicon-search nobtn padding_input-group"></button></span>
										<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe el usuario, producto, calificacion o fecha..."/>
									</div>
								</div>
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
					                            <th class="col-sm-3 col-md-3 col-lg-3">Usuario</th>
					                            <th class="col-sm-3 col-md-3 col-lg-3">Producto</th>
					                            <th class="col-sm-3 col-md-3 col-lg-3">Calificacion</th>
					                            <th class="col-sm-3 col-md-3 col-lg-3">Fecha</th>
									        </tr>
									    </thead>
									    <tbody>
										<?php
											require("../sql/conexion.php");
											$consulta = "select nombre_producto, usuario, fecha_ingreso, calificacion_producto, id_calificacion_producto from calificacion_productos c, productos p, clientes cli where c.id_cliente = cli.id_cliente and c.id_producto = p.id_producto";
											if( isset( $_POST['txtBuscar'] ) != "" && Validator::numeros_letras( $_POST['txtBuscar'] ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " and ( calificacion_producto like '%$busqueda%' or nombre_producto LIKE '%$busqueda%' or usuario LIKE '%$busqueda%' or fecha_ingreso LIKE '%$busqueda%' ) ORDER BY fecha_ingreso ASC;";
							    			}
							    			else $consulta = $consulta . " ORDER BY fecha_ingreso ASC;";
											$comentarios = ""; //Arreglo de datos
											foreach($PDO->query($consulta) as $datos){
												$comentarios .= "<tr>";
						                            //$comentarios .= "<input type='hidden' class='id_calificacion' value='$datos[id_calificacion_producto]' />";
						                            $comentarios .= "<td>$datos[usuario]</td>";
						                            $comentarios .= "<td>$datos[nombre_producto]</td>";
						                            $comentarios .= "<td>$datos[calificacion_producto]</td>";
						                            $comentarios .= "<td>$datos[fecha_ingreso]</td>";
					                          $comentarios .= "</tr>";
											}
											print($comentarios);
											$PDO = null;
										?>
										</tbody>
									</table>
								</div>
							</div>
		        		</div>
		        	</div>
		        </div>
		    </form>
		</section><!--Conent ='DD-->
	</div><!--ConentWrapper ='DD-->
</div><!--Wrapper ='DD-->

<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>

<script src="../publico/js/bootstrap.min.js"></script>

<script src="dist/js/app.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>

<script src="plugins/datatables/dataTables.bootstrap.js"></script>

<script src="../publico/js/mainB.js"></script>

</body>
</html>