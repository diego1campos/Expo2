<?php

	$id = null;
    if(!empty($_GET['id'])) {
        $id = $_GET['id'];
    }

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Detalles de Compra</title>
</head>
<body class="hold-transition skin-red sidebar-mini">

<?php include 'inc/menu.php'; ?>
<div class="wrapper">
	<?php include 'inc/aside.php'; ?><!--Barra de menu sidebar-->
	<div class="content-wrapper"><!-- Contenedor -->
		<section class="content-header">
	      <h1>Detalles de Compra</h1>
	    </section>
	    <form method="post">
		<section class="content">
	      	<div class="row">
	    		<div class="col-xs-12">
	        		<div class="box">
	            		<div class="box-body">

	            			<div class="col-sm-1 col-md-1 col-lg-1">
								<button class="btn btn-danger" type="submit" name="action" >
							     <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
							    </button>
							</div>

	            			<div class="col-sm-7 col-md-7 col-lg-7">
								<div class="form-group">
									<input class="form-control" id="txtProducto" type="text" class="validate" 
									 name="txtNombre" placeholder="Nombre de Producto..."/>
								</div>
							</div>

						</div>
						<div class="box-body table-responsive">
							<table class="table table-bordered table-hover" id="tabla_productos">
							    <thead>
							        <tr>
							            <th class="col-sm-2 col-md-2 col-lg-2">Categoria</th>
							            <th class="col-sm-4 col-md-4 col-lg-4">Producto</th>
							            <th class="col-sm-1 col-md-1 col-lg-1">Precio</th>
							            <th class="col-sm-2 col-md-2 col-lg-2">Cantidad-Lb</th>
							        </tr>
							    </thead>
							    <tbody id="lista_productos">
								<?php
									require("../sql/conexion.php");
									$consulta = "SELECT id_producto, categoria, nombre_producto, precio_producto, existencias FROM productos inner join categorias on categorias.id_categoria = productos.id_categoria where id_producto = $id";
									$productos = ""; //Arreglo de datos
									foreach($PDO->query($consulta) as $datos){
										$productos .= "<tr>";
											
											$productos .= "<td>$datos[categoria]</td>";
											$productos .= "<td>$datos[nombre_producto]</td>";
											$productos .= "<td>$datos[precio_producto]</td>";
											$productos .= "<td>$datos[existencias]</td>";
										
										$productos .= "</tr>";
									}
									print($productos);
									$PDO = null;
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section><!--Conent ='DD-->
		</form>
	</div><!--ConentWrapper ='DD-->
</div><!--Wrapper ='DD-->
</body>
</html>