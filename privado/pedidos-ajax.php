<?php
  //Se establece todas las clases o funciones necesarias ='D'
  require("../lib/database.php");
  //require("../lib/validator.php");
  $consulta = "SELECT id_pedido, fecha_pedido, hora_inicial, hora_final, total FROM ((`pedidos` inner join direcciones on direcciones.id_direccion = pedidos.id_direccion ) inner join clientes on clientes.id_cliente = direcciones.id_cliente) inner join horarios_entrega on horarios_entrega.id_horario_entrega = pedidos.id_horario_entrega where pedidos.estado = 0";
  $tabla = "";
  $pedidos = Database::getRows( $consulta, null );
  foreach($pedidos as $datos)
  {
    $tabla .= "<tr>";
    $tabla .= "<td>$datos[fecha_pedido]</td>";
    $tabla .= "<td>$datos[hora_inicial] a $datos[hora_final]</td>";
    $tabla .= "<td>$$datos[total]</td>";

    $tabla .= "<td class='text-center'>";
    $tabla .= "<a class='icono_tamano glyphicon glyphicon-phone-alt padding_right_nojs'  href='procesar_pedido.php?id=" . base64_encode($datos['id_pedido']) . "' ></a>";
                      $tabla .= '<a href="detalle_pedido.php?id='.base64_encode($datos['id_pedido']).'" class="icono_tamano glyphicon glyphicon-eye-open"></a>';
    $tabla .= "</td>";
    $tabla .= "</tr>";
  }
  echo json_encode( $tabla );
?>