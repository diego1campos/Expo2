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

if(!empty($_POST)) 
{

	$respuesta =  $_POST['respuesta'];
	    if (Validator::numeros_letras( $respuesta ))
	    {
	    	require("../sql/conexion.php");
			$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT respuesta FROM clientes where id_cliente=$_SESSION[id_cliente]";
			$stmt = $PDO->prepare($sql);
			$stmt->execute();
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			$PDO = null;
			if($data != null) if( password_verify( $respuesta, $data['respuesta']) ) header("location: recuperarc3");
			else $error = "Respuesta incorrecta.";
		}				         
		else $error = "Error, por favor revise los campos señalados.";

	    ( ! ( Validator::numeros_letras( $respuesta ) ) ) ? $er_usuario = "error_data" : "";

}
/*else
{*/
	require("../sql/conexion.php");
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if( ! isset( $_SESSION['id_cliente'] ) ){
    	header( "location: recuperarc" );
    	exit();
    }
    if( isset( $_SESSION['nombre_cliente'] ) ){
    	header( "location: index" );
    	exit();
    }
    $sql = "SELECT pregunta FROM clientes, preguntas WHERE preguntas.id_pregunta=clientes.id_pregunta and id_cliente=$_SESSION[id_cliente]";
    $stmt = $PDO->prepare($sql);
	$stmt->execute();
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$pregunta=$data['pregunta'];
//}

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
				<div class="col-md-6 col-md-offset-3 text-center">
					<h4 class="form-signin-heading black fa fa-info "> Pregunta de Seguridad</h4>
					<br>	
					<label class="colorW"> <?php print($pregunta); ?></label>
					<input name="respuesta" onpaste=";return false" autocomplete="off" type="password" class="form-control <?php print( ( isset($er_usuario) ) ? "$er_usuario": ""); ?>" placeholder="Respuesta" required="" autofocus="">
					<br>
					<button class="btn btn-lg btn-primary btn-block" type="submit">
						Continuar
					</button>
				</div>	
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