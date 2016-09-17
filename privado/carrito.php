<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Carrito</title>
</head>
<body class="hold-transition skin-red sidebar-mini">

<?php include 'inc/menu.php'; ?>
<div class="wrapper">
	<?php include 'inc/aside.php'; ?><!--Barra de menu sidebar-->
	<div class="content-wrapper"><!-- Contenedor -->
		<section class="content-header">
	      <h1>Carrito</h1>
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

	            			<div class="col-sm-4 col-md-4 col-lg-4">
								<div class="form-group">
								<input onpaste=";return false"  type="text" name="txtBuscar" length="100" maxlenght="100" class="form-control vletras_esp <?php print( ( isset($er_buscar) ) ? "$er_buscar": ""); ?>" type="text" value="<?php print((isset($buscar) != "")?"$buscar":""); ?>" required />
								</div>
							</div>

							<div class="col-sm-4 col-md-4 col-lg-4">
								<div class="form-group">
							<input onpaste=";return false"  type="text" name="txtBuscar2" length="100" maxlenght="100" class="form-control vletras_esp <?php print( ( isset($er_buscar2) ) ? "$er_buscar2": ""); ?>" type="text" value="<?php print((isset($buscar2) != "")?"$buscar2":""); ?>" required />
								</div>
							</div>
						</div>
					
					<div class="box-body table-responsive">
							<table class="table table-bordered table-hover" id="tabla_productos">
							    <thead>
							        <tr>
							     
							            <th class="col-sm-2 col-md-2 col-lg-2">Nombre</th>
							            <th class="col-sm-2 col-md-2 col-lg-2">Apellido</th>
							            <th class="col-sm-1 col-md-1 col-lg-1">Producto</th>
							            <th class="col-sm-1 col-md-1 col-lg-1">Cantidad</th>
							          	<th class="col-sm-1 col-md-1 col-lg-1">Mas</th>
							           
							        </tr>
							    </thead>
			<tbody id="lista_productos">
						<?php
						if(!empty($_POST))
						  {
						    require("../sql/conexion.php");
						    require("../lib/validator.php");//Validar campos :D
						    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						    try
						    {
							    $buscar = $_POST['txtBuscar'];
								$buscar2 = $_POST['txtBuscar2'];
							    if (Validator::letras($buscar) && Validator::letras($buscar2))
							    {
								      	 	
								  $consulta = "SELECT * from carritooo WHERE nombres_cliente LIKE '$buscar%' and apellidos_cliente LIKE '$buscar2%'";
								 // $stmt = $PDO->prepare($consulta);
								 // $stmt->execute(array ($buscar, $buscar2));
								           //Ejecutar procedimiento para bitacora ='}'
								           //$consulta = "call inserta_bitacora(1,1,1,'".$consulta."');";
								           //www.mega-dvdrip.com
								           // $stmt->execute();//array(null)
								  $productos = ""; //Arreglo de datos
								foreach($PDO->query($consulta) as $datos)
								{
									$productos .= "<tr>";
									$productos .= "<td>$datos[nombres_cliente]</td>";
									$productos .= "<td>$datos[apellidos_cliente]</td>";
									$productos .= "<td>$datos[nombre_producto]</td>";
									$productos .= "<td>$datos[cantidad_producto]</td>";

									$productos .= '<td class="text-center">
									<a href="detalles_compra.php?id='.$datos
									['id_producto'].'" 
									class = "a_text_normal glyphicon glyphicon-edit padding_right_nojs"></a>
									</td>';
									$productos .= "</tr>";


								}

								$productos .= '<td class="text-center">
									<a href="entregas.php?id='.$datos
									['id_cliente'].'" 
									class = "a_text_normal glyphicon glyphicon-edit padding_right_nojs"></a>
								</button>';
								

								print($productos);
													$PDO = null;
								}

								  else $error_data = "Error, solo letras.";	
								  ( ! ( Validator::letras($buscar) ) ) ? $er_buscar = "error_data" : "";
								  ( ! ( Validator::letras($buscar2) ) ) ? $er_buscar2 = "error_data" : "";
								}
								catch( Exception $Exception ) 
								{
								    $error = $Exception->getMessage( );
								}
							}
							?>
							</tbody>
							<?php
		    				print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
		    				print ( ( isset($error) ) ? '<div class="alert alert-danger" role="alert">'.$error.'</div>' : "" );
			                ?>	   
					</div>
				</div>
			</div>
		</section><!--Conent ='DD-->
		</form>
	</div><!--ConentWrapper ='DD-->
</div><!--Wrapper ='DD-->
</body>
</html>