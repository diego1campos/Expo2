<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Revisar pedido</title>

        
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/modal.css">
        <link rel="stylesheet" href="css/esmenu.css">
        <link rel="stylesheet" href="css/icomoon.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">

</head>
<body>
<!-- Div principal -->
<div class="navbar-wrapper">
    <div class="container-fluid">
        <nav class="navbar navbar-fixed-top">
            <div class="container">               
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#" > ISA DELI & SMOKE HOUSE</a> 
                    
                </div>

                <!--Elementos del menú-->

                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">

                        
                        <li ><a href="#" class="">Inicio</a></li>

                        <!--Catalogo-->

                        <li class=" dropdown">
                            <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Catalogo <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class=" dropdown">
                                    <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Aves</a>
                                </li>
                                <li><a href="#">Carne de Res</a></li>
                                <li><a href="#">Embutidos</a></li>
                                <li><a href="#">Viceras</a></li>
                            </ul>
                        </li>

                        <!--Historia-->


                        <li><a href="#">Nuestra Historia</a></li>

                        <!--Promociones-->

                        <li class=" dropdown">
                            <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Promociones </a>
                        </li>

                    </ul>

                    <!--Fuera de los apartados-->
                    <ul class="nav navbar-nav pull-right">
                        <li class=" dropdown">
                            <a href="#" class="btn" role="button" data-toggle="modal" data-target="#login-modal">Iniciar Sesión</a>


                        <!-- Inicio Iniciar Sesión -->
                        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            	<div class="modal-dialog">
                        			<div class="modal-content">
                        				<div class="modal-header" align="center">
                        					<img class="img-circle" id="img_logo" src="img/isa.jpg">
                        					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        					</button>
                        				</div>
                                        
                                        <!-- Formualario -->
                                        <div id="div-forms">
                                        
                                            <!-- Iniciar Sesión -->
                                            <form id="login-form">
                        		                <div class="modal-body">
                        				    		<div id="div-login-msg">
                                                        <div id="icon-login-msg" class="glyphicon glyphicon-chevron-right"></div>
                                                        <span id="text-login-msg">Escribe tu usuario y contraseña.</span>
                                                    </div>
                        				    		<input id="login_username" class="form-control" type="text" placeholder="Nombre de usuario" required>
                        				    		<input id="login_password" class="form-control" type="password" placeholder="Constraseña" required>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox"> Recuerdame
                                                        </label>
                                                        <label>
                                                            <input type="checkbox"> Acepto los términos y condiciones
                                                        </label>
                                                    </div>
                                		    	</div>
                        				        <div class="modal-footer">
                                                    <div>
                                                        <button type="submit" class="btn btn-lg btn-block">Iniciar Sesión</button>
                                                    </div>
                        				    	    <div>
                                                        <button id="login_lost_btn" type="button" class="btn btn-link">¿Olvidaste tu contraseña?</button>
                                                        <button id="login_register_btn" type="button" class="btn btn-link">Registrate</button>
                                                    </div>
                        				        </div>
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

                        </li>
                         
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>




<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/modal.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>