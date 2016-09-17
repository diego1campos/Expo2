<?php
    //Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    //Page::header( print( ( isset( $_GET['error'] ) && base64_decode( $_GET['error'] ) == 1 ) ? "Error 404" : "Error 403" ) );
    Page::header( "Error 404" );
?>
<div class="container-fluid margin_top_navbar">

<br>
<br>
<br>
<br>
<br>
<br>
<div class="page-header">
  <h1><?php print ( ( isset( $_GET['error'] ) && base64_decode( $_GET['error'] ) == 1 ) ? 'Dirección de pagina invalida' : "No tiene permisos para realizar esta accion." ); ?> <small>ISADELI</small></h1>
</div>

</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<!Se añade el pie de pagina ='DDD>
<?php
  $footer =   '<footer>
            <div class="row">
              <div class="divider-diego size"></div>
                <div class="col-xs-4 col-md-4 col-sm-4 col-xs-mod">
                  <ul class="footer">
                    <li class="footerlititulo">Servicio al cliente</li>
                    <li><a href="#">Preguntas frecuentes</a></li>
                    <li><a href="#">Contactanos</a></li>
                    <li><a href="#">Terminos y condiciones</a></li>
                  </ul>
                </div>
                <div class="col-xs-4 col-md-4 col-sm-4 col-xs-mod">
                  <ul class="footer">
                    <li class="footerlititulo">Conocenos</li>
                    <li><a href="#">Misión, Visión y Valores</a></li>
                  </ul>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xs-mod">
                  <ul class="footer">
                    <li class="footerlititulo">Siguenos</li>
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">';
                      $consulta = "SELECT * FROM redes_sociales order by id_red_social ASC";
                        //$red_social = "";
                        $red_social = Database::getRows($consulta, null);
                        foreach($red_social as $data){
                          $footer .=
                          '<a href="'.$data['url_red_social'].'" target="_blank">
                          <img class="img-responsive imgcircular contactos" src="../img/redes_sociales/'.$data['logo_red_social'].'" alt="'.$data['logo_red_social'].'" />
                              </a>';
                        }
              $footer .= '
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" id="fcontac">';
                      // inner join tipos_contactos on tipos_contactos.id_tipo_contacto = contactos_empresa.id_tipo_contacto
                        $consulta = "SELECT contacto_empresa FROM contactos_empresa order by id_contacto_empresa ASC";
                        $contacto_empresa = Database::getRows($consulta, null);
                        foreach($contacto_empresa as $data){
                          $footer .=
                          '<li>'.$data['contacto_empresa'].'</li>';
                        }
              $footer .= '
                      <li>¡Con gusto te antenderemos!</li>
                      </div>
                    </div>
                 </ul>
              </div>
            </div>
          </footer>

          <script src="../publico/js/jquery-2.2.3.min.js"></script>

          <script src="../publico/js/sweet-alert.js"></script>

          <script src="../publico/js/bootstrap.min.js"></script>

          <script src="../publico/js/mainD.js"></script>

          <script src="../publico/js/star-rating.min.js"></script><!-- Calificacion -->

          <!--script src="../publico/js/main2.js"--></script>';

  //$footer .= /*( $articulo == true ) ? */'<script src="js/star-rating.min.js"></script><!-- Calificacion -->'/* : ''*/;

    $footer .= '</body>

          </html>';
    print($footer);
?>