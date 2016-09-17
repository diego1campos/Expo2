<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
	ob_start();
    //Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    Page::header("Realizar compra");
    if(!empty($_POST)){
        if ( isset($_POST['categoria']) ) $categoria = $_POST['categoria'];
        if ( isset($_POST['presentacion']) ) $presentacion = $_POST['presentacion'];
        if ( isset($_POST['txtBuscar']) ) $busqueda = $_POST['txtBuscar'];
        if ( isset($_POST['txtBuscar']) && $_POST['txtBuscar'] != "" && ! Validator::letras($_POST['txtBuscar'] ) ) $error_busqueda = "Datos ingresados invalidos, solo se admiten palabras sin espacio.";
        if ( isset($_POST['borrar_productos'] ) ){
        	//Seleccionar registros de carrito :D
		    $consulta = "select carrito.id_img_producto, id_producto, id_presentacion, cantidad_producto from carrito inner join img_productos on img_productos.id_img_producto = carrito.id_img_producto where id_cliente = ?;";
			$data = Database::getRows( $consulta, array( $_SESSION['id_cliente'] ) );
	        //Actualizo existencias
	        if ( $data != null ) {
		        foreach ( $data as $key ) {
		        	//seleccionar existwencias antes
		        	$consulta = "select existencias from existencias where id_producto = ? and id_presentacion = ?;";
		        	$existen = Database::getRow( $consulta, array( $key['id_producto'], $key['id_presentacion'] ) );
		        	//
		        	$consulta = "update existencias set existencias = ? where id_producto = ? and id_presentacion = ?;";
		        	Database::executeRow( $consulta, array( ( $existen['existencias'] + $key['cantidad_producto'] ), $key['id_producto'], $key['id_presentacion'] ) );
		        }
		        //Ahora elimino los registros de carrito relacionados con ese cliente :)
				$consulta = "delete from carrito where id_cliente = ?;";
				$elimino_carrito = Database::executeRow( $consulta, array( $_SESSION['id_cliente'] ) );
			}
		}
		else if ( isset( $_POST['realizar_compra'] ) && isset( $_POST['r_pedido'] ) ){

			//Cuando lo manda al local no es necesario que ingrese una fecha o horario :D

			//Eliminar registros de carrito y pasarlos a detalles compras para luego crear el registro en copra ='D'
		    $consulta = "select carrito.id_img_producto, precio_producto, cantidad_producto from carrito inner join img_productos on img_productos.id_img_producto = carrito.id_img_producto inner join productos on productos.id_producto = img_productos.id_producto where id_cliente = ?;";
			$data = Database::getRows( $consulta, array( $_SESSION['id_cliente'] ) );
			
			//Ahora elimino los registros de carrito relacionados con ese cliente :)
			$consulta_eliminar_carrito = "delete from carrito where id_cliente = ?;";
			
			//insertamos la compra --Tengo que ocupar el metodo anterior por que necesito ocupar la variable $PDO o de conexion :')
			require("../sql/conexion.php");
			$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if ( $_POST['r_pedido'] == 2 ){//Si la opcion es local
				//Elimino los registros de tabla carrito pero solamente si es mayor a 1 registro :D
				if ( $data != null && count($data) >= 1 ) $elimino_carrito = Database::executeRow( $consulta_eliminar_carrito, array( $_SESSION['id_cliente'] ) );

				$consulta = "insert into pedidos_local ( id_cliente, fecha_pedido, total, estado ) values ( ?, ?, ?, ? );";
				$stmt = $PDO->prepare($consulta);
				if ( $elimino_carrito == 1 ) if ( count($data) >= 1 ) $exito_inser_pedido = $stmt->execute( array ( $_SESSION['id_cliente'], date("Y-m-d H:i:s"), 0, 0 ) );
			}
			else{//Cuando awuebo debe seleccionar una fecha :D
				if ( isset( $_POST['fecha_entrega'] ) && Validator::fecha( $_POST['fecha_entrega'] ) ){
					if ( Date( $_POST['fecha_entrega'] ) >= Date( date( 'Y-m-d' ) ) ){
						$max_dias_pedido = Database::getRow( "select max_dias_pedido from datos;", null );//Obtengo los dias como maximo despues de la fecha actual, donde se puede realizar el pedido :D
						if ( strtotime( $_POST['fecha_entrega'] ) <= ( strtotime( date( 'Y-m-d' ) ) + ( $max_dias_pedido['max_dias_pedido'] * 86400 ) ) ){//86400 Es el resultado de multiplicar 24hrs * 3600s (ya que, 1hr = 3600s :)
							if ( isset( $_POST['id_horario_entrega'] ) && Validator::numero( $_POST['id_horario_entrega'] ) ){
								//Obtengo la hora inicial del horario seleccionado
								$horario_entrega = Database::getRow( "select hora_inicial from horarios_entrega where id_horario_entrega = ?;", array( $_POST['id_horario_entrega'] ) );
								//Obtengo la hora actual del servidor "date("H:i:s")"
								//if ( strtotime( $horario_entrega['hora_inicial'] ) >= strtotime( date("H:i:s") ) ){
									//Si la opcion es otra direccion o direcciones ya ingresadas
									if ( ( $_POST['r_pedido'] == 1 || $_POST['r_pedido'] == 3 ) && isset( $_POST['id_direccion'] ) && Validator::numero( $_POST['id_direccion'] ) ){
										if ( $_POST['r_pedido'] == 3 && isset( $_POST['direccion'] ) && ! Validator::direccion( $_POST['direccion'] ) ) {
											$error = "La direccion ingresada es invalida.";
										}
										else if ( $_POST['r_pedido'] == 3 && isset( $_POST['direccion'] ) && Validator::direccion( $_POST['direccion'] ) ) {//Insertare la direccion ingresada
											$consulta = "insert into direcciones ( id_cliente, direccion ) values ( ?, ? );";
											$stmt = $PDO->prepare($consulta);
											$exito_inser_direc = $stmt->execute( array ( $_SESSION['id_cliente'], $_POST['direccion'] ) );
											if ( $exito_inser_direc == 1 ) $id_direccion = $PDO->lastInsertId();
										}
										else if ( $_POST['r_pedido'] == 1 ) $id_direccion = $_POST['id_direccion'];

										if ( isset( $id_direccion ) ){
											//Obtengo si hay registros con este id de direccion :D
											$valida_direccion = Database::getRow( "select * from direcciones where id_direccion = ?;", array ( $id_direccion ) );
											if ( $valida_direccion != null ) {
												/*Obtener la cantidad como minima de productos para llevar el pedido adomicilio*/
												$min_pro_pedido = Database::getRow( "select min_pro_pedido from datos", null );

												//Elimino de carritos pero solamente si el minimo de registros es mayor a 7 :D
												if ( $data != null && count($data) >= $min_pro_pedido['min_pro_pedido'] ) $elimino_carrito = Database::executeRow( $consulta_eliminar_carrito, array( $_SESSION['id_cliente'] ) );

												if ( $elimino_carrito == 1 ){
													$consulta = "insert into pedidos ( id_direccion, id_horario_entrega, fecha_pedido, total, estado ) values ( ?, ?, ?, ?, ? );";
													$stmt = $PDO->prepare($consulta);
													$exito_inser_pedido = $stmt->execute( array ( $id_direccion, $_POST['id_horario_entrega'], $_POST['fecha_entrega'], 0, 0 ) );
												}
												else $error = "Debe comprar almenos " . $min_pro_pedido['min_pro_pedido'] . " productos, para relizar el pedido a domicilio.";
											}
											else $error = "Id de dirección invalido";
										}
									}
								//}
								//else $error = "Horario de entrega invalido, la hora inicial no debe de haber transcurrido.";
							}
							else $error = "Id de horario invalido.";
						}
						else $error = "Fecha invalida, no debe superar la fecha ". date( 'Y-m-d' ) . " Hoola xd" .".";
					}
					else $error =  "Fecha invalida, no debe ser menor que " . date( 'Y-m-d' ) . ".";
				}
				else $error = "Fecha invalida, debe seguir el formato 'año\"-\"mes\"-\"dia'.";
			}

			if ( isset( $exito_inser_pedido ) && $exito_inser_pedido == 1 ) $id_pedido = $PDO->lastInsertId();
				$PDO = null;

			//Coloco cero como total por que luego updatear el dato, por que si no me hubiera tocado hacer dos foreach, uno para sacar el total a pagar y luego insertar para luego ya etner el id e insertar a detalles compras, para lo cual ahi por ley tengo que ocupar un foreach para sacar uno por uno del resultado de carrito :)
			$p_cargo_envio = Database::getRow( "select cargo_pedidos from datos", null );
			( $_POST['r_pedido'] == 2 ) ? $total_pago = 0 : $total_pago = $p_cargo_envio['cargo_pedidos'];

			if ( isset( $id_pedido ) && $id_pedido != null ){
				foreach ($data as $carrito) {
					( $_POST['r_pedido'] == 2 ) ? $consulta = "insert into detalles_pedidos_local ( id_pedido_local, id_img_producto, cantidad_producto, precio_producto ) values ( ?, ?, ?, ? );" : $consulta = "insert into detalles_pedidos ( id_pedido, id_img_producto, cantidad_producto, precio_producto ) values ( ?, ?, ?, ? );";
					Database::executeRow( $consulta, array( $id_pedido, $carrito['id_img_producto'], $carrito['cantidad_producto'], $carrito['precio_producto'] ) );
					$total_pago += ( $carrito['precio_producto'] * $carrito['cantidad_producto'] );
				}

				//Proceso completo
				( $_POST['r_pedido'] == 2 ) ? $consulta = "update pedidos_local set total = ? where id_pedido_local = ?;" : $consulta = "update pedidos set total = ? where id_pedido = ?;";
				$exito_totalxd = Database::executeRow( $consulta, array( $total_pago, $id_pedido ) );
			}
		    //Proceso completo :D
		    if ( isset( $exito_totalxd ) && $exito_totalxd == 1 ) header( "location: index" );
		}
    }
?>
<div class="container margin_top_navbar">
	<ul class="nav nav-tabs nav-justified">
		<li class="active"><a data-toggle="tab" href="#compras">Compras</a></li>
	<?php
		require ('../lib/paginacion.php');
		$sql = "SELECT carrito.id_img_producto, productos.id_producto, nombre_producto, precio_producto, imagen_producto, id_presentacion, cantidad_producto FROM (`carrito` inner join img_productos on img_productos.id_img_producto = carrito.id_img_producto) inner join productos on productos.id_producto = img_productos.id_producto WHERe id_cliente=? order by nombre_producto ASC";
		$Paginacion = new Paginacion();
		$records_per_page=10;
		$parametro = array( $_SESSION['id_cliente'] );
		$newconsulta = $Paginacion->paging($sql,$records_per_page);//Me regresa la consulta con el limit, claro que cada vez que le des uno al paging, lo modifica :)
		$data = Database::getRows($newconsulta, $parametro );//Id_producto
		print( ( isset( $data ) != null && count($data) >= 1 ) ? '<li><a data-toggle="tab" href="#reap" id="tab_reap">Relizar pedido</a></li>' : '<li><a href="#">Relizar pedido</a></li>' );
	?>
	</ul>

	<div class="tab-content alinear">
		<div class="tab-pane fade in active" id="compras">
			<div class="row thumbnail colordiv" id="divtitulos">
				<div class="col-xs-3 col-xs-offset-2 col-sm-3 col-sm-offset-3 col-md-3 col-md-offset-3 col-lg-3 col-lg-offset-3">
					<p class="textitulo">Nombre-precio-presentacion</p>
				</div>
				<div class="col-xs-2 col-xs-offset-2 col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2">
					<p class="textitulo">Cantidad</p>
				</div>
				<div class="col-xs-1 col-xs-offset-1 col-sm-1 col-sm-offset-1 col-md-1 col-md-offset-1 col-lg-1 col-lg-offset-1">
					<p class="textitulo">Subtotal</p>
				</div>
			</div>
			<?php 
				if ( isset( $error ) ) print("<div class='alert alert-danger' role='alert'>" . $error . "</div>"); 
			?>
			<!--Foreach para mostrar todas las compras en el carrito-->
			<?php
				$total_can = 0;//para mostrar en la otra pestaña cuantos productos se lleva el cliente
				$total_pago = 0;//mostrar el total de la compra :D
				if( $data != null ){
					$compras = "";//Arreglo para guardar los registros :D
					foreach ($data as $compra) {//span---> id_img_producto="'.$compra['id_img_producto'].'"
						$compras .= '<div class="row thumbnail divinopro colordiv"><!-- se añade la clase size a todas las imagenes-->
										<input type="hidden" class="id_img_producto" value="'.$compra['id_img_producto'].'" />
										<div class="col-xs-2 col-xs-offset-10 col-sm-2 col-sm-offset-10 col-md-2 col-md-offset-10 col-lg-2 col-lg-offset-10 divbor"><!--Se agrega para el efecto de ubicar la x en su lugar ="DD-->
											<span onclick="javascript: Mensaje( 0, '.$compra['id_img_producto'].', 3 );" class="glyphicon glyphicon-remove-circle"></span>
										</div>
										<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 divima"><!--Se agrega la imagen-->
											<img src="../img/productos/'.$compra['imagen_producto'].'" alt="'.$compra['nombre_producto'].'" class="size">
										</div>
										<div class="col-xs-3 col-sm-4 col-md-4 col-lg-4 divnomb">
											<p class="texnormal">'.$compra['nombre_producto'].'</p>
											<p class="texnormal producto_precio">$'.$compra['precio_producto'].'</p>
											<div class="row col-xs-3 col-sm-9 col-md-9 col-lg-9">
												<select class="form-control id_presentacion" onclick="javascript: actualizar_compras( $(this), 2 );">
										            <!--option value="" disabled selected>Seleccione la presentacion</option-->';
													//todas las opciones de cambiar de presentacion el producto =}
													$consulta = 'select presentaciones.id_presentacion, presentacion from presentaciones inner join img_productos on img_productos.id_presentacion = presentaciones.id_presentacion where id_producto = ? order by presentacion';
													$presentaciones = Database::getRows($consulta, array( $compra['id_producto'] ) );//Id_producto
													$oppresentaciones = "";//Arreglo para guardar los registros :D
													$anterior_id = 0;//Controlo para no colocar las presentaciones repetidas :}
													foreach ($presentaciones as $presentacion) {
														if ( $anterior_id != $presentacion['id_presentacion'] ){
															$oppresentaciones .= "<option value='$presentacion[id_presentacion]'";
										                    if( $presentacion['id_presentacion'] == $compra['id_presentacion'] ){
										                    	$oppresentaciones .= " selected";
										                    }
										                    $oppresentaciones .= " style='color:$presentacion[presentacion];'>$presentacion[presentacion]</option>";
										                }
										                $anterior_id = $presentacion['id_presentacion'];
													}
													$compras .= $oppresentaciones;//Imprimmos el resultado =}
													//Hasta aqui llego con lo de presentaciones
									$compras .= '</select>
											</div>
										</div>
										<div class="div_cant_sub">
											<div class="col-xs-3 col-sm-2 col-md-2 col-lg-2 divcant">
												<div class="row">
													<div class="col-xs-7 col-sm-7 col-md-7 col-lg-3 subdivcant">
														<input type="text" class="form-control cantidad" placeholder="Cantidad" name="cantidad" value="'.$compra['cantidad_producto'].'">
													</div>
													<div class="col-xs-4 col-sm-4 col-md-4 col-lg-3 subdivcant">
														<button type="button" class="btn btn-default btndiego" onclick="javascript: actualizar_compras( $(this), 1 );"> <span class="glyphicon glyphicon-refresh"></span> </button>
													</div>
												</div>
											</div>
											<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 divsub">
												<p class="texnormal">$'.( $compra['cantidad_producto'] * $compra['precio_producto'] ).'</p>
											</div>
										</div>
									</div>';
						$total_can += $compra['cantidad_producto'];
						$total_pago += ( $compra['precio_producto'] * $compra['cantidad_producto'] );
					}
					//$comentarios .= '<button type="button" class="btn btn-primary col-xs-12 btncolor">Mostrar más</button>';
					print( $compras );
					$compras = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center">
								 			<div class="pagination-wrap">
								            '.$Paginacion->paginglink($sql,$records_per_page, $parametro).'
								        	</div>
								        </div>';
					print( $compras );
				}
				else print("<div class='alert alert-danger' role='alert'>No hay productos añadidos.</div>");
				//print( "<a>".$newconsulta."</a>" );
			?>
			<!--Foreach para mostrar todas las compras en el carrito-->
			<!--Fin de productos='DD-->
		</div>
		<!--Parte de realizacion de pedido ='DDD-->
		<?php if ( count($data) >= 1 ){ ?>			
			<div class="tab-pane fade" id="reap">
				<form method="post" name="realizar_pedido">
					<div class="row">
						<!--Se procede a agregar la parte de fecha ='DD-->
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 colordiv thumbnail" id="divfecha">
							<div class="row row-normal">
								<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" id="tex_fec">
								    <p class="texnormal2">Fecha de entrega:</p>
								</div>
								<div class="col-xs-2 col-sm-2 col-md-3 col-lg-3 padding" id="ing_fec">
									<div class="input-group date">
					                  <div class="input-group-addon">
					                    <i class="fa fa-calendar"></i>
					                  </div>
					                  <input type="text" class="form-control pull-right" name="fecha_entrega" id="datepicker" value="<?php print( date( 'Y-m-d' ) );?>" >
					                </div>
									<!--div class="row">
									    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 no_padding">
										    <input type="text" class="form-control" name="fecha_pedido" id="fecha_pedido" >
										</div>
									    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 padding_right">
										    <button type="button" class="btn btn-default size btnisa"><span class="glyphicon glyphicon-calendar"></span></button>
										</div>
									</div-->
								</div>
								<!--Pense en insertar el divider xd por falta de tiempo no xd-->
								<!--Segunda parte de la hora-->
								<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 padding_left_nojs" id="tex_ho">
								    <p class="texnormal2">Hora de entrega:</p>
								</div>
								<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 padding_right_nojs" id="ing_ho">
								    <select class="form-control" name="id_horario_entrega" id="horarios_entrega">
								    	<?php
								    		$dia = getdate();//Le sumo 1 por que comienza en 0
								    		//1 es domingo, 2 es lunes, 3 es martes, 4 es miercoles, 5 es jueves, 6 es viernes y 7 es sabado
								    		$data_horarios = Database::getRows( "select id_horario_entrega, hora_inicial, hora_final from horarios_entrega where dia = ?;", array ( $dia['wday'] + 1 ) );
								    		$horarios = "";
								    		foreach ( $data_horarios as $key ) {
								    			$horarios .= '<option value="' . $key['id_horario_entrega'] . '">' . $key['hora_inicial'] . ' a ' . $key['hora_final'] . '</option>';
								    		}
								    		if ( $horarios == null ) $horarios = '<option >No poseemos horario para este dia.</option>';
								    		print( $horarios );
								     	?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<!--Se procede a agregar el mapa ='D-->
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" id="divMapDDDContent">
							 <div class="row row-normal">
							 	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 colordiv thumbnail" id="divMapDDDContentC">
							 		<div id="divMapDDD">
									 	<!--Mapa ='DDD-->
									 </div>
							 	</div>
							 </div>
						</div>
						<!--Se procede a seleccionar el lugar a donde dejar el pedido-->
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 colordiv thumbnail" id="divlugar">
							<div class="row row-normal">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<p class="texnormal2">Cantidad de productos:</p>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<p class="texnormal3" id="p_total_can"><?php print( $total_can ); ?></p>
								</div>
								<br>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<p class="texnormal2">Total a pagar:</p>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<p class="texnormal3" id="p_total_pago"><?php print( '$' . $total_pago ); ?></p>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<p class="texnormal2">Cargo de envio:</p>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<p class="texnormal3" id="p_cargo_envio">
										<?php
										$cargo_pedidos = Database::getRow( "select cargo_pedidos from datos", null );/*Obtener la cantidad como minima de productos para llevar el pedido adomicilio*/
										print( "$" . $cargo_pedidos['cargo_pedidos'] );
										?>
									</p>
									<p>(Si el pedido es a domicilio, se sumara el cargo por envio)</p>
								</div>
								<div class="divider-diego no_padding size"></div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<p class="texnormal2">Lugar de entrega:</p>
								</div>
								<div class="padding"><!--Lo pongo para aplicarselo a cada elemento ='D-->
									<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 padding_right_nojs">
									    <label class="phand" id="lblmidirec"><input type="radio" name="r_pedido" value="1" id="inmidirec" checked="">Dirección ingresada</label>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 padding_right_nojs">
									    <label class="phand" id="lbllocaldirec"><input type="radio" name="r_pedido" value="2" id="inlocaldirec">Local ISADELI</label>
									</div>
									<!--div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 no_padding"-->
								    	<!--div class="divider-vdiego" id="di_v_hei_divi"></div-->
								    <!--/div-->
								    <!--Se agrega el otro aqui por motivos de mejor estructura -->
									<div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 no_padding">
									    <label class="phand" id="lblotradirec"><input type="radio" name="r_pedido" value="3" id="inotradirec">Otra</label>
									</div>
								</div>
							</div>
							<!--div class="divider-diego no_padding size"></div-->
							<!--Se procede a ingresar los datos de dirección, o corrobarlos ='DD-->
							<div class="tab-content" id="tc_direccion">
								<!--div class="row margin">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<p class="texnormal2">Selecciona tu direccion:</p>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p class="texnormal3">San Salvador</p>
									</div>
								</div-->
								<div class="tab-pane active row margin" id="midirec">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<p class="texnormal2">Selecciona tu direccion:</p>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<select name="id_direccion" class="form-control">
											<?php
												$consulta = "select id_direccion, direccion from direcciones where id_cliente = ?;";
												$re_direcciones = Database::getRows($consulta, array( $_SESSION['id_cliente'] ) );									
												$direcciones = "";
												foreach ($re_direcciones as $key) $direcciones .= "<option value='$key[id_direccion]'>$key[direccion]</option>";
												print( $direcciones );
											?>
										</select>
									</div>

									<!--div class="row margin">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p class="texnormal2">Municipio:</p>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p class="texnormal3">San Salvador</p>
										</div>
									</div>
									<div class="row margin">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p class="texnormal2">Direccion:</p>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p class="texnormal3">Col San Antonio, pasaje #3, casa #33.</p>
										</div>
									</div-->
								</div>
								<div class="tab-pane" id="localdirec">
									<div class="row margin">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p class="texnormal2">Municipio:</p>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p class="texnormal3">San Salvador</p>
										</div>
									</div>
									<div class="row margin">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p class="texnormal2">Direccion:</p>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p class="texnormal3">7a Calle Poniente y 83 Ave. Nte. Calle El Mirador #119, Colonia Escalón</p>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="otradirec">
									<!--div class="row margin">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p class="texnormal2">Municipio:</p>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										    <select class="form-control">
											    <option value="0">Aguilares</option>
											    <option value="1">Apopa</option>
											    <option value="2">Ayutuxtepeque</option>
											    <option value="3">Cuscatancingo</option>
											    <option value="4">Delgado</option>
											    <option value="5">El Paisnal</option>
											    <option value="6">Guazapa</option>
											    <option value="7">Ilopango</option>
											    <option value="8">Mejicanos</option>
											    <option value="9">Nejapa</option>
											    <option value="10">Panchimalco</option>
												<option value="11">Rosario de Mora</option>
												<option value="12">San Marcos</option>
												<option value="13">San Martín</option>
												<option value="14">San Salvador</option>
												<option value="15">Santiago Texacuangos</option>
												<option value="16">Santo Tomás</option>
												<option value="17">Soyapango</option>
												<option value="18">Tonacatepeque</option>
										  	</select>
										</div>
									</div-->
									<div class="row margin">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p class="texnormal2">Direccion:</p>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<input type="text" class="form-control" name="direccion" placeholder="7a Calle Poniente y 83 Ave. Nte. Calle El Mirador #119, Colonia Escalón">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<button type="submit" name="realizar_compra" value="si" class="btn btn-default btnisa size" id="btnreal_ped">Realizar pedido</button>
								</div>
							</div>
						</div><!--Por el boton Realizar pedido ='DD-->
						<!--Segundo mapa, invisible, y luego visible y el otro invisble-->
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" id="divMapDDDContent2">
							 <div class="row row-normal">
							 	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 colordiv thumbnail" id="divMapDDDContentC2">
							 		<div id="divMapDDD2">
									 	<!--Mapa ='DDD-->
									 </div>
							 	</div>
							 </div>
						</div>
					</div>




					<!--div class="row">
						<div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
							<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
								<div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
									<p class="texnormal">Cantidad de productos:</p>
								</div>
								<div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
									<!--?php
										$consulta = "select count(id_img_producto) Productos from carrito where id_cliente = ?;";
										$data = Database::getRow( $consulta, array( $_SESSION['id_cliente'] ) );
									?>
									<p class="texnormal"><!--?php  print( ( $data['Productos'] != null ) ? $data['Productos'] : '0' ); ?></p>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
							<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
								<form method="post">
									<button name="realizar_compra" class="btn btn-primary size">Realizar pedido</button>
									<br>
									<br>
									<button name="borrar_productos" class="btn btn-default btndiego size">Cancelar pedido</button>
								</form>
							</div>
						</div>
					</div-->
				</form>
			</div>
		<?php } ?>
	</div>
</div>

<!--Se añade el pie de pagina ='DDD-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXJSw2d5lmXJBqEMkCCbDBzQusCr3nhj4"></script>
<?php Page::footer(); ?>