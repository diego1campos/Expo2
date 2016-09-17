<?php
  //Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
  ob_start();
  //Se establece todas las clases o funciones necesarias ='D'
  require("../lib/database.php");
  require("../lib/validator.php");
  //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
  require("../lib/page-privado.php");
  //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  $permisos = Page::header("Pedidos", "pedidos");
?>
                        <div class="col-sm-8 col-md-8 col-lg-8">
                            <div class="input-group">
                              <span class="input-group-addon no_padding_input-group"><button type="submit" name="action" value="Buscar" class="glyphicon glyphicon-search nobtn padding_input-group"></button></span>
                              <input class="form-control" type="text" class="validate" name="txtBuscar" placeholder="Escriba los nombres o apellidos del cliente, o el total de la compra"/>
                            </div>
                        </div>
                       
                        <br>
                        <br>
            </form>
              <!--PHP INICIO-->
              <?php
                if(isset($_POST['txtBuscar']) != "" && ( Validator::decimal( $_POST['txtBuscar'] ) || Validator::letras( $_POST['txtBuscar'] ) ) )
                {
                  $buscar = $_POST['txtBuscar'];
                 $consulta = "SELECT id_pedido, nombres_cliente, apellidos_cliente, fecha_pedido, hora_inicial, hora_final, total FROM ((`pedidos` inner join direcciones on direcciones.id_direccion = pedidos.id_direccion ) inner join clientes on clientes.id_cliente = direcciones.id_cliente) inner join horarios_entrega on horarios_entrega.id_horario_entrega = pedidos.id_horario_entrega where pedidos.estado = 0 and  ( nombres_cliente LIKE '%$buscar%' or apellidos_cliente LIKE '%$buscar%' or total LIKE '%$buscar%' )";
                }
                 else
                {
                  $consulta = "SELECT id_pedido, nombres_cliente, apellidos_cliente, fecha_pedido, hora_inicial, hora_final, total FROM ((`pedidos` inner join direcciones on direcciones.id_direccion = pedidos.id_direccion ) inner join clientes on clientes.id_cliente = direcciones.id_cliente) inner join horarios_entrega on horarios_entrega.id_horario_entrega = pedidos.id_horario_entrega where pedidos.estado = 0";
                }
                if ( isset($_POST['txtBuscar']) != "" && ( ! Validator::decimal( $_POST['txtBuscar'] ) && ! Validator::letras( $_POST['txtBuscar'] ) ) ) print( '<div class="alert alert-danger" role="alert">Busqueda invalida</div>' );
              ?>
              <!--PHP FIN-->

              <!--TABLA EMPLEADOS -->

              <div class="box-body">
                <table class="table table-bordered table-hover conf_tabla">
                  <thead>
                  <tr>
                    <th>Nombres</th>
                    <th>Fecha de entrega</th>
                    <th>Horario de entrega</th>
                    <th>Total(+cargo)</th>
                    <th>Acciones</th>
                    
                  </tr>
                  </thead>

                  <tbody id="">
    

                    <?php
                    $tabla = "";
                    $pedidos = Database::getRows( $consulta, null );
                    foreach($pedidos as $datos)
                    {
                      $tabla .= "<tr>";
                      $tabla .= "<td>$datos[nombres_cliente] $datos[apellidos_cliente]</td>";
                      $tabla .= "<td>$datos[fecha_pedido]</td>";
                      $tabla .= "<td>$datos[hora_inicial] a $datos[hora_final]</td>";
                      $tabla .= "<td>$$datos[total]</td>";

                      $tabla .= "<td class='text-center'>";
                      $tabla .= '<a href="eliminar_pedido?id=' . base64_encode($datos['id_pedido']) . '" class="icono_tamano glyphicon glyphicon-remove-circle padding_right_nojs"></a>';// padding_right_nojs 
                      $tabla .= '<a href="detalle_pedido?id='.base64_encode($datos['id_pedido']).'" class="icono_tamano glyphicon glyphicon-eye-open"></a>';
                      $tabla .= "</td>";
                      $tabla .= "</tr>";
                    }

                    $sql = "UPDATE `pedidos` SET estado = 1 WHERE id_pedido ="; 

                    print($tabla);
                    ?>
                  
                 
                  </tbody>

                </table>
              </div>
            </div>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>