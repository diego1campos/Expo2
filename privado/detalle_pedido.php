<?php
    //Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
	ob_start();//Definicion: Esta función activará el almacenamiento en búfer de la salida. Mientras dicho almacenamiento esté activo, no se enviará ninguna salida desde el script (aparte de cabeceras); en su lugar la salida se almacenará en un búfer interno.	
	//Desactivar errores no funciona :D
	//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	require("../lib/validator.php");
	//!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
	require("../lib/page-privado.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Detalle pedido", "pedidos");
?>
		            			<br>
		            			<div class="col-sm-8 col-md-8 col-lg-8">
		            				<!--a href="<?php
				            					/*if ( $_GET['pag_an'] == "en" ) $pag_anterior = "entregar_pedidos.php";
												else if ( $_GET['pag_an'] == "pe" ) $pag_anterior = "pedidos.php";
												else if ( $_GET['pag_an'] == "en-ad" ) $pag_anterior = "entregar_pedidos-admin.php";
				            					print ( $pag_anterior ); */
		            						?>"><span class="glyphicon glyphicon-arrow-left treintapx"></span></a-->
		            			</div>
		            			<div class="col-sm-8 col-md-8 col-lg-8">
									<div class="input-group">
										<span class="input-group-addon no_padding_input-group"><button type="submit" name="action" value="Buscar" class="glyphicon glyphicon-search nobtn padding_input-group"></button></span>
										<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe el nombre del producto o presentacion..."/>
									</div>
								</div>
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
									            <th class="col-sm-4 col-md-4 col-lg-4">Imagen producto</th>
									            <th class="col-sm-3 col-md-3 col-lg-3">Nombre producto</th>
									            <th class="col-sm-1 col-md-1 col-lg-1">Precio</th>
									            <th class="col-sm-2 col-md-2 col-lg-2">Presentacion</th>
									        </tr>
									    </thead>
									    <tbody>
										<?php
											$consulta = "SELECT detalles_pedidos.id_img_producto, productos.id_producto, nombre_producto, precio_producto, imagen_producto, presentacion, cantidad_producto FROM ( ( (`detalles_pedidos` inner join img_productos on img_productos.id_img_producto = detalles_pedidos.id_img_producto) inner join productos on productos.id_producto = img_productos.id_producto) inner join presentaciones on presentaciones.id_presentacion = img_productos.id_presentacion) inner join pedidos on pedidos.id_pedido = detalles_pedidos.id_pedido WHERe detalles_pedidos.id_pedido = ?/* and pedidos.estado = 0*/";
											if( isset( $_POST['txtBuscar'] ) != "" && Validator::letras( $_POST['txtBuscar'] ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " and ( nombre_producto LIKE '%$busqueda%' or presentacion LIKE '%$busqueda%' ) order by nombre_producto ASC";
							    			}
							    			else $consulta = $consulta . " order by nombre_producto ASC";
							    			if ( isset( $_GET['id'] ) && Validator::numero( base64_decode( $_GET['id'] ) ) /*&& isset( $_GET['pag_an'] ) && ( $_GET['pag_an'] == "en" || $_GET['pag_an'] == "pe" || $_GET['pag_an'] == "en-ad" ) */ ) $data_productos = Database::getRows( $consulta, array( base64_decode($_GET['id']) ) );
										  	else{
										  		header( "location: pedidos" );
										  		exit();
										  	}
											$productos = ""; //Arreglo de datos
											if ( $data_productos != null ){
												foreach($data_productos as $datos){
													$productos .= "<tr>";
														$productos .= "<td><img src='../img/productos/$datos[imagen_producto]' alt='$datos[nombre_producto]' class='img-responsive'></td>";
														$productos .= "<td>$datos[nombre_producto]</td>";
														$productos .= "<td>$$datos[precio_producto]</td>";
														$productos .= "<td>$datos[presentacion]</td>";
													$productos .= "</tr>";
												}
												print($productos);
											}
											else{
												/*if ( $_GET['pag_an'] == "en" ) $pag_anterior = "entregar_pedidos.php";
												else if ( $_GET['pag_an'] == "pe" ) $pag_anterior = "pedidos.php";
												else if ( $_GET['pag_an'] == "en-ad" ) $pag_anterior = "entregar_pedidos-admin.php";
										  		header( "location: " . $pag_anterior );
										  		exit();*/
										  	}
										?>
										</tbody>
									</table>
								</div>
							</div>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>