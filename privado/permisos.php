<?php
  //Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page-privado.php");

    //Sirve para utilizar la funcion header en cualquier lugar de la pagina :D
  ob_start();
  $permisos = Page::header("Permisos", "tipos_usuarios" );

  //if ( $permisos != 4 && $permisos != 5 && $permisos != 6 && $permisos != 7 ){
   //   header( "location: index" );
     // exit();
  //}
  if ( !empty($_POST) ) {
    $suma_calificacion=0;
    if ( isset( $_POST['calificacion_productos'] ) ) foreach ( $_POST['calificacion_productos'] as $valor ) $suma_calificacion+=$valor;

    $suma_categorias=0;
    if ( isset( $_POST['categorias'] ) ) foreach ( $_POST['categorias'] as $valor ) $suma_categorias+=$valor;

    $suma_clientes=0;
    if ( isset( $_POST['clientes'] ) ) foreach ( $_POST['clientes'] as $valor ) $suma_clientes+=$valor;

    $suma_comentariosP=0;
    if ( isset( $_POST['comentarios_productos'] ) ) foreach ( $_POST['comentarios_productos'] as $valor ) $suma_comentariosP+=$valor;

    $suma_contactoE=0;
    if ( isset( $_POST['contactos_empresa'] ) ) foreach ( $_POST['contactos_empresa'] as $valor ) $suma_contactoE+=$valor;

    $suma_datos=0;
    if ( isset( $_POST['datos'] ) ) foreach ( $_POST['datos'] as $valor ) $suma_datos+=$valor;

    $suma_detalleP=0;
    if ( isset( $_POST['detalles_pedidos'] ) ) foreach ( $_POST['detalles_pedidos'] as $valor ) $suma_detalleP+=$valor;

    $suma_detalleL=0;
    if ( isset( $_POST['detalles_pedidos_local'] ) ) foreach ( $_POST['detalles_pedidos_local'] as $valor ) $suma_detalleL+=$valor;

    $suma_direcciones=0;
    if ( isset( $_POST['direcciones'] ) ) foreach ( $_POST['direcciones'] as $valor ) $suma_direcciones+=$valor;

    $suma_empleados=0;
    if ( isset( $_POST['empleados'] ) ) foreach ( $_POST['empleados'] as $valor ) $suma_empleados+=$valor;

    $suma_entregarp=0;
    if ( isset( $_POST['entregar_pedidos'] ) ) foreach ( $_POST['entregar_pedidos'] as $valor ) $suma_entregarp+=$valor;

    $suma_existencias=0;
    if ( isset( $_POST['existencias'] ) ) foreach ( $_POST['existencias'] as $valor ) $suma_existencias+=$valor;

    $suma_horario=0;
    if ( isset( $_POST['horarios_entrega'] ) ) foreach ( $_POST['horarios_entrega'] as $valor ) $suma_horario+=$valor;
    
    $suma_index=0;
    if ( isset( $_POST['index_imagenes'] ) ) foreach ( $_POST['index_imagenes'] as $valor ) $suma_index+=$valor;
   
    $suma_imgP=0;
    if ( isset( $_POST['img_productos'] ) ) foreach ( $_POST['img_productos'] as $valor ) $suma_imgP+=$valor;
   
    $suma_pedidos=0;
    if ( isset( $_POST['pedidos'] ) ) foreach ( $_POST['pedidos'] as $valor ) $suma_pedidos+=$valor;
   
    $suma_pedidosL=0;
    if ( isset( $_POST['pedidos_local'] ) ) foreach ( $_POST['pedidos_local'] as $valor ) $suma_pedidosL+=$valor;
    
    $suma_preguntas=0;
    if ( isset( $_POST['preguntas'] ) ) foreach ( $_POST['preguntas'] as $valor ) $suma_preguntas+=$valor;
   
    $suma_preguntasF=0;
    if ( isset( $_POST['preguntas_frecuentes'] ) ) foreach ( $_POST['preguntas_frecuentes'] as $valor ) $suma_preguntasF+=$valor;

    $suma_presentaciones=0;
    if ( isset( $_POST['presentaciones'] ) ) foreach ( $_POST['presentaciones'] as $valor ) $suma_presentaciones+=$valor;
    
    $suma_productos=0;
    if ( isset( $_POST['productos'] ) ) foreach ( $_POST['productos'] as $valor ) $suma_productos+=$valor;  
    
    $suma_redes=0;
    if ( isset( $_POST['redes_sociales'] ) ) foreach ( $_POST['redes_sociales'] as $valor ) $suma_redes+=$valor;  
    
    $suma_terminosC=0;
    if ( isset( $_POST['terminos_condiciones'] ) ) foreach ( $_POST['terminos_condiciones'] as $valor ) $suma_terminosC+=$valor;  
   
    $suma_tiposC=0;
    if ( isset( $_POST['tipos_contactos'] ) ) foreach ( $_POST['tipos_contactos'] as $valor ) $suma_tiposC+=$valor;  
   
    $suma_tipoU=0;
    if ( isset( $_POST['tipos_usuarios'] ) ) foreach ( $_POST['tipos_usuarios'] as $valor ) $suma_tipoU+=$valor;  

    $suma_valores=0;
    if ( isset( $_POST['valores'] ) ) foreach ( $_POST['valores'] as $valor ) $suma_valores+=$valor;  

    $suma_backup=0;
    if ( isset( $_POST['backup'] ) ) foreach ( $_POST['backup'] as $valor ) $suma_backup+=$valor;

    @$Nombre_permiso=$_POST['Nombre_permiso'];
    
    require("../sql/conexion.php");


    

    if (Validator::numeros_letras( $Nombre_permiso )){
      
      if ( $suma_calificacion <= 7 &&  $suma_categorias  <= 7 &&  $suma_clientes  <= 7 &&  $suma_comentariosP  <= 7 &&  $suma_contactoE  <= 7 &&  $suma_datos  <= 7 &&  $suma_detalleP  <= 7 && 
            $suma_detalleL  <= 7 &&  $suma_direcciones  <= 7 &&  $suma_empleados  <= 7 &&  $suma_entregarp  <= 7 &&  $suma_existencias  <= 7 &&  $suma_horario  <= 7 &&  $suma_index  <= 7 &&  $suma_imgP  <= 7 &&   $suma_pedidos  <= 7 &&  $suma_pedidosL  <= 7 && 
            $suma_preguntas  <= 7 &&  $suma_preguntasF  <= 7 &&  $suma_presentaciones  <= 7 &&  $suma_productos  <= 7 &&  $suma_redes  <= 7 &&  $suma_terminosC  <= 7 &&  $suma_tiposC  <= 7 &&  $suma_tipoU  <= 7 &&  $suma_valores <= 7 )  {
            

          if ( ! Validator::permiso_agregar( $permisos ) ) $error = "No tiene permisos para realizar esta accion.";
            else {  
            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO tipos_usuarios( tipo_usuario, calificacion_productos, categorias, clientes, comentarios_productos, contactos_empresa, datos, 
                          detalles_pedidos, detalles_pedidos_local, direcciones, empleados ,entregar_pedidos, existencias, horarios_entrega, index_imagenes, 
                          img_productos, pedidos, pedidos_local, preguntas , preguntas_frecuentes , presentaciones, productos, redes_sociales, terminos_condiciones, 
                          tipos_contactos, tipos_usuarios, valores, backup) 
                      values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $PDO->prepare($sql);
                $stmt->execute(array($Nombre_permiso,$suma_calificacion, $suma_categorias, $suma_clientes, $suma_comentariosP, $suma_contactoE, $suma_datos, $suma_detalleP,
                $suma_detalleL,$suma_direcciones,$suma_empleados,$suma_entregarp,$suma_existencias,$suma_horario,$suma_index,$suma_imgP, $suma_pedidos, $suma_pedidosL,
                $suma_preguntas,$suma_preguntasF,$suma_presentaciones,$suma_productos,$suma_redes, $suma_terminosC, $suma_tiposC, $suma_tipoU, $suma_valores, $suma_backup));
                $PDO = null;
                Database::executeRow( "call inserta_bitacora( ?, ?, ?, ? );" , array ( $_SESSION['id_empleado'], 19, 1, $sql ) );
                header("location: ver_permisos");
          }
        }
        else{
          header("location: permisos");
        }
    }

    else $error = "Error, por favor revise los campos señalados.";

    ( ! ( Validator::numeros_letras( $Nombre_permiso ) ) ) ? $er_nombre = "error_data" : "";
  }


  print ( ( isset($error_data) ) ? '<div class="alert alert-danger" role="alert">'.$error_data.'</div>' : "" );
  print ( ( isset($error) ) ? '<div class="alert alert-danger" role="alert">'.$error.'</div>' : "" );


  ?>


    <!-- Contenido principal -->
  
      <div class="container ">
        <div class="row">

          <div class="box-body col-lg-12">
            <div class="row">
              <div class="col-xs-6">
                <label>Nombre del tipo de usuario</label>
                <input type="text" autocomplete="off" name="Nombre_permiso" class="form-control <?php print( ( isset($er_nombre) ) ? "$er_nombre": ""); ?>" placeholder=" ...">
              </div>
            </div> 
          </div> 
            <br>

  <div class="container">
    <div class="row">
      <div class="well well-sm col-md-9 col-lg-11 ">
       
            <!--Primer grupo -->
            
            <div class="btn-group col-md-6  col-lg-3" data-toggle="buttons">
              <h5>Calificación productos</h5>
              <label  class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input class="access_check" type="checkbox" autocomplete="off" checked id="agregar_calificacionp" value="4" name="calificacion_productos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label   class="btn btn-success btnUsuario"  data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input class="access_check" type="checkbox" id="modificar_calificacionp" autocomplete="off" value="2" name="calificacion_productos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label  class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input class="access_check" type="checkbox"  id="eliminar_calificacionp" autocomplete="off" value="1" name="calificacion_productos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>            
            </div> 

            <div class="btn-group col-md-6  col-lg-3" data-toggle="buttons">
              <h5>Categorias</h5>
              <label  class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input class="access_check" type="checkbox" autocomplete="off" checked id="agregar_categorias" value="4" name="categorias[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label  class="btn btn-success btnUsuario"  data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input class="access_check" type="checkbox" id="modificar_categorias" autocomplete="off" value="2" name="categorias[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label  class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input class="access_check" type="checkbox"  id="eliminar_categorias" autocomplete="off" value="1" name="categorias[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>   
            </div>

            <div class="btn-group col-md-6  col-lg-3" data-toggle="buttons">
              <h5>Clientes</h5>
              <label  class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input class="access_check" type="checkbox" autocomplete="off" checked id="agregar_cliente" value="4" name="clientes[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label  class="btn btn-success btnUsuario"  data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input class="access_check" type="checkbox" id="modificar_cliente" autocomplete="off" value="2" name="clientes[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label  class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input class="access_check" type="checkbox"  id="eliminar_cliente" autocomplete="off" value="1" name="clientes[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>   
            </div>

            <div class="btn-group col-md-6  col-lg-3" data-toggle="buttons">
              <h5>Comentarios de productos</h5>
              <label  class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input class="access_check" type="checkbox" autocomplete="off" checked id="agregar_comentariop" value="4" name="comentarios_productos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label  class="btn btn-success btnUsuario"  data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input class="access_check" type="checkbox" id="modificar_comentariop" autocomplete="off" value="2" name="comentarios_productos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label  class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input class="access_check" type="checkbox"  id="eliminar_comentariop" autocomplete="off" value="1" name="comentarios_productos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>               
            </div>


            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Contacto de Empresa</h5>
              <label  class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input class="access_check" type="checkbox" autocomplete="off" checked id="agregar_contactoe" value="4" name="contactos_empresa[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label  class="btn btn-success btnUsuario"  data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input class="access_check" type="checkbox" id="modificar_contactoe" autocomplete="off" value="2" name="contactos_empresa[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label  class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input class="access_check" type="checkbox"  id="eliminar_contactoe" autocomplete="off" value="1" name="contactos_empresa[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>   
            </div>

            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Datos</h5>
              <label  class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input class="access_check" type="checkbox" autocomplete="off" checked id="agregar_datos" value="4" name="datos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label  class="btn btn-success btnUsuario"  data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input class="access_check" type="checkbox" id="modificar_datos" autocomplete="off" value="2" name="datos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label  class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input class="access_check" type="checkbox"  id="eliminar_datos" autocomplete="off" value="1" name="datos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>   
            </div>
            
            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Detalle pedidos</h5>
              <label  class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input class="access_check" type="checkbox" autocomplete="off" checked id="agregar_detallep" value="4" name="detalles_pedidos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label  class="btn btn-success btnUsuario"  data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input class="access_check" type="checkbox" id="modificar_detallep" autocomplete="off" value="2" name="detalles_pedidos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label  class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input class="access_check" type="checkbox"  id="eliminar_detallep" autocomplete="off" value="1" name="detalles_pedidos[]"> 
                <span class="glyphicon glyphicon-ok"></span>
              </label>   
              
            </div>

            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Detalles pedidos local</h5>
              <label  class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input class="access_check" type="checkbox" autocomplete="off" checked id="agregar_detallep" value="4" name="detalles_pedidos_local[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label  class="btn btn-success btnUsuario"  data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input class="access_check" type="checkbox" id="modificar_detallepl" autocomplete="off" value="2" name="detalles_pedidos_local[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label  class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input class="access_check" type="checkbox"  id="eliminar_detallepl" autocomplete="off" value="1" name="detalles_pedidos_local[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>   
            </div>
        

            <!--Primer grupo -->
            
            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Direcciones</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_direcciones"  value="4" name="direcciones[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_direcciones" value="2" name="direcciones[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_direcciones" value="1" name="direcciones[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
              
            </div>

            <!--Segundo grupo -->
   
            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Empleados</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_empleados" value="4" name="empleados[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_empleados" value="2" name="empleados[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_empleados" value="1" name="empleados[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
              
            </div>

            <!--Tercer grupo -->

            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Entregar pedidos</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_entregarp" value="4" name="entregar_pedidos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_entregarp" value="2" name="entregar_pedidos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_entregarp" value="1" name="entregar_pedidos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
              
            </div>

           <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Existencias</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_existencias" value="4" name="existencias[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_existencias" value="2" name="existencias[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_existencias" value="1" name="existencias[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
              
            </div>
        

            <!--Primer grupo -->
            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Horarios de entrega</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_horarios" value="4" name="horarios_entrega[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_horarios" value="2" name="horarios_entrega[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_horarios" value="1" name="horarios_entrega[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
              
            </div>

            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Imagenes Index</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_imagenesI" value="4" name="index_imagenes[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_imagenesI" value="2" name="index_imagenes[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_imagenesI" value="1" name="index_imagenes[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            </div>

            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Imagenes de productos</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_imagenesp" value="4" name="img_productos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_imagenesp" value="2" name="img_productos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_imagenesp" value="1" name="img_productos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>  

              </div>
            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Pedidos</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_pedidos" value="4" name="pedidos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_pedidos"  value="2" name="pedidos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_pedidos" value="1" name="pedidos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            </div>

          
          
            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Pedidos local</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_pedidosl" value="4" name="pedidos_local[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_pedidosl"  value="2" name="pedidos_local[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_pedidosl" value="1" name="pedidos_local[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            </div>    
              
            
            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Preguntas</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_preguntas" value="4" name="preguntas[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_preguntas"  value="2" name="preguntas[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_preguntas" value="1" name="preguntas[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            </div>

            <!--Segundo grupo -->
   
            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Preguntas frecuentes</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_preguntasf"value="4" name="preguntas_frecuentes[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_preguntasf"value="2" name="preguntas_frecuentes[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_preguntasf"value="1" name="preguntas_frecuentes[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
              
            </div>

            <!--Tercer grupo -->

            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Presentaciones</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_presentaciones" value="4" name="presentaciones[]">  
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_presentaciones" value="2" name="presentaciones[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_presentaciones" value="1" name="presentaciones[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>  

                
              
            </div>
        

            <!--Primer grupo -->
            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Productos</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_productos" value="4" name="productos[]">  
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_productos" value="2" name="productos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_productos" value="1" name="productos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>
            </div>  
            
            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Redes sociales</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_redes" value="4" name="redes_sociales[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_redes" value="2" name="redes_sociales[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_redes" value="1" name="redes_sociales[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
              
            </div>

            <!--Segundo grupo -->
   
            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Terminos y Condiciones</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" id="agregar_terminos" checked value="4" name="terminos_condiciones[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_terminos" value="2" name="terminos_condiciones[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_terminos" value="1" name="terminos_condiciones[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
              
            </div>

            <!--Tercer grupo -->

           <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Tipos de contactos</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_tiposc" value="4" name="tipos_contactos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_tiposc" value="2" name="tipos_contactos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_tiposc" value="1" name="tipos_contactos[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
              
            </div>

           
         

            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Tipos de usuarios</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_tipoU" value="4" name="tipos_usuarios[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_tipoU" value="2" name="tipos_usuarios[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_tipoU" value="1" name="tipos_usuarios[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            </div>

             <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Valores</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de Insertar!">
                <input type="checkbox" autocomplete="off" checked id="agregar_valores" value="4" name="valores[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>

              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de Modificar!">
                <input type="checkbox" autocomplete="off" id="modificar_valores" value="2" name="valores[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
            
              <label class="btn btnUsuario btn-danger " data-toggle="tooltip" data-placement="top" title="¡Permiso de Eliminar!">
                <input type="checkbox" autocomplete="off" id="eliminar_valores" value="1" name="valores[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>      
              
            </div>
            <div class="btn-group col-md-6 col-lg-3 " data-toggle="buttons">
              <h5>Backup</h5>
              <label class="btn btn-info btnUsuario active " data-toggle="tooltip" data-placement="top" title="¡Permiso de exportar!">
                <input type="checkbox" autocomplete="off" checked value="4" name="backup[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>
              <label class="btn btn-success btnUsuario" data-toggle="tooltip" data-placement="top" title="¡Permiso de importar!">
                <input type="checkbox" autocomplete="off" value="2" name="backup[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>
              <label class="btn btn-danger btnUsuario " data-toggle="tooltip" data-placement="top" title="¡Permiso de eliminar!">
                <input type="checkbox" autocomplete="off" checked value="1" name="backup[]">
                <span class="glyphicon glyphicon-ok"></span>
              </label>
              
            </div>
           </div>
           </div>
           </div> 


      <button id="guardar_permiso"> Guardar</button>
    </form>    


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

    

   
  <!-- ./wrapper -->

  <!-- REQUIRED JS SCRIPTS -->

  <!-- jQuery 2.2.0 -->
  <script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="../publico/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/app.min.js"></script>
  <script src="plugins/datatables/jquery.dataTables.js"></script>

  <script src="plugins/datatables/dataTables.bootstrap.js"></script>
  <script>/*
    $(function () {
      $("#example1").DataTable();
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
    });*/ 
  </script>

  <!-- Optionally, you can add Slimscroll and FastClick plugins.
       Both of these plugins are recommended to enhance the
       user experience. Slimscroll is required when using the
       fixed layout. -->
  </body>
  </html>
