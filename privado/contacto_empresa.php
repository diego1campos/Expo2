<?php
  //Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
  ob_start();
  //Se establece todas las clases o funciones necesarias ='D'
  require("../lib/database.php");
  require("../lib/validator.php");
  //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
  require("../lib/page-privado.php");

  $permisos = Page::header("Contactos de empresa", "contactos_empresa");

  if(!empty($_POST)){
    $action = $_POST['action'];
    if ( $action != "Buscar" ){
    	$contacto_empresa = $_POST['txtcontacto_empresa'];
    	@$id_tipo_contacto = $_POST['id_tipo_contacto'];
	    require("../sql/conexion.php");
	    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	   	//Validar
	   	try{
		   	if ( Validator::numeros_letras($contacto_empresa) && Validator::numero($id_tipo_contacto) )
		   	{
			    if ( $action == "Agregar" ){
			    	if ( ! Validator::permiso_agregar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
		    		else {
				        $sql = "INSERT INTO contactos_empresa(id_tipo_contacto, contacto_empresa) values(?,?)";            
				        $stmt = $PDO->prepare($sql);
				        @$exito = $stmt->execute(array ( $id_tipo_contacto, $contacto_empresa ) );
				        $PDO = null;
				        Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 3 , 1, $sql ) );
	   				}
			    }
			    else if ( $action == "Editar" ){
			    	$id_contacto_empresa = $_POST['id_contacto_empresa'];
			    	if ( Validator::numero( $id_contacto_empresa ) ){
			    		if ( ! Validator::permiso_modificar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
		    			else {
					        $sql = "update contactos_empresa set id_tipo_contacto=?, contacto_empresa=? where contactos_empresa.id_contacto_empresa=?";
					        $stmt = $PDO->prepare($sql);
					        @$exito = $stmt->execute(array ( $id_tipo_contacto, $contacto_empresa, $id_contacto_empresa ) );
					        $PDO = null;
					        Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 3 , 1, $sql ) );
	   					}
				    }
			    	else $error = "Id no valido.";
			    }
			}
			else $error_data = "Error, por favor revise los campos señalados.";
			( ! ( Validator::numeros_letras( $contacto_empresa ) ) ) ? $er_categoria = "error_data" : "";
		}
		
		catch( Exception $Exception ) 
		{
			if($Exception->getCode() == 23000)
			{
				$error = "Dato duplicado";
			}
			else
			{
				$error = $Exception->getMessage();
			}
		}	
	}
}

	$palabra = '';
	if ( isset($action) && $action == "Agregar" ) $palabra = "añadida";
	else $palabra = "editada";
	print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Pregunta '.$palabra.' con exito.</div>' : "" );
	print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
	print ( ( isset($error) ) ? '<div class="alert alert-danger" role="alert">'.$error.'</div>' : "" );
?> 
		            			<div class="col-sm-4 col-md-4 col-lg-4 no_padding">
									<div class="col-sm-12 col-md-12 col-lg-12">
										<label class="">Contacto</label>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
										<input type="hidden" name="id_contacto_empresa" id="id_contacto_empresa" />
										<input class="form-control <?php print( ( isset($er_categoria) ) ? "$er_categoria": ""); ?>" id="txtcontacto_empresa" type="text" class="validate" name="txtcontacto_empresa" placeholder="Ingrese aquí..."/>
									</div>
									<br>
									<br>
									<br>
									<br>
									<div class="col-sm-12 col-md-12 col-lg-12">
											
									        <select id="id_tipo_contacto" name="id_tipo_contacto"  class="form-control <?php print( ( isset($er_presentacion) ) ? "$er_presentacion": ""); ?>">
								          	<option value="" disabled selected>Seleccione tipo de contacto</option>
								            <?php
								              require("../sql/conexion.php");
								              $consulta="SELECT id_tipo_contacto, tipo_contacto FROM tipos_contactos";
				                                foreach ($PDO->query($consulta) as $row) {
				                                    echo "<option value ='$row[id_tipo_contacto]'";
				                                    if (isset($tipo_contacto) && $tipo_contacto == $row["id_tipo_contacto"])
				                                    {
				                                        echo " selected";
				                                    }
				                                    echo ">";
				                                    echo $row["tipo_contacto"];
				                                    echo "</option>";
				                                }
								             
								              $PDO = null;
								            ?>
								        </select>
										</div>
								</div>
								<br>
									
									<br>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button id="btn_contactoE" type="submit" name="action" value="Agregar" class="btn btn-primary size">
									        <span class="glyphicon glyphicon-plus"></span>
									    </button>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-6">
										<br>
										<button id="btn-c_ContactoE" type="button" class="btn btn-danger size">
									        <span class="glyphicon glyphicon-remove"></span>
									    </button>
									    <br>
									    <br>
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
										<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe el contacto de la empresa..."/>
									</div>
								</div>
							</div>
							<div class="box-body table-responsive">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table table-bordered table-hover conf_tabla">
									    <thead>
									        <tr>
									            <th class="col-sm-4 col-md-4 col-lg-4">Contacto</th>
									            <th class="col-sm-4 col-md-4 col-lg-4">Tipo Contacto</th>
									            <th class="col-sm-4 col-md-4 col-lg-4">Acciones</th>
									        </tr>
									    </thead>
									    <tbody>
										<?php
											require("../sql/conexion.php");
											$consulta = "SELECT id_contacto_empresa, contacto_empresa, tipo_contacto FROM contactos_empresa, tipos_contactos where tipos_contactos.id_tipo_contacto = contactos_empresa.id_tipo_contacto ";
											if( isset( $_POST['txtBuscar'] ) != "" && Validator::numeros_letras( $_POST['txtBuscar'] ) ){
							    				$busqueda = $_POST['txtBuscar'];
							    				$consulta = $consulta . "AND (contacto_empresa LIKE '%$busqueda%' or tipo_contacto like '%$busqueda%') order by contacto_empresa ASC";
							    			}
							    			else $consulta = $consulta . "order by contacto_empresa ASC";
											$productos = ""; //Arreglo de datos
											foreach($PDO->query($consulta) as $datos){
												$productos .= "<tr>";
													$productos .= "<td class='contacto_empresa'>$datos[contacto_empresa]</td>";
													$productos .= "<td class='tipo_contacto'>$datos[tipo_contacto]</td>";
													$productos .= '<td class="text-center"><a id_contacto_empresa="'.$datos['id_contacto_empresa'].'" class="glyphicon glyphicon-edit padding_right_ico icono_tamano up" onclick="$(this).e_Contactoe();"></a><a href="eliminar_contactoE?id='.$datos['id_contacto_empresa'].'" class="glyphicon glyphicon-remove-circle icono_tamano"></a></td>';
												$productos .= "</tr>";
											}
											print($productos);
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