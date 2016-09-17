<?php

		print ( ( isset( $error ) ) ? '<div class="alert alert-danger" role="alert">'.$error.'</div>' : "" ); ?>
		<div class="col-sm-12 col-md-12 col-lg-12 ">
			<h3> <?php print ( ( isset($cosa) != "" ) ? "¿Desea eliminar ". $cosa ."?" : ""); ?> </h3>
		</div>
		<div class="col-sm-8 col-md-8 col-lg-8">
			<div class="col-sm-6 col-md-6 col-lg-6">
				<br>
				<button type="submit" name="action" class="btn btn-primary size">
			        <span class="glyphicon glyphicon-plus"></span>
			    </button>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6">
				<br>
				<a href=" <?php print ( ( isset($pag_cancelar) != "" ) ? $pag_cancelar : ""); ?> "><button type="button" class="btn btn-danger margin_top size">
			        <span class="glyphicon glyphicon-remove"></span>
			    </button></a>
			    <br>
			    <br>
			</div>
		</div>
	</div><!--cierro el box-body =D-->
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>