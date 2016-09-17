<?php
    //Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    Page::header("Catalogo");
    if(!empty($_POST)){
        if ( isset($_POST['categoria']) ) $categoria = $_POST['categoria'];
        if ( isset($_POST['presentacion']) ) $presentacion = $_POST['presentacion'];
        if ( isset($_POST['txtBuscar']) ) $busqueda = $_POST['txtBuscar'];
        if ( isset($_POST['txtBuscar']) && $_POST['txtBuscar'] != "" && ! Validator::letras($_POST['txtBuscar'] ) ) $error_busqueda = "Datos ingresados invalidos, solo se admiten palabras sin espacio.";
    }
    else if ( isset( $_GET['id'] ) && Validator::numero( base64_decode( $_GET['id'] ) ) ){
        $_GET['id'] = base64_decode( $_GET['id'] );
        $categoria = array ( $_GET['id'] );
    }
    else if ( isset( $_GET['error'] ) && base64_decode( $_GET['error'] ) == 1 ){
        $error = "Debe iniciar seción para visualizar la información del producto.";
    }
?>
<div class="container-fluid margin_top_navbar">
    <?php print ( ( isset($error) ) ? '<div class="alert alert-danger" role="alert">'.$error.'</div>' : "" ); ?>
    <form id="frmcatalogo" method="post" enctype="multipart/form-data" name="frmcatalogo">
        <div class="row">
            <div class="col-sm-3 col-md-3 col-lg-2">
                <?php print ( ( isset($error_busqueda) ) ? '<div class="alert alert-danger" role="alert">'.$error_busqueda.'</div>' : "" ); ?>
                <div class="input-group">
                    <span class="input-group-addon no_padding_input-group"><button data-toggle="tooltip" title="Click derecho para limpiar y recargar" data-placement="bottom" id="btnbuscar" type="submit" name="action" value="Buscar" class="glyphicon glyphicon-search nobtn padding_input-group"></button></span>
                    <input class="form-control" type="text" name="txtBuscar" id="txtBuscar" placeholder="Nombre producto..." value="<?php print((isset($busqueda) != "")?"$busqueda":""); ?>" />
                </div>
                <br>
                <div class="colordiv" id="divfiltros"><!--Se establece el filtro visible en computadoras de sm en adelanta-->
                    <p class="textcatalogo">Categoria</p>
                    <li class="divider-diego"></li>
                    <?php
                        require("../sql/conexion.php");
                        $consulta = "SELECT * FROM categorias order by categoria ASC";
                        $categorias = ""; //Arreglo de datos
                        foreach($PDO->query($consulta) as $datos){
                            //$categorias .= '<li name="estado" value="1" onclick="javascript:document.frmcatalogo.submit();" class="lfiltro ali_cbx"><input type="checkbox" aria-label="..."></li>';
                            $categorias .= '<div class="divfiltro ali_cbx">';
                                $categorias .= '<input class="with-gap" name="categoria[]" value="'.$datos['id_categoria'].'" id="c'.$datos['id_categoria'].'" type="checkbox" onclick="javascript:document.frmcatalogo.submit();"';
                                if ( isset( $categoria ) ){
                                    foreach ($categoria as $key) {
                                        if ( $datos['id_categoria'] == $key ) $categorias .= ' checked';
                                    }
                                }
                                $categorias .= '/><label for="c'.$datos['id_categoria'].'" class="lblfiltro stseparator">'.$datos['categoria'].'</label>';
                            $categorias .= '</div>';
                        }
                        print($categorias);
                        $PDO = null;
                    ?>
                </div>
                <!--Se agrega el div de marcas ='DDD-->
                <div class="colordiv" id="divmarcas"><!--Se establece el filtro visible en computadoras de sm en adelanta-->
                    <p class="textcatalogo">Presentacion</p>
                    <li class="divider-diego"></li>
                    <!--ul id="lfiltro"<!------<!Hacen un margen que no quiero tratar de editar>
                    <!Necesito una lista para el efecto hover ='DD-->
                    <?php
                        require("../sql/conexion.php");
                        $consulta = "SELECT * FROM presentaciones order by presentacion ASC";
                        $categorias = ""; //Arreglo de datos
                        foreach($PDO->query($consulta) as $datos){
                            //$categorias .= '<li name="estado" value="1" onclick="javascript:document.frmcatalogo.submit();" class="lfiltro ali_cbx"><input type="checkbox" aria-label="..."></li>';
                            $categorias .= '<div class="divfiltro ali_cbx">';
                                $categorias .= '<input class="with-gap" name="presentacion[]" value="'.$datos['id_presentacion'].'" id="p'.$datos['id_presentacion'].'" type="checkbox" onclick="javascript:document.frmcatalogo.submit();"';
                                if ( isset( $presentacion ) ){
                                    foreach ($presentacion as $key) {
                                        if ( $datos['id_presentacion'] == $key ) $categorias .= ' checked';
                                    }
                                }
                                $categorias .= '/><label for="p'.$datos['id_presentacion'].'" class="lblfiltro stseparator">'.$datos['presentacion'].'</label>';
                            $categorias .= '</div>';
                        }
                        print($categorias);
                        $PDO = null;
                    ?>
                    
                </div>
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 conf_tabla" id="divarticulosC"><!--Donde se mostraran TODOS los articulos-->
                <div class="row">
                    <?php
                        require("../sql/conexion.php");
                        //select * from productos limit 1 offset 3
                        //select * from productos limit 3,1
                        $consulta = "SELECT id_producto, categorias.id_categoria, categoria, nombre_producto, precio_producto, estado FROM (productos inner join categorias on categorias.id_categoria = productos.id_categoria)";
                        if ( isset( $categoria ) ){
                            $contador = 0;
                            foreach ($categoria as $key) {
                                if ( $contador == 0 )$consulta .=  " where (categorias.id_categoria = $key";
                                else $consulta .=  " or categorias.id_categoria = $key";
                                $contador++;
                            }
                            $consulta .=  ")";
                            $where_estado = true;
                        }
                        //SELECT id_producto, categorias.id_categoria, categoria, nombre_producto, precio_producto, estado FROM (productos inner join categorias on categorias.id_categoria = productos.id_categoria)
                        if ( isset( $presentacion ) ){
                            $contador = 0;
                            foreach ($presentacion as $key) {
                                if ( $contador == 0 && !isset( $categoria ) ) $consulta .=  "  where (SELECT count(id_presentacion) from img_productos where ( id_presentacion = $key ";
                                else if ( $contador == 0 && isset( $categoria ) ) $consulta .=  "  and (SELECT count(id_presentacion) from img_productos where ( id_presentacion = $key ";
                                else $consulta .=  "or id_presentacion = $key ";
                                $contador++;
                            }
                            $consulta .=  ") and img_productos.id_producto = productos.id_producto) > 0";
                            $where_estado = true;
                        }
                        //require ('../lib/validator.php');
                        if( isset($_POST['txtBuscar']) && $_POST['txtBuscar'] != "" && Validator::letras($_POST['txtBuscar']) ){
                            if ( ! isset( $presentacion ) && ! isset( $categoria ) ) $consulta .= " where nombre_producto LIKE '%$busqueda%'";
                            else  $consulta .= " and nombre_producto LIKE '%$busqueda%'";
                            $where_estado = true;
                        }
                        ( ! isset( $where_estado ) ) ? $consulta .=  " where estado = 1 order by nombre_producto ASC" : $consulta .=  " and estado = 1 order by nombre_producto ASC";
                        //print('<a>'.$consulta.'</a>');
                        require ('../lib/paginacion.php');
                        $Paginacion = new Paginacion();
                        $records_per_page=9;
                        $newconsulta = $Paginacion->paging($consulta,$records_per_page);//Me regresa la consulta con el limit, claro que cada vez que le des uno al paging, lo modifica :)
                        //
                        $stmt = $PDO->prepare($newconsulta);
                        $stmt->execute();
                        $productos = ""; //Arreglo de datos
                        if( $stmt->rowCount() > 0 ){
                            foreach($PDO->query($newconsulta) as $datos){
                                //Seleccionamos la imagen :)
                                $contador = 0;
                                $sql = "SELECT id_img_producto, imagen_producto FROM img_productos where id_producto = ?";
                                if ( isset($presentacion) ){
                                    foreach ($presentacion as $key) {
                                        if ( $contador == 0 ) $sql .=  " and ( id_presentacion = $key ";
                                        else $sql .=  "or id_presentacion = $key ";
                                        $contador++;
                                    }
                                    $sql .=  ")";
                                }
                                $stmt = $PDO->prepare($sql);
                                $stmt->execute( array ( $datos['id_producto'] ) );
                                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                                //
                                if ( $data['imagen_producto'] == null ){
                                    $sql = "SELECT id_img_producto, imagen_producto FROM img_productos where id_producto = ?";
                                    $stmt = $PDO->prepare($sql);
                                    $stmt->execute( array ( $datos['id_producto'] ) );
                                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                                }
                                //Seleccionamos la imagen
                                $productos .= '<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 nuevo_padding">';
                                    $productos .= '<div class="colordiv divarticulos thumbnail">';
                                        $productos .= '<a class="enlacesinf" href="infoarticulo.php?id='.base64_encode($data['id_img_producto']).'">';
                                            $productos .= '<img id_imagen="'.$data['id_img_producto'].'" src="../img/productos/'.$data['imagen_producto'].'" alt="" class="img-responsive img-catalogo porefec_apare">';
                                            $productos .= '<li class="divider-diego porefec_apare"></li>';
                                            $productos .= '<div class="row">';
                                                $productos .= '<div class=" col-xs-7 col-sm-7 col-md-7 col-lg-7 col-lg-offset-1">';
                                                    $productos .= '<div class="tex_nom_p">';
                                                        $productos .= '<h4 class="tamaop porefec_apare">'.$datos['nombre_producto'].'</h4>';
                                                    $productos .= '</div>';
                                                $productos .= '</div>';
                                                $productos .= '<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">';
                                                    $productos .= '<div class="precio">';
                                                        ( isset( $_SESSION['nombre_cliente'] ) ? $productos .= '<h4 class=" porefec_apare" >$'.$datos['precio_producto'].'</h4>' : "" );
                                                    $productos .= '</div>';
                                                $productos .= '</div>';
                                            $productos .= '</div>';
                                            $productos .= '<div class="row">';
                                                $productos .= '<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 padding_left_nojs">';
                                                    //Sacar calificacion del producto acumulada :D
                                                    $sql = "select ROUND( AVG(calificacion_producto),1 ) Prom from calificacion_productos where id_producto=?";
                                                    $stmt = $PDO->prepare($sql);
                                                    $stmt->execute( array ( $datos['id_producto'] ) );
                                                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                                                    //
                                                    //$productos .= '<span class="glyphicon porefec_apare">'.$data['Prom'].'</span>';
                                                    for ($i = 1 ; $i <= $data['Prom']; $i++) {
                                                        $productos .= '<span class="fa fa-star porefec_apare"></span>';
                                                    }
                                                    if ( substr($data['Prom'], -1) > 0 ) $productos .= '<span class="fa fa-star-half-o porefec_apare"></span>';
                                                $productos .= '</div>';
                                                $productos .= '<div class="col-xs-5 col-sm-5 col-md-5 col-lg-8 col-lg-offset-4">';
                                                    $productos .= '<a><button type="button" class="btn btn-default btnisa porefec_apare btn-comprar" onclick="javascript: catalogo_carrito( $(this) );"><i class="material-icons">shopping_cart</i></button></a>';
                                                $productos .= '</div>';
                                            $productos .= '</div>';
                                        $productos .= '</a>';
                                    $productos .= '</div>';
                                $productos .= '</div>';
                            }
                            print($productos);
                            $PDO = null;
                            ?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center">
                                <div class="pagination-wrap paginacion">
                                <?php $Paginacion->paginglink($consulta,$records_per_page,null); ?>
                                </div>
                            </div>
                        <?php
                        }
                        else
                        {
                            ?>
                            <label class="size no_datos treintapx" align="center">No se encuentran productos...</label>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </form>
</div>
<br>
<br>
<br>
<br>
<br>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>