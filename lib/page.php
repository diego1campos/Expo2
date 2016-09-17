<?php

class Page
{
	public static function header($title){
		/*ANTES ESTABA FUERA DE AQUI :)*/
		
		session_start();

		//funcion iniciar sesion
		function iniciar_sesion( $data ){
			//$click_login = "Hola";
			/*tiempo sesion---Guardamos la fecha y hora actual en la variable de sesion :D*/
			$_SESSION["ultimoAcceso_mc"] = date("Y-m-d H:i:s");
		   	/*tiempo sesion*/
		    $_SESSION['id_cliente'] = $data['id_cliente'];
		    $_SESSION['nombre_cliente'] = $data['nombres_cliente']." ".$data['apellidos_cliente'];
		    $_SESSION['img_cliente'] = $data['img_cliente'];
		    //Actualizo el campo de estado_sesion a la variable id de la sesion por que va a iniciar sesion
		    $exito = Database::executeRow( 'update clientes set estado_sesion=? where id_cliente = ?;', array( session_id(), $_SESSION['id_cliente'] ) );
		    //header("location: indexx.php");
		    unset( $_POST );//Elimino los datos que se utilizaron para inciar sesion :D
		}
		//funcion iniciar sesion

		//Cerrar sesion
		function cerrar_sesion( $destruir_sesion ){
			//Vuelvo el estado de la sesion a 0 solo cuando cierra sesion... por que me interesa tambien SOLO eliminar todo con la sesion :D}
			if ( ! isset( $destruir_sesion ) ) $exito = Database::executeRow( 'update clientes set estado_sesion = ? where id_cliente = ?;', array( 0, $_SESSION['id_cliente'] ) );
			if ( ( isset( $exito ) && $exito == 1 ) || isset( $destruir_sesion ) ){
				session_destroy();
				unset( $_SESSION );
				unset( $_POST );
				header( "location: index" );
				//print(( "location: " . session_id() . ".php" ));
				exit();
			}
		}
		//Cerrar sesion

		/*Tiempo de sesion*/
		if ( isset( $_SESSION["ultimoAcceso_mc"] ) ) {
			$hora =  $_SESSION["ultimoAcceso_mc"];
		   	$ahora = date("Y-m-d H:i:s");//Obtenemos la fecha y hora actual en el servidor
		    $tiempo_transcurrido = ( strtotime($ahora) - strtotime($hora) );		    
		    //comparamos el tiempo transcurrido
		 	//900segundos = 15 min
		    if ( $tiempo_transcurrido >= 600 ) cerrar_sesion();
		   	else $_SESSION["ultimoAcceso_mc"] = $ahora;
		}
	   /*Tiempo de sesion*/

		//Si seleccionoo "no" a restaurar contraseña, Lo mando a iniciar sesion tranquilo jaja xd :D
		if ( isset( $_POST['no'] ) ){
			$data = Database::getRow( "SELECT * FROM clientes WHERE usuario=?", array( $_SESSION['usuario'] ) );
			iniciar_sesion( $data );
		}

		//Si selecciono restaurar la contra
		if ( isset( $_POST['restaurar'] ) ){
			$_SESSION['restaurar'] = 'si';
			header( "location: recuperarc" );
			exit();
		}

		if( !empty($_POST) ){
		    if ( isset($_POST['usuario']) ) $alias = $_POST['usuario'];
		    if ( isset($_POST['clave']) ) $clave = $_POST['clave'];
		    if ( isset($_POST['clave']) && isset($_POST['usuario']) && $alias != "" && $clave != "" && Validator::letras($alias) && Validator::numeros_letras($clave) ){
		        try{
		            $data = Database::getRow( "SELECT * FROM clientes WHERE usuario=?", array($alias) );
		            if( $data != null ){
		                $hash = $data['clave'];
		                if ( password_verify( $clave, $hash) ) {
		                //if ( $clave == $hash ){
		                	if( $data['estado_sesion'] == '0' ||  $data['estado_sesion'] == session_id() ) iniciar_sesion( $data );
		                	else{
		                      if ( Validator::numeros_letras($_POST['usuario']) ) $_SESSION['usuario'] = $_POST['usuario'];
		                      else $error = "Usuario ingresado invalido.";
		                      $sesion_ini = "si";//Si ya hay una sesion establecida
		                    }
		                }
		                else $error = "La contraseña es incorrecta.";                
		            }
		            else $error = "Usuario no encontrado.";
		            print ( ( isset($error) ) ? '<input class="alert alert-danger" type="hidden" login="'.$error.'">' : "" );
		        }
		        catch( Exception $Exception ){
		            $error = $Exception->getMessage();
		        }
		    }
		}
		//if( ! isset($click_login) ) session_start();

		if ( isset( $_POST['crs'] ) ) cerrar_sesion();
		
		/*ANTES ESTABA FUERA DE LA CLASE Y TODO :)*/
		
		
		if( isset( $_SESSION['nombre_cliente'] ) ){//Si ha iniciado sesion, pero la sesion ya fue sobreescribida =}
			$session_current_id = Database::getRow( "select estado_sesion from clientes where id_cliente = ?;", array( $_SESSION['id_cliente'] ) );
			if ( $session_current_id['estado_sesion'] != session_id() ) cerrar_sesion( true );
		}
		/*paginas prohibidas sin haber iniciado sesion :)*/
		else if( ! isset( $_SESSION['nombre_cliente'] ) && $title == "Articulo" ){
			header( "location: catalogo?error=" . base64_encode(1) );
			exit();
		}
		else if( ! isset( $_SESSION['nombre_cliente'] ) && $title != 'Preguntas Frecuentes' && $title != 'Terminos y condiciones' && $title != 'Recuperar contraseña' && $title != "Catalogo" && $title != "Inicio" && $title != "Isadeli" && $title != 'Registrar' && $title != "Error 404" && $title != "Error 403" && $title != "Preguntas frecuentes" && $title != "Terminos y condiciones" && $title != "Historia" ){//Si no ha iniciado sesion =}
			header( "location: index" );
			exit();
		}
		/*paginas prohibidas sin haber iniciado sesion :)*/
		ini_set("date.timezone","America/El_Salvador");
		$filename = basename( $_SERVER['PHP_SELF'] );
		$header = '<!--DOCTYPE html-->
					<html lang="es">
					<head>
						<meta charset="utf-8">
						<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
						<title>'.$title.'</title>

						<link rel="stylesheet" type="text/css" href="' . ( ( $title == "Error 404" || $title == "Error 403" ) ? '../publico/' : "" ) . 'css/bootstrap.min.css" />
						<link rel="stylesheet" type="text/css" href="' . ( ( $title == "Error 404" || $title == "Error 403" ) ? '../publico/' : "" ) . 'css/mainD-info.css" />
						<link rel="stylesheet" type="text/css" href="' . ( ( $title == "Error 404" || $title == "Error 403" ) ? '../publico/' : "" ) . 'css/font-awesome.min.css"><!-- Font Awesome -->
						<!--link rel="stylesheet" type="text/css" href="' . ( ( $title == "Error 404" || $title == "Error 403" ) ? '../publico/' : "" ) . 'css/icomoon.css"-->
						<link rel="stylesheet" type="text/css" href="' . ( ( $title == "Error 404" || $title == "Error 403" ) ? '../publico/' : "" ) . 'css/modal.css" />
				        <link rel="stylesheet" type="text/css" href="' . ( ( $title == "Error 404" || $title == "Error 403" ) ? '../publico/' : "" ) . 'css/esmenu.css">
						<link rel="stylesheet" type="text/css" href="../privado/dist/css/AdminLTE.min.css"><!--Para incluir el menu desplegable de cerrar cesion-->
						<link rel="stylesheet" type="text/css" href="' . ( ( $title == "Error 404" || $title == "Error 403" ) ? '../publico/' : "" ) . 'css/mainD.css" /><!--Lo baje estaba despues de icomoon-->
						<link rel="stylesheet" type="text/css" href="' . ( ( $title == "Error 404" || $title == "Error 403" ) ? '../publico/' : "" ) . 'css/sweet-alert.css"><!--Para incluir el menu desplegable de cerrar cesion--><!--Lo ocupo por que en algunas ocaciones ocupo ajax-->
						<link rel="stylesheet" type="text/css" href="../privado/plugins/datepicker/datepicker3.css">
						<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">';
			$header .=  ( $title == 'Articulo' ) ? '<link rel="stylesheet" type="text/css" href="css/star-rating.min.css" media="all" /><!-- Calificacion -->' : '';
			/*css solo del index :)*/
			$header .=  ( $title == 'Inicio' ) ? '<link rel="stylesheet" type="text/css" href="css/esmenu.css" media="all" />' : '';
			//$header .=  ( $title == 'Inicio' ) ? '<link rel="stylesheet" type="text/css" href="css/main.css" media="all" />' : '';
			$header .=  ( $title == 'Inicio' ) ? '<link rel="stylesheet" type="text/css" href="css/animations.css" media="all" />' : '';
			/*css solo del index :)*/
			/*css solo del Historia :)*/
			$header .=  ( $title == 'Historia' ) ? '<link rel="stylesheet" type="text/css" href="css/jquery.fullPage.css" />' : '';
			$header .=  ( $title == 'Historia' ) ? '<link rel="stylesheet" href="css/mainL.css" rel="stylesheet" />' : '';
			
			/*css solo del Historia :)*/
		$header .=	'</head>
					<body class="back-body">
						<div class="navbar-wrapper">
						    <div class="container-fluid">
						        <nav class="navbar navbar-fixed-top ancho" role="navigation">
						            <div class="container">               
						                <div class="navbar-header">
						                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						                    <span class="sr-only">Toggle navigation</span>
						                    <span class="icon-bar"></span>
						                    <span class="icon-bar"></span>
						                    <span class="icon-bar"></span>
						                    </button>
						                    <a class="navbar-brand isadeli" href="index">ISADELI</a> 
						                </div>

						                <!--Elementos del menú-->

						                <div id="navbar" class="navbar-collapse collapse">
						                    <ul class="nav navbar-nav">

						                        <!--Catalogo-->

						                        <li class=" dropdown p">
						                            <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="material-icons">shopping_cart</i>Catalogo <span class="caret"></span></a>
						                            <ul class="dropdown-menu ">
									                    <li><a href="catalogo" class="">Catalogo</a></li>';//para que tambien pueda seleccionarlo sin filtrar xd
									                        $consulta = "SELECT * from categorias";
									                        $data = Database::getRows( $consulta, null );
									                        foreach($data as $datos){
									                        	$header .= "<li><a href='catalogo?id=" . base64_encode( $datos['id_categoria'] ) . "'>$datos[categoria]</a></li>";
									                        }
						                            $header .= '
						                            </ul>
						                        </li>


						                        <li><a href="#"><i class="material-icons">https</i> ¿Quienes somos?</a></li>';


						                        	if ( isset( $_SESSION['nombre_cliente'] ) ){
									               $cerrar_cesion = '<li class=" dropdown">
											                            <a href="compras">Carrito</a>
											                        </li>
											                        <li class=" dropdown">
											                            <a href="compras_realizadas">Compras</a>
											                        </li>
									                				<li class="dropdown user user-menu">
															            <!-- Menu Toggle Button -->
															            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
															              <!-- The user image in the navbar-->
															              <img src="../img/clientes/' . $_SESSION['img_cliente'] . '" class="user-image" alt="User Image">
															              <!-- hidden-xs hides the username on small devices so only the image appears. -->
															              <span class=""><!--hidden-xs-->
															              	 '.$_SESSION['nombre_cliente'].'
															              </span>
															            </a>
															            <ul class="dropdown-menu" id="listmenu_limpiar">
															              <li class="listmenu_limpiar_xs"><a href="registrar_clientes">Perfil</a></li>
						                                				  <li class="listmenu_limpiar_xs">
																		  	<a href="#" id="a_cerrar_sesion">
																		  		Cerrar Sesión
						                                				  		<form id="frmlogin" method="post"><input type="hidden" name="crs" value="crs"></input></form>
						                                				  	</a>
						                                				  </li>
															              <!-- The user image in the menu -->
															              <li class="user-header">
															                <img src="../img/clientes/' . $_SESSION['img_cliente'] . '" class="img-circle" alt="User Image">

															                <p>
															                  '.$_SESSION['nombre_cliente'].'

															                  <!--Base ? Fecha de ingreso del empleado-->
															                  <!--small>Miembro desde Nov. 2012</small-->
															                </p>
															              </li>

															              <!-- Menu Footer-->
															              <li class="user-footer">
															                <div class="pull-left">
															                  <a href="registrar_clientes" class="btn btn-default btn-flat black_ground">Perfil</a>
															                </div>
															                <div class="pull-right">
															                <form method="post">
															                	<button class="nobtn-cerrar_s" type="submit" name="crs" value="crs">
															                		<a class="btn btn-default btn-flat black_ground">Cerrar Sesión</a>
														                  		</button>
													                  		</form>
															                </div>
															              </li>
															            </ul>
															          </li>
															    </ul>
															<!--/ul-->';
													$header .= $cerrar_cesion;
												}
												else $header .= '<li class=""><a href="#" data-toggle="modal" data-target="#login-modal"><i class="material-icons">account_circle</i>  Iniciar Sesión</a></li>';
												$header .= '
						                    </ul>

						                    <!--Fuera de los apartados-->
						                    <!--ul class="nav navbar-nav pull-right" id="btnin_se"-->';
					                        	/*if ( isset( $_SESSION['nombre_cliente'] ) ){
									                $cerrar_cesion = '<!--ul class="navbar-custom-menu" id="custom-menu"-->
									                					<ul class="nav navbar-nav">
									                						<li class="dropdown user user-menu">
																	            <!-- Menu Toggle Button -->
																	            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
																	              <!-- The user image in the navbar-->
																	              <img src="../privado/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
																	              <!-- hidden-xs hides the username on small devices so only the image appears. -->
																	              <span class="hidden-xs">
																	              	 '.$_SESSION['nombre_cliente'].'
																	              </span>
																	            </a>
																	            <ul class="dropdown-menu">
																	              <!-- The user image in the menu -->
																	              <li class="user-header">
																	                <img src="../privado/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

																	                <p>
																	                  Alexander Pe - Administrador

																	                  <!--Base ? Fecha de ingreso del empleado-->
																	                  <small>Miembro desde Nov. 2012</small>
																	                </p>
																	              </li>

																	              <!-- Menu Footer-->
																	              <li class="user-footer">
																	                <div class="pull-left">
																	                  <a href="#" class="btn btn-default btn-flat">Perfil</a>
																	                </div>
																	                <div class="pull-right">
																	                  <form method="post"><button class="nobtn-cerrar_s" type="submit" name="crs" value="crs"><a class="btn btn-default btn-flat">Cerrar Sesión</a></button></form>
																	                </div>
																	              </li>
																	            </ul>
																	          </li>
																	    </ul>
																	<!--/ul-->';
													$header .= $cerrar_cesion;
												}
												else $header .= '<li class=""><a href="#" class="btn" role="button" data-toggle="modal" data-target="#login-modal">Iniciar Sesión</a></li>';*/
					                            $header .= '
						                    <!--/ul-->

						                    <!-- Inicio Iniciar Sesión -->
						                    '/*Si ha iniciado sesion lo meto para luego mostrarlo con jequery*/ . ( ( isset( $sesion_ini ) ) ? '<input type="hidden" id="mostrar_modal" si="si" />' : "" ) . '
						                    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
						                            <div class="modal-dialog">
						                                <div class="modal-content">
						                                    <div class="modal-header" align="center">
						                                    	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						                                        </button>
						                                        <img class="img-circle img-responsive" id="img_logo" src="../img/logo.png">
						                                    </div>
						                                    
						                                    <!-- Formualario -->
						                                    <div id="div-forms">
						                                    
						                                        <!-- Iniciar Sesión -->
						                                        <form id="login-form" method="post">
						                                            ' . ( ( ! isset( $sesion_ini ) ) ? '
						                                            		<div class="modal-body">
								                                                <div id="div-login-msg" style="color:black">
								                                                    <div id="icon-login-msg" class="glyphicon glyphicon-chevron-right"></div>
								                                                    <span id="text-login-msg">Escribe tu usuario y contraseña.</span>
								                                                </div>
								                                                <input name="usuario" id="login_username" autocomplete="off" class="form-control" type="text" placeholder="Nombre de usuario" required>
								                                                <input name="clave" id="login_password" autocomplete="off" class="form-control" type="password" placeholder="Constraseña" required>
								                                                <!--div class="checkbox">
								                                                    <label class="black">
								                                                        <input type="checkbox"> Recuerdame
								                                                    </label>
								                                                    <label class="black">
								                                                        <input type="checkbox"> Acepto los términos y condiciones
								                                                    </label>
								                                                </div-->
								                                            </div>
								                                            <div class="modal-footer">
								                                                <div>
								                                                    <button type="submit" class="btn btn-lg btn-block">Iniciar Sesión</button>
								                                                </div>
								                                                <div>
								                                                    <a href="recuperarc"><button id="login_lost_btn" type="button" class="btn btn-link">¿Olvidaste tu contraseña?</button></a>
								                                                    <a href="registrar_clientes"><button id="login_register_btn" type="button" class="btn btn-link">Registrate</button></a>
								                                                </div>
								                                            </div>' :
								                                            /*Si existe una sesion iniciada :D*/
								                                            '<div class="modal-body" style="color:black">
								                                                <div class="">
																		            <h3>Tiene una sesión ya establecida en otro dispositivo. Si desconoce esta actividad, le sugerimos restaurar la contraseña.</h3>
																		            <h3>¿Desea restaurar la contraseña?</h3>
																	            </div>
								                                            </div>
								                                            <div class="modal-footer">
								                                                <div class="col-xs-offset-0 col-xs-6 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-6">
																                	<button name="restaurar" type="submit" class="btn btn-primary btn-block btn-flat">Restaurar contraseña</button>
																                </div>
																                <div class="col-xs-offset-0 col-xs-6 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-6">
																                	<button name="no" type="submit" class="btn btn-danger btn-block btn-flat">No</button>
																                </div>
								                                            </div>' ) . '
						                                        </form>
						                                        <!-- Fin del Inicio de Sesión -->

						                                        
						                                        <!-- Contraseña olvidada -->
						                                        <form id="lost-form" style="display:none;">
						                                            <div class="modal-body">
						                                                <div id="div-lost-msg">
						                                                    <div id="icon-lost-msg" class="glyphicon glyphicon-chevron-right"></div>
						                                                    <span id="text-lost-msg">Ingresa tu Correo Electonico</span>
						                                                </div>
						                                                <input id="lost_email" class="form-control" type="text" placeholder="E-Mail" required>
						                                            </div>
						                                            <div class="modal-footer">
						                                                <div>
						                                                    <button type="submit" class="btn btn-lg btn-block">Enviar</button>
						                                                </div>
						                                                <div>
						                                                    <button id="lost_login_btn" type="button" class="btn btn-link">Iniciar Sesión</button>
						                                                    <button id="lost_register_btn" type="button" class="btn btn-link">Registrate</button>
						                                                </div>
						                                            </div>
						                                        </form>
						                                        <!-- Termina formulario de password -->
						                                        
						                                        <!-- Registro -->
						                                        <form id="register-form" style="display:none;">
						                                            <div class="modal-body">
						                                                <div id="div-register-msg">
						                                                    <div id="icon-register-msg" class="glyphicon glyphicon-chevron-right"></div>
						                                                    <span id="text-register-msg">Crea una cuenta</span>
						                                                </div>
						                                                <input id="register_username" class="form-control" type="text" placeholder="Nombre de usuario" required>
						                                                <input id="register_email" class="form-control" type="text" placeholder="E-Mail" required>
						                                                <input id="register_password" class="form-control" type="password" placeholder="Contraseña" required>
						                                            </div>
						                                            <div class="modal-footer">
						                                                <div>
						                                                    <button type="submit" class="btn btn-lg btn-block">Registrarte</button>
						                                                </div>
						                                                <div>
						                                                    <button id="register_login_btn" type="button" class="btn btn-link">Iniciar Sesión</button>
						                                                    <button id="register_lost_btn" type="button" class="btn btn-link">¿Olvidaste tu contraseña?</button>
						                                                </div>
						                                            </div>
						                                        </form>
						                                        <!-- End | Register Form -->
						                                        
						                                    </div>
						                                    <!-- Fin de div principal -->
						                                    
						                                </div>
						                            </div>
						                        </div>
						                </div>
						            </div>
						        </nav>
						    </div>
						</div>';
	  	if ( $title != 'Recibo' ) print($header);
	}

