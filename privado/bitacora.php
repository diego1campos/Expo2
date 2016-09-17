<?php
  	ob_start();
    require("../lib/database.php");
    require("../lib/validator.php");
    require("../lib/page-privado.php");
	$permisos = Page::header("Bitacora", "bitacora");

	if ( $permisos == 0 ) header( "location: index" );

?>

<form method="post">

	            		<div class="col-sm-1 col-md-1 col-lg-1">
	            				<br>
								<button class="btn btn-danger" type="submit" name="action" >
							     <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
							    </button>
							</div>

	            			<div class="col-sm-3 col-md-3 col-lg-3">
								<div class="form-group">
									<label for="nombre">Nombre empleado</label>
									<input class="form-control" type="text" name="txtNombre" id="nombre" class="validate" placeholder="Nombre completo" value="<?php print( ( isset($_POST['txtNombre']) ) ? $_POST['txtNombre'] : ""); ?>" />
								</div>
							</div>

					<div class="col-sm-2 col-md-2 col-lg-2">
						<div class="form-group">
						<label for="tabla">Tabla</label>
					    <select id="tabla" name="txtTabla" class="form-control">
					      <option value="" selected>No seleccionado</option>
					      <?php
						    	$consulta = "select * from tablas";
				    			$opciones = ""; //Arreglo de datos
				    			foreach( Database::getRows( $consulta, null ) as $datos)
				    			{
									$opciones .= "<option value='$datos[id_tabla]'";
									if(isset($tipo) == $datos['id_tabla'])
									{
										$opciones .= " selected";
									}
									$opciones .= ">$datos[tabla]</option>";
				    			}
				    			print($opciones);
						    ?>
					    </select>
					</div>
					</div>

					<div class="col-sm-2 col-md-2 col-lg-2">
						<div class="form-group">
							<label for="acciones">Acciones</label>
						    <select id="acciones" name="txtAcciones" class="form-control">
						      <option value="" selected>No seleccionado</option>
						      <?php
							    	$consulta = "SELECT * FROM tipos_acciones";
					    			$opciones = ""; //Arreglo de datos
					    			foreach( Database::getRows( $consulta, null ) as $datos)
					    			{
										$opciones .= "<option value='$datos[id_tipo_acciones]'";
										if(isset($tipo) == $datos['id_tipo_acciones'])
										{
											$opciones .= " selected";
										}
										$opciones .= ">$datos[tipo_accion]</option>";
					    			}
					    			print($opciones);
							    ?>
						    </select>
						</div>
					</div>

				<div class="col-sm-2 col-md-2 col-lg-2">
					<div class="form-group">
						<label for="fecha_inicial">Fecha inicial</label>
						<input id="fecha_inicial" class="form-control fecha_picker" name="txtFecha" type="text" placeholder="Fecha inicial" value="<?php print( ( isset($_POST['txtFecha']) ) ? $_POST['txtFecha'] : ""); ?>">
					</div>
				</div>

				<div class="col-sm-2 col-md-2 col-lg-2">
					<div class="form-group">
						<label for="fecha_final">Fecha final</label>
						<input id="fecha_final" class="form-control fecha_picker" name="txtFecha2"  type="text" placeholder="Fecha final" value="<?php print( ( isset($_POST['txtFecha2']) ) ? $_POST['txtFecha2'] : ""); ?>">
					</div>
				</div>

						</div>
					</form>
						<div class="box-body table-responsive">
							<table class="table table-bordered table-hover conf_tabla">
							    <thead>
							        <tr>
							            <th class="col-sm-2 col-md-2 col-lg-2">Nombre</th>
							            <th class="col-sm-2 col-md-2 col-lg-2">Tabla</th>
							            <th class="col-sm-2 col-md-2 col-lg-2">Accion</th>
							            <th class="col-sm-3 col-md-4 col-lg-3">Descripcion</th>
							            <th class="col-sm-2 col-md-2 col-lg-2">Fecha</th>
							           
							        </tr>
							    </thead>
							    <tbody id="">
								<?php
									if( isset($_POST['txtNombre']) != "" || isset($_POST['txtTabla']) != "" || isset($_POST['txtAcciones']) != "" || isset($_POST['txtFecha']) != "" || isset($_POST['txtFecha2	']) != "" ){
										/*VISTA ARTURO---select b.id_tabla, a.id_tipo_acciones, concat( e.nombres_empleado, " ", e.apellidos_empleado ) nombre_empleado, t.tabla, a.tipo_accion, b.descripcion, b.fecha_ingreso from empleados e, tablas t, tipos_acciones a, bitacora b where b.id_empleado = e.id_empleado and b.id_tabla = t.id_tabla and b.id_tipo_accion = a.id_tipo_acciones;*/
										//Consulta para probar en phpmyadmin :)-->SELECT * from bita where nombre_empleado like '%diego%' and id_tabla like '%%' and id_tipo_acciones like '%%' and cast( fecha_ingreso as date ) between '' and ''
										$consulta = "SELECT * from bita where nombre_empleado like '%";

										$consulta .= ( isset( $_POST['txtNombre'] ) && Validator::letras( $_POST['txtNombre'] ) ) ? trim( $_POST['txtNombre'] ) : "";

										$consulta .= "%' and id_tabla like '%";

										$consulta .= ( isset($_POST['txtTabla']) && Validator::numero( $_POST['txtTabla'] ) ) ? trim( $_POST['txtTabla'] ) : "" ;

										$consulta .= "%' and id_tipo_acciones like '%";

										$consulta .= ( isset($_POST['txtAcciones']) && Validator::numero( $_POST['txtAcciones'] ) ) ? trim( $_POST['txtAcciones'] ) : "";

										$consulta .= "%'";
										//var_dump ( ( isset( $_POST['txtNombre'] ) && Validator::letras( $_POST['txtNombre'] ) ) ? $consulta : "");
										//Si se han ingresado ambas! fechas
										if ( $_POST['txtFecha'] != null  || $_POST['txtFecha2'] != null ){
											$consulta .= " and cast( fecha_ingreso as date ) between '";
	
											$consulta .= (isset ($_POST['txtFecha']) && Validator::fecha( $_POST['txtFecha'] ) ) ? trim($_POST['txtFecha']) : "";
	
											$consulta .= "' and '";
	
											$consulta .= (isset ($_POST['txtFecha2']) && Validator::fecha( $_POST['txtFecha2'] ) ) ? trim($_POST['txtFecha2']) : "";
	
											$consulta .= "'";
										}
									}
									else
									{
										$consulta = "SELECT * FROM bita";
									}
									$productos = ""; //Arreglo de datos
									//echo "<a>".$consulta."</a>";
									foreach( Database::getRows( $consulta, null ) as $datos){
										$productos .= "<tr>";
											$productos .= "<td>$datos[nombre_empleado]</td>";
											$productos .= "<td>$datos[tabla]</td>";
											$productos .= "<td>$datos[tipo_accion]</td>";
											$productos .= "<td>$datos[descripcion]</td>";
											$productos .= "<td>$datos[fecha_ingreso]</td>";
										$productos .= "</tr>";
									}
									print($productos);
								?>
								</tbody>
							</table>

<?php Page::footer(); ?>