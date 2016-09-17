<?php
    //Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
	ob_start();
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    Page::header("Compras realizadas");
    /*if ( isset( $_GET['id'] ) && Validator::numero( $_GET['id'] ) ){
    	//a
    }
    else header("location: compras_realizadas.php");*/
?>
<div class="container margin_top_navbar">
	
	<form method="post" id="compras">
		<ul class="nav nav-tabs nav-justified">
			<li <?php print( ( /*! isset( $_POST['id_pedido'] ) && */isset( $_POST['id_pedido_local'] ) ) ? '' : 'class="active"' ); ?>><a data-toggle="tab" href="#pedidos">Pedidos</a></li>
			<li <?php print( ( isset( $_POST['id_pedido_local'] ) ) ? 'class="active"' : '' ); ?>><a data-toggle="tab" href="#pedidos_local">Pedidos local</a></li>
		</ul>

		<div class="tab-content alinear">
			<div class="tab-pane fade <?php print( ( isset( $_POST['id_pedido_local'] ) ) ? '' : "in active" ); ?>" id="pedidos">
				<?php
					if ( isset($_POST['id_pedido'] ) && Validator::numero( $_POST['id_pedido'] ) ){

						$imprimir = '<div class="row thumbnail colordiv" id="divtitulos">
										<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-1 col-md-2 col-md-offset-1 col-lg-2 col-lg-offset-1">
											<p class="textitulo">Producto</p>
										</div>
										<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-1 col-md-2 col-md-offset-1 col-lg-2 col-lg-offset-1">
											<p class="textitulo">Presentacion</p>
										</div>
										<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-1 col-md-2 col-md-offset-1 col-lg-2 col-lg-offset-1">
											<p class="textitulo">Cantidad</p>
										</div>
										<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-1 col-md-2 col-md-offset-1 col-lg-2 col-lg-offset-1">
											<p class="textitulo">Cantidad</p>
										</div>
									</div>';
						$consulta = "SELECT nombre_producto, detalles_pedidos.precio_producto, imagen_producto, cantidad_producto, presentacion FROM ( ( ( (detalles_pedidos inner join img_productos on img_productos.id_img_producto = detalles_pedidos.id_img_producto) inner join pedidos on pedidos.id_pedido = detalles_pedidos.id_pedido) inner join productos on productos.id_producto = img_productos.id_producto ) inner join presentaciones on presentaciones.id_presentacion = img_productos.id_presentacion) inner join direcciones on direcciones.id_direccion = pedidos.id_direccion WHERe id_cliente=? and detalles_pedidos.id_pedido = ? order by nombre_producto ASC";

						require ('../lib/paginacion.php');
						$Paginacion = new Paginacion();
						$records_per_page=10;
						$parametro = array( $_SESSION['id_cliente'], $_POST['id_pedido'] );
						$newconsulta = $Paginacion->paging($consulta, $records_per_page);//Me regresa la consulta con el limit, claro que cada vez que le des uno al paging, lo modifica :)

						$compras_detalles = Database::getRows( $newconsulta, $parametro );

						if ( $compras_detalles != null ){
							foreach ( $compras_detalles as $compra ) {//<!--input type="hidden" class="id_img_producto" value="'.$compra['id_compra'].'" /-->
							  $imprimir .= '<div class="row thumbnail divinopro colordiv"><!-- se añade la clase size a todas las imagenes-->
												
												<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 divima"><!--Se agrega la imagen-->
													<img src="../img/productos/'.$compra['imagen_producto'].'" alt="Chuleta orrinca" class="size">
												</div>
												<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 divnomb">
													<p class="texnormal">'.$compra['nombre_producto'].'</p>
													<!--p class="texnormal producto_precio">$'.$compra['precio_producto'].'</p-->
													
												</div>
												<div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">
													<p class="texnormal cantidad">'.$compra['presentacion'].'</p>
												</div>
												<div class="div_cant_sub">
													<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
														<p class="texnormal cantidad">'.$compra['cantidad_producto'].'</p>
													</div>
												</div>

											</div>';
							}
							print( $imprimir );//Imprimo el resultado :D
							$imprimir = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center">
										 			<div class="pagination-wrap">
										            '.$Paginacion->paginglink($consulta, $records_per_page, $parametro).'
										        	</div>
										        </div>';
							print( $imprimir );
						} 
			    	}
			    	else{
						$imprimir = '<div class="row thumbnail colordiv" id="divtitulos">
										<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2">
											<p class="textitulo">Fecha compra</p>
										</div>
										<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2">
											<p class="textitulo">Total</p>
										</div>
										<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2">
											<p class="textitulo">Accion</p>
										</div>
									</div>';
						$consulta = "select * from pedidos inner join direcciones on direcciones.id_direccion = pedidos.id_direccion where id_cliente=?;";
						$compras = Database::getRows( $consulta, array( $_SESSION['id_cliente'] ) );

						if ( $compras != null ){
							foreach ( $compras as $compra ) {//<!--input type="hidden" class="id_img_producto" value="'.$compra['id_compra'].'" /-->
							  $imprimir .= '<div class="row thumbnail divinopro colordiv">
												<div class="col-xs-3 col-xs-offset-1 col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-1 col-lg-3 col-lg-offset-1 fecha_compra">
													<p class="texnormal">'.$compra['fecha_pedido'].'</p>
												</div>
												<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2 total">
													<p class="texnormal">$'.$compra['total'].'</p>
												</div>
												<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2">
													<button class="btn btn-primary" name="id_pedido" value="'.$compra['id_pedido'].'">Ver</button>
													<a href="recibo?p='.base64_encode( $compra['id_pedido'] ).'" class="btn btn-warning">Recibo</a>
												</div>
											</div>';//Por si acaso xd --> <a style="color: white;" href="compras_realizadas?id=' . $compra['id_pedido'] . '"></a>
							}
							print( $imprimir );//Imprimo el resultado :D
						}
						else print("<div class='alert alert-danger' role='alert'><i class='material-icons left'>No posee compras realizadas.</div>");
					}
				?>
			</div>
			<div class="tab-pane fade <?php print( ( isset( $_POST['id_pedido_local'] ) ) ? 'in active' : "" ); ?>" id="pedidos_local">
				<?php
					if ( isset($_POST['id_pedido_local'] ) && Validator::numero( $_POST['id_pedido_local'] ) ){

						$imprimir = '<div class="row thumbnail colordiv" id="divtitulos">
										<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2">
											<p class="textitulo">Producto</p>
										</div>
										<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2">
											<p class="textitulo">Presentacion</p>
										</div>
										<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2">
											<p class="textitulo">Cantidad</p>
										</div>
									</div>';
						$consulta = "SELECT nombre_producto, detalles_pedidos_local.precio_producto, imagen_producto, cantidad_producto, presentacion FROM ( ( ( (detalles_pedidos_local inner join img_productos on img_productos.id_img_producto = detalles_pedidos_local.id_img_producto) inner join pedidos_local on pedidos_local.id_pedido_local = detalles_pedidos_local.id_pedido_local) inner join productos on productos.id_producto = img_productos.id_producto ) inner join presentaciones on presentaciones.id_presentacion = img_productos.id_presentacion) WHERe id_cliente=? and detalles_pedidos_local.id_pedido_local = ? order by nombre_producto ASC";

						require ('../lib/paginacion.php');
						$Paginacion = new Paginacion();
						$records_per_page=10;
						$parametro = array( $_SESSION['id_cliente'], $_POST['id_pedido_local'] );
						$newconsulta = $Paginacion->paging($consulta, $records_per_page);//Me regresa la consulta con el limit, claro que cada vez que le des uno al paging, lo modifica :)

						$compras_detalles = Database::getRows( $newconsulta, $parametro );

						if ( $compras_detalles != null ){
							foreach ( $compras_detalles as $compra ) {//<!--input type="hidden" class="id_img_producto" value="'.$compra['id_compra'].'" /-->
							  $imprimir .= '<div class="row thumbnail divinopro colordiv"><!-- se añade la clase size a todas las imagenes-->
												
												<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 divima"><!--Se agrega la imagen-->
													<img src="../img/productos/'.$compra['imagen_producto'].'" alt="Chuleta orrinca" class="size">
												</div>
												<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 divnomb">
													<p class="texnormal">'.$compra['nombre_producto'].'</p>
													<!--p class="texnormal producto_precio">$'.$compra['precio_producto'].'</p-->
													
												</div>
												<div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">
													<p class="texnormal cantidad">'.$compra['presentacion'].'</p>
												</div>
												<div class="div_cant_sub">
													<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
														<p class="texnormal cantidad">'.$compra['cantidad_producto'].'</p>
													</div>
												</div>

											</div>';
							}
							print( $imprimir );//Imprimo el resultado :D
							$imprimir = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center">
										 			<div class="pagination-wrap">
										            '.$Paginacion->paginglink($consulta, $records_per_page, $parametro).'
										        	</div>
										        </div>';
							print( $imprimir );
						} 
			    	}
			    	else{
						$imprimir = '<div class="row thumbnail colordiv" id="divtitulos">
										<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2">
											<p class="textitulo">Fecha compra</p>
										</div>
										<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2">
											<p class="textitulo">Total</p>
										</div>
										<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2">
											<p class="textitulo">Accion</p>
										</div>
									</div>';
						$consulta = "select * from pedidos_local where id_cliente=?;";
						$compras = Database::getRows( $consulta, array( $_SESSION['id_cliente'] ) );

						if ( $compras != null ){
							foreach ( $compras as $compra ) {//<!--input type="hidden" class="id_img_producto" value="'.$compra['id_compra'].'" /-->
							  $imprimir .= '<div class="row thumbnail divinopro colordiv">
												<div class="col-xs-3 col-xs-offset-1 col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-1 col-lg-3 col-lg-offset-1 fecha_compra">
													<p class="texnormal">'.Date( $compra['fecha_pedido'] ).'</p>
												</div>
												<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2 total">
													<p class="texnormal">$'.$compra['total'].'</p>
												</div>
												<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2">
													<button class="btn btn-primary" name="id_pedido_local" value="'.$compra['id_pedido_local'].'">Ver</button>
													<a href="recibo?p_l='.base64_encode( $compra['id_pedido_local'] ).'" class="btn btn-warning">Recibo</a>
												</div>
											</div>';//Por si acaso xd --> <a style="color: white;" href="compras_realizadas?id=' . $compra['id_pedido'] . '"></a>
							}
							print( $imprimir );//Imprimo el resultado :D
						}
						else print("<div class='alert alert-danger' role='alert'><i class='material-icons left'>No posee compras realizadas.</div>");
					}
				?>
			</div>
		</div>
	</form>
</div>

<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>