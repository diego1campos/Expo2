<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
	//Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page-privado.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    $permisos = Page::header("Vista de productos", "productos");
	if ( ! empty($_POST) ){
		try{
			$id_producto = $_POST['id_producto'];
			if ( Validator::numero($id_producto) ){
				if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
				else {
					$consulta = "update productos set vistas = 0 where id_producto = ?;";            
			        $exito = Database::executeRow( $consulta , array ( $id_producto ) );
			        //Bitacora
			        Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 15 , 2, $consulta ) );
			    }
			}
			else if ( $id_producto == 'todos' ){
				if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
				else {
					$consulta = "update productos set vistas = 0;";            
			        $exito = Database::executeRow( $consulta , null );
			        Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 15 , 2, $consulta ) );
			    }
			}
			else $error[] = "Id de producto invalido.";
		}
		catch ( Exception $Exception ){
			$error[] = $Exception->getMessage();
		}
	}

		        				print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Numero de visto reiniciado con exito.</div>' : "" );
		        				if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' ); ?>
		        				<br>
								<div class="col-sm-8 col-md-8 col-lg-8">
									<input type="hidden" id="id_producto" name="id_producto" />
									<div class="input-group">
										<span class="input-group-addon no_padding_input-group"><button type="submit" name="action" value="Buscar" class="glyphicon glyphicon-search nobtn padding_input-group"></button></span>
										<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe la categoria, producto o Nº..."/>
									</div>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									<button data-toggle="tooltip" title="Reiniciar todos los productos." data-placement="bottom" type="submit" name="id_producto" value="todos" class="btn btn-primary size">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								</div>
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
					                            <th class="col-sm-4 col-md-4 col-lg-4">Categoria</th>
					                            <th class="col-sm-4 col-md-4 col-lg-4">Producto</th>
					                            <th class="col-sm-2 col-md-2 col-lg-2">Nº visto</th>
					                            <th class="col-sm-2 col-md-2 col-lg-2">Reiniciar</th>
									        </tr>
									    </thead>
									    <tbody>
										<?php
											require("../sql/conexion.php");
											$consulta = "SELECT id_producto, categoria, nombre_producto, vistas FROM productos inner join categorias on categorias.id_categoria = productos.id_categoria";
											if( isset( $_POST['txtBuscar'] ) != "" && ( Validator::letras( $_POST['txtBuscar'] ) || Validator::numero( $_POST['txtBuscar'] ) ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . " and ( vistas like '%$busqueda%' or nombre_producto LIKE '%$busqueda%' or categoria LIKE '%$busqueda%' )";
							    			}
							    			$consulta = $consulta . " ORDER BY categoria ASC;";
											$comentarios = ""; //Arreglo de datos
											foreach($PDO->query($consulta) as $datos){
												$comentarios .= "<tr>";
						                            $comentarios .= "<td>$datos[categoria]</td>";
						                            $comentarios .= "<td>$datos[nombre_producto]</td>";
						                            $comentarios .= "<td>$datos[vistas]</td>";
						                            $comentarios .= '<td class="text-center"><button name="id_producto" value="'.$datos['id_producto'].'"  class="nobtn-trans" type="submit"><a class="icono_tamano glyphicon glyphicon-refresh"></a></button></td>';
					                          $comentarios .= "</tr>";
											}
											print($comentarios);
											$PDO = null;
										?>
										</tbody>
									</table>
								</div>
							</div>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>