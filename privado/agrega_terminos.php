<?php
    if(!empty($_POST))
    {
        //Campos del formulario.
        $termino = $_POST['txttermino'];
        $descripcion = $_POST['txtdescripcion'];
        function mthAgregar($termino,$descripcion)
        {
            require("../sql/conexion.php");
            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT into terminos_condiciones(termino,descripcion) values(?,?)";
            $stmt = $PDO->prepare($sql);
            $stmt->execute(array($termino,$descripcion));
            $PDO = null;           
            header("location:agrega_terminos.php");
        }
        mthAgregar($termino,$descripcion);
        
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Terminos y condiciones</title>

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
	      <h1>Datos</h1>
	    </section>
		<section class="content">
	      	<div class="row">
	    		<div class="col-xs-12">
	        		<div class="box">
	        			<form id="frmcategoria" name="frmcategoria" method="post" enctype="multipart/form-data">
		            		<div class="box-body">
		            			<div class="col-sm-12 col-md-4 col-lg-3 no_padding margenpreguntas">
									<div class="col-sm-12 col-md-12 col-lg-3 margentitulopreguntas">
										<label class="">Termino:</label>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-9 margenpreguntas" >
										<input type="hidden" name="id_categoria"/>
										<input class="form-control" id="txtcategoria" type="text" class="validate" name="txttermino" placeholder="Ingrese el dato..."/>
									</div>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-4 no_padding margenpreguntas">
									<div class="col-sm-12 col-md-12 col-lg-4 margentitulopreguntas">
										<label class="">Descripción:</label>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-8 margenpreguntas" >
										<input type="hidden" name="id_categoria"/>
										<textarea class="form-control col-lg-1" rows="4" id="comment" name="txtdescripcion" placeholder="Ingrese la descripcion del dato..." ></textarea>
									</div>
								</div>

								<div class="col-xs-5 col-xs-offset-3 col-sm-12 col-sm-offset-0 col-md-4 col-lg-4 col-lg-offset-0">
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
										<br>
										<button type="submit" name="action" value="Agregar" class="btn btn-primary size">
									        <span class="glyphicon glyphicon-plus"></span>
									    </button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<br>
										<button type="button" class="btn btn-danger size">
									        <span class="glyphicon glyphicon-ban-circle"></span>
									    </button>
									    <br>
									    <br>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="row">
	    		<div class="col-xs-12">
	        		<div class="box">
	        			<div class="box-body">
	        				<br>
							<div class="col-sm-8 col-md-8 col-lg-8">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
									<input class="form-control" id="txtBuscar_productos" type="text" class="validate" name="txtBuscar_productos" placeholder="Escribe la pregunta..."/>
								</div>
							</div>
						</div>
						<div class="box-body table-responsive">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<table class="table table-bordered table-hover" id="tabla_productos">
								    <thead>
								        <tr>
								            <th class="col-sm-3 col-md-3 col-lg-3">Termino</th>
								            <th class="col-sm-3 col-md-3 col-lg-3">Descripción</th>
								            <th class="col-sm-3 col-md-3 col-lg-3">Acciones</th>
								        </tr>
								    </thead>
								    <?php
									    require("../sql/conexion.php");
										$consulta = "SELECT * from terminos_condiciones";      
										$tabla="";
										foreach ($PDO->query($consulta) as $datos) 
										{

									    $tabla.="<tbody id='lista_productos'>";
									    $tabla.="<tr>";
									    $tabla.="<td><div class='preguntas'>$datos[termino]</div></td>";
									    $tabla.="<td><div class='preguntas'>$datos[descripcion]</div></td>";
									    $tabla.="<td>";
									    $tabla.="<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-offset-3'>";
									    $tabla.="	<div class='col-xs-6 col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-2 col-lg-4 col-lg-offset-0'>";
	  									$tabla.="		<a href='eliminar_terminos.php?id=$datos[id_termino_condicion]'><span class='glyphicon glyphicon-pencil funcionesdatos'></span></a>";
	  									$tabla.="	</div>";
										$tabla.="	<div class='col-xs-6 col-sm-2 col-sm-offset-3 col-md-1 col-md-offset-2 col-lg-4 col-lg-offset-0'>";
	  									$tabla.="		<a href='eliminar_terminos.php?id=$datos[id_termino_condicion]'><span class='glyphicon glyphicon-remove funcionesdatos'></span></a>";
	  									$tabla.="	</div>";
	  									$tabla.="</div>";
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