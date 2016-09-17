<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
	ob_start();
	//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	require("../lib/validator.php");
	//!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
	require("../lib/page-privado.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Horarios mas usados", "graficos_reportes");
  	
  	if ( $permisos == 0 ) header( "location: index" );

	            				/*tratado de sacar los productos mas vendidos*/
	            				//if ( isset( $_POST['id_producto'] ) ){
	            					//if ( Validator::numero( $_POST['id_producto'] ) ) {
	            						$productos = Database::getRows( "SELECT distinct(hora_inicial), hora_final, (SELECT COUNT(id_horario_entrega) from pedidos where id_horario_entrega = horarios_entrega.id_horario_entrega ) cantidad_horarios from pedidos inner join horarios_entrega ON horarios_entrega.id_horario_entrega = pedidos.id_horario_entrega order by cantidad_horarios desc limit 10;", null );

	            						if ( isset( $_POST['fecha1'] ) && isset( $_POST['fecha2'] ) ){
			            					if ( Validator::fecha( $_POST['fecha1'] ) ) {
			            						//Consulta que sirve pero aja... xd -->SELECT detalles_pedidos.id_img_producto, nombre_producto, id_presentacion, (SELECT sum(cantidad_producto) from detalles_pedidos inner join img_productos on img_productos.id_img_producto = detalles_pedidos.id_img_producto inner join pedidos on pedidos.id_pedido = detalles_pedidos.id_pedido where id_producto = productos.id_producto and pedidos.fecha_pedido BETWEEN '2016-09-20' and '2016-09-20' ) cantidad_producto from detalles_pedidos inner join img_productos on img_productos.id_img_producto = detalles_pedidos.id_img_producto inner join pedidos on pedidos.id_pedido = detalles_pedidos.id_pedido inner join productos on productos.id_producto = img_productos.id_producto where pedidos.fecha_pedido BETWEEN '2016-09-20' and '2016-09-20' order by cantidad_producto desc limit 10;
			            						//Consulta vieja :D--> SELECT detalles_pedidos.id_img_producto, nombre_producto, id_presentacion, (SELECT sum(cantidad_producto) from detalles_pedidos inner join img_productos on img_productos.id_img_producto = detalles_pedidos.id_img_producto where id_producto = productos.id_producto ) cantidad_producto from detalles_pedidos inner join img_productos on img_productos.id_img_producto = detalles_pedidos.id_img_producto inner join pedidos on pedidos.id_pedido = detalles_pedidos.id_pedido inner join productos on productos.id_producto = img_productos.id_producto where pedidos.fecha_pedido BETWEEN ? and ? order by cantidad_producto desc limit 10;
				            					if ( Validator::fecha( $_POST['fecha2'] ) ) $productos = Database::getRows( "SELECT distinct(hora_inicial), hora_final, (SELECT COUNT(id_horario_entrega) from pedidos where id_horario_entrega = horarios_entrega.id_horario_entrega and fecha_pedido BETWEEN ? and ? ) cantidad_horarios from pedidos inner join horarios_entrega ON horarios_entrega.id_horario_entrega = pedidos.id_horario_entrega order by cantidad_horarios desc limit 10;", array( $_POST['fecha1'], $_POST['fecha2'] ) );
				            					else $error = "Fecha final ingresada invalida.";
				            				}
				            				else $error = "Fecha inicial ingresada invalida.";
			            				}

			            				$n = array();
			            				$c = array();
			            				foreach ( $productos as $producto ) {
			            					$n[] = $producto['hora_inicial']." ".$producto['hora_final'];
			            					$c[] = $producto['cantidad_horarios'];
			            				}
			            			//}
			            			//	else $error = "Id del producto invalido.";
	            				//}

	            				print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
	            				print ( ( isset($error) ) ? '<div class="alert alert-danger" role="alert">'.$error.'</div>' : "" );
	            				
	            			?>
	            			<div class="col-sm-3 col-md-3 col-lg-3">
			            				<div class="form-group">
											<label for="fecha1">Fecha inicial:</label>
											<input name="fecha1" value="<?php print( @$_POST['fecha1'] ); ?>" class="form-control fecha_picker"/>
										</div>
									</div>
									<div class="col-sm-3 col-md-3 col-lg-3">
										<div class="form-group">
											<label for="fecha2">Fecha final:</label>
											<input name="fecha2" value="<?php print( @$_POST['fecha2'] ); ?>" class="form-control fecha_picker"/>
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

										<?php
											//if ( ! isset( $id_producto ) ) print( '<h2>Seleccione un producto.</h2><div style="min-width: 310px; height: 200; margin: 0 auto"></div>' );
										?>
										<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
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

<!--hacer el grafico-->
<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>
<style type="text/css">
	${demo.css}
</style>
<?php
//if ( isset( $_POST['id_producto'] ) ){ ?>
	<script type="text/javascript">
		$(function () {
		    // Create the chart
		    $('#container').highcharts({
		        chart: {
		            plotBackgroundColor: null,
		            plotBorderWidth: null,
		            plotShadow: false,
		            type: 'pie'
		        },
		        title: {
		            text: 'Porcentaje de ventas según presentacion.'
		        },
		        tooltip: {
		            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		        },
		        plotOptions: {
		            pie: {
		                allowPointSelect: true,
		                cursor: 'pointer',
		                dataLabels: {
		                    enabled: true,
		                    format: '<b>{point.name}</b>: {point.percentage:.1f}%',
		                    style: {
		                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
		                    }
		                }
		            }
		        },
		        series: [{
		            name: 'Porcentaje',
		            colorByPoint: true,
		            data: [
		            <?php
		          		$columnas = "";
						for ( $i = 0 ; $i < sizeof($n) ; $i++ ) {
				            $columnas .= "{
							                name: '".$n[$i]."',
							                y: ".$c[$i]."
								          },";
	    				}
	    				print($columnas);
					?>
					]
		        }]
		    });
		});
	</script>
<?php //} ?>
<!--hacer el grafico-->

<script src="../publico/js/bootstrap.min.js"></script>

<script src="dist/js/app.min.js"></script>

<script src="../publico/js/mainB.js"></script>

<!--scripts graficos-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js"></script><!--Mostrar calendario-->
<!--scripts graficos-->

</body>
</html>