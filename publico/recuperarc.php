<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
  	ob_start();
	require("../sql/conexion.php");
	//Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    Page::header("Recuperar contraseña");
    
    if( isset( $_SESSION['nombre_cliente'] ) ){
    	header( "location: index" );
    	exit();
    }

if(!empty($_POST)) 
	{
    //Campos del formulario.
    	  $usuario = $_POST['usuario'];
    	if (Validator::numeros_letras( $usuario ))
    	{
    	  	 require("../sql/conexion.php");
	         $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	         $sql = "SELECT id_cliente, usuario FROM clientes where usuario=?";
	         $stmt = $PDO->prepare($sql);
	         $stmt->execute(array($usuario));
	         $data = $stmt->fetch(PDO::FETCH_ASSOC);
	         $PDO = null;
	         if($data != null)
	         {
	         	session_start();
	         	$_SESSION['id_cliente'] = $data['id_cliente'];
	         	$_SESSION['usuario'] = $data['usuario'];
	         	header("location: recuperarc2");
	         }	
	         else $error = "Usario inexistente.";
		}				         
		else $error = "Error, por favor revise los campos señalados.";

    	 ( ! ( Validator::numeros_letras( $usuario ) ) ) ? $er_usuario = "error_data" : "";
    	
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
					<h1 class="form-signin-heading text-muted stroke text-center"> Recuperar Contraseña</h1>
					<div class="col-md-6 col-md-offset-3 text-center">
					<h4 class="form-signin-heading stroke black"><span class="fa fa-user"> Ingrese su nombre de usuario</h4>
					
					<input name="usuario" onpaste=";return false" autocomplete="off" type="text" class="form-control <?php print( ( isset($er_usuario) ) ? "$er_usuario": ""); ?>" placeholder="Nombre de Usuario " required="" autofocus="">
					<br>

					<button id="btn-recuperar" name="action" class="btn btn-lg btn-primary btn-block" type="submit">
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