<?php  
    ob_start();
    require("../lib/database.php");
    require("../lib/validator.php");
    require("../lib/page-privado.php");
	require("../sql/conexion.php");
  	$permisos = Page::header("Entregas", "horarios_entrega");
  	//$dias = $_POST['cmbD2'];

	if(!empty($_POST))
	{
		$action = $_POST['action'];
		
		try
    	{
	    	@$hora_inicio = $_POST['txtHora'];
			@$hora_final = $_POST['txtHora2'];
			@$estado = $_POST['cmbE'];
			@$c = $_POST['id'];
			@$dia = $_POST['cmbD'];
			$resultado = substr($hora_inicio, 0, -3);
		    $resultado2 = substr($hora_final, 0, -3);

			if ( Validator::hora($hora_final) && Validator::hora($hora_inicio) && ( $dia >= 1 && $dia <= 7 ) )
			{
				if ( strtotime( $hora_final ) > strtotime( $hora_inicio ) )
				{
					if ( strtotime( $hora_final ) - strtotime( $hora_inicio ) >= 3600 )
					{
						//if ($resultado < $resultado2)
						//{
							if ( $action == "Agregar" )
							{
								if ( ! Validator::permiso_agregar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";

								else 
								{
							        $sql = "INSERT INTO horarios_entrega (dia, hora_inicial, hora_final, estado) values(?, ?, ?, ?)";
							        $stmt = $PDO->prepare($sql);
							        $exito = $stmt->execute(array($dia, $hora_inicio, $hora_final, $estado));
							        $con_bi = "call inserta_bitacora( ?, ?, ?, ? )";
								    Database::executeRow( $con_bi , array ($_SESSION['id_empleado'],20,1, $sql));
							        $PDO = null;
						    	}
					      	}

					      	else if ( $action == "Editar" )
						    {
						    	if (  Validator::numero($c) ){
								    if ( ! Validator::permiso_modificar( $permisos ) ) $error[] = "No tiene permisos para realizar esta accion.";
								    else
								    {
									    $sql = "UPDATE horarios_entrega SET dia = ?, hora_inicial = ?, hora_final = ?, estado = ? WHERE id_horario_entrega = $c";
								        $stmt = $PDO->prepare($sql);
								        $exito = $stmt->execute(array($dia, $hora_inicio, $hora_final, $estado));
								        $con_bi = "call inserta_bitacora( ?, ?, ?, ? )";
									    Database::executeRow( $con_bi , array ($_SESSION['id_empleado'],20,2, $sql));
							        $PDO = null;
								    }
								}
								else $error[] = "Id de horario invalido.";
							}
			   			//}
			   			//else $error[] = "Horario invalido: el horario ingresado esta incluido dentro de otro, por favor revisar.";
					}
					else $error[] = "Horario invalido: debe de haber al menos una hora de diferencia entre la hora inicial y final.";
		   		}
		   		else $error[] = "Horario invalido: la hora inicial no debe ser mayor que la hora final.";
			}

			//throw new Exception("Por favor revise las horas.");  	
			else $error_data = "Error, por favor revise los campos señalados.";

		    ( ! ( Validator::hora($hora_inicio) ) ) ? $error[] = "Hora inicial: por favor ingrese una hora valida." : "";

		    ( ! ( Validator::hora($hora_final) ) ) ? $error[] = "Hora final: por favor ingrese una hora valida." : "";

		    ( ! ( $dia >= 1 && $dia <= 7 ) ) ? $error[] = "Dia invalido: por favor seleccione un dia." : "";

		}

		catch( Exception $Exception ) {
		   	if( $Exception->getCode() == 23000 ) $error[] = "Horario ya existente, por favor ingrese otro.";
		    else $error[] = $Exception->getMessage();
		}
	}
?>


<link rel="stylesheet" href="css/bootstrap-material-datetimepicker.css" />
<script type="text/javascript" src="css/js-date.js"></script>
<script type="text/javascript" src="css/bootstrap-material-datetimepicker.js"></script>
<script type="text/javascript" src="myjs.js"></script>

<?php

$palabra = '';

if ( isset($action) && $action == "Agregar" ) $palabra = "añadida";

else $palabra = "editada";

print ( ( isset($exito) && $exito == 1 ) ? '<div class="alert alert-success" role="alert">Horario de entrega '.$palabra.' con exito.</div>' : "" );

print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );

if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' );
?>	

<input type="hidden"  id="id_horario_entrega" name="id" class="<?php print( ( isset($er_hora_inicio) ) ? "$er_id": ""); ?>">

<div class="col-sm-3 col-md-3 col-lg-3">
<select name="cmbD"  class="form-control" id="dia" >
<option value="0" selected>Seleccionar Dia</option>
<option value="1">Domingo</option>
<option value="2">Lunes</option>
<option value="3">Martes</option>
<option value="4">Miercoles</option>
<option value="5">Jueves</option>
<option value="6">Viernes</option>
<option value="7">Sabado</option>
</select>  
</div>