	public static function footer(){
		$footer = 	'<footer>
						<div class="row">
							<div class="divider-diego size"></div>
						  	<div class="col-xs-4 col-md-4 col-sm-4 col-xs-mod">
						  		<ul class="footer">
						  			<li class="footerlititulo">Servicio al cliente</li>
							  		<li><a href="preguntas" class="enlaces_blancos">Preguntas frecuentes</a></li>
							  		<!--li><a href="#" class="enlaces_blancos">Contactanos</a></li-->
						  			<li><a href="terminosexpo" class="enlaces_blancos">Terminos y condiciones</a></li>
						  		</ul>
						  	</div>
						  	<div class="col-xs-4 col-md-4 col-sm-4 col-xs-mod">
						  		<ul class="footer">
						  			<li class="footerlititulo">Conocenos</li>
							  		<li><a href="historia" class="enlaces_blancos">Misión, Visión y Valores</a></li>
						  		</ul>
						  	</div>
						  	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xs-mod">
						  		<ul class="footer">
						  			<li class="footerlititulo">Siguenos</li>
						  			<div class="row">
						  				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">';
											$consulta = "SELECT * FROM redes_sociales order by id_red_social ASC";
					  						//$red_social = "";
					  						$red_social = Database::getRows($consulta, null);
					  						foreach($red_social as $data){
					  							$footer .=
					  							'<a href="'.$data['url_red_social'].'" target="_blank">
													<img class="img-responsive imgcircular contactos" src="../img/redes_sociales/'.$data['logo_red_social'].'" alt="'.$data['logo_red_social'].'" />
						            			</a>';
					  						}
							$footer .= '
						  				</div>
						  				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" id="fcontac">';
											// inner join tipos_contactos on tipos_contactos.id_tipo_contacto = contactos_empresa.id_tipo_contacto
					  						$consulta = "SELECT contacto_empresa FROM contactos_empresa order by id_contacto_empresa ASC";
					  						$contacto_empresa = Database::getRows($consulta, null);
					  						foreach($contacto_empresa as $data){
					  							$footer .=
					  							'<li>'.$data['contacto_empresa'].'</li>';
					  						}
							$footer .= '
											<li>¡Con gusto te antenderemos!</li>
						  				</div>
						  			</div>
								 </ul>
							</div>
						</div>
					</footer>

					<script src="js/jquery-2.2.3.min.js"></script>

					<script src="js/sweet-alert.js"></script>

					<script src="js/bootstrap.min.js"></script>

					<script src="js/star-rating.min.js"></script><!-- Calificacion -->

					<script src="js/mainD.js"></script>

					<script src="../privado/plugins/datepicker/bootstrap-datepicker.js"></script>

					<script src="js/css3-animate-it.js"></script>';

	//$footer .= /*( $articulo == true ) ? */'<script src="js/star-rating.min.js"></script><!-- Calificacion -->'/* : ''*/;

		$footer .= '</body>

					</html>';
		print($footer);
	}

	/*
	public static function setCombo($name, $value, $query)
	{
		$data = Database::getRows($query, null);
		$combo = "<select name='$name' required>";
		if($value == null)
		{
			$combo .= "<option value='' disabled selected>Seleccione una opción</option>";
		}
		foreach($data as $row)
		{
			$combo .= "<option value='$row[0]'";
			if(isset($_POST[$name]) == $row[0] || $value == $row[0])
			{
				$combo .= " selected";
			}
			$combo .= ">$row[1]</option>";
		}	
		$combo .= "</select>
				<label style='text-transform: capitalize;'>$name</label>";
		print($combo);
	}*/
}
?>