<?php
  	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
  	//Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page-privado.php");
	//Por el antiguo metodo de conectar con la base :)
	require("../sql/conexion.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Comentarios", "comentarios");

  	if(!empty($_POST)){
	    $id_comentario = base64_decode( $_POST['id_comentario'] );
	    try{
	    	if ( Validator::numero( $id_comentario ) ){
	    		if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
				else {
		    		$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			        $consulta = "update comentarios_productos set estado_comentario=1 where id_comentario=?";
			        $stmt = $PDO->prepare($consulta);
			        $exito = $stmt->execute(array ( $id_comentario ) );
			        $PDO = null;
			        if ( $exito == 1 ){
			        	//Ejecutar procedimiento para bitacora ='}'
				        $exito = Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 24, 2, $consulta ) );
			        }
			    }
		    }
		    else $error[] = "Id no valido.";
	    }
	    catch( Exception $Exception ){
			$error[] = $Exception->getMessage();
		}
  	}
?>
		            			<?php
		            				if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
		            				if ( isset($exito) && $exito == 1 ) echo '<div class="alert alert-success" role="alert">Comentario aprobado con exito.</div>';
		            			?>
		            			<input type="hidden" name="id_comentario" id="id_comentario"/>
		            			<div class="col-sm-8 col-md-8 col-lg-8 no_padding">
									<div class="col-sm-12 col-md-12 col-lg-12 no_padding">
										<div class="col-sm-12 col-md-12 col-lg-12">
											<label>Comentario</label>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-12">
											<textarea class="l-dato size resize" id="tcoment" readonly></textarea>
										</div>
									</div>
								</div>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button type="submit" class="btn btn-primary size"><span class="fa fa-check"></span></button>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
									    <a id="a_eliminar"><button type="button" class="btn btn-danger size"><span class="fa fa-close"></span></button></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
		    		<div class="col-xs-12">
		        		<div class="box">
		        			<div class="box-body">
		        				<br>
								<div class="col-sm-8 col-md-8 col-lg-8">
									<div class="input-group">
										<span class="input-group-addon no_padding_input-group"><button type="submit" name="action" value="Buscar" class="glyphicon glyphicon-search nobtn padding_input-group"></button></span>
										<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe la categoria, producto, usuario o fecha..."/>
									</div>
								</div>
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
					                            <th class="col-sm-3 col-md-3 col-lg-3">Producto</th>
					                            <th class="col-sm-3 col-md-3 col-lg-3">Usuario</th>
					                            <th class="col-sm-3 col-md-3 col-lg-3">Fecha</th>
					                            <th class="col-sm-2 col-md-2 col-lg-2">Acciones</th>
									        </tr>
									    </thead>
									    <tbody>
										<?php
											require("../sql/conexion.php");
											$consulta = "select id_comentario, comentario_producto, categoria, nombre_producto, usuario, fecha_ingreso, estado_comentario  from comentarios_productos c, productos p, clientes cli, categorias ca where c.id_cliente = cli.id_cliente and c.id_producto = p.id_producto and p.id_categoria = ca.id_categoria and estado_comentario=0";
											if( isset( $_POST['txtBuscar'] ) != "" && Validator::numeros_letras( $_POST['txtBuscar'] ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " and (categoria LIKE '%$busqueda%' or nombre_producto LIKE '%$busqueda%' or usuario LIKE '%$busqueda%' or fecha_ingreso LIKE '%$busqueda%') ORDER BY fecha_ingreso ASC;";
							    			}
							    			else $consulta = $consulta . " ORDER BY fecha_ingreso ASC;";
											$comentarios = ""; //Arreglo de datos
											foreach($PDO->query($consulta) as $datos){
												$comentarios .= "<tr>";
						                            $comentarios .= "<input type='hidden' class='id_comentario' value='".base64_encode( $datos['id_comentario'] )."' />";
						                            $comentarios .= "<td class='producto'>$datos[nombre_producto]</td>";
						                            $comentarios .= "<td class='usuario'>$datos[usuario]</td>";
						                            $comentarios .= "<input type='hidden' class='comentario' value='$datos[comentario_producto]' />";
						                            $comentarios .= "<td class='fecha'>$datos[fecha_ingreso]</td>";
						                            $comentarios .= '<td class="text-center"><a class="up glyphicon glyphicon-comment icono_tamano" onclick="javascript: $(this).coment();"></a></td>';
					                          $comentarios .= "</tr>";
											}
											print($comentarios);
											$PDO = null;
										?>
										</tbody>
									</table>
								</div>
							</div>
		        		</div>
		        	</div>
		        </div>
		    </form>
		</section><!--Conent ='DD-->
	</div><!--ConentWrapper ='DD-->
</div><!--Wrapper ='DD-->

<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>

<script src="../publico/js/bootstrap.min.js"></script>

<script src="dist/js/app.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>

<script src="plugins/datatables/dataTables.bootstrap.js"></script>

<script src="../publico/js/mainB.js"></script>

</body>
</html>