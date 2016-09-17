<?php
require("../sql/conexion.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/database.php");
    require("../lib/page-privado.php");

ob_start();
$permisos = Page::header("Agregar empleado", "empleados" );
if(!empty($_POST)) 
{
	$action = $_POST['action'];
	try{
    //Campos del formulario.
    	  $tipo_usuario = $_POST['tipo_usuario'];
          $nombre_empleado = $_POST['nombre_empleado'];
          $apellido_empleado = $_POST['apellido_empleado'];
          $documento_empleado = $_POST['documento_empleado'];
          $correo_empleado = $_POST['correo_empleado'];
          $usuario_empleado = $_POST['usuario_empleado'];
          $id_pregunta = $_POST['id_pregunta'];
          $respuesta_empleado = $_POST['respuesta_empleado'];
          $imagen = $_FILES['archivo'];
          $fecha_nacimiento = $_POST['fecha_nacimiento'];



		if( $imagen['name'] != null )
		{

	        if($imagen['type'] == "image/jpeg" || $imagen['type'] == "image/png" || $imagen['type'] == "image/x-icon" || $imagen['type'] == "image/gif")
	        {
	          $info_imagen = getimagesize($imagen['tmp_name']);
	          $ancho_imagen = $info_imagen[0]; 
	          $alto_imagen = $info_imagen[1];
		        if ( $ancho_imagen >= 500 && $alto_imagen >= 500)
		        {
		            $nuevo_id = uniqid(); //Esto sirve para darle un nombre único a cada archivo de imagen.
		            $nombre_archivo = $imagen['tmp_name'];
		            $imagen_empleado = $nuevo_id.".png";
		            $destino = "../img/empleados/$imagen_empleado";
		            move_uploaded_file($nombre_archivo, $destino); //Función para subir archivos al servidor.
		            
		            //Validar campos :D
					     if (Validator::numero( $tipo_usuario ) && Validator::letras( $nombre_empleado )
					     && Validator::letras( $apellido_empleado ) && Validator::dui( $documento_empleado )
					     && Validator::correo($correo_empleado ) && Validator::numeros_letras( $usuario_empleado )
					     && Validator::letras( $respuesta_empleado ) && Validator::numero( $id_pregunta) 
					     && Validator::fecha( $fecha_nacimiento )
					     )
					    {
					    	if ( ( strtotime( date("Y-m-d") ) - strtotime($fecha_nacimiento) ) >= 568080000 ){//Mi forma :P if ( ( strtotime( date("Y-m-d H:i:s") ) - strtotime($fecha_nacimiento) ) >= 568080000 ){---resultado de php -568080000
						    	if ( $_POST['clave1'] != null || $_POST['clave2'] != null ){
				                    if ( Validator::numeros_letras( $_POST['clave1'] ) && Validator::numeros_letras( $_POST['clave2'] ) ){
				                      $clave1 = $_POST['clave1'];
				                      $clave2  = $_POST['clave2'];
				                        if($clave1==$clave2)
				                        {
									      	if (strlen($clave1) >= 8 ) {
									      		if ($clave2!=$usuario_empleado) {
									      			if ( ! Validator::permiso_agregar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
			    									else {
												         require("../sql/conexion.php");
												         $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
												         $clave_empleado = password_hash($clave2, PASSWORD_DEFAULT);
												         $respuesta_encriptado = password_hash($respuesta_empleado, PASSWORD_DEFAULT);
												         $sql = "INSERT INTO empleados(id_tipo_usuario, nombres_empleado, apellidos_empleado, n_documento, correo, usuario, clave, id_pregunta, respuesta, img_empleado, estado_sesion, fecha_registro, fecha_nacimiento) values(?,?,?,?,?,?,?,?,?,?,0, '" . date( "Y-m-d H:i:s" ) . "', ?)";
												         $stmt = $PDO->prepare($sql);
												         @$stmt->execute(array($tipo_usuario, $nombre_empleado, $apellido_empleado, $documento_empleado, $correo_empleado, $usuario_empleado, $clave_empleado, $id_pregunta, $respuesta_encriptado, $imagen_empleado, $fecha_nacimiento));
											         
												         $PDO = null;
												         Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 7 , 1, $sql ) );
												     	header("location: empleados");
												    }	
									         	}
	                            				else{
					                            $error_data = "La Contraseña no puede ser igual al nombre de usuario";
					                            }
	                          				}
				                            else{
				                            $error = "La longitud de la contraseña debe ser mayor a 8 caracteres.";
				                            }
				                        }
				                        else{
				                          $error = "Las contraseñas no coinciden.";
										}
										( ! ( Validator::numeros_letras( $clave1 ) ) ) ? $er_clave1 = "error_data" : "";
										( ! ( Validator::numeros_letras( $clave2 ) ) ) ? $er_clave2 = "error_data" : "";
	                       			}
	                   			}
	                   		}
	                   		else $error = "Debe ser mayor de edad (más de 18 años).";
                  		}
                
			    		
			    		else $error = "Error, por favor revise los campos señalados.";

				    	( ! ( Validator::numero( $id_pregunta ) ) ) ? $er_pregunta = "error_data" : "";
				    	
				    	( ! ( Validator::letras( $nombre_empleado ) ) ) ? $er_nombre = "error_data" : "";
				    	
				    	( ! ( Validator::letras( $apellido_empleado ) ) ) ? $er_apellido = "error_data" : "";

				    	( ! ( Validator::dui( $documento_empleado ) ) ) ? $er_dui = "error_data" : "";
				        
				        ( ! ( Validator::correo( $correo_empleado ) ) ) ? $er_correo = "error_data" : "";
				        
				        ( ! ( Validator::numeros_letras( $usuario_empleado ) ) ) ? $er_usuario = "error_data" : "";

				        ( ! ( Validator::letras( $respuesta_empleado ) ) ) ? $er_respuesta = "error_data" : "";
					    
					    ( ! ( Validator::numero( $tipo_usuario ) ) ) ? $ertipo_usuario = "error_data" : "";

					    ( ! ( Validator::fecha( $fecha_nacimiento ) ) ) ? $er_fecha = "error_data" : "";
					    

	      		}

	          else throw new Exception("La dimensión de la imagen no es valida.");
	        }
	        else throw new Exception("El tipo de imagen no es valido.");

    	}
    }	

	catch( Exception $Exception ) {
		if($Exception->getCode() == 23000)
		{
			if ( preg_match("/(usuario)+/", trim( $Exception->getMessage() ) ) ) $error = 'Usuario ingresado ya existente.';
			if ( preg_match("/(n_documento)+/", trim( $Exception->getMessage() ) ) ) $error = 'Documento ingresado ya existente.';
		}
		else
		{
			$error = $Exception->getMessage();
		}
	   			
     }
  }




	print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
	print ( ( isset($error) ) ? '<div class="alert alert-danger" role="alert">'.$error.'</div>' : "" );
