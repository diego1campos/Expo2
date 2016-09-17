<?php
class Validator{

	public static function datos_mvh($num_le){
		if ( preg_match("/^[á,é,í,ó,ú,a-zA-Z[:space:]0-9\"\;\.\:\,\-\(\)]+$/", trim($num_le) ) ) return true;
		else return false;
	}
	
	public static function respaldo($num_le){
		if ( preg_match("/^(isadeli-backup\()+([0-9]{4})+\-+([0-9]{2})+\-+([0-9]{2})+( )+([0-9]{2})+\:+([0-9]{2})+\:+([0-9]{2})+()+(\)\.sql)+$/", trim($num_le) ) ) return true;
		else return false;
	}
	
	public static function decimal($decimal){
		if ( preg_match("/^\d+(\.\d{1,2})?$/", trim($decimal) ) ) return true;
		else return false;
	}

	public static function numero($numero){
		if ( preg_match("/^[0-9]+$/", trim($numero) ) ) return true;
		else return false;
	}

	public static function numeros_letras($num_le){
		if ( preg_match("/^[á,é,í,ó,ú,a-zA-Z[:space:]0-9]+$/", trim($num_le) ) ) return true;
		else return false;
	}

	public static function letras($letras){
		if ( preg_match("/^[A-Z[:space:]á,é,í,ó,ú,a-z]+$/", trim($letras) ) ) return true;
		else return false;
	}

	public static function imagen($imagen){
		if ( preg_match("/^(..\/img\/productos\/)+[a-zA-Z0-9]+(\.png)+$/", trim($imagen) ) ) return true;
		else return false;
	}
	public static function dui($dui){
		if ( preg_match("/^\d{9}?$/", trim($dui) ) ) return true;
		else return false;
	}

	public static function correo($correo){
		if ( preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/", trim($correo) ) ) return true;
		else return false;
	}

	public static function direccion($correo){
		if ( preg_match("/^[á,é,í,ó,ú,a-zA-Z[:space:]0-9\#\,\.]+$/", trim($correo) ) ) return true;
		else return false;
	}

	public static function fecha($fecha){
		if ( preg_match("/^([0-9]{4})+\-+([0-9]{2})+\-+([0-9]{2})$/", trim($fecha) ) ) return true;
		else return false;
	}

	public static function permiso_agregar($permisos){
		if ( $permisos == 4 || $permisos == 5 || $permisos == 6 || $permisos == 7 ) return true;
		else return false;
	}

	public static function permiso_modificar($permisos){
		if ( $permisos == 2 || $permisos == 3 || $permisos == 6 || $permisos == 7 ) return true;
		else return false;
	}

	public static function permiso_eliminar($permisos){
		if ( $permisos == 1 || $permisos == 3 || $permisos == 5 || $permisos == 7 ) return true;
		else return false;
	}
	public static function preguntas($preguntas){
		if ( preg_match("/^[á,é,í,ó,ú,a-zA-Z0-9¿? :space:]+$/", trim($preguntas) ) ) return true;
		else return false;
}}
?>