<?php

if( ! isset($click_login) ) session_start();

function cerrar_sesion( $destruir_sesion ){
	//Vuelvo el estado de la sesion a 0 solo cuando cierra sesion... por que me interesa tambien SOLO eliminar todo con la sesion :D}
	if ( !isset($destruir_sesion) ) $exito = Database::executeRow( 'update empleados set estado_sesion = ? where id_empleado = ?;', array( 0, $_SESSION['id_empleado'] ) );
	if ( ( isset($exito) && $exito == 1 ) || isset($destruir_sesion) ){
		session_destroy();
		unset( $_SESSION );
		header( "location: login" );
		//print(( "location: " . session_id() . ".php" ));
	}	
	exit();
}

/*Tiempo de sesion*/
if ( isset( $_SESSION["ultimoAcceso_mc"] ) ) {
	$hora =  $_SESSION["ultimoAcceso_mc"];
   	$ahora = date("Y-m-d H:i:s");//Obtenemos la fecha y hora actual en el servidor
    $tiempo_transcurrido = ( strtotime($ahora) - strtotime($hora) );
    //comparamos el tiempo transcurrido
 	//600segundos = 15 min
    if ( $tiempo_transcurrido >= 600 ) cerrar_sesion();
   	else $_SESSION["ultimoAcceso_mc"] = $ahora;
}
/*Tiempo de sesion*/

if ( isset( $_POST['crs'] ) ) cerrar_sesion();

