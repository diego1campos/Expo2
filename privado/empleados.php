<?php

  //Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
  ob_start();
  //Se establece todas las clases o funciones necesarias ='D'
  require("../lib/database.php");
  require("../lib/validator.php");
  //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
  require("../lib/page-privado.php");

  $permisos = Page::header("Empleados", "empleados");
?>


                        <div class="col-sm-8 col-md-8 col-lg-8">
                            <div class="input-group">
                              <span class="input-group-addon no_padding_input-group"><button type="submit" name="action" value="Buscar" class="glyphicon glyphicon-search nobtn padding_input-group"></button></span>
                              <input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escribe el nombre del producto o una categoria..."/>
                            </div>
                        </div>
                                
                        <div class="col-sm-2 col-md-2 col-lg-2">
                          <a href="agregar_empleado">
                            <button type="button" class="btn btn-primary size">
                                  <span class="glyphicon glyphicon-plus"></span>
                              </button>
                            </a>
                        </div>
                       
                        <br>
                        <br>
            </form>
              <!--PHP INICIO-->
              <?php
                    if(isset($_POST['txtBuscar']) != "" && Validator::numeros_letras( $_POST['txtBuscar'] ) )
                    {
                      $buscar = $_POST['txtBuscar'];
                      $consulta = "SELECT id_empleado, nombres_empleado, apellidos_empleado, n_documento, usuario, correo FROM empleados, preguntas WHERE empleados.id_pregunta = preguntas.id_pregunta AND nombres_empleado LIKE '%$buscar%'";
                    }
                    else
                    {
                      $consulta = "SELECT id_empleado, nombres_empleado, apellidos_empleado, n_documento, usuario, correo FROM empleados, preguntas WHERE empleados.id_pregunta = preguntas.id_pregunta ";
                    }
              ?>
              <!--PHP FIN-->

              <!--TABLA EMPLEADOS -->

              <div class="box-body">
                <table class="table table-bordered table-hover conf_tabla">
                  <thead>
                  <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Documento</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>configuraciones</th>
                  </tr>
                  </thead>

                  <tbody>

                    <?php
                    require("../sql/conexion.php");
                    $tabla = "";
                    foreach($PDO->query($consulta) as $datos)
                    {
                      if ( $datos['id_empleado'] != $_SESSION['id_empleado'] ){
                        $tabla .= "<tr>";
                        $tabla .= "<td> $datos[nombres_empleado]</td>";
                        $tabla .= "<td> $datos[apellidos_empleado]</td>";
                        $tabla .= "<td> $datos[n_documento]</td>";
                        $tabla .= "<td> $datos[usuario]</td>";
                        $tabla .= "<td> $datos[correo]</td>";
                        $tabla .= "<td class='text-center' >";
                        $tabla .= "<a class='icono_tamano glyphicon glyphicon-edit padding_right_nojs' href='m_empleados?id_empleado=".base64_encode($datos['id_empleado'])."'></a>&nbsp;";
                        $tabla .= "<a class='icono_tamano glyphicon glyphicon-remove-circle' href='eliminar_empleado?id_empleado=".base64_encode($datos['id_empleado'])."'></a>";
                        $tabla .= "</td>";
                        $tabla .= "</tr>";
                      }
                    }

                    print($tabla);
                    $PDO = null;
                    ?>
                  
                 
                  </tbody>

                </table>
              </div>
              <!-- /.box-body -->
        </div>
      </div>
    </div>

    <!--prueba-->
    </section>
    <!-- /.content -->
  </div>

</div>

<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>

<script src="../publico/js/bootstrap.min.js"></script>

<script src="dist/js/app.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>

<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

<script src="../publico/js/mainB.js"></script>


</body>
</html>
