//entregas xdd
$('#btn-c-horario').click(function() 
{
    $('input').val( '' );
    $('select').val( 0 );
    $('#btn-horario span')
      .addClass('glyphicon-edit')
      .removeClass('glyphicon-plus');
 });

jQuery.fn.e_entregas = function() 
{
  var id_horario_entrega = $(this).attr("id_horario_entrega");
  var dia = $(this).attr("dia");
  var hora_inicial = $(this).attr("hora_inicial");
  var hora_final = $(this).attr("hora_final");
  var estado = $(this).attr("estado");
  $('#id_horario_entrega').val(id_horario_entrega);
  $('#dia').val(dia);
  $('#time').val(hora_inicial);
  $('#time2').val(hora_final);
  $('#estado').val(estado);
  $('#btn-horario').attr('value', 'Editar');

  $('#btn-horario span')
  .removeClass('glyphicon-plus')
  .addClass('glyphicon-edit');
};

//entregas xdd

/*redes sociales*/
$( document ).ready(function() {
  //Datepicker
  //if ( $('title').html() == "Horarios mas usados" || "Productos con mejor calificación" || "Productos más vendidos" || "Productos más vendidos" || "Presentaciones por producto" || "Bitacora" ){
    $('.fecha_picker').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    });
  //}
  //Datepicker
  
  if ( $( 'title' ).html() == 'Redes sociales' ) $('#pro_img').css('height','100px');

  /*Modificar permiso*/
  if ( $('title').html() == "Modificar permiso" ){
    
    if ( $('#id_tipo_usuario').attr( 'value' ) != null ){
      var id = $('#id_tipo_usuario').attr( 'value' );
      //$('#form_tpusuarios')[0].reset();

      //AJAX para obtener permisos :D
      var url = '../privado/obtener.php';
      $.ajax({
        type:'POST',
        url:url,
        data: "id=" + id,
        success: function(valores){
          var datos = eval(valores);
          //nombre de los named en permisos 
          var cp = ['Nombre_permiso','calificacion_productos','categorias','clientes','comentarios_productos','contactos_empresa','datos','detalles_pedidos','detalles_pedidos_local',
              'direcciones','empleados','entregar_pedidos','existencias','horarios_entrega','index_imagenes','img_productos','pedidos','pedidos_local',
              'preguntas','preguntas_frecuentes','presentaciones','productos','redes_sociales','terminos_condiciones','tipos_contactos','tipos_usuarios','valores', 'backup'];

          $('#txtNombreTU').val(datos[0]);//Lo que devuelve el json puro en la casilla 0

          for (var i = 1; i <= datos.length; i++) {
            //Permiso de agregar
            if( datos[i] == 4 || datos[i] == 5 || datos[i] == 6 || datos[i] == 7 ){
              $('input[name="'+cp[i]+'[]"][value=4]').attr( 'checked', 'checked' );
              $('input[name="'+cp[i]+'[]"][value=4]').parent().addClass( 'active' );
            }
            //Permiso de modificar
            if( datos[i] == 2 || datos[i] == 3 || datos[i] == 6 || datos[i] == 7 ){
              $('input[name="'+cp[i]+'[]"][value=2]').attr( 'checked', 'checked' );
              $('input[name="'+cp[i]+'[]"][value=2]').parent().addClass( 'active' );
            }
            //Permiso de eliminar
            if( datos[i] == 1 || datos[i] == 3 || datos[i] == 5 || datos[i] == 7 ){
              $('input[name="'+cp[i]+'[]"][value=1]').attr( 'checked', 'checked' );
              $('input[name="'+cp[i]+'[]"][value=1]').parent().addClass( 'active' );
            }
          }
          return false;
        }
      });
      return false;
    }
  }
  /*Modificar permiso*/
});
/*redes sociales*/
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
  if ( $('title').html() == "Agregar producto" || $('title').html() == "Editar producto" || $('title').html() == "Imagenes productos" || $('title').html() == "Agregar empleado" || $('title').html() == "Modificar empleado" || $('title').html() == "Redes Sociales" || $('title').html() == "Categorias" || $('title').html() == "Registrar primer usuario" ) document.getElementById('pro_img_url').addEventListener('change', img_a_pro, false);
  //if ( $('title').html() == "Imagenes" ) $('#pro_img').height('200px');
  //
  /*Productos*/
  /*Img_prouctos*/
  jQuery.fn.e_imagenes = function() {
    up();
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
    $('#btna_imagen').attr('value', 'Agregar');
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
  //$('[data-toggle="tooltip"]').tooltip();
  /*subir :)*/
  function up (){
    $('body,html').animate({
      scrollTop: 0 ,
      }, 300
    );
  }
  /*TODOS*/
  /*limpiar-mensaje*/
  /*limpiar = setTimeout(function(){
    if ( $(document).find('div.alert') ){
      $(document).find('div.alert').fadeOut('slow');
    }
  }, 2000);*/
  /*limpiar-mensajes*/
  /*Img_prouctos*/
  /*Categorias*/
  $('#btn-c_categoria').click(function() {
    $('#id_categoria').val( '' );
    $('#txtcategoria').val( '' );
    $('#btn_categoria').attr( 'value', "Agregar");
    $('#btn_categoria span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
    $('#pro_img').attr('src', '../img/logo.png' );//reseteamos la imagen
    $('#imagen_antigua').attr('value', '' );
  });

  jQuery.fn.e_categoria = function() {
    up();
    var id_categoria = $(this).attr( "id_categoria" );
    var fila = $(this).parents("tr");
    var categoria = $(fila).find('.categoria').html();  
    var imagen_antigua = $(fila).find("img").attr("src");//Imagen categoria
    //Se asignan las cosas ='DD
    $('#pro_img').attr('src', imagen_antigua );//Imagen categoria
    $('#imagen_antigua').attr('value', imagen_antigua );
    $('#id_categoria').val( id_categoria );
    $('#txtcategoria').val( categoria );
    $('#btn_categoria').attr('value', 'Editar');
    $('#btn_categoria span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };
  /*Categorias*/
  /*Existencias*/
  $('#btn-c_existencias').click(function() {
    $('#id_existencia').val( '' );
    $('#existencias').val( '' );
    $('#btn_existencias').attr( 'value', "Agregar");
    $('#btn_existencias span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
  });

  jQuery.fn.e_existencia = function() {
    up();
    var id_existencia = $(this).attr( "id_existencia" );
    var fila = $(this).parents("tr");
    var existencias = $(fila).find('.existencias').html();  
    var id_presentacion = $(fila).find('td[id_presentacion]').attr( 'id_presentacion' );
    //Se asignan las cosas ='DD
    $('#id_existencia').val( id_existencia );
    $('#id_presentacion').val( id_presentacion );
    $('#existencias').val( existencias );
    $('#btn_existencias').attr('value', 'Editar');
    $('#btn_existencias span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };
  /*existencias*/
  /*presentaciones*/
  $('#btn-c_presentacion').click(function() {
    $('#id_presentacion').val( '' );
    $('#txtpresentacion').val( '' );
    $('#btn_presentacion').attr( 'value', "Agregar");
    $('#btn_presentacion span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
  });

  jQuery.fn.e_presentacion = function() {
    up();
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
  /*comentarios*/
  jQuery.fn.coment = function() {
    up();
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
    $('#a_eliminar').attr( 'href', ( 'eliminar_comentario.php?id=' + id_comentario ) );
    $('#id_comentario').attr( 'value', id_comentario );
  };
  /*comentarios*/

  /*Preguntas*/
  $('#btn-c_pregunta').click(function() {
    $('#id_pregunta').val( '' );
    $('#txtpregunta').val( '' );
    $('#btn_pregunta').attr( 'value', "Agregar");
    $('#btn_pregunta span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
  });

  jQuery.fn.e_pregunta = function() {
    up();
    var id_pregunta = $(this).attr( "id_pregunta" );
    console.log(id_pregunta);
    var fila = $(this).parents("tr");
    var pregunta = $(fila).find('.pregunta').html();  
    console.log(pregunta);
    //Se asignan las cosas ='DD
    $('#id_pregunta').val( id_pregunta );
    $('#txtpregunta').val( pregunta );
    $('#btn_pregunta').attr('value', 'Editar');
    $('#btn_pregunta span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };
  /*Preguntas*/

  /*Tipo contacto*/
  $('#btn-c_Tcontacto').click(function() {
    $('#id_tipo_contacto').val( '' );
    $('#txtcontacto').val( '' );
    $('#btn_Tcontacto').attr( 'value', "Agregar");
    $('#btn_Tcontacto span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
  });

  jQuery.fn.e_Tcontacto = function() {
    up();
    var id_tipo_contacto = $(this).attr( "id_tipo_contacto" );
    console.log(id_tipo_contacto);
    var fila = $(this).parents("tr");
    var tipo_contacto = $(fila).find('.tipo_contacto').html();  
    console.log(tipo_contacto);
    //Se asignan las cosas ='DD
    $('#id_tipo_contacto').val( id_tipo_contacto );
    $('#txtcontacto').val( tipo_contacto );
    $('#btn_Tcontacto').attr('value', 'Editar');
    $('#btn_Tcontacto span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };
  /*Tipo contacto*/

  

  /*contacto empresa */
    $('#btn-c_ContactoE').click(function() {
    $('#id_tipo_contacto').val( '' );
    $('#txtcontacto_empresa').val( '' );
    $('#btn_contactoE').attr( 'value', "Agregar");
    $('#btn_contactoE span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
  });

  jQuery.fn.e_Contactoe = function() {
    var fila = $(this).parents("tr");
    up();
    var tipo_contacto = $(fila).find(".tipo_contacto").html();
    //Se asignan las cosas ='DD
    var elemento = $('#id_tipo_contacto').find("option");
    for ( i = 0; i < elemento.size(); i++ ){
      if ( $(elemento[i]).html() == tipo_contacto ) {
        $(elemento[i]).attr('selected','');
      }
      else{
        $(elemento[i]).removeAttr('selected');
      }
    }
    var id_contacto_empresa = $(this).attr( "id_contacto_empresa" );
    var tipo_contacto = $(fila).find('.contacto_empresa').html();
    //Se asignan las cosas ='DD
    $('#id_contacto_empresa').val( id_contacto_empresa );
    $('#txtcontacto_empresa').val( tipo_contacto );
    $('#btn_contactoE').attr('value', 'Editar');
    $('#btn_contactoE span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };
  /*contacto empresa */

  /*imagenes index*/
  jQuery.fn.e_imagen_index = function() {
    var id_img_index = $(this).attr( "id_imagen" );
    var fila = $(this).parents("tr");
    var imagen = $(fila).find('.imagen').attr('src');
    //Se asignan las cosas ='DD
    $('#imagen_indexx').attr( 'src', imagen );
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
    $('#pro_img').attr( 'src', '../img/logo.png' );
    $('#txtred').val( '' );
    $('#imagen_antigua').val( '' );
    $('#btn_redes').attr( 'value', "Agregar");
    $('#btn_redes span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
  });
  /*redes sociales*/

   /*cargo pedidos
 */
  jQuery.fn.e_cargo_pedidos = function() {
    var id_cargo = $(this).attr( "id_cargo_pedidos" );
    console.log(id_cargo);
    var fila = $(this).parents("tr");
    var cargo_pedido = $(fila).find('.cargo').html();  
    console.log(cargo_pedido);

    //Se asignan las cosas ='DD
    $('#id_cargo_pedido').val( id_cargo );
    $('#txtcargo').val( cargo_pedido );
    $('#btn_cargo_pedidos').attr('value', 'Editar');
    $('#btn_cargo_pedidos span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };
    $('#btncancelarCP').click(function(e) {
    $('#id_presentacion').val( '' );
    $('#txtcargo').val( '' );
  });

   /*producto minimo
 */
  jQuery.fn.e_pro_min = function() {
    var id_pro_min = $(this).attr( "id_pro_min" );
    console.log(id_pro_min);
    var fila = $(this).parents("tr");
    var pro_min = $(fila).find('.pro_min').html();  
    console.log(pro_min);

    //Se asignan las cosas ='DD
    $('#id_producto_min').val( id_pro_min );
    $('#txtpro_min').val( pro_min );
    $('#btn_pro_min').attr('value', 'Editar');
    $('#btn_pro_min span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };
    $('#btncancelarPM').click(function(e) {
    $('#id_producto_min').val( '' );
    $('#txtpro_min').val( '' );
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
    /*Preguntas frecuentes*/

    /*terminos y condiciones*/
    jQuery.fn.e_termino_condicion = function() {
    var id_termino = $(this).attr( "id_termino_condicion" );
    console.log(id_termino);
    var fila = $(this).parents("tr");
    var termino = $(fila).find('.terminos').html();  
    var descripcion = $(fila).find('.descripcion').html();
    console.log(termino);

    //Se asignan las cosas ='DD
    $('#id_termino').val( id_termino );
    $('#txttermino').val( termino );
    $('#txtdescripcion').val( descripcion );
    $('#btn_termino').attr('value', 'Editar');
    $('#btn_termino span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };
    $('#btncancelarTC').click(function(e) {
    $('#id_termino').val( '' );
    $('#txttermino').val( '' );
    $('#txtdescripcion').val( '' );
    $('#btn_termino').attr( 'value', "Agregar");
    $('#btn_termino span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
  });

/*Valores*/
    jQuery.fn.e_valor = function() {
    var id_valor = $(this).attr( "id_valor" );
    console.log(id_valor);
    var fila = $(this).parents("tr");
    var valor = $(fila).find('.valor').html();  
    var descripcion = $(fila).find('.descripcion').html();
    console.log(valor);

    //Se asignan las cosas ='DD
    $('#id_valor').val( id_valor );
    $('#txtvalor').val( valor );
    $('#txtdescripcion').val( descripcion );
    $('#btn_valor').attr('value', 'Editar');
    $('#btn_valor span')
      .removeClass('glyphicon-plus')
      .addClass('glyphicon-edit');
  };
    $('#btncancelarV').click(function(e) {
    $('#id_valor').val( '' );
    $('#txttermino').val( '' );
    $('#txtdescripcion').val( '' );
    $('#btn_valor').attr( 'value', "Agregar");
    $('#btn_valor span')
      .addClass('glyphicon-plus')
      .removeClass('glyphicon-edit');
  });
 /*Datos*/

});//<---No tocar xd

/*DIEGO(lo que me faltaba)*/
/*Actualizar pedidos*/
function actualizar_pedidos(){
  if ( $('title').html() == "Pedidos" && $('#pedidos_tabla') != null ){
    $.ajax({
      type:'POST',
      url:'pedidos-ajax.php',
      data:null,
      success: function(datos){
        var pedidos = eval( datos );
        $('#pedidos_tabla').html( pedidos );
      }
    });
    return false;
  }
}
/*Actualizar pedidos--cont*/

setInterval( "actualizar_pedidos()", 1000 );//3600000
/*Actualizar pedidos-fin xd*/

/*LOGIN - AJAX*/
$('#btncontinuar').click(function(e) {
//jQuery.fn.btncontinuar = function() {
  recuperar_contra();
});

/*funcion recuperar contra*/
function recuperar_contra( oficialxd ) {//Si de veras le dio a olvidar contra
  /*btn 1 paso*/
  $('.alert').fadeOut('slow');
  if ( $('#btncontinuar').attr('value') == 1 || oficialxd != null ){
    $.ajax({
      type:'POST',
      url: 'login-ajax.php',
      data: 'accion=1' + ( ( oficialxd != null ) ? ('&usuario=' + oficialxd) : "" ),//Asignar los datos
      success: function(valores){
        var datos = eval(valores);
        if ( datos === false ) swal( "Error.", "Usuario invalido, solo se admiten numeros y letras." );
        else if ( datos == "noexiste" ) swal( "Error.", "Usuario no encontrado." );
        else{
          $('.login-box-msg').remove();
          $('button[name=no]').parent().remove();
          $('.ocultar').css('display','none');
          $('#datos_recuperar').html( datos );
          $('#btncontinuar').parent().attr('class', 'col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8');
          $('#btncontinuar').attr({
                                    'value': "2",
                                    'type': "button"
                                  })
                            .html('Continuar');
        }
      }
    });
    return false;
  }
  /*btn 1 paso*/
  else if ( $('#btncontinuar').attr('value') == 2 ){
  /*paso2*/ 
    $.ajax({
      type:'POST',
      url: 'login-ajax.php',
      data: 'respuesta=' + $('#respuesta').val(),//Asignar los datos
      success: function(valores){
        var datos = eval(valores);
        if ( datos == "validacion" ) swal( "Error.", "Solo se admiten numeros y letras." );
        else if ( datos == "respuestainc" ) swal( "Error.", "Respuesta incorrecta." );
        else{
          $('#datos_recuperar').html( datos );
          $('#btncontinuar').attr('value', "3" );
        }
      }
    });
    return false;
  /*paso2*/
  }
  else if ( $('#btncontinuar').attr('value') == 3 ){
  /*paso3*/
    $.ajax({
      type:'POST',
      url: 'login-ajax.php',
      data: 'contra1=' + $('#contra1').val()
          + '&contra2=' + $('#contra2').val(),//Asignar los datos
      success: function(valores){
        var datos = eval(valores);
        if ( datos == "validacion" ) swal( "Error.", "Solo se admiten numeros y letras." );
        else if ( datos == "nocoinciden" ) swal( "Error.", "Las contraseñas no coinciden." );
        else if ( datos == "longitud" ) swal( "Error.", "La longitud de la contraseña debe ser mayor a 8 caracteres." );
        else if ( datos == "igualusuario" ) swal( "Error.", "La contraseña no puede ser igual al nombre de usuario." );
        else if ( datos === true ) window.location.href = "login";
        else swal( "Error.", "Problemas con el servidor." );
      }
    });
    return false;
  /*paso3*/
  }
}
/*funcion recuperar contra*/

/*recuperar contra OFICIAL*/
$('#olvide').click(function(e) {
  if ( $('#usuario').val() == "" ) $('#mensaje_error').html( '<div class="alert alert-danger" role="alert">Debe de ingresar un usuario.</div>' );
  else{
    recuperar_contra( $('#usuario').val() );
  }
});
/*recuperar contra OFICIAL*/

/*LOGIN - AJAX*/

/*JIVOCHAT :D*/
(function(){ var widget_id = 'w4ENIJo0hr';var d=document;var w=window;function l(){
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
/*JIVOCHAT :D*/

/*DIEGO*/