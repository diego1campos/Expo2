<?php
    //Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    Page::header("Inicio");
		
		$imagenes = Database::getRows( "select * from index_imagenes;", null );
$informacion =	'<div class="col-xs-12 col-sm-12 col-md-12 colordiv " id="">
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
											<img src="../img/slider_index/'.$key['imagen'].'" alt="señor" id="size" class="img-responsive">
											<!--div class="carousel-caption">
												<h3>Fucsia</h3>
											</div-->
										</div>';
				   else $informacion .= '<div class="item">
											<img src="../img/slider_index/'.$key['imagen'].'" alt="señor" id="size" class="img-responsive">
											<!--div class="carousel-caption">
												<h3>Fucsia</h3>
											</div-->
										</div>';
										
									$contar++;
								}
				$informacion .= '</div>
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
								$tabla .= "<h2 class='h-bold temas Imargentemas'>Nuestra historia</h2>";
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
			<div class="container marginbotN-50">
				<div class="row">
					<div class="col-lg-8 col-lg-offset-2">
						<div class="animatedParent">
							<div class="section-heading text-center">
								<h2 class="h-bold animated bounceInDown temas marginbotNT">Nuestros productos</h2>
								<div class="divider-header"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container-fluid q">
				<div class="row animatedParent">
					<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 animated fadeInUp m margeNP">
						<a href="#" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="" class="portfolio-box">
							<img src="../img/nuestros_productos/costilla.png" class="tamaimagenN imagenNP" alt="">
							<div class="portfolio-box-caption">
								<div class="portfolio-box-caption-content">
									<div class="project-category text-faded">
										Categoria
									</div>
									<div class="project-name">
										carne de pollo
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 animated fadeInUp m margeNP ">
						<a href="#" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="" class="portfolio-box">
							<img src="../img/nuestros_productos/carnepavo.png" class="tamaimagenN imagenNP margeNP1" alt="">
								<div class="portfolio-box-caption">
									<div class="portfolio-box-caption-content">
										<div class="project-category text-faded">
											Categoria
										</div>
										<div class="project-name">
											carne de pollo
										</div>
									</div>
								</div>
						</a>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 animated fadeInUp m margeNP">
						<a href="#" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="" class="portfolio-box">
							<img src="../img/nuestros_productos/chorizo.png" class="tamaimagenN imagenNP" alt="">
								<div class="portfolio-box-caption">
									<div class="portfolio-box-caption-content">
										<div class="project-category text-faded">
											Categoria
										</div>
										<div class="project-name">
											carne de pollo
										</div>
									</div>
								</div>
						</a>
					</div>
						<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 animated fadeInUp m margeNP">
						<a href="#" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="" class="portfolio-box">
							<img src="../img/nuestros_productos/costillacerdo.png" class="tamaimagenN imagenNP" alt="">
								<div class="portfolio-box-caption">
									<div class="portfolio-box-caption-content">
										<div class="project-category text-faded">
											Categoria
										</div>
										<div class="project-name">
											carne de pollo
										</div>
									</div>
								</div>
						</a>
					</div>
						<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 animated fadeInUp m margeNP">
						<a href="#" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="" class="portfolio-box">
							<img src="../img/nuestros_productos/costillacerdo.png" class="tamaimagenN imagenNP" alt="">
								<div class="portfolio-box-caption">
									<div class="portfolio-box-caption-content">
										<div class="project-category text-faded">
											Categoria
										</div>
										<div class="project-name">
											carne de pollo
										</div>
									</div>
								</div>
						</a>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 animated fadeInUp m margeNP margeNP1">
						<a href="#" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="" class="portfolio-box ">
							<img src="../img/nuestros_productos/costillacerdo.png" class=" imagenNP" alt="">
								<div class="portfolio-box-caption">
									<div class="portfolio-box-caption-content">
										<div class="project-category text-faded">
											Categoria
										</div>
										<div class="project-name">
											carne de pollo
										</div>
									</div>
								</div>
						</a>
					</div>
				</div>
			</div>
		</section>
		<!-- fin de seccion nuestros productos -->

		<!-- Inicio Productos mas vendidos 

		<section id="service" class="home-section color-dark bg-gray">
			<div class="container marginPMV">
				<div class="row">
					<div class="col-lg-8 col-lg-offset-2">
						<div class="animatedParent">
							<div class="section-heading text-center">
								<h2 class="h-bold animated bounceInDown temas ImargentemasMT">Productos mas vendidos</h2>
								<div class="divider-header"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		    /*require("../sql/conexion.php");
			$consulta = "SELECT I.id_img_producto, I.imagen_producto, P.id_producto,P.nombre_producto from productos P, img_productos I WHERE p.id_producto=I.id_producto LIMIT 3";      
			$tabla="";
			foreach ($PDO->query($consulta) as $datos) 
			{

		    $tabla.= "<div class='text-center'>";
		    $tabla.= "<div class='container'>";
		    $tabla.="<div class='row animatedParent ImargentemasM'>";
		    $tabla.="<div class='col-xs-offset-2 col-xs-8 col-sm-offset-0 col-sm-4 col-md-offset-0 col-md-4'>";
		    //$tabla.="<input type='hidden' name='imagen_antigua' id='imagen_antigua' />";
		    $tabla.="<div class='animated rotateInDownLeft'>";
		    $tabla.="<div class='service-box'>";
		    $tabla.="<div class='service-desc'>";
		    $tabla.="<h5>$datos[nombre_producto]</h5>";
		    $tabla.="<div class='divider-header'></div>";
			$tabla.="<div class='row'>";
			$tabla.="<div class='col-lg-offset-0 col-lg-12 col-md-offset-0 col-md-12 col-sm-offset-0 col-sm-12 col-xs-offset-2 col-xs-8'>	";
			$tabla.="<img src='../img/productos/$datos[imagen_producto]' alt='Error al cargar imagen' class='img-circle'>";
			$tabla.="</div>";
			$tabla.="</div>";
			$tabla.="<a href=' class='btn btn-skin Gbotonmas'>Learn more</a>";
			$tabla.="</div>";
			$tabla.="</div>";
			$tabla.="</div>";
			$tabla.="</div>";
			}
			print($tabla);
			$PDO = null;*/
		?>
		</section>
		<!-- Fin seccion mas vendidos -->
		<!-- Inicio Productos mas vendidos -->
		<section id="service" class="home-section color-dark">
			<div class="container marginPMV">
				<div class="row">
					<div class="col-lg-8 col-lg-offset-2">
						<div class="animatedParent">
							<div class="section-heading text-center">
								<h2 class="h-bold animated bounceInDown temas ImargentemasMT">Productos mas vendidos</h2>
								<div class="divider-header"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="text-center">
				<div class="container">
					<div class="row animatedParent ImargentemasM">
						<div class="col-xs-offset-2 col-xs-8 col-sm-offset-0 col-sm-4 col-md-offset-0 col-md-4">
							<div class="animated rotateInDownLeft">
								<div class="service-box">
									<div class="service-desc">						
										<h5>Costilla de cerdo</h5>
											<div class="divider-header"></div>
												<div class="row">
													<div class="col-lg-offset-0 col-lg-12 col-md-offset-0 col-md-12 col-sm-offset-0 col-sm-12 col-xs-offset-2 col-xs-8">	
														<img src="../img/productos/salchicha.png" alt="Error al cargar imagen" class="img-circle tamaimagen imagen2">
													</div>
												</div>
												<a href="#" class="btn btn-skin Gbotonmas">Learn more</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-offset-2 col-xs-8 col-sm-offset-0 col-sm-4 col-md-offset-0 col-md-4">
							<div class="animated rotateInDownLeft slower">
								<div class="service-box service-box2">
									<div class="service-desc">
										<h5>Lonja de pescado</h5>
											<div class="divider-header"></div>
												<div class="row">
													<div class="col-lg-offset-0 col-lg-12 col-md-offset-0 col-md-12 col-sm-offset-0 col-sm-12 col-xs-offset-2 col-xs-8">	
														<img src="../img/productos/filete.png" alt="Error al cargar imagen" class="img-circle tamaimagen imagen2" >
													</div>
												</div>
												<a href="#" class="btn btn-skin Gbotonmas ">Learn more</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-offset-2 col-xs-8 col-sm-offset-0 col-sm-4 col-md-offset-0 col-md-4">
							<div class="animated rotateInDownLeft slower">
								<div class="service-box">
									<div class="service-desc">
										<h5>Lonja de pescado</h5>
											<div class="divider-header"></div>
												<div class="row">
													<div class="col-lg-offset-0 col-lg-12 col-md-offset-0 col-md-12 col-sm-offset-0 col-sm-12 col-xs-offset-2 col-xs-8">	
														<img src="../img/productos/salchicha.png" alt="Error al cargar imagen" class="img-circle tamaimagen imagen2" >
													</div>
												</div>
												<a href="#" class="btn btn-skin Gbotonmas ">Learn more</a>
									</div>
								</div>
							</div>
						</div>
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