$(function () {
  /*Productos*/
  function img_a_pro(evt) {
      var files = evt.target.files; // FileList object

      // Obtenemos la imagen del campo "file".
      for (var i = 0, f; f = files[i]; i++) {
        //Solo admitimos imágenes.
        if (!f.type.match('image.*')) {
            continue;
        }

        var reader = new FileReader();

        reader.onload = (function(theFile) {
            return function(e) {
              // Insertamos la imagen
             $("#pro_img").attr("src", e.target.result );
             $("#pro_img").attr("tittle", escape(theFile.name) );
            };
        })(f);

        reader.readAsDataURL(f);
      }
  };
  if ( $('title').html() == "Agregar producto" || $('title').html() == "Editar producto" || $('title').html() == "Imagenes" || $('title').html() == "Redes sociales" || $('title').html() == "Editar datos" ) document.getElementById('pro_img_url').addEventListener('change', img_a_pro, false);
  //if ( $('title').html() == "Imagenes" ) $('#pro_img').height('200px');
  //
  /*Productos*/
  /*Img_prouctos*/
  jQuery.fn.e_imagenes = function() {
    var fila = $(this).parents("tr");
    var imagen_antigua = $(fila).find("img").attr("src");
    var presentacion = $(fila).find(".presentacion").html();
    //Se asignan las cosas ='DD
    $('#pro_img').attr('src', imagen_antigua );
    $('#imagen_antigua').attr('value', imagen_antigua );
    var elemento = $('#id_presentacion').find("option");
    for ( i = 0; i < elemento.size(); i++ ){
      if ( $(elemento[i]).html() == presentacion ) {
        $(elemento[i]).attr('selected','');
      }
      else{
        $(elemento[i]).removeAttr('selected');
      }
    }
    $('#btna_imagen').attr('value', 'Editar');
    $('#btna_imagen span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
    //Pasa el id ='D'
    var id_img_producto = $(this).attr( "id_img_producto" );
    $('#id_img_producto').attr( "value" , id_img_producto );
    $('#pro_img_url').removeAttr( 'required');//Quito el requiered
  };

  $( '#btn_cane_imagen' ).click(function() {
    /*var elemento = $('#id_presentacion').find("option");
    for ( i = 0; i < elemento.size(); i++ ){
      if ( i == 0 ) {
        //$(elemento[i]).removeAttr('disabled');
        $(elemento[i]).attr('selected','selected');
        //$(elemento[i]).attr('disabled','');
      }
      else{
        $(elemento[i]).removeAttr('selected');
      }
    }*/
    $('#id_img_producto').attr( "value" , '' );
    $('#btna_imagen').attr('value', 'Editar');
    $('#btna_imagen span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
    //
    $('#pro_img').attr('src', '../img/productos/logo.png' );
    $('#pro_img_url').attr( 'required');//Añado el requiered ='DD'
  });

  /*Tabla productos*/
  $('.conf_tabla').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false
  });
  //Bootrstarp tooltip :D
  $('[data-toggle="tooltip"]').tooltip();
  /*subir :)*/
  $('.up').click(function() {
    $('body,html').animate({
      scrollTop: 0 ,
      }, 300
    );
  });
  /*TODOS*/
  limpiar = setTimeout(function(){
    if ( $(document).find('div.alert') ){
      $(document).find('div.alert').fadeOut('slow');
    }
  }, 2000);
  /*Img_prouctos*/
  /*Categorias*/
  $('#btn-c_categoria').click(function() {
    $('#id_categoria').val( '' );
    $('#txtcategoria').val( '' );
    $('#btn_categoria').attr( 'value', "Agregar");
    $('#btn_categoria span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
  });

  jQuery.fn.e_categoria = function() {
    var id_categoria = $(this).attr( "id_categoria" );
    var fila = $(this).parents("tr");
    var categoria = $(fila).find('.categoria').html();  
    //Se asignan las cosas ='DD
    $('#id_categoria').val( id_categoria );
    $('#txtcategoria').val( categoria );
    $('#btn_categoria').attr('value', 'Editar');
    $('#btn_categoria span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };



  /*Categorias*/
  /*presentaciones*/
  $('#btn-c_presentacion').click(function() {
    $('#id_presentacion').val( '' );
    $('#txtpresentacion').val( '' );
    $('#btn_presentacion').attr( 'value', "Agregar");
    $('#btn_presentacion span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
  });


/*********************************************************************************/

  jQuery.fn.e_presentacion = function() {
    var id_presentacion = $(this).attr( "id_presentacion" );
    var fila = $(this).parents("tr");
    var presentacion = $(fila).find('.presentacion').html();  
    //Se asignan las cosas ='DD
    $('#id_presentacion').val( id_presentacion );
    $('#txtpresentacion').val( presentacion );
    $('#btn_presentacion').attr('value', 'Editar');
    $('#btn_presentacion span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };
  /*presentaciones*/
  /*inged*/
  /*imagenes index*/
  jQuery.fn.e_imagen_index = function() {
    var id_img_index = $(this).attr( "id_imagen" );
    var fila = $(this).parents("tr");
    var imagen = $(fila).find('.imagen').attr('src');
    //Se asignan las cosas ='DD
    $('#pro_img').attr( 'src', imagen );
    $('#imagen_antigua').val( imagen );
    $('#id_imagen').val( id_img_index );
    $('#btna_imagen').attr('value', 'Editar');
    $('#btna_imagen span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };
  $('#btn-c_imagen').click(function() {
    $('#id_imagen').val( '' );
    $('#pro_img').attr( 'src','../img/slider_index/logo.png' );
    $('#btna_imagen').attr( 'value', "Agregar");
    $('#btna_imagen span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
  });
  /*index*/

  /*redes sociales*/
  jQuery.fn.e_redes = function() {
    var id_red_social = $(this).attr( "id_red_social" );
    var fila = $(this).parents("tr");
    var imagen = $(fila).find('img').attr('src');
    //var imagen_antigua = $(fila).find('img').attr('src');
    var direccion = $(fila).find('.linkredes').html();
    //Se asignan las cosas ='DD
    $('#id_red_social').val( id_red_social );
    $('#pro_img').attr( 'src', imagen );
    $('#imagen_antigua').val( imagen );
    $('#txtred').val( direccion );
    $('#btn_redes').attr('value', 'Editar');
    $('#btn_redes span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };

  $('#btn-c_redes').click(function(e) {
    $('#id_presentacion').val( '' );
    $('#pro_img').attr( 'src', '../img/productos/logo.png' );
    $('#txtred').val( '' );
    $('#imagen_antigua').val( '' );
    $('#btn_redes').attr( 'value', "Agregar");
    $('#btn_redes span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
  });

  /*Preguntas frecuentes*/
  jQuery.fn.e_pregunta_frecuentes = function() {
    var id_pregunta_frecuente = $(this).attr( "id_pregunta_frecuente" );
    console.log(id_pregunta);
    var fila = $(this).parents("tr");
    var pregunta = $(fila).find('.pregunta').html();  
    var respuesta = $(fila).find('.respuesta').html();
    console.log(pregunta);

    //Se asignan las cosas ='DD
    $('#id_pregunta').val( id_pregunta_frecuente );
    $('#txtpregunta').val( pregunta );
    $('#txtrespuesta').val( respuesta );
    $('#btn_preguntas_frecuentes').attr('value', 'Editar');
    $('#btn_preguntas_frecuentes span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };
    $('#btncancelarP').click(function(e) {
    $('#id_presentacion').val( '' );
    $('#txtpregunta').val( '' );
    $('#txtrespuesta').val( '' );
    $('#btn_preguntas_frecuentes').attr( 'value', "Agregar");
    $('#btn_preguntas_frecuentes span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
  });

      /*Datos*/
   jQuery.fn.e_datos = function() {
    var id_datos = $(this).attr( "id_datos" );
    console.log(id_datos);
    var fila = $(this).parents("tr");
    var nombre = $(fila).find('.nombre').html();  
    var descripcion = $(fila).find('.descripcion').html();
    //console.log(pregunta);

    //Se asignan las cosas ='DD
    var elemento = $('#id_nombre_dato').find("option");
    for ( i = 0; i < elemento.size(); i++ ){
      if ( $(elemento[i]).html() == nombre ) {
        $(elemento[i]).attr('selected','');
      }
      else{
        $(elemento[i]).removeAttr('selected');
      }
    }
    $('#id_datos').val( id_datos );
    $('#txtdescripcion').val( descripcion );
    $('#btn_datos').attr('value', 'Editar');
    $('#btn_datos span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };
    $('#btncancelard').click(function(e) {
    $('#id_datos').val( '' );
    $('#txtdescripcion').val( '' );
    $('#btn_datos').attr( 'value', "Agregar");
    $('#btn_datos span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
  });








  /*comentarios*/
  $('.coment').click(function() {
    var fila = $(this).parents('tr');
    var id_comentario = $(fila).find('.id_comentario').attr('value');
    var producto = $(fila).find('.producto').html();
    var usuario = $(fila).find('.usuario').html();
    var fecha = $(fila).find('.fecha').html();
    var comentario = $(fila).find('.comentario').attr('value');
    //Pasar datos ='}'
    $('#lnombre_producto').html( producto );
    $('#lusuario').html( usuario );
    $('#lfecha_ingreso').html( fecha );
    $('#tcoment').html( comentario );
    //
    $('#a_eliminar').attr( 'href', ( 'eliminar.php?id=' + id_comentario ) );
    $('#id_comentario').attr( 'value', id_comentario );
  });
  /*comentarios*/
});