<div class="col-sm-2 col-md-2 col-lg-2">
<input type="text" id="time" name="txtHora" class="form-control floating-label vletras_esp <?php print( ( isset($er_hora_inicio) ) ? "$er_hora_inicio": ""); ?>"  placeholder="Hora Inicial">
</div>

<div class="col-sm-2 col-md-2 col-lg-2">
<input type="text" id="time2" name="txtHora2" class="form-control floating-label vletras_esp <?php print( ( isset($er_hora_final) ) ? "$er_hora_final": ""); ?>" placeholder="Hora Final">
</div>

<div class="col-sm-3 col-md-3 col-lg-3">
<select name="cmbE"  class="form-control" id="estado">
<option value="0">Inhabilitado</option>
<option value="1">Habilitado</option>
</select>  
</div>

<div class="col-sm-1 col-md-1 col-lg-1">
	<button class="btn btn-r" id="btn-horario" type="submit" name="action" value="Agregar" >
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
	</button>
</div>

<div class="col-sm-1 col-md-1 col-lg-1">
	<button id="btn-c-horario" type="button" class="btn btn-danger size">
        <span class="glyphicon glyphicon-remove"></span>
    </button>
</div>

<script type="text/javascript">
		$(document).ready(function()
		{
			$('#time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});

			$('#time2').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});
			
			$('#min-date').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY HH:mm', minDate : new Date() });

			$.material.init()
		});
		</script>
		</div>
	</div>
</div>
</div>
				
<div class="row">
<div class="col-xs-12">
	<div class="box">
		<div class="box-body">
			<br>
<div class="col-sm-1 col-md-1 col-lg-1">
<button class="btn btn-r" type="submit" name="action" >
<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
</button>
</div>

<div class="col-sm-3 col-md-3 col-lg-3">
<select name="cmbD2"  class="form-control" id="tipoUsuario">
<option value="1">Domingo</option>
<option value="2">Lunes</option>
<option value="3">Martes</option>
<option value="4">Miercoles</option>
<option value="5">Jueves</option>
<option value="6">Viernes</option>
<option value="7">Sabado</option>
</select>  
</div>



<div class="col-md-12">
<div class="box-body table-responsive">
	<table class="table table-bordered table-hover" id="">
		<thead>
			<tr>
				<th class="col-sm-1 col-md-1 col-lg-1">Dia</th>
				<th class="col-sm-2 col-md-2 col-lg-2">Hora Inicio</th>
				<th class="col-sm-2 col-md-2 col-lg-2">Hora Final</th>
				<th class="col-sm-2 col-md-2 col-lg-2">Estado</th>
				<th class="col-sm-2 col-md-2 col-lg-2">Mas</th>
			</tr>
		</thead>

<tbody id="">

<?php
require("../sql/conexion.php");
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$productos = "";
$consulta = "select * from horarios_entrega";
foreach($PDO->query($consulta) as $datos)
{
	$productos .= "<tr>";
	if ( $datos['dia'] == 1 ) $dia = 'Domingo';
	else if ( $datos['dia'] == 2 ) $dia = 'Lunes';
	else if ( $datos['dia'] == 3 ) $dia = 'Martes';
	else if ( $datos['dia'] == 4 ) $dia = 'Miercoles';
	else if ( $datos['dia'] == 5 ) $dia = 'Jueves';
	else if ( $datos['dia'] == 6 ) $dia = 'Viernes';
	else if ( $datos['dia'] == 7 ) $dia = 'Sabado';

	if ( $datos['estado'] == 0 ) $estado = 'Inhabilitado';
	else if ( $datos['estado'] == 1 ) $estado = 'Habilitado';

	$productos .= "<td>$dia</td>";
	$productos .= "<td>".substr( $datos['hora_inicial'], 0, -3 )."</td>";
	$productos .= "<td>".substr( $datos['hora_final'], 0, -3 )."</td>";
	$productos .= "<td>$estado</td>";

	$productos .= '<td class="text-center">

	<a class="glyphicon glyphicon-edit padding_right_ico icono_tamano up" onclick="javascript: $(this).e_entregas();" id_horario_entrega="' . $datos['id_horario_entrega'] . '" dia="'.$datos['dia'].'"   hora_inicial = "'. substr( $datos['hora_inicial'], 0, -3 ) .'"  hora_final = "'. substr( $datos['hora_final'], 0, -3 ).'" estado = "'. $datos['estado'].'"></a>

	<a href="eliminar_entrega.php?id='.$datos['id_horario_entrega'].'" class="glyphicon glyphicon-remove-circle a_text_normal "></a></td>';

$productos .= "</tr>";
print($productos);
$PDO = null;
}

?>
</tbody>  
</table>
</div>
<!--hola aqui termina tabla-->
</div>
</div>
</div>
</div>