?>     

							    <div class="col-sm-6 col-md-6 col-lg-6">

							     	<div class="form-group">
							        	<label for="">Nombres</label>
							        	<input  onpaste=";return false" type="text" id="nombre_empleado" name="nombre_empleado" required='required' class="form-control vletras_esp <?php print( ( isset($er_nombre) ) ? "$er_nombre": "");  ?>" maxlength="50" autocomplete="off"  
                                		value='<?php print(!empty($nombre_empleado)?$nombre_empleado:""); ?>'>
                                		<?php print(!empty($nombre_empleadoError)?"<span class='help-block'>$nombre_empleadoError</span>":""); ?>
							      	</div>

							      	<div class="form-group">
							        	<label for="">Apellidos</label>
							        	 <input onpaste=";return false" type="nombre" id="apellido_empleado" name="apellido_empleado" required='required'  class="form-control vletras_esp <?php print( ( isset($er_apellido) ) ? "$er_apellido": "");  ?>"  maxlength="100" autocomplete="off"  
                               			 value='<?php print(!empty($apellido_empleado)?$apellido_empleado:""); ?>'>
                                		<?php print(!empty($apellido_empleadoError)?"<span class='help-block'>$apellido_empleadoError</span>":""); ?>
							      	</div>

							     	<div class="form-group">
								        <label for="id_pregunta">Pregunta</label>
								        <select id="id_pregunta" name="id_pregunta"  class="form-control select2 <?php print( ( isset($er_pregunta) ) ? "$er_pregunta": ""); ?>">
								          	<option value="" disabled selected>Seleccione pregunta</option>
								            <?php
								              require("../sql/conexion.php");
								              $sql="SELECT id_pregunta, pregunta FROM preguntas";
				                                foreach ($PDO->query($sql) as $row) {
				                                    echo "<option value ='$row[id_pregunta]'";
				                                    if (isset($id_pregunta) && $id_pregunta == $row["id_pregunta"])
				                                    {
				                                        echo " selected";
				                                    }
				                                    echo ">";
				                                    echo $row["pregunta"];
				                                    echo "</option>";
				                                }
								             
								              $PDO = null;
								            ?>
								        </select>
								    </div>
								    <div class="form-group">
								        <label for="tipo_usuario">Tipo de usuario</label>
								        
								        <select required id="tipo_usuario" name="tipo_usuario" class="form-control <?php print( ( isset($ertipo_usuario) ) ? "$ertipo_usuario": ""); ?>">
								          	<option value="" disabled selected>Seleccione tipo de usuario</option>
								            <?php
								              require("../sql/conexion.php");
								              $sql="SELECT id_tipo_usuario, tipo_usuario FROM tipos_usuarios";
				                                foreach ($PDO->query($sql) as $row) {
				                                    echo "<option value ='$row[id_tipo_usuario]'";
				                                    if (isset($tipo_usuario) && $tipo_usuario == $row["id_tipo_usuario"])
				                                    {
				                                        echo " selected";
				                                    }
				                                    echo ">";
				                                    echo $row["tipo_usuario"];
				                                    echo "</option>";
				                                }
								              
								              $PDO = null;
								            ?>
								        </select>
								    </div>
							      	<div class="form-group">
			                       		<label for="Nombre">Respuesta</label>
				                        <input  onpaste=";return false" type="password" id="respuesta_empleado" name="respuesta_empleado" required='required' class="form-control vletras_esp <?php print( ( isset($er_respuesta) ) ? "$er_respuesta": ""); ?>" maxlength="100" autocomplete="off"  
				                                value='<?php print(!empty($respuesta_empleado)?$respuesta_empleado:""); ?>'>
				                                <?php print(!empty($respuesta_empleadoError)?"<span class='help-block'>$respuesta_empleadoError</span>":""); ?>
			                        </div>
							      	<div class="form-group">
				                        <label  for="Nombre">Numero de Documento</label>
				                        <input  onpaste=";return false" type="nombre" id="documento_empleado" name="documento_empleado" required='required'  class="form-control vnumeros <?php print( ( isset($er_dui) ) ? "$er_dui": ""); ?>" minlength="9" maxlength="9" autocomplete="off"  
				                                value='<?php print(!empty($documento_empleado)?$documento_empleado:""); ?>'>
				                                <?php print(!empty($documento_empleadoError)?"<span class='help-block'>$documento_empleadoError</span>":""); ?>
                      				</div>
                      				<div class="form-group">
				                        <label for="Nombre">Correo</label>
				                        <input  onpaste=";return false" type="" id="correo_empleado" name="correo_empleado" required='required' class="form-control <?php print( ( isset($er_correo) ) ? "$er_correo": ""); ?>" maxlength="60" autocomplete="off"  
				                                value='<?php print(!empty($correo_empleado)?$correo_empleado:""); ?>'>
				                                <?php print(!empty($documento_empleadoError)?"<span class='help-block'>$correo_empleadoError</span>":""); ?>
				                    </div>
				                    <div class="form-group">
				                        <label for="Nombre">Usuario</label>
				                        <input  onpaste=";return false" type="nombre" id="usuario_empleado" name="usuario_empleado" required='required'  class="form-control <?php print( ( isset($er_usuario) ) ? "$er_usuario": ""); ?> " maxlength="50" autocomplete="off"  
				                                value='<?php print(!empty($usuario_empleado)?$usuario_empleado:""); ?>'>
				                                <?php print(!empty($usuario_empleadoError)?"<span class='help-block'>$usuario_empleadoError</span>":""); ?>
				                      </div>
				                    
							    </div>
							    <div class="col-sm-6 col-md-6 col-lg-6">
							        <div class="form-group">
							        	<label for="archivo">Imagen principal</label>
								        <img src="../img/logo.png" class="img-responsive" id="pro_img"/>
								        <BR>
						          		<input name="archivo" type="file" required  id="pro_img_url"/>
						          	</div>
						          	
						          	<br><br>
				                    <div class="row">
			                          <div class="col-xs-12 col-sm-6 col-md-6">
			                            <div class="form-group">
			                            <label for="archivo">Contraseña</label>
			                              <input autocomplete="off" onpaste=";return false" type="password" name="clave1" id="clave1"  placeholder="Contraseña" tabindex="5"
			                              class="form-control input-lg <?php print( ( isset($er_clave1) ) ? "$er_clave1": "");  ?>" value='<?php print(!empty($clave1)?$clave1:""); ?>'>
			                              <?php print(!empty($clave1_empleadoError)?"<span class='help-block'>$clave1_empleadoError</span>":""); ?> 
			                            </div>
			                          </div>

			                          <div class="col-xs-12 col-sm-6 col-md-6">
			                            <div class="form-group">
				                            <label for="archivo">Confirmar contraseña</label>
				                              	<input autocomplete="off" onpaste=";return false" type="password" name="clave2" id="clave2"  placeholder="Confirma tu contraseña" tabindex="6"
					                            class="form-control input-lg <?php print( ( isset($er_clave2) ) ? "$er_clave2": "");  ?>" value='<?php print(!empty($clave2)?$clave2:""); ?>'>
					                            <?php print(!empty($clave2_empleadoError)?"<span class='help-block'>$clave2_empleadoError</span>":""); ?> 
			                            </div>
			                          </div>
			                          <div class="col-xs-12 col-sm-6 col-md-6">
			                            <div class="form-group">
				                            <label for="archivo">Fecha de nacimiento</label>
				                              	<input autocomplete="off" onpaste=";return false" type="text" name="fecha_nacimiento" id="datetimepicker"  placeholder="Año-Mes-Día" tabindex="7"
					                            class="form-control input-lg <?php print( ( isset($er_fecha) ) ? "$er_fecha": "");  ?>" value='<?php print(!empty($fecha_nacimiento)?$fecha_nacimiento:""); ?>'>
					                            <?php print(!empty($fecha_empleadoError)?"<span class='help-block'>$fecha_empleadoError</span>":""); ?> 
			                            </div>
			                          </div>
			                         
			                        </div>

			                        
						        	
							    </div>
							</div>
							<div class="box-body text-center">
							    <button type="submit" name="action" class="btn btn-primary btncolor margin_right fbtn">
							        <span class="glyphicon glyphicon-plus"></span>
							    </button>
							    <button type="button" class="btn btn-danger fbtn">
							        <span class="">Cancelar</span>
							    </button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section><!--Conent ='DD-->
	</div><!--ConentWrapper ='DD-->
</div><!--Wrapper ='DD-->

<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>

<script src="../publico/js/bootstrap.min.js"></script>

<script src="dist/js/app.min.js"></script>

<script src="../publico/js/mainB.js"></script>

</body>
</html>