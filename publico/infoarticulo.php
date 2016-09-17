<?php
	//insert into comentarios_productos VALUES (2,3,1,1,'hola me llamo diego','2016-06-10 19:15:00')

	//if ( $_GET['n'] != "" && Validator::letras( $_GET['n'] ) ) Page::header($_GET['n']);
    //else header( "location: catalogo.php" );
    //Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page.php");
    if ( isset( $_GET['id'] ) && Validator::numero( base64_decode( $_GET['id'] ) ) ){
    	$_GET['id'] = base64_decode( $_GET['id'] );
    	if(!empty($_POST)){
    		
		}
		else{
	        $consulta = "SELECT categorias.categoria, presentaciones.id_presentacion, productos.id_producto, productos.id_categoria, img_productos.id_producto, nombre_producto, precio_producto FROM ((img_productos inner join productos on productos.id_producto = img_productos.id_producto) inner join presentaciones on presentaciones.id_presentacion = img_productos.id_presentacion) inner join categorias on productos.id_categoria = categorias.id_categoria  WHERE img_productos.id_img_producto = ? and estado = 1";
	        $data = Database::getRow( $consulta, array( $_GET['id'] ) );
			if ( $data == null ) header("location: catalogo.php");//Si no existe el id como imagen de producto
			//
			$id_producto = $data['id_producto'];
			//Insertamos la nueva vista al producto :)
			$vista_actual = Database::getRow( "select vistas from productos where id_producto = ?;", array( $id_producto ) );
			$nueva_vistas = $vista_actual['vistas'] + 1;
			Database::executeRow( "update productos set vistas = ? where id_producto = ?;", array( $nueva_vistas, $id_producto ) );
			//Insertamos la nueva vista al producto :)
			$id_categoria = $data['id_categoria'];
			$categoria = $data['categoria'];
			$nombre_producto = $data['nombre_producto'];
		    $precio_producto = $data['precio_producto'];
		    //$nombre_proveedor = $data['nombre_proveedor'];
		    $id_presentacion = $data['id_presentacion'];

		    //A mostrar todas las imegenes de la misma presentacion :D
	        $consulta = "SELECT imagen_producto FROM img_productos inner join presentaciones on presentaciones.id_presentacion = img_productos.id_presentacion WHERE presentaciones.id_presentacion = ? and id_producto = ?;";
	        $imagenes = Database::getRows( $consulta, array( $id_presentacion, $id_producto ) );
		}
    }
    else
    {
    	header( "location: catalogo" );
    }
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    Page::header("Articulo");
?>
<!--Comeinza la estructura de la pagina-->
<div class="containter margin_top_navbar">
<!--?php include 'inc/breadcrumb_common.php'; ?><Se establece la barra que indica la pagina o filtro actual-->
<!--Slider que mostrara las posibles imagenes del producto-->

	<div class="container-fluid">
		<?php
$informacion =	'<div class="col-xs-12 col-sm-8 col-md-8 colordiv " id="divpro_coments">
					<div class="row">
						<div class="" id="divinfopro">
							<input id="id_producto" type="hidden" value="'. $id_producto .'" />
							<input id="id_img_producto" type="hidden" value="'. $_GET['id'] .'" />
							<br>
							<h3 id="tproducto">'.$nombre_producto.'</h3>
							<div class="carousel slide" id="slider_info_art" data-ride="carousel">
								<ol class="carousel-indicators" id="ci_infoart">';

									for ( $contar = 0; $contar < sizeof($imagenes) ; $contar++ ) {
										if ( $contar == 0 /*&& sizeof($imagenes) != 1*/ ) $informacion .= '<li data-target="#slider_info_art" data-slide-to="'.$contar.'" class="active"></li>';
										else /*if ( sizeof($imagenes) > 1 ) */$informacion .= '<li data-target="#slider_info_art" data-slide-to="'.$contar.'"></li>';
									}
				$informacion .= '</ol>
								<div class="carousel-inner">';
								$contar = 0;
								foreach ($imagenes as $key) 
								{
	if ( $contar == 0 )	$informacion .= '<div class="item active">
											<img src="../img/productos/'.$key['imagen_producto'].'" alt="'.$key['imagen_producto'].'" class="img-responsive">
											<!--div class="carousel-caption">
												<h3>Fucsia</h3>
											</div-->
										</div>'
										;

				   else $informacion .= '<div class="item">
											<img src="../img/productos/'.$key['imagen_producto'].'" alt="'.$key['imagen_producto'].'" class="img-responsive">
											<!--div class="carousel-caption">
												<h3>Fucsia</h3>
											</div-->
										</div>';
										
									$contar++;
								}
				$informacion .= '</div>
							</div>
							<li class="divider-diego "></li>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
							//Sacar calificacion del producto acumulada :D
		                    $sql = "select ROUND( AVG(calificacion_producto),1 ) Prom from calificacion_productos where id_producto=?";
		                    $cali = Database::getRow( $sql, array ( $id_producto ) );
		                    //
		                    $sql = "select id_cliente from calificacion_productos where id_producto = ? and id_cliente = ?";
		                    $cali_id_cliente = Database::getRow( $sql, array ( $id_producto, $_SESSION['id_cliente'] ) );
			$informacion .= '<input id="calificacion" value="' . $cali['Prom'] . '" type="number" class="rating ' . ( ( $cali_id_cliente['id_cliente'] != null ) ? 'cali-hecha' : '' )  . '" min=0 max=5 step=0.1 data-size="lg">
						</div>
						<!--div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<p class="tin_ti">Categoria:</p>
							</div>
							<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
								<p class="pcarac margin-info_carac">
									'.$categoria.'
								</p>
							</div>
						</div-->
						<!--div class="col-xs-6 col-sm-2 col-md-2 col-lg-2" id="divcarac1">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<p class="tin_ti">
									Marca:
								</p>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<p class="pcarac margin-info_carac">
									
								</p>
							</div>
						</div-->
						<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" id="divcarac2">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<p class="tin_ti">
									Categoria:
								</p>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<p class="tin_ti">
									'.$categoria.'
								</p>
							</div>
						</div>
						<div class="precio col-xs-6 col-sm-5 col-md-5 col-lg-5">
							<!--div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								
							</div-->
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<p class="tin_ti" style="font-size:40px;text-align:right;">$'.$precio_producto.'</p>
							</div>
						</div>
					</div>
					<div class="row  hidden-sm hidden-md hidden-lg">
						<div class="col-xs-12">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<p class="tin_ti">Presentacion:</p>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<select id="select_presentacionn" class="form-control" onclick="javascript: actualizar_infopro( $(this), 1 );" >';
										//todas las opciones de cambiar la presentacion el producto =}
										$consulta = 'select presentaciones.id_presentacion, presentacion from presentaciones inner join img_productos on img_productos.id_presentacion = presentaciones.id_presentacion where id_producto = ? order by id_presentacion';
										$presentaciones = Database::getRows($consulta, array( $id_producto ) );//Id_producto
										$oppresentaciones = "";//Arreglo para guardar los registros :D
										$anterior_id = 0;//Controlo para no colocar las presentaciones repetidas :}
										foreach ($presentaciones as $presentacion) {
											if ( $anterior_id != $presentacion['id_presentacion'] ){
												$oppresentaciones .= "<option value='$presentacion[id_presentacion]'";
							                   	if( $presentacion['id_presentacion'] == $id_presentacion ){
							                   		$oppresentaciones .= " selected";
							                    }
							                    $oppresentaciones .= " '>$presentacion[presentacion]</option>";
							                }
							                $anterior_id = $presentacion['id_presentacion'];
										}
										$informacion .= $oppresentaciones;//Imprimmos el resultado =}
					$informacion .= '</select>
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12">
									<p class="tin_ti">Cantidad:</p>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12">';
									//Ahora comprobamos si ya fue añadido (podra añadirlo desde compras, pero no le veo nada de malo, solo es un master X'D)
							    	$sql = "select id_img_producto, cantidad_producto from carrito where id_img_producto = ? and id_cliente = ?;";
							    	$id_exis = Database::getRow( $sql, array ( $_GET['id'], $_SESSION['id_cliente'] ) );
					$informacion .= '<INPUT id="cantidadd" style="color: black" TYPE="NUMBER" MIN="1" MAX="10000" STEP="1" VALUE="' . ( ( $id_exis['id_img_producto'] != null ) ? $id_exis['cantidad_producto'] : '1') . '" class="size">';
				$informacion .= '</div>
							</div>
						</div>
						<div class="col-xs-offset-2 col-xs-8 col-sm-offset-2 col-sm-8 col-md-offset-2 col-md-8">
							<button id="btnanadircarritoo" type="button" class="btn btn-primary btncolor size">';
    					    	$informacion .= ( $id_exis['id_img_producto'] != null ) ? 'Editar' : 'Añadir al carrito';
			$informacion .= '	
							</button>
						</div>
						<!--div class="col-xs-6 col-sm-4 col-md-4">
							<!--a href="" target="_blank"><button class="imgcircular contactos goo"><span class="fa fa-google-plus"></span></button></a>
							<a href="https://twitter.com/?status=Me encanta este producto!!! http://localhost/catworld/publico/infoarticulo.php?id=' . base64_encode($_GET['id']) . '" target="_blank"><button class="imgcircular contactos twi"><span class="fa fa-twitter"></span></button></a>
							<a href="https://www.facebook.com/sharer/sharer.php?u=http://localhost/catworld/publico/infoarticulo.php?id=' . base64_encode($_GET['id']) . '" target="_blank"><button class="imgcircular contactos fwhite fac"><span class="fa fa-facebook-official"></span></button></a>
						</div-->
					</div>
					<div class="row">
						<div class="">
							<li class="divider-diego"></li><!Se añade un separador normal para dividir las secciones>
						</div>
					</div>
					<!--Añado el campo para ingresar comentarios-->
					<div class="row">
						<div class="col-xs-7 col-sm-8 col-md-8 col-lg-8" id="div_in_com">
							<textarea id="txtcoment" type="text" class="form-control" placeholder="Comentario..."></textarea>
						</div>
						<div class="col-xs-5 col-sm-4 col-md-4 col-lg-4" id="div_btn_incom">
							<button id="btna_comentario" type="button" class="btn btn-primary btncolor">Comentar</button>
							<button id="btnc_comentario" type="button" class="btn btn-default">Cancelar</button>
						</div>
					</div>
					<br>
					<div style="color:black;"><!--Contenerdor que contendra los Comentarios-->';
						require("../lib/paginacion.php");
				/*agregar img_cliente*/		$sql = "select img_cliente, usuario, comentario_producto from comentarios_productos c inner join clientes cli on cli.id_cliente = c.id_cliente where estado_comentario=? and id_producto=?";
						$Paginacion = new Paginacion();
						$records_per_page=10;
						$parametro = array( 1, $id_producto );
						$newconsulta = $Paginacion->paging($sql,$records_per_page);//Me regresa la consulta con el limit, claro que cada vez que le des uno al paging, lo modifica :)
						$data = Database::getRows($newconsulta, $parametro );//Id_producto
						if( $data != null ){
							foreach ($data as $comentario) {
							    $informacion .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 thumbnail colordivdiv">
													<div class="media">
														<div class="col-xs-4 col-sm-3 col-md-3 col-lg-2 img-coment-size">
														  	<div class="media-left">
														    	<a href="#">
														    		<img src="../img/clientes/'.$comentario['img_cliente'].'" alt="" class="img-responsive">
														    	</a>
														  	</div>
														</div>
														<div class="col-xs-8 col-sm-9 col-md-9 col-lg-10">
														  	<div class="media-body">
															    <h4 class="media-heading">'.$comentario['usuario'].'</h4>
															    	'.$comentario['comentario_producto'].'
														  	</div>
														</div>
													</div>
												</div>';
							}
							print( $informacion );
							$informacion = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center">
									 			<div class="pagination-wrap">
									            '.$Paginacion->paginglink($sql,$records_per_page, $parametro).'
									        	</div>
										     </div>';
						}
						else $informacion .= "<div class='alert alert-success' role='alert' align='center-align'> No hay comentarios. </div>";
	$informacion .= '</div>
				</div>
				<!--Parte PC que se mostrara el carrito y mas datos =DD-->
				<div class="hidden-xs col-sm-4 col-md-4 col-lg-4 ">
					<div class="thumbnail colordiv">
						<div class="row">
							<div class="col-md-6 col-lg-6">
								<h3>Presentacion:</h3>
							</div>
							<br class="hidden-xs">
							<div class="col-md-6 col-lg-6">
								<select id="select_presentacion" class="form-control" onclick="javascript: actualizar_infopro( $(this), 1 );" >';
									//todas las opciones de cambiar la presentacion el producto =}
									$consulta = 'select presentaciones.id_presentacion, presentacion from presentaciones inner join img_productos on img_productos.id_presentacion = presentaciones.id_presentacion where id_producto = ? order by id_presentacion';
									$presentaciones = Database::getRows($consulta, array( $id_producto ) );//Id_producto
									$oppresentaciones = "";//Arreglo para guardar los registros :D
									$anterior_id = 0;//Controlo para no colocar las presentaciones repetidas :}
									foreach ($presentaciones as $presentacion) {
										if ( $anterior_id != $presentacion['id_presentacion'] ){
											$oppresentaciones .= "<option value='$presentacion[id_presentacion]'";
						                   	if( $presentacion['id_presentacion'] == $id_presentacion ){
						                   		$oppresentaciones .= " selected";
						                    }
						                    $oppresentaciones .= " '>$presentacion[presentacion]</option>";
						                }
						                $anterior_id = $presentacion['id_presentacion'];
									}
									$informacion .= $oppresentaciones;//Imprimmos el resultado =}
				$informacion .= '</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-lg-6">
								<h3>Cantidad:</h3>
							</div>
							<br class="hidden-xs">
							<div class="col-md-6 col-lg-6">';
								//Ahora comprobamos si ya fue añadido (podra añadirlo desde compras, pero no le veo nada de malo, solo es un master X'D)
    					    	$sql = "select id_img_producto, cantidad_producto from carrito where id_img_producto = ? and id_cliente = ?;";
    					    	$id_exis = Database::getRow( $sql, array ( $_GET['id'], $_SESSION['id_cliente'] ) );

				$informacion .= '<INPUT id="cantidad" style="color: black" TYPE="NUMBER" MIN="1" MAX="10000" STEP="1" VALUE="' . ( ( $id_exis['id_img_producto'] != null ) ? $id_exis['cantidad_producto'] : '1') . '" class="size">';

			$informacion .= '</div>
						</div>
						<div class="row">
							<div class="col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
								<button id="btnanadircarrito" type="button" class="btn btn-primary btncolor size">';
	    					    	$informacion .= ( $id_exis['id_img_producto'] != null ) ? 'Editar' : 'Añadir al carrito';
				$informacion .= '	
								</button>
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 thumbnail colordiv">
						<p class="ptitulo">
							Compartir
						</p>
						<li class="divider-diego"></li>
						<div class="col-sm-4 col-md-4 col-lg-4 colordiv">
							<a href="https://plus.google.com/share?url=http://localhost/catworld/publico/infoarticulo.php?id=' . base64_encode($_GET['id']) . '" target="_blank"><button class="imgcircular contactos goo"><span class="fa fa-google-plus"></span></button></a>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 colordiv">
							<a href="https://twitter.com/?status=Me encanta este producto!!! http://localhost/catworld/publico/infoarticulo.php?id=' . base64_encode($_GET['id']) . '" target="_blank"><button class="imgcircular contactos twi"><span class="fa fa-twitter"></span></button></a>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 colordiv">
							<a href="https://www.facebook.com/sharer/sharer.php?u=http://localhost/catworld/publico/infoarticulo.php?id=' . base64_encode($_GET['id']) . '" target="_blank"><button class="imgcircular contactos fwhite fac"><span class="fa fa-facebook-official"></span></button></a>
						</div>
					</div>';
					$mas_marca = Database::getRows( "SELECT id_producto, nombre_producto, precio_producto, estado FROM productos where id_categoria = ? and estado = 1 and id_producto != ?", array( $id_categoria, $id_producto ) );
					if ( $mas_marca != null ){
		$informacion .= '<div class="thumbnail colordiv" id="div-relleno-mas">
							<p class="ptitulo">
								Mas sobre
							</p>
							<li class="divider-diego"></li>
							<!--Ingresaremos el carrusel para desplazar los productos =DD-->
							<div class="carousel slide" id="spro_mas" data-ride="carousel">
								<div class="carousel-inner">';
									$contar = 0;
									foreach ($mas_marca as $key) {
										$informacion .= '<div class="item' . ( ( $contar == 0 ) ? ' active' : '') . '">
															<div class="divpro_in divindart colordiv colordivdivindex">';
																$consulta = "SELECT id_img_producto, imagen_producto FROM img_productos where id_producto = ?";//" and id_producto != ?";
																	$imagen = Database::getRow( $consulta, array( $key['id_producto'] ) );
												$informacion .= '<a class="enlacesinf" href="infoarticulo.php?id=' . base64_encode($imagen['id_img_producto']) . '">
																	<img src="../img/productos/'.$imagen['imagen_producto'].'" alt="" class="img-responsive">
																	<div class="precio">
																		<h4 >$'.$key['precio_producto'].'</h4>
																	</div>';
																	$consulta = "SELECT id_presentacion FROM img_productos where id_producto = ? order by id_presentacion;";
																	$colores = Database::getRows( $consulta, array( $key['id_producto'] ) );
																	$anterior_id = 0;//Controlo para no colocar las presentaciones repetidas :}
																	$contar = 0;
																	foreach ( $colores as $id_presentacion ) {
																		if ( $anterior_id != $id_presentacion['id_presentacion'] ){
																			$contar++;
														                }
														                $anterior_id = $id_presentacion['id_presentacion'];
																	}
													$informacion .= '<h5>' . $contar . ( ( $contar != 1 ) ? ' presentaciones' : ' presentacion' ) . '</h5>
																	<li class="divider-diego"></li>
																	<h4>'.$key['nombre_producto'].'</h4>
																</a>
															</div>
														</div>';
										$contar++;
									}
				$informacion .= '</div>
								<!--Ahora se ingresa las flechas para desplazarse en el carrusel =DDD-->
								<a href="#spro_mas" class="carousel-control left ft infle" data-slide="prev">
									<span class="glyphicon glyphicon-chevron-left"></span>
					        	</a>
					        	<a href="#spro_mas" class="carousel-control right ft infle" data-slide="next"> 
					        		<span class="glyphicon glyphicon-chevron-right"></span>
					        	</a>
							</div>
						</div>';
					}

		/*$informacion .= '/*<!--div class="thumbnail colordiv"><!--Solo es para que contenga todo en un thumbnail =DD-->
						<p class="ptitulo">
							Top Collares
						</p>
						<li class="divider-diego"></li>
						<!--Ingresaremos el carrusel para desplazar los productos =DD-->
						<div class="carousel slide" id="stop" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active">
									<div class="divpro_in divindart colordiv colordivdivindex">
										<a class="enlacesinf" href="infoarticulo.php">
											<img src="img/collar4.jpg" alt="" class="img-responsive">
											<div class="precio">
												<h4 >$9.99</h4>
											</div>
											<h5>5 colores</h5>
											<li class="divider-diego"></li>
											<h4>Collar catish con perlas artificiales</h4>
										</a>
									</div>
								</div>
								<div class="item">
									<div class="divpro_in divindart colordiv colordivdivindex">
										<img src="img/collar1.jpg" alt="" class="img-responsive">
										<div class="precio">
											<h4 >$9.99</h4>
										</div>
										<h5>5 colores</h5>
										<li class="divider-diego"></li>
										<h4>Collar rash con diamantes artificiales</h4>
									</div>
								</div>
							</div>
							<!--Ahora se ingresa las flechas para desplazarse en el carrusel =DDD-->
							<a href="#stop" class="carousel-control left ft infle" data-slide="prev">
								<span class="glyphicon glyphicon-chevron-left"></span>
				        	</a>
				        	<a href="#stop" class="carousel-control right ft infle" data-slide="next"> 
				        		<span class="glyphicon glyphicon-chevron-right"></span>
				        	</a>
						</div>
					</div>
				</div>';*/
			print( $informacion );
		?>
	</div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>