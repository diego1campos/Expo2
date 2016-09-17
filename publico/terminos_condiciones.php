<?php
  //Se establece todas las clases o funciones necesarias ='D'
  require("../lib/database.php");
  require("../lib/validator.php");
  //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
  require("../lib/page.php");
  //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
  Page::header("Terminos y condiciones");
?>
<h1 id="Gterminos" class="margin_top_navbar text-center">
  TÉRMINOS Y CONDICIONES
</h1>
<div class="container-fluid Gterminoscolor">
  <div class="row">
    <div class="col-lg-10 col-lg-offset-1 margeninferiorterminos">
      <p class="fterminocolor">
        Antes de usar este sitio Web. Estos Términos y Condiciones se
        aplican a todas las visitas y uso que se hagan del Sitio, así como al Contenido (conforme se define más adelante), la información, 
        recomendaciones y/o servicios que se le proporcionan a través del Sitio. Al acceder y usar el Sitio, usted manifiesta su consentimiento 
        a estos Términos y Condiciones en su totalidad, además de manifestar su aceptación a lo dispuesto en cualquier otra ley o reglamentació
        n que se aplique al Sitio, la Internet, y/o la Red Mundial o World Wide Web. Abandone el Sitio, si no está de acuerdo con estos Términos
        y Condiciones en su totalidad.
      </p>
    </div>
    <div class="col-lg-10 col-lg-offset-1">
      <?php
          require("../sql/conexion.php");
          $consulta = "SELECT * from terminos_condiciones order by termino asc";
          $productos = ""; //Arreglo de datos
          foreach($PDO->query($consulta) as $datos){
          $productos .= "<div class='panel-body margeterminos'>";
          $productos .= "<div class='panel-group' id='accordion'>";
          $productos .= "<tr>";
          $productos .= "<div class='panel panel-default'>";
          $productos .= "<div class='panel-heading '>";
          $productos .= "<h4 class='panel-title'>";
          $productos .= "<a data-toggle='collapse' data-parent='#accordion' href='#collapse1' class='Gtematerminos'> ";
          $productos .= "<td>$datos[termino]</td>";
          $productos .= "</a>";
          $productos .= "</h4>";
          $productos .= "</div>";
          $productos .= "<div id='collapse1' class='panel-collapse collapse in'>";
          $productos .= "<div class='panel-body Gdescripcion'>";
          $productos .= "<td>$datos[descripcion]</td>";
          $productos .= '</div>';
          $productos .= '</div>';
          $productos .= '</div>'; 
          $productos .= '</div>';
          $productos .= '</div>';        
          }
          print($productos);
          $PDO = null;
      ?>
    </div>
  </div>
</div>
<br>
<br>
<br>
<br>
<br>

<?php Page::footer(); ?>