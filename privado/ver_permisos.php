<?php

  //Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
  ob_start();
  //Se establece todas las clases o funciones necesarias ='D'
  require("../lib/database.php");
  require("../lib/validator.php");
  //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
  require("../lib/page-privado.php");

  $permisos = Page::header("Permisos de usuarios", "tipos_usuarios");
?>


              <div class="col-md-6">
                <span class="input-group" id="basic-addon1"></span>
                <input  type="text" class="form-control" placeholder="Nombre del empleado" class="validate" name="txtBuscar">
              </div> 
              
              <div class="col-sm-2 col-md-2 col-lg-2">
                <a href="permisos">
                    <button type="button" class="btn btn-primary size">
                      <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </a>
              </div>

              <br><br>

            </form>
            <!--Fin - Buscar-->

                  <?php
                    if(isset($_POST['txtBuscar']) != "" && Validator::numeros_letras( $_POST['txtBuscar'] ) )
                    {
                      $buscar = $_POST['txtBuscar'];
                     
                          $consulta = "SELECT id_tipo_usuario, tipo_usuario FROM tipos_usuarios Where tipo_usuario LIKE '%$buscar%'";
                    }                                                                                                                                                                                                                                                 
                    else{
                          $consulta = "SELECT id_tipo_usuario, tipo_usuario FROM tipos_usuarios";
                    }    
                    
                  ?>

 

              <div class="box-body ">
                <table id="example2" class="table table-bordered table-hover conf_tabla">

                  <!--Encabezados de la tabla-->
                    <thead>
                      <tr>
                        <th>Nombre de permiso</th>
                        <th>conf</th>
                      </tr>
                    </thead>
                    <tbody>
                    <!-- Fin - Encabezados de la tabla-->

                    <?php
                    require("../sql/conexion.php");
                    $tabla = "";
                    foreach($PDO->query($consulta) as $datos)
                    {
                      
                       $tabla .= "<tr>";
                      $tabla .= "<td> $datos[tipo_usuario]</td>";
                      $tabla .= "<td class='text-center' >";
                      $tabla .= "<a class='icono_tamano glyphicon glyphicon-edit padding_right_nojs' href='modificar_permiso?id_tipo_usuario=".base64_encode($datos['id_tipo_usuario'])."'></a>&nbsp;";
                      $tabla .= "<a class='icono_tamano glyphicon glyphicon-remove-circle' href='eliminar_permiso?id_tipo_usuario=".base64_encode($datos['id_tipo_usuario'])."'></a>";
                      $tabla .= "</td>";
                      $tabla .= "</tr>";
                    

                    
                    }

                    print($tabla);
                    $PDO = null;
                    ?>
                    <!--PHP fin de la tabla-->
                    </tbody>
                </table>  
              </div>
              <!-- /.box-body -->
            </div>
          </div>
        </div>

      

      </section>

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="pull-right hidden-xs">
        Anything you want
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2016 <a href="#">Catworld</a>.</strong> Todos los derechos reservados.
    </footer>

    

 <script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>

<script src="../publico/js/bootstrap.min.js"></script>

<script src="dist/js/app.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>

<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

<script src="../publico/js/mainB.js"></script>
  </body>
  </html>
