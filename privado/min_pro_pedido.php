<?php
ob_start();
//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	require("../lib/validator.php");
	//!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
	require("../lib/page-privado.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  	$permisos = Page::header("Minimo producto", "datos");
  if(!empty($_POST)){
  	try{
	    $action = $_POST['action'];
	    if ( $action != "Buscar" ){
	    	$max_dias = $_POST['txtpro_min'];
	    	
		    require("../sql/conexion.php");
		    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		   	//Validar
		   	//require("../lib/validator.php");
		   	if (Validator::numero( $max_dias ) ){
			  
			  	if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
			  	else
			  	{
			  	
				        $sql = "UPDATE datos set min_pro_pedido=? where id_dato=?";
				        $stmt = $PDO->prepare($sql);
				        $exito = $stmt->execute(array ( $max_dias,1 ) );
				       //Ejecutar procedimiento para bitacora ='}'
					            $con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
					        	$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 1 , 2, $sql ) );
				        $PDO = null;
				   
			    }
		   	}
		
			else $error_data = "Error, por favor revise los campos señalados.";
			( ! ( Validator::numero( $max_dias ) ) ) ? $error[] = "Maximo dia: Solo se permite numeros" : "";
			}	
		}
	
	catch( Exception $Exception ){
		$error[] = $Exception->getMessage();
	}
  }
  	 if ( empty($_POST) )
	    {
	            require("../sql/conexion.php");
	            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	            $sql = "SELECT * FROM datos";
	            $stmt = $PDO->prepare($sql);
	            $stmt->execute();
	            $data = $stmt->fetch(PDO::FETCH_ASSOC);
	            $PDO = null;
	        	$max_dia = $data['min_pro_pedido'];
	      
	        
	    }
   $palabra = '';
	if ( isset($action) && $action == "Agregar" ) $palabra = "editado";
	else $palabra = "editados";
	print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Minimo producto '.$palabra.' con exito.</div>' : "" );
	print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
	if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
?>

	
		            			
	            			 	<div class="col-xs-3 col-sm-4 col-md-2 col-lg-2">
                                    <img src="../img/productos/logo.png" alt="" class="imagen_red img-responsive">
                                </div>
		            			<div class="col-xs-7 col-sm-6 col-sm-offset-0 col-md-7 col-lg-6  no_padding margenredes">
									<div class="col-xs-3 col-sm-2 col-md-offset-1 col-md-3 col-lg-3 col-lg-offset-0 ">
										<label class="">Minimo producto:</label>
									</div>
									<div class="col-xs-7 col-sm-9 col-sm-offset-2 col-md-9	col-md-offset-0 col-lg-9 agregarred" >
										<input type="hidden" name="id_categoria"/>
										
										<input class="form-control " id="txtpro_min" type="text" class="validate" name="txtpro_min" value="<?php print( ( isset($max_dia) ) ? "$max_dia": ""); ?>"></input>
									</div>
								</div>

								<div class="col-xs-3 col-sm-3 col-sm-offset-0 col-md-4 col-lg-4 botones">
									<div class="col-xs-6 col-sm-6 col-md-5 col-md-offset-0 col-lg-6">
										<br>
										<button id="btn_pro_min"type="submit" name="action" value="Agregar" class="btn btn-primary size col-xs-12 col-sm-10 col-sm-offset-0 col-md-12 col-lg-12 col-lg-offset-0">
									        <span class="glyphicon glyphicon-edit"></span>
									    </button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-5 col-lg-6">
										<br>
										<button id="btncancelarPM"name="action" value="cancelar" class="btn btn-danger size col-xs-12 col-sm-12 col-sm-offset-0 col-md-12 col-lg-12">
									        <span class="glyphicon glyphicon-ban-circle"></span>
									    </button>
									    <br>
									    <br>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
				<div class="row">
	    		<div class="col-xs-12 col-xs-offset-0 col-md-12 col-md-offset-0 col-lg-0 col-lg-offset-0">
	        		<div class="box">
	        			<div class="box-body">
	        				<br>
							<div class="col-sm-8 col-md-8 col-lg-8">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
									<input class="form-control" id="txtbuscar_red" type="text" class="validate" name="txtBuscar_productos" placeholder="Escribe la red social..."/>

								</div>
							</div>
						</div>
						<!--consulta de redes-->
						<div class="box-body table-responsive">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<table class="table table-bordered table-hover conf_tabla">
								    <thead>
								        <tr>
								            <th class="col-sm-3 col-md-3 col-lg-3">Minimo producto</th>
								            
								        </tr>
								    </thead>
								    <?php
									    require("../sql/conexion.php");
										$consulta = "SELECT * from datos";      
										$tabla="";
										foreach ($PDO->query($consulta) as $datos) 
										{

									    $tabla.= "<tbody id='lista_productos'>";
									    $tabla.= "<tr>";
									    $tabla.="<div class='col-sm-12 col-md-12 col-lg-12 col-lg-offset-2'>";
									    //$tabla.="<input type='hidden' name='imagen_antigua' id='imagen_antigua' />";
									    $tabla.="</div>";
									    $tabla.="<td><div class='pro_min'>$datos[min_pro_pedido]</div></td>";
									    $tabla.="<td> ";
									    $tabla.="<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-offset-1'>";
									    $tabla.="<div class='col-xs-6 col-sm-4 col-md-5 col-lg-5>'";
								
										$tabla.="</div>";
										$tabla.="<div class='col-xs-6 col-sm-4 col-sm-offset-3 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-1'>";
	  									$tabla.="</div>";
	  									$tabla.="</div>'";
	  									$tabla.="</td>";
									    $tabla.="</tr>";
										}
										print($tabla);
    									$PDO = null;
									?>
									</tbody>
								</table>
							</div>
						</div>
	        		</div>
	        	</div>
	        </div>
		</section><!--Conent ='DD-->


<?php Page::footer(); ?>


</body>
</html>