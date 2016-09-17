<?php
	//Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
    ob_start();
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page-privado.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    $permisos = Page::header( "Backup de datos", "backup" );
    //AGREGAR ES EXPORTAR, MODIFICAR ES IMPORTAR Y ELIMINAR ES ELIMINAR XD
    if ( isset( $_POST['exportar'] ) ) if ( Validator::permiso_agregar( $permisos ) )	shell_exec( "mysqldump -u root isadeli > '/var/www/sitio.com/backups/isadeli-backup(".date( "Y-m-d H:i:s" ).").sql'" );
    else $error[] = "No tiene permisos para realizar esta acción";
    
    if ( isset( $_POST['importar']  ) ){
	    if ( Validator::permiso_modificar( $permisos ) ){
			//if ( Validator::respaldo( $_POST['nombre_respaldo'] ) ){
				//Se puede loguear con la base, luego eliminarla, y luego crearla de nuevo (crear no importar xd) :)
				require("../sql/conexion.php");
				$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $PDO->prepare("drop database isadeli;");
				$stmt->execute();
				$stmt = $PDO->prepare("create database isadeli;");
				$stmt->execute();
				$PDO = null;
				shell_exec("mysql -u root isadeli < '/var/www/sitio.com/backups/".$_POST['importar']."'" );
			//}
			//else $error[] = "El respaldo seleccionado no posee el formato de nombre correcto.";
	    }
	    else $error[] = "No tiene permisos para realizar esta acción";
    }

							if ( isset($error) ) foreach( $error as $error_campos ) print ( '<div class="alert alert-danger" role="alert">'.$error_campos.'</div>' ); ?>
							
							<div class="col-sm-8 col-md-8 col-lg-8">
								<!--div class="col-sm-6 col-md-6 col-lg-6">
									<br>
									<button type="submit" name="importar" class="btn btn-primary size">
								        <span class="glyphicon glyphicon glyphicon-arrow-left"></span> Importar
								    </button>
								</div-->
								<div class="col-sm-6 col-md-6 col-lg-6">
									<br>
									<button type="submit" name="exportar" class="btn btn-success size">Exportar
								        <span class="glyphicon glyphicon glyphicon-arrow-right"></span>
								    </button>
								    <br>
								    <br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
	    		<div class="col-xs-12">
	        		<div class="box">
	        			<!--div class="box-body">
	        				<br>
							<div class="col-sm-8 col-md-8 col-lg-8">
								<div class="input-group">
									<span class="input-group-addon no_padding_input-group"><button type="submit" name="action" value="Buscar" class="glyphicon glyphicon-search nobtn padding_input-group"></button></span>
									<input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe la categoria..."/>
								</div>
							</div>
						</div-->
						<div class="box-body table-responsive">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<table class="table table-bordered table-hover conf_tabla">
								    <thead>
								        <tr>
								            <th class="col-sm-8 col-md-8 col-lg-8">Nombre</th>
								            <th class="col-sm-4 col-md-4 col-lg-4">Acciones</th>
								        </tr>
								    </thead>
								    <tbody>
									<?php
										$backups = "";
										//var_dump( scandir('/home/ubuntu/workspace/ex/backups') );
										foreach( scandir('/var/www/sitio.com/backups') as $backup ){
											if ( $backup != '.' && $backup != '..' ){
												$backups .= "<tr>";
													$backups .= "<td class='categoria'>$backup</td>";
													//$backups .= '<td class="text-center"><button type="submit" name="importar" value="'.$backup.'" class=" nobtn btn-info padding_right_ico">Importar</button><button type="submit" name="eliminar" value="'.$backup.'" class=" nobtn  glyphicon glyphicon-remove icono_tamano"></button></td>';
													$backups .= '<td class="text-center"><a><button type="submit" name="importar" value="'.$backup.'" class="nobtn padding_right_ico glyphicon glyphicon-repeat icono_tamano" data-toggle="tooltip" data-placement="top" title="Importar"></button></a><a href="eliminar_backup?id=' . base64_encode( $backup ) . '" class="glyphicon glyphicon-remove icono_tamano" data-toggle="tooltip" data-placement="top" title="Eliminar"></a></td>';
												$backups .= "</tr>";
											}
										}
										print($backups);
									?>
									</tbody>
								</table>
							</div>
						</div>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>