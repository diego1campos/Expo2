<?php
	//Si ya inicio sesion
	session_start();
	if ( isset( $_SESSION['nombre_empleado'] ) ) header("location: starter");
	//Si no ha iniciado sesion :(
	else header("location: login");
?>