<?php

	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
  	ob_start();
	//Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    Page::header("Recuperar contraseña");

    if( ! isset( $_SESSION['id_cliente'] ) ){
    	header( "location: recuperarc" );
    	exit();
    }
    if( isset( $_SESSION['nombre_cliente'] ) ){
    	header( "location: index" );
    	exit();
    }

if(isset($_POST['cambio'])) 
{
    
	$clave1 =  $_POST['clave1'];
	$clave2 = $_POST['clave2'];
	    if (Validator::numeros_letras( $clave1 ) && Validator::numeros_letras($clave2))
	    {
	    	if($clave1==$clave2)
	    	{
	    		if (strlen($clave1) >= 8 ) {

	    			if ( $clave1 != $_SESSION['usuario']) {

				    	require("../sql/conexion.php");
				    	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				    	$clave = password_hash($clave1, PASSWORD_DEFAULT);
			            $consulta = "update clientes set clave=? where id_cliente= $_SESSION[id_cliente]";
			            $stmt = $PDO->prepare($consulta);
		           		$stmt->execute(array($clave));			
						header("location: index");

					}
					else $error = "La contrasena no puede ser igual al nombre de usuario.";
				} 
				else $error = "La longitud de la contraseña debe ser mayor a 8 caracteres.";
			}
			else $error = "Las contraseñas no coinciden.";	
		}				         
		else $error = "Solamente se admiten numeros y letras, revise los campos señalados.";

	    ( ! ( Validator::numeros_letras( $clave1 ) ) ) ? $er_clave1 = "error_data" : "";
	    ( ! ( Validator::numeros_letras( $clave2 ) ) ) ? $er_clave2 = "error_data" : "";
}	    

?>

<!doctype>
<html>
	
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Iniciar Sesión</title>

		
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/login.css" />
		
	</head>
	<body>
		<div id="fullscreen_bg" class="fullscreen_bg container-fluid margin_top_navbar"/>
			<?php print ( ( isset($error) ) ? '<div class="alert alert-danger" role="alert">'.$error.'</div>' : "" ); ?>

			<div class="container">

				<form class="form-signin" method="post">
					<h1 class="form-signin-heading text-muted">Cambiar contraseña</h1>
					
					<input name="clave1" onpaste=";return false" autocomplete="off" type="password" class="form-control <?php print( ( isset($er_clave1) ) ? "$er_clave1": ""); ?>" placeholder="contraseña" required="" autofocus="">
					<input name="clave2" onpaste=";return false"  autocomplete="off" type="password" class="form-control <?php print( ( isset($er_clave2) ) ? "$er_clave2": ""); ?>" placeholder="confirmar contraseña" required="" autofocus="">
					<br>
					<button class="btn btn-lg btn-primary btn-block" type="submit" name="cambio">
						Continuara
					</button>
				</form>

			</div>
		</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>