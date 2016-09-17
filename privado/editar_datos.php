<?php
ob_start();
//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	require("../lib/validator.php");
	//!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
	require("../lib/page-privado.php");
	//Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    	$permisos = Page::header("Datos", "datos");
    if(!empty($_POST))
    {
    	try
    	{
	 
	        //Post values
	        $mision = $_POST['txtmision'];
	        $vision = $_POST['txtvision'];
	        $historia = $_POST['txthistoria'];
	
	        require("../sql/conexion.php");
	        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        if ( Validator::datos_mvh( $mision ) && Validator::datos_mvh( $vision ) && Validator::datos_mvh($historia))
	        {
	        	if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
	        	else
	        	{
		        $sql = "UPDATE datos SET mision = ?, vision = ?, historia = ? WHERE id_dato = ?";
		        $stmt = $PDO->prepare($sql);
		       $exito= $stmt->execute(array($mision, $vision,$historia,1));
		       //Ejecutar procedimiento para bitacora ='}'
		        $con_bi = "call inserta_bitacora( ?, ?, ?, ? );";
		    	$exito = Database::executeRow( $con_bi , array ( $_SESSION['id_empleado'], 4 , 2, $sql ) );
		        $PDO = null;
		        unset( $_POST );
	        }
	        }
	        else $error_data = "Error, por favor revise los campos señalados.";
				( ! ( Validator::datos_mvh( $mision ) ) ) ? $error[] = "Misión: solo se permiten numeros, letras y ciertos caracteres especiales(.,:;\"-)." : "";
				( ! ( Validator::datos_mvh( $vision ) ) ) ? $error[] = "Visión: solo se permiten numeros, letras y ciertos caracteres especiales (.,:;\"-)." : "";
				( ! ( Validator::datos_mvh( $historia ) ) ) ? $error[] = "Historia: solo se permiten numeros, letras y ciertos caracteres especiales (.,:;\"-)" : "";
	    
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
	             $misionA = $data['mision'];
	        	$visionA = $data['vision'];
	        	$historiaA = $data['historia'];
	    }
    $palabra = '';
	if ( isset($action) && $action == "Agregar" ) $palabra = "añadidos";
	else $palabra = "editados";
	print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Datos '.$palabra.' con exito.</div>' : "" );
	print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
	if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
?>



		            		<div class="box-body">
		            	
		            			 <div class="col-lg-12 datosM">
										<div class="col-sm-12 col-md-12 col-lg-1 col-lg-offset-0 ">
											<label class="datos">Misión:</label>
										</div>
										<div class="col-sm-12 col-md-9 col-lg-5  " >
											<textarea class="form-control col-lg-1 " rows="4" id="txtdescripcion" name="txtmision" placeholder="Ingrese la descripcion del dato..." required><?php print( ( isset($misionA) ) ? "$misionA": ""); ?></textarea>
										</div>

										<div class="col-sm-12 col-md-12 col-lg-1 col-lg-offset-0 ">
											<label class="datos margenRR">Visión:</label>
										</div>
										<div class="col-sm-12 col-md-9 col-lg-5  " >
											<textarea class="form-control col-lg-1" rows="4" id="txtdescripcion" name="txtvision" placeholder="Ingrese la descripcion del dato..." required> <?php print( ( isset($visionA) ) ? "$visionA": ""); ?></textarea>
										</div>

										<div class="col-sm-12 col-md-12 col-lg-1 col-lg-offset-0 datosM">
											<label class="datos">Historia:</label>
										</div>
										<div class="col-sm-12 col-md-9 col-lg-5  datosM" >
											<textarea class="form-control " rows="4" id="txtdescripcion" name="txthistoria" placeholder="Ingrese la descripcion del dato..." required><?php print( ( isset($historiaA) ) ? "$historiaA": ""); ?></textarea>
										</div>
									</div>
								

								<div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-3 col-md-offset-3 col-lg-3 col-lg-offset-8"><br>
									<button type="submit" id="btn_datos" name="action" value="Editar" class="btn btn-primary size">
								        <span class="glyphicon glyphicon-edit"></span>
								    </button>
								</div>

							</div>
						
</div><!--Wrapper ='DD-->

<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>

<script src="../publico/js/bootstrap.min.js"></script>

<script src="dist/js/app.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.js"></script>

<script src="plugins/datatables/dataTables.bootstrap.js"></script>

<script src="../publico/js/mainB.js"></script>

</body>
</html>