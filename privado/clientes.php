<?php
  $error = ""; //xd
  if(!empty($_POST)){
    $action = $_POST['action'];
    $categoria = $_POST['txtcategoria'];
    require("../sql/conexion.php");
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ( $action == "Agregar" ){
        $sql = "INSERT INTO categorias(categoria) values(?)";            
        $stmt = $PDO->prepare($sql);
        $exito = $stmt->execute(array ( $categoria ));
        $PDO = null;
        if ( $exito == 1 ){
        	echo "<script>alert('Hola');</script>" ;
        	echo $exito;
        }
    }
    else if ( $action == "Editar" ){
    	$id_categoria = $_POST['id_categoria'];
        $sql = "update cateogiras set categoria=? where id_categoria=?";
        $stmt = $PDO->prepare($sql);
        $exito = $stmt->execute(array($categoria, $id_categoria));
        $PDO = null;
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Clientes</title>

	<link rel="stylesheet" type="text/css" href="../publico/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="../publico/css/sweet-alert.css">
	<link rel="stylesheet" type="text/css" href="../publico/css/mainD.css" />
	<link rel="stylesheet" type="text/css" href="css/Gerardo.css" />
  	<link rel="stylesheet" type="text/css" href="../publico/css/font-awesome.min.css"><!-- Font Awesome -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"><!-- Ionicons -->
	<link rel="stylesheet" type="text/css" href="plugins/datatables/dataTables.bootstrap.css"><!-- Theme style -->
	<link rel="stylesheet" type="text/css" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/skin-red.min.css">
</head>
<body class="hold-transition skin-red sidebar-mini">

<?php include 'inc/menu.php'; ?>
<div class="wrapper">
	<?php include 'inc/aside.php'; ?><!--Barra de menu sidebar-->
	<div class="content-wrapper"><!-- Contenedor -->
		<section class="content-header">
	      <h1>Clientes</h1>
	    </section>
		<section class="content">
			<div class="row">
	    		<div class="col-xs-12">
	        		<div class="box">
	        			<div class="box-body">
	        				<br>
							<div class="col-sm-8 col-md-8 col-lg-8">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
									<input class="form-control" id="txtBuscar_productos" type="text" class="validate" name="txtBuscar_productos" placeholder="Escriba el nombre del cliente..."/>
								</div>
							</div>
						</div>
						<div class="box-body table-responsive">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<table class="table table-bordered table-hover">
								    <thead>
								        <tr>
								            <th class="col-sm-3 col-md-3 col-lg-3">Imagen de cliente</th>
								            <th class="col-sm-3 col-md-3 col-lg-3">Nombre del cliente</th>
								            <th class="col-sm-3 col-md-3 col-lg-3">Funciones</th>
								        </tr>
								    </thead>
								     <?php
									    require("../sql/conexion.php");
										$consulta = "SELECT id_cliente, nombres_cliente,apellidos_cliente, usuario, img_usuario FROM clientes order by nombres_cliente ASC";      
										$tabla="";
										foreach ($PDO->query($consulta) as $datos) 
										{

									    $tabla.= "<tbody id='lista_productos'>";
									    $tabla.= "<tr>";
									    $tabla.="<div class='col-sm-12 col-md-12 col-lg-12 col-lg-offset-2'>";
									    $tabla.="<td width='0px'><img src='../img/clientes/$datos[img_usuario]' alt='Error al cargar imagen' class='iconoredes img-responsive'></td>";
									    $tabla.="</div>";
									    $tabla.="<td><div class='nombrecliente'> $datos[nombres_cliente]$datos[apellidos_cliente]<br> Usuario: $datos[usuario] </div></td>";
									    $tabla.="<td> ";
									    $tabla.="<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-offset-1'>";
									    $tabla.="<div class='col-xs-6 col-sm-4 col-sm-offset-3 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-1'>";
	  									$tabla.="<a href='consultar_cliente.php?id=$datos[id_cliente]'> <span class='glyphicon glyphicon-user funcionesredes'></span></a>";
	  									$tabla.="</div>";
										$tabla.="<div class='col-xs-6 col-sm-4 col-sm-offset-3 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-1'>";
	  									$tabla.="<a href='.php?id=$datos[id_cliente]'> <span class='glyphicon glyphicon-remove funcionesredes'></span></a>";
	  									$tabla.="</div>";
	  									$tabla.="</div>'";
	  									$tabla.="</td>";
									    $tabla.="</tr>";
										}
										print($tabla);
    									$PDO = null;
									?>
	
  								
								
									</tbody>
								</table>
							</div>
						</div>
	        		</div>
	        	</div>
	        </div>
		</section><!--Conent ='DD-->
	</div><!--ConentWrapper ='DD-->
</div><!--Wrapper ='DD-->

<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>

<script src="../publico/js/bootstrap.min.js"></script>

<script src="dist/js/app.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.js"></script>

<script src="plugins/datatables/dataTables.bootstrap.js"></script>

<script src="../publico/js/mainD.js"></script>

</body>
</html>