class Page
{
	public static function header( $title, $campo_pagina ){
		if( isset( $_SESSION['nombre_empleado'] ) ){//Si ha iniciado sesion, pero la sesion ya fue sobreescribida =}
			$session_current_id = Database::getRow( "select estado_sesion from empleados where id_empleado = ?;", array( $_SESSION['id_empleado'] ) );
			if ( $session_current_id['estado_sesion'] != session_id() ) cerrar_sesion( true );
		}
		else{
			header( "location: login" );
			exit();
		}
		ini_set("date.timezone","America/El_Salvador");
		$filename = basename( $_SERVER['PHP_SELF'] );
		$header = '<!DOCTYPE html>
					<html lang="es">
					<head>
						<meta charset="utf-8">
						<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
						<title>'.$title.'</title>
						<link rel="stylesheet" type="text/css" href="../publico/css/bootstrap.min.css" />
						<link rel="stylesheet" type="text/css" href="../publico/css/sweet-alert.css">
						<link rel="stylesheet" type="text/css" href="../publico/css/mainD.css" />
					  	<link rel="stylesheet" type="text/css" href="../publico/css/font-awesome.min.css"><!-- Font Awesome -->
						<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"><!-- Ionicons -->
						<link rel="stylesheet" type="text/css" href="plugins/datatables/dataTables.bootstrap.css"><!-- Theme style -->
						<link rel="stylesheet" type="text/css" href="dist/css/AdminLTE.min.css">
						<link rel="stylesheet" href="dist/css/skins/skin-red.min.css">
						<link rel="stylesheet" type="text/css" href="plugins/datepicker/datepicker3.css"><!--Mostrar calendario-->
						' . ( ( $title == 'Permisos' || $title == 'Modificar permiso' ) ? '<link rel="stylesheet" href="../publico/css/usuarios.css">' : '' ) . '
					</head>
					<!--Planitlla-->
					<body class="skin-red sidebar-mini">
						<header class="main-header">
						    <!-- Logo -->
						    <a href="index2.html" class="logo">
						      <!-- mini logo for sidebar mini 50x50 pixels -->
						      <span class="logo-mini">ISA</span>
						      <!-- logo for regular state and mobile devices -->
						      <span class="logo-lg"><b>ISA</b>DELI</span>
						    </a>

						    <!-- Header Navbar -->
						    <nav class="navbar navbar-static-top" role="navigation">
						      <!-- Sidebar toggle button-->
						      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						        <span class="sr-only">Toggle navigation</span>
						      </a>
						      <!-- Navbar Right Menu -->
						      <div class="navbar-custom-menu">
						        <ul class="nav navbar-nav">
						          
						          <!-- User Account Menu -->
						          <li class="dropdown user user-menu">
						            <!-- Menu Toggle Button -->
						            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
						              <!-- The user image in the navbar-->
						              <img src="../img/empleados/' . $_SESSION['img_empleado'] . '" class="user-image" alt="User Image">
						              <!-- hidden-xs hides the username on small devices so only the image appears. -->
						              <span class="hidden-xs">' . $_SESSION['nombre_empleado'] . '</span>
						            </a>
						            <ul class="dropdown-menu">
						              <!-- The user image in the menu -->
						              <li class="user-header">
						                <img src="../img/empleados/' . $_SESSION['img_empleado'] . '" class="img-circle" alt="User Image">

						                <p>
						                  ' . $_SESSION['nombre_empleado'] . '

						                  <!--Base ? Fecha de ingreso del empleado-->
						                  <!--small>Miembro desde Nov. 2012</small-->
						                </p>
						              </li>

						              <!-- Menu Footer-->
						              <li class="user-footer">
						                <div class="pull-left">
						                  <a href="m_empleados?id_empleado=' . base64_encode('editar') . '" class="btn btn-default btn-flat">Perfil</a>
						                </div>
						                <div class="pull-right">
						                  <form method="post">
						                	<button class="nobtn-cerrar_s" type="submit" name="crs" value="crs" style="background-color:rgba(0, 0, 0, 0);">
						                		<a class="btn btn-default btn-flat">Cerrar Sesión</a>
					                  		</button>
				                  		  </form>
						                </div>
						              </li>
						            </ul>
						          </li>
						         
						        </ul>
						      </div>
						    </nav>
						  </header>
						<!--Planitlla-->

						<div class="wrapper">
							<!--Menu lateral-->
							<aside class="main-sidebar">

							    <!-- sidebar: style can be found in sidebar.less -->
							    <section class="sidebar">

							      <!-- Sidebar perfil -->
							      <div class="user-panel">
							        ?>
							      </div>

							      <!-- Sidebar Menu -->
							      <ul class="sidebar-menu">
							        <li class="header">Configuraciones</li>
							        <!-- Optionally, you can add icons to the links -->
							        <li class="active"><a href="index"><i class="fa fa-tachometer"></i> <span>Inicio </span></a></li>
							        <li><a href="backup"><i class="fa fa-check"></i> <span>Backup de datos </span></a></li>
							        <!--li><a href=""><i class="fa fa-check"></i> <span>Inventario </span></a></li-->
							        <li ><a href="productos"><i class="fa fa-glass"></i> <span>Productos</span></a></li>
							        <li ><a href="produc_vistas"><i class="fa fa-glass"></i> <span>Vistas productos</span></a></li>
							        <li><a href="presentaciones"><i class="fa fa-archive "></i> <span>Presentaciones </span></a></li>
							        <li><a href="clientes"><i class="fa fa-user "></i> <span>Clientes </span></a></li>
							        
							        
							        <li class="treeview">
							          <a href="empleados"><i class="fa fa-suitcase"></i> <span>Empleados</span></a>
							        </li>
							        <li class="treeview">
							          <a href="#"><i class="glyphicon glyphicon-check"></i> <span>Pedidos</span> <i class="fa fa-angle-left pull-right"></i></a>
							          <ul class="treeview-menu">
							          	<li><a href="horarios_entrega">Horarios entrega</a></li>
							          	<li><a href="pedidos">Pedidos</a></li>
							          	<li><a href="pedidos-admin">Pedidos (Admin)</a></li>
							          	<li><a href="pedidos_local">Pedidos local</a></li>
							          	<li><a href="pedidos_local-admin">Pedidos local (Admin)</a></li>
							            <li><a href="entregar_pedidos">Entregar pedidos</a></li>
							            <li><a href="entregar_pedidos-admin">Entregar pedidos (Admin)</a></li>
							          </ul>
							        </li>
							        <li class="treeview">
							          <a href="#"><i class="fa fa-pencil-square-o"></i> <span>Mantenimientos</span> <i class="fa fa-angle-left pull-right"></i></a>
							          <ul class="treeview-menu">
							            <li><a href="ver_permisos">Tipos de Usuario</a></li>
							            <li><a href="tipo_contacto">Tipos de Contacto</a></li>
							            <li><a href="categorias">Categorias</a></li>
							            <!--li><a href="#">Colores</a></li-->
							            <li><a href="pregunta_seguridad">Preguntas seguridad</a></li>
							          </ul>
							        </li>
							        <li class="treeview">
							          <a href="#"><i class="glyphicon glyphicon-signal"></i> <span>Gráficos</span> <i class="fa fa-angle-left pull-right"></i></a>
							          <ul class="treeview-menu">
							            <li><a href="gra_pro_comentarios">Productos más comentareados</a></li>
							            <li><a href="gra_pro_calificados">Productos mejores calificados</a></li>
							            <li><a href="gra_pro_presentaciones">Presentaciones más vendidas<br>por producto</a></li>
							            <li><a href="gra_pro_vendidos">Productos más vendidos</a></li>
							            <li><a href="gra_horarios">Horarios más usados</a></li>
							          </ul>
							        </li>
							        <li class="treeview">
							          <a href="#"><i class="fa fa-info"></i> <span>Información de Empresa</span> <i class="fa fa-angle-left pull-right"></i></a>
							          <ul class="treeview-menu">
							            <li><a href="contacto_empresa">Contactos de la Empresa</a></li>
							            <li><a href="preguntas_frecuentes">Preguntas Frecuentes</a></li>
							            <li><a href="terminos_condiciones">Términos</a></li>
							            <li><a href="redes_sociales">Redes Sociales</a></li>
							            <li><a href="datos">Datos</a></li>
							            <li><a href="bitacora">Bitacora</a></li>
							          </ul>
							        </li>

							        <li class="treeview">
							          <a href="#"><i class="fa fa-info"></i> <span>Nosotros</span> <i class="fa fa-angle-left pull-right"></i></a>
							          <ul class="treeview-menu">'/*
							              <!--?php
							                require("../sql/conexion.php");
							                $consulta = "SELECT * from datos";
							                $tabla="";
							                foreach ($PDO->query($consulta) as $datos) 
							                  {
							                   $tabla.="<li><a href='datos.php?id=$datos[id_datos]'>$datos[nombre]</a></li>";
							                    }
							                  print($tabla);
							                  $PDO = null;
							            ?-->*/.'

							          </ul>
							        </li>
							     
							      </ul>
							      <!-- /.sidebar-menu -->
							    </section>
							    <!-- /.sidebar -->
							  </aside>
							<!--Menu lateral-->

						    <div class="content-wrapper">
							    <section class="content-header">
							      <h1>' . $title . '</h1>
							    </section>
							    <section class="content">
									<form method="post" enctype="multipart/form-data">
								      	<div class="row">
								    		<div class="col-xs-12">
								        		<div class="box">
								            		<div class="box-body">';
	  	print($header);

	  	//Permisos
	  	//En el index lo mando null :D
	  	if ( isset( $campo_pagina ) ){
			$permisos = Database::getRow( "select $campo_pagina from tipos_usuarios where id_tipo_usuario = ?;", array( $_SESSION['id_tipo_usuario'] ) );
			if ( $permisos["$campo_pagina"] == 0 ){//SI no tiene ningun permiso
			  header("location: index");
			  exit();
			}
			else return $permisos["$campo_pagina"];
		}
		//Permisos
	}

	public static function footer(){
	$footer =  '							</div><!--cierro el box =D-->
										</div><!--cierro el col-xs-12-->
									</div><!--cierro el row =D-->
								</form>
							</section><!--Conent =DD-->
						</div><!--ConentWrapper =DD-->
					</div><!--Wrapper =DD-->
					
					<script src="../publico/js/jquery-2.2.3.min.js"></script>

					<script src="../publico/js/bootstrap.min.js"></script>

					<!--script src="dist/js/app.min.js"></script-->

					<script src="plugins/datatables/jquery.dataTables.min.js"></script>

					<script src="plugins/datatables/dataTables.bootstrap.js"></script>

					<script src="dist/js/app.min.js"></script>

					<script src="../publico/js/mainB.js"></script>
					
					<script src="plugins/datepicker/bootstrap-datepicker.js"></script><!--Mostrar calendario-->

				</body>

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