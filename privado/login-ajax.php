<?php
	session_start();
	//Se establece todas las clases o funciones necesarias ='D'
	require("../lib/database.php");
	require("../lib/validator.php");
	if ( isset( $_POST['usuario'] ) && Validator::numeros_letras( $_POST['usuario'] ) ){
		$pregunta = Database::getRow( "select pregunta from empleados inner join preguntas on preguntas.id_pregunta = empleados.id_pregunta where usuario = ?;", array( $_POST['usuario'] ) );
		if ( $pregunta['pregunta'] != null ) $_SESSION['usuario'] = $_POST['usuario'];
		else{
			echo json_encode( 'noexiste' );
			exit();
		}

	}
	if ( isset( $_POST['usuario'] ) && ! Validator::numeros_letras( $_POST['usuario'] ) ){
		echo json_encode( false );
		exit();
	}

	if ( isset( $_POST['accion'] ) &&  $_POST['accion'] == 1 ){
		$pregunta = Database::getRow( "select pregunta from empleados inner join preguntas on preguntas.id_pregunta = empleados.id_pregunta where usuario = ?;", array( $_SESSION['usuario'] ) );

		$html = '<h3 class="login-box-msg">Pregunta de Seguridad</h1>
				<h4><strong>¿'.$pregunta['pregunta'].'?</strong></h4>
				<div class="form-group has-feedback">
					<input id="respuesta" onpaste=";return false" autocomplete="off" type="password" class="form-control" placeholder="Respuesta" required="" autofocus="">
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<!--div class="col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
					<button id="btncontinuar" value="2" class="btn btn-primary btn-block btn-flat" type="button">Continuar</button>
				</div-->';
	}

	else if ( isset( $_POST['respuesta'] ) && Validator::numeros_letras( $_POST['respuesta'] ) ){
		$respuesta = Database::getRow( 'select respuesta from empleados where usuario = ?', array( $_SESSION['usuario'] ) );
		if( password_verify( $_POST['respuesta'], $respuesta['respuesta']) ){
		//if ( $_POST['respuesta'] == $respuesta['respuesta'] ){
			$html = '<h3 class="login-box-msg">Ingresar nueva contraseña</h1>
					<div class="form-group has-feedback">
					    <input id="contra1"" onpaste=";return false" autocomplete="off" type="password" class="form-control placeholder="Nueva contraseña" required="" >
					    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
				    </div>
				    <div class="form-group has-feedback">
					  	<input id="contra2"" onpaste=";return false" autocomplete="off" type="password" class="form-control placeholder="Repetir contraseña" required="" >
					  	<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				    </div>
				  	<!--div class="col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
				    	<button id="btncontinuar" value="3" class="btn btn-primary btn-block btn-flat" type="button">Restaurar</button>
				    </div-->';
		}
		else echo json_encode( "respuestainc" );
	}
	if ( isset( $_POST['respuesta'] ) && ! Validator::numeros_letras( $_POST['respuesta'] ) ) echo json_encode( "validacion" );

	if ( isset( $_POST['contra1'] ) && Validator::numeros_letras( $_POST['contra1'] ) && isset( $_POST['contra2'] ) && Validator::numeros_letras( $_POST['contra2'] ) ){
		if ( $_POST['contra1'] == $_POST['contra2'] ){
			if ( strlen( $_POST['contra1'] ) >= 8 ) {
	    		if ( $_POST['contra1'] != $_SESSION['usuario']) {
	    			$clave = password_hash( $_POST['contra1'], PASSWORD_DEFAULT );
					$exito = Database::executeRow( 'update empleados set clave = ? where usuario = ?;', array( $clave, $_SESSION['usuario'] ) );
					if ( $exito == 1 ) $exito = Database::executeRow( 'update empleados set estado_sesion = ? where usuario = ?;', array( '0', $_SESSION['usuario'] ) );
					echo json_encode( $exito );
				}
				else echo json_encode( "igualusuario" );
			}
			else echo json_encode( "longitud" );
		}
		else echo json_encode( "nocoinciden" );
	}

	if ( ( isset( $_POST['contra1'] ) && ! Validator::numeros_letras( $_POST['contra1'] ) ) || ( isset( $_POST['contra2'] ) && ! Validator::numeros_letras( $_POST['contra2'] ) ) ) echo json_encode( "validacion" );

	if ( isset( $html ) ) echo json_encode( $html );
?>