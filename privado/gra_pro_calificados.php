<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
	ob_start();
	//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	require("../lib/validator.php");
	//!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
	require("../lib/page-privado.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Productos con mejor calificación", "graficos_reportes");
  	
  	if ( $permisos == 0 ) header( "location: index" );

	            				/*tratado de sacar los productos mas vendidos*/
	            				$productos = Database::getRows( "SELECT nombre_producto, (SELECT AVG(calificacion_producto) from calificacion_productos where id_producto = productos.id_producto ) PROM_CALIFICACION from productos order by PROM_CALIFICACION desc limit 10;", null );
	            				if ( isset( $_POST['fecha1'] ) && isset( $_POST['fecha2'] ) ){
	            					if ( Validator::fecha( $_POST['fecha1'] ) ) {
	            						//Consulta que sirve pero aja... xd -->SELECT detalles_pedidos.id_img_producto, nombre_producto, id_presentacion, (SELECT sum(cantidad_producto) from detalles_pedidos inner join img_productos on img_productos.id_img_producto = detalles_pedidos.id_img_producto inner join pedidos on pedidos.id_pedido = detalles_pedidos.id_pedido where id_producto = productos.id_producto and pedidos.fecha_pedido BETWEEN '2016-09-20' and '2016-09-20' ) cantidad_producto from detalles_pedidos inner join img_productos on img_productos.id_img_producto = detalles_pedidos.id_img_producto inner join pedidos on pedidos.id_pedido = detalles_pedidos.id_pedido inner join productos on productos.id_producto = img_productos.id_producto where pedidos.fecha_pedido BETWEEN '2016-09-20' and '2016-09-20' order by cantidad_producto desc limit 10;
	            						//Consulta vieja :D--> SELECT detalles_pedidos.id_img_producto, nombre_producto, id_presentacion, (SELECT sum(cantidad_producto) from detalles_pedidos inner join img_productos on img_productos.id_img_producto = detalles_pedidos.id_img_producto where id_producto = productos.id_producto ) cantidad_producto from detalles_pedidos inner join img_productos on img_productos.id_img_producto = detalles_pedidos.id_img_producto inner join pedidos on pedidos.id_pedido = detalles_pedidos.id_pedido inner join productos on productos.id_producto = img_productos.id_producto where pedidos.fecha_pedido BETWEEN ? and ? order by cantidad_producto desc limit 10;
		            					if ( Validator::fecha( $_POST['fecha2'] ) ) $productos = Database::getRows( "SELECT nombre_producto, (SELECT AVG(calificacion_producto) from calificacion_productos where id_producto = productos.id_producto and fecha_ingreso BETWEEN ? and ? ) PROM_CALIFICACION from productos order by PROM_CALIFICACION desc limit 10;", array( $_POST['fecha1'], $_POST['fecha2'] ) );
		            					else $error = "Fecha final ingresada invalida.";
		            				}
		            				else $error = "Fecha inicial ingresada invalida.";
	            				}

	            				print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
	            				print ( ( isset($error) ) ? '<div class="alert alert-danger" role="alert">'.$error.'</div>' : "" );


	            				$n = array();
	            				$c = array();
	            				foreach ( $productos as $producto ) {
	            					if ( $producto['PROM_CALIFICACION'] != null ){
		            					$n[] = $producto['nombre_producto'];
		            					$c[] = $producto['PROM_CALIFICACION'];
		            				}
	            				}
	            				/*for ( $i = 0 ; $i < sizeof($n) ; $i++ ) {
	            					print('<a>'.$n[$i].' '.$c[$i].'</a><br>');
	            				}*/
	            				/*tratando de sacar los productos mas vendidos*/
	            			?>
	            				<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>
								<style type="text/css">
									${demo.css}
								</style>
								<script type="text/javascript">
									$(function () {
									    // Create the chart
									    $('#container').highcharts({
									        chart: {
									            type: 'column'
									        },
									        title: {
									            text: 'Productos mejores calificados'
									        },
									        xAxis: {
									            type: 'category'
									        },
									        yAxis: {
									            title: {
									                text: 'Puntaje'
									            }

									        },
									        legend: {
									            enabled: false
									        },
									        plotOptions: {
									            series: {
									                borderWidth: 0,
									                dataLabels: {
									                    enabled: true,
									                    format: '{point.y:.1f}'
									                }
									            }
									        },

									        tooltip: {
									            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
									            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b><br/>'
									        },

									        series: [{
									            name: 'Puntaje',
									            colorByPoint: true,
									            data: [
									            <?php
									          		$columnas = "";
				            						for ( $i = 0 ; $i < sizeof($n) ; $i++ ) {
						            					/*if ( ( $i +1 ) == sizeof($n) ) $columnas .= "{
																						                name: '".$n[$i]."',
																						                y: ".$c[$i].",
																						                drilldown: null
																						            }";
						            					else $columnas .= "{
																                name: '".$n[$i]."',
																                y: ".$c[$i].",
																                drilldown: null
																            },";*/
											            $columnas .= "{
															                name: '".$n[$i]."',
															                y: ".$c[$i].",
															                drilldown: null
															            },";
						            				}
						            				print($columnas);
				            					?>
				            					]
									        }]
									    });
									});
								</script>
				            			<div class="col-sm-3 col-md-3 col-lg-3">
				            				<div class="form-group">
												<label for="fecha1">Fecha inicial:</label>
												<input name="fecha1" value="<?php print( @$_POST['fecha1'] ); ?>" id="fecha1" class="form-control fecha_picker"/>
											</div>
										</div>
										<div class="col-sm-3 col-md-3 col-lg-3">
											<div class="form-group">
												<label for="fecha2">Fecha final:</label>
												<input name="fecha2" value="<?php print( @$_POST['fecha2'] ); ?>" id="fecha2" class="form-control fecha_picker"/>
											</div>
										</div>
										<div class="col-sm-2 col-md-2 col-lg-2">
											<br>
											<button type="submit" class="btn btn-primary size">
										        <span class="glyphicon glyphicon-refresh"></span>
										    </button>
										</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
			    		<div class="col-xs-12">
			        		<div class="box">
			        			<div class="box-body">
										<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
									</div>
								</div>
		            		</div>
						</form>
					</div>
				</div>
			</div>
		</section><!--Conent ='DD-->
	</div><!--ConentWrapper ='DD-->
</div><!--Wrapper ='DD-->

<script src="../publico/js/bootstrap.min.js"></script>

<script src="dist/js/app.min.js"></script>

<script src="../publico/js/mainB.js"></script>

<!--graficos-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js"></script><!--Mostrar calendario-->
<!--graficos-->

</body>
</html>