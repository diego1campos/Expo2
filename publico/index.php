<?php
    //Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    Page::header("Inicio");
		
		$imagenes = Database::getRows( "select * from index_imagenes;", null );
$informacion =	'<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  " id="">
					<div class="row">
						<div class="" id="divinfopro">
							<div class="carousel slide" id="slider_info_art" data-ride="carousel">
								<ol class="carousel-indicators" id="ci_infoart">';
									for ( $contar = 0; $contar < sizeof($imagenes) ; $contar++ ) {
										if ( $contar == 0 /*&& sizeof($imagenes) != 1*/ ) $informacion .= '<li data-target="#slider_info_art" data-slide-to="'.$contar.'" class="active"></li>';
										else /*if ( sizeof($imagenes) > 1 ) */$informacion .= '<li data-target="#slider_info_art" data-slide-to="'.$contar.'"></li>';
									}
				$informacion .= '</ol>
								<div class="carousel-inner">';
								$contar = 0;
								foreach ($imagenes as $key) {
	if ( $contar == 0 )	$informacion .= '<div class="item active">
											<img src="../img/slider_index/'.$key['imagen'].'" alt="señor" id="size" class="img-responsive Gtama">
											<!--div class="carousel-caption">
												<h3>Fucsia</h3>
											</div-->
										</div>';
				   else $informacion .= '<div class="item">
											<img src="../img/slider_index/'.$key['imagen'].'" alt="señor" id="size" class="img-responsive Gtama">
											<!--div class="carousel-caption">
												<h3>Fucsia</h3>
											</div-->
										</div>';
										
									$contar++;
								}
				$informacion .= '</div>
							</div>
						</div>
					</div>
				</div>';
							print( $informacion );
							?>

		<!-- fin de slider -->

	
		<!-- inicio secction Nuestra historia -->
		<section id="about" class=" seccionhistoria color-dark bg-white">
		<?php
    			require("../sql/conexion.php");
   				$consulta = "SELECT * from datos where id_dato=1";
    			$tabla = ""; //Arreglo de datos
    			foreach($PDO->query($consulta) as $datos)
    			{
					$tabla .= "<div class='container'>";
					$tabla .= "<div class='row'>";
						$tabla .= "<div class='col-lg-8 col-lg-offset-2'>";     
							$tabla .= "<div class='animatedParent'>";
							$tabla .= "<div class='section-heading text-center animated bounceInDown'>";
								$tabla .= "<h2 class='h-bold temas Imargentemas espacioH'>Nuestra historia</h2>";
								$tabla .= "<div class='divider-header'></div>";
								$tabla .= "</div>";
								$tabla .= "</div>";
								$tabla .= "</div>";
								$tabla .= "</div>";
								$tabla .= "</div>";
								$tabla .= "<div class='container'>";
								$tabla .= "<div class='row'>";
							$tabla .= "<div class='col-lg-10 col-lg-offset-1 animatedParen text-center'>		";
							$tabla .= "<p id='Iquines' class='col-lg-12'> $datos[historia]</p>";
						$tabla .= "</div>";
						$tabla .= "<div class='col-lg-10 col-lg-offset-1 col-md-10 col-sm-10 animatedParen text-center '>		";
							$tabla .= "<a href='#' class='btn btn-skin Gbotonmas botonNH text-center'> 	Saber mas</a>";
						$tabla .= "</div>";
				$tabla .= "</div>";
				$tabla .= "</div>";
    			}
    			print($tabla);
    			$PDO = null;
    		?>	
		</section>
		<!--fin de seccion nuestra historia -->

		<!-- Inicio seccion nuestros productos -->
		<section id="works" class="seccionnuestrosp color-dark text-center bg-white ImargenNP">
			<div class="container marginbotN-50 ">
				<div class="row">
					<div class="col-lg-8 col-lg-offset-2">
						<div class="animatedParent">
							<div class="section-heading text-center ">
								<h2 class="h-bold animated bounceInDown temas marginbotNT espacioN">Nuestros productos</h2>
								<div class="divider-header"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container-fluid q">
				<div class="row animatedParent">
					<?php
					require("../sql/conexion.php");
					$consulta = "SELECT categoria, categorias.imagen_categoria from categorias ";
					$tabla = ""; //Arreglo de datos
					foreach($PDO->query($consulta) as $datos)
					{
					#$tabla .= "<div class='container-fluid q'>";
						#$tabla .= "<div class='row animatedParent'>";
								$tabla .= "<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12 animated fadeInUp margeNP margen222'>";
									$tabla .= "<a href=''data-lightbox-gallery='gallery1'  class='portfolio-box'>";
										$tabla .= "<img src='../img/categorias/$datos[imagen_categoria]' class='tamaimagenN imagenNP' alt=''>";
											$tabla .= "<div class='portfolio-box-caption'>";
												$tabla .= "<div class='portfolio-box-caption-content'>";
													$tabla .= "<div class='project-category text-faded'>Categoria</div>";
														$tabla .= "<div class='project-name'> $datos[categoria]</div>";
												$tabla .= "</div>";
											$tabla .= "</div>";
									$tabla .= "</a>";
								$tabla .= "</div>";
							#$tabla .= "</div>";
						#$tabla .= "</div>";

					}
					print($tabla);
					$PDO = null;
					?>	
				</div>
			</div>
		</section>
		<!-- fin de seccion nuestros productos -->


		<!-- Inicio Productos mas vendidos -->
		<section id="service" class="home-section color-dark margenbajo">
			<div class="container marginPMV">
				<div class="row">
					<div class="col-lg-8 col-lg-offset-2">
						<div class="animatedParent">
							<div class="section-heading text-center">
								<h2 class="h-bold animated bounceInDown temas ImargentemasMT espacio">Productos mas vendidos</h2>
								<div class="divider-header"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="text-center">
				<div class="container">
					<div class="row animatedParent ImargentemasM">
							<?php
								require("../sql/conexion.php");
								$consulta = "select nombre_producto, imagen_producto from productos inner join img_productos on productos.id_producto = img_productos.id_producto  order by vistas desc";
								$tabla = ""; //Arreglo de datos
								$contador = 0;//Sirve para colocar solo los primeros 3
								foreach($PDO->query($consulta) as $datos)
								{
									if ( $contador < 3 ){
										$tabla .= "<div class='col-xs-offset-2 col-xs-8 col-sm-offset-0 col-sm-4 col-md-offset-0 col-md-4'>";
											$tabla .= "<div class='animated rotateInDownLeft'>";
												$tabla .= "<div class='service-box'>";     
													$tabla .= "<div class='service-desc'>	";
														$tabla .= "<h5>$datos[nombre_producto]</h5>";
														$tabla .= "<div class='divider-header'></div>";
															$tabla .= "<div class='row'>";
																$tabla .= "<div class='col-lg-offset-0 col-lg-12 col-md-offset-0 col-md-12 col-sm-offset-0 col-sm-12 col-xs-offset-2 col-xs-8'>	";
																	$tabla .= "<img src='../img/productos/$datos[imagen_producto]' alt='Error al cargar imagen' class='img-circle tamaimagen imagen2'>";
																$tabla .= "</div>";
															$tabla .= "</div>";
															$tabla .= "<a href='' class='btn btn-skin Gbotonmas'>Learn more</a>";
														$tabla .= "</div>";
												$tabla .= "</div>";
											$tabla .= "</div>";
										$tabla .= "</div>";
										$contador++;
									}
								}
								print($tabla);
								$PDO = null;
							?>	
				
					</div>
				</div>
			</div>
		</section>
		<!-- Fin seccion mas vendidos -->
<script>
    $('.carousel').carousel({
        interval: 2000 //changes the speed
    })
</script>
<br>
<br>
<br>
<br>
<br>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>