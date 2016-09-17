<?php 
  require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    Page::header("Historia");
?>


<div id="fullpage">

	<!--Imagen principal-->
	<div class="section imgisa" id="section0">
		 <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="brand-heading stroke letraH1enHistoria">ISA DELI & SMOKE HOUSE</h1>
                        <p class="intro-text stroke">Ofrecemos el verdadero sabor de la casa desde 1962</p>
                        
                    </div>
                </div>
            </div>
        </div>
	</div>
        
	<div class="section imgHis" id="section1">
		<div class="row">
            <div class="col-lg-8 col-lg-offset-2 fWhite">
            	<div class="trans">
	                <?php
                require("../sql/conexion.php");
                $consulta = "SELECT D.nombre, D.descripcion from datos D where nombre='Historia'";
                
                $tabla = ""; //Arreglo de datos
                foreach($PDO->query($consulta) as $datos)
                {
                    $tabla .= "<h2 class='text-center  letraH1enHistoria fBlack '>$datos[nombre]</h2>";
                    $tabla .= " <p class='justi  fBlack'>$datos[descripcion] </p>";
                }
                print($tabla);
                $PDO = null;
            ?> 
	                </p>
                </div>
            </div>
		</div>
	</div>


	<div class="section imgVismi img-responsive" id="section2">
	    <div class="slide" id="slide1">
	    	<div class="col-lg-8 col-lg-offset-2 fWhite">
            	<div class="vismi">
            	        <?php
                require("../sql/conexion.php");
                $consulta = "SELECT D.nombre, D.descripcion from datos D where nombre='vision'";
                
                $tabla = ""; //Arreglo de datos
                foreach($PDO->query($consulta) as $datos)
                {
                    $tabla .= "<h2 class='text-center  letraH1enHistoria '>$datos[nombre]</h2>";
                    $tabla .= " <p class='text-center'>$datos[descripcion] </p>";
                }
                print($tabla);
                $PDO = null;
            ?> 
            	        <?php
                require("../sql/conexion.php");
                $consulta = "SELECT D.nombre, D.descripcion from datos D where nombre='mision'";
                
                $tabla = ""; //Arreglo de datos
                foreach($PDO->query($consulta) as $datos)
                {
                    $tabla .= "<h2 class='text-center  letraH1enHistoria '>$datos[nombre]</h2>";
                    $tabla .= " <p class='text-center'>$datos[descripcion] </p>";
                }
                print($tabla);
                $PDO = null;
            ?> 
				</div>
			</div>
	   	</div>
			

	
				

		<div class="slide" id="slide1">

			<div class="col-lg-8 col-lg-offset-2 fWhite">
            	<div class="valores">
					<h2 class="text-center  letraH1enHistoria ">Valores</h2>

					<p class="text-center">Honestidad: Profesional y personal en nuestra labor.</p>

					<p class="text-center">Responsabilidad: Con nuestros compromisos y en el cumplimiento de nuestros servicios.</p>

					<p class="text-center">
					Compromiso: Con las necesidades de cada uno de nuestros clientes interno y externo.</p>

					<p class="text-center">
					Fidelidad: Para con los clientes internos y externos.</p>
				</div>
	   		</div>
			


		</div>

	  
	</div>
	
</div>


	<script src="js/jquery-1.11.2.min.js"></script>
	<script src="js/jquery-ui-1.9.2.custom.min.js"></script>

	<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
	
	<script type="text/javascript" src="js/jquery.fullPage.js"></script>
	<script type="text/javascript" src="js/examples.js"></script>
	
	<script type="text/javascript" src="js/bootstrap.min.js"></script>



</body>
</html>
