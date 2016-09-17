<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
    //Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page-privado.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    $permisos = Page::header("Productos", "productos");
?>
		            			<br>
		            			<div class="col-sm-8 col-md-8 col-lg-8">
									<div class="input-group">
										<span class="input-group-addon no_padding_input-group"><button type="submit" name="action" value="Buscar" class="glyphicon glyphicon-search nobtn padding_input-group"></button></span>
										<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe el nombre del producto o una categoria..."/>
									</div>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									<a href="agregar_producto">
										<button type="button" class="btn btn-primary size">
									        <span class="glyphicon glyphicon-plus"></span>
									    </button>
								    </a>
								</div>
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
									            <th class="col-sm-2 col-md-2 col-lg-2">Categoria</th>
									            <th class="col-sm-3 col-md-3 col-lg-3">Producto</th>
									            <th class="col-sm-1 col-md-1 col-lg-1">Precio</th>
									            <th class="col-sm-2 col-md-2 col-lg-2">Estado</th>
									            <th class="col-sm-4 col-md-4 col-lg-4">Acciones</th>
									        </tr>
									    </thead>
									    <tbody>
										<?php
											require("../sql/conexion.php");
											$consulta = "SELECT id_producto, categoria, nombre_producto, precio_producto, estado FROM productos inner join categorias on categorias.id_categoria = productos.id_categoria";
											if( isset( $_POST['txtBuscar'] ) != "" && Validator::letras( $_POST['txtBuscar'] ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " where nombre_producto LIKE '%$busqueda%' or categoria LIKE '%$busqueda%' order by nombre_producto ASC";
							    			}
							    			else $consulta = $consulta . " order by nombre_producto ASC";
											$productos = ""; //Arreglo de datos
											foreach($PDO->query($consulta) as $datos){
												$productos .= "<tr>";
													//$productos .= "<td class='td_oculto'>$datos[id_producto]</td>";
													$productos .= "<td>$datos[categoria]</td>";
													$productos .= "<td>$datos[nombre_producto]</td>";
													$productos .= "<td>$datos[precio_producto]</td>";
													$estado = "";
													if ( $datos['estado'] == 1 ) $esta = 'Habilitado';
													else $esta = 'Inhabilitado';
													$productos .= "<td>$esta</td>";
													$productos .= '<td class="text-center"><a href="editar_producto?id='.base64_encode( $datos['id_producto'] ).'" class="icono_tamano glyphicon glyphicon-edit padding_right_nojs"></a><a href="eliminar_producto?id='.base64_encode( $datos['id_producto'] ).'" class="icono_tamano glyphicon glyphicon-remove-circle"></a><a href="img_pro?id='.base64_encode( $datos['id_producto'] ).'" class="glyphicon glyphicon-camera a_text_normal padding_left_nojs icono_tamano" ></a></a><a href="existencias?id='.base64_encode( $datos['id_producto'] ).'" class="glyphicon glyphicon-book a_text_normal padding_left_nojs icono_tamano" ></a></td>';
												$productos .= "</tr>";
											}
											print($productos);
											$PDO = null;
										?>
										</tbody>
									</table>
								</div>
							</div>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>