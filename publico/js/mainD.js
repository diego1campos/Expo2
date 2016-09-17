$(function () {
  //Agregando el efecto responsivo de altura al divider ='DD
  //Timer ='DDD
  /*function tamano_vserpara(){
    var alto = $('.hei_divi').css('height');
    $('#di_v_hei_divi').css('height',alto);
  }
  setInterval("tamano_vserpara()",100);*/
  //
  //Todos ='DD
  if (matchMedia) {//Se ejeuta cuando hay un cambio en los pixeles de la ventana
    var mm_es = window.matchMedia("(max-width: 570px)");
    //No se que paso y elimine el contenido y aja... para que hacer esto si nadie lo vera jaja ='P ---var mm_esped = window.matchMedia("(max-width: 600px)");
    var mm_esped2 = window.matchMedia("(max-width: 423px)");
    var mm_esped3 = window.matchMedia("(max-width: 650px)");
    var mm_esped4 = window.matchMedia("(max-width: 450px)");
    var mm_esped5 = window.matchMedia("(max-width: 520px)");
    var mm_eslo = window.matchMedia("(max-width: 768px)");
    mm_es.addListener(CambioEs);
    CambioEs(mm_es);
    //
    mm_esped2.addListener(CambioEsped2);
    CambioEsped2(mm_esped2);
    //
    mm_esped3.addListener(CambioEsped3);
    CambioEsped3(mm_esped3);
    //
    //
    mm_esped4.addListener(CambioEsped4);
    CambioEsped4(mm_esped4);
    //
    mm_esped5.addListener(CambioEsped5);
    CambioEsped5(mm_esped5);
    //
    mm_eslo.addListener(CambioLo);
    CambioLo(mm_eslo);
    /*ESPED= estructura-pedido-numero que se me ocurrio X'D*/
    /*ESlo= estructura-login-numero que se me ocurrio X'D*/
  }
  // Cambio el media query
  function CambioEs(mm_es) {
    if (mm_es.matches) {
      $('.divima')//Reajusta la estructura de la imagen
        .removeClass('col-xs-3')
        .addClass('col-xs-12');
      $('.divbor')
        .css('height','28px')
        .css('font-size','22px');
      $('.divnomb')//Reajusta la estructura de el nombre
        .removeClass('col-xs-3')
        .addClass('col-xs-12');
      $('.div_cant_sub').addClass('row');//Une en una sola fila la cantidad y el sub
      $('.div_cant_sub')
        .css('margin-left','0px')
        .css('margin-right','0px')
        .css('padding-left','10px');
      $('.divcant').removeClass('col-xs-3');
      $('.divsub').removeClass('col-xs-2');
      $('.divcant').addClass('col-xs-8');
      $('.divsub').addClass('col-xs-4');
      $('#divtitulos').css('display','none');//Ocultar el divtitulos ='DD
      $('.divcant, .divsub').css('padding-top','0px');
    }
    else {
      $('.divima')
        .removeClass('col-xs-12')
        .addClass('col-xs-3');
      $('.divbor')
        .css('height','')
        .css('font-size','');
      $('.divnomb')
        .removeClass('col-xs-12')
        .addClass('col-xs-3');
      $('.div_cant_sub').removeClass('row');
      $('.div_cant_sub')
        .css('margin-left','')
        .css('margin-right','')
        .css('padding-left','');
      $('.divcant').removeClass('col-xs-8');
      $('.divsub').removeClass('col-xs-4');
      $('.divcant').addClass('col-xs-3');
      $('.divsub').addClass('col-xs-2');
      $('#divtitulos').css('display','block');
      $('.divcant, .divsub').css('padding-top','');
    }

  }
  //Cuando nos encontramos en una rea sumamente reducida ='}}
  function CambioEsped2(mm_esped2) {
    if (mm_esped2.matches){
      $('.hei_divi').removeClass('no_padding');
    }
    else{
      $('.hei_divi').removeClass('col-xs-12');
    }
  }
  //
  //Reajusta la estructura por 1º es xs, y de forma no exagerada ;)
  function CambioEsped3(mm_esped3) {
    if (mm_esped3.matches){
      //Fecha
      $('#tex_fec').removeClass('col-xs-3');
      $('#tex_fec').addClass('col-xs-6');
      //
      $('#ing_fec').removeClass('col-xs-2');
      $('#ing_fec').addClass('col-xs-6');
      //Hora
      $('#tex_ho').removeClass('col-xs-3');
      $('#tex_ho').addClass('col-xs-6');
      //
      $('#ing_ho').removeClass('col-xs-4');
      $('#ing_ho').addClass('col-xs-6');
      //METO AQUI EL PADDING POR CONVENENCIA ='DD
      $('.padding_right').css('padding-right','15px');
    }
    else{
      //Fecha
      $('#tex_fec').removeClass('col-xs-6');
      $('#tex_fec').addClass('col-xs-3');
      //
      $('#ing_fec').removeClass('col-xs-6');
      $('#ing_fec').addClass('col-xs-2');
      //Hora
      $('#tex_ho').removeClass('col-xs-6');
      $('#tex_ho').addClass('col-xs-3');
      //
      $('#ing_ho').removeClass('col-xs-6');
      $('#ing_ho').addClass('col-xs-4');
      //METO AQUI EL PADDING POR CONVENENCIA ='DD
      $('.padding_right').css('padding-right','0px');
    }
  }
  //Otro cambio a la estructura en xs
  //Ya que el mapa no se debe de ver claro y la informacion de lugar, tambien ='DD
  function CambioEsped5(mm_esped5) {
    if (mm_esped5.matches){
      //divLugar
      $('#divlugar').removeClass('col-xs-4');
      $('#divlugar').addClass('col-xs-12');
      $('#divMapDDDContent').css('display','none');//Es mejor que aparezca abajo
      $('#divMapDDDContent2').css('display','block');//Se oculta y se muestra (abajo y arriba, vicebersa)
      //Cambiar de tamaño el mapa
      $('#divMapDDD2').css('height','300px');
      $('#divMapDDDContent2').removeClass('col-xs-8');
      $('#divMapDDDContent2').addClass('col-xs-12');
      $('#divMapDDDContent2').addClass('no_padding');
    }
    else{
      //divLugar
      $('#divlugar').removeClass('col-xs-12');
      $('#divlugar').addClass('col-xs-4');
      //Cambiar de tamaño el mapa
      $('#divMapDDD2').css('height','');
      $('#divMapDDDContent2').removeClass('col-xs-8');
      $('#divMapDDDContent2').addClass('col-xs-12');
      $('#divMapDDDContent2').removeClass('no_padding');
      //
      $('#divMapDDDContent').css('display','block');//Es mejor que aparezca abajo
      $('#divMapDDDContent2').css('display','none');//Se oculta y se muestra (abajo y arriba, vicebersa)
    }
  }
  //
  //

  //Otro cambio a la estructura en xs, es que es muy exagerado D:
  function CambioEsped4(mm_esped4) {
    if (mm_esped4.matches){
      //Fecha
      $('#tex_fec').removeClass('col-xs-6');
      $('#tex_fec').addClass('col-xs-12');
      //
      $('#ing_fec').removeClass('col-xs-6');
      $('#ing_fec').addClass('col-xs-12');
      //Se ve mejor ;)
      $('#ing_fec .row div').css('padding-left','15px');
      //Hora
      $('#tex_ho').removeClass('col-xs-6');
      $('#tex_ho').addClass('col-xs-12');
      //
      $('#ing_ho').removeClass('col-xs-6');
      $('#ing_ho').addClass('col-xs-12');
      //Se ve mejor ;)
      $('#ing_ho').css('padding-left','15px');
      //Mucho mejor xd
      $('#tex_ho').css('margin-top','10px');
      $('#ing_ho').css('padding-bottom','5px');
      //
      //Catalogo ='DD
      $('.divarticulos').parent().removeClass('col-xs-6');
      $('.divarticulos').parent().addClass('col-xs-12');
      //
      //Footer
      $('.col-xs-mod').css('width','100%');
    }
    else{
      //Fecha
      $('#tex_fec').removeClass('col-xs-12');
      $('#tex_fec').addClass('col-xs-6');
      //
      $('#ing_fec').removeClass('col-xs-12');
      $('#ing_fec').addClass('col-xs-6');
      //Se ve mejor ;)
      $('#ing_fec .row div').css('padding-left','0px');
      //Hora
      $('#tex_ho').removeClass('col-xs-12');
      $('#tex_ho').addClass('col-xs-6');
      //
      $('#ing_ho').removeClass('col-xs-12');
      $('#ing_ho').addClass('col-xs-6');
      //Se ve mejor ;)
      $('#ing_ho').css('padding-left','0px');
      $('#ing_ho').css('padding-bottom','');
      $('#tex_ho').css('margin-top','');
      //
      //Catalogo ='DD
      $('.divarticulos').parent().removeClass('col-xs-12');
      $('.divarticulos').parent().addClass('col-xs-6');
      //
      //Footer
      $('.col-xs-mod').css('width','');
    }
  }
  function CambioLo(mm_eslo) {
    if (mm_eslo.matches){
      $('#listmenu_limpiar').find('.user-header').css('display','none');
      $('#listmenu_limpiar').find('.user-footer').css('display','none');
      //
      $('#listmenu_limpiar').find('.listmenu_limpiar_xs').css('display','block');
      //$('#custom-menu').removeClass('navbar-custom-menu');
    }
    else{
      //$('#custom-menu').addClass('navbar-custom-menu');
      $('#listmenu_limpiar').find('.user-header').css('display','block');
      $('#listmenu_limpiar').find('.user-footer').css('display','block');
      //
      $('#listmenu_limpiar').find('.listmenu_limpiar_xs').css('display','none');
    }
  }
  //
  //Todos ='DD



  //Compras :D
  //
  //Evento click en los radio button ='DD
  $("#lblmidirec").click(function(){
    //Por si esta oculto ;)
    $('#divfecha').fadeIn( "slow" );
    //Quito
    $('#localdirec').removeClass('active');
    $('#localdirec').css('display','none');
    //Quito
    $('#otradirec').removeClass('active');
    $('#otradirec').css('display','none');
    //Agrego
    $( "#midirec" ).fadeIn( "slow");
    $('#midirec').addClass('active');
  });
  //
  $("#inlocaldirec").click(function(){
    //Ooculto fechas :D ;)
    $('#divfecha').fadeOut( "slow" );
    //Quito
    $('#midirec').removeClass('active');
    $('#midirec').css('display','none');
    //Quito
    $('#otradirec').removeClass('active');
    $('#otradirec').css('display','none');
    //Agrego
    $( "#localdirec" ).fadeIn( "slow" );
    $('#localdirec').addClass('active');
  });
  //
  $("#lblotradirec").click(function(){
    //Por si esta oculto ;)
    $('#divfecha').fadeIn( "slow" );
    //Quito
    $('#midirec').removeClass('active');
    $('#midirec').css('display','none');
    //Quito
    $('#localdirec').removeClass('active');
    $('#localdirec').css('display','none');
    //Agrego
    $( "#otradirec" ).fadeIn( "slow" );
    $('#otradirec').addClass('active');
  });
  //Efecto colocar bonito ='DDD
  //Todos
  $( document ).ready(function() {
    //Clase avtive, inicio :)
    if ( $('title').html() == "Inicio" ){
      $('.active').css( 'width', '100%' )
                  .css( 'height', '100%' );
    }
    //Clase avtive :)
    
    //Datepicker-realizar compra
    if ( $('title').html() == "Realizar compra" ){
      $('#datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
      });
      $('.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top').css( 'color', 'red' );
    }
    //Datepicker-realizar compra
      /*Mostrar modal login*/
      if ( $('#mostrar_modal').attr('si') != null ) $('#login-modal').modal({show: 'false'});
      /*Mostrar modal login*/
      /*Mover mensaje de error XD*/
      if ( $('.alert').attr('login') != null ){
        var contenido_html = $('*').find( '.margin_top_navbar' ).html();
        var mensaje = $('.alert').attr('login');
        $('*').find( '.margin_top_navbar' ).html( '<div class="alert alert-danger" role="alert">' + mensaje + '</div>' + contenido_html );
      }
      /*Mover mensaje de error XD*/
      /*calificacion*/
      if ( $('title').html() == "Articulo" ){
        $('.glyphicon-star').click(function(e){
          $.ajax({
            type:'POST',
            url: 'infopro-ajax.php',
            data: 'id_producto=' + $('#id_producto').attr( 'value' )
                   + '&calificacion=' + parseFloat( $('.label').html() )//Solo lo ocupa esa cosa donde aparece la calificacion
                   + '&tipo_accion=2',
            success: function(valores){
              var datos = eval(valores);
              if( datos[0] === true ){
                swal( "Exito.", "Calificacion " + datos[1] + " con exito." );
                if ( ! $('.glyphicon-star').hasClass('cali-hecha') ) $('.glyphicon-star').addClass('cali-hecha');
              }
              else{
                swal( "Error.", "Error: " + datos );
              }
            }
          });
          return false;
        });
      }
      /*calificacion*/
      //Compras
      $('.divinopro').efecto_aparecer({    //Invoca al plugin ='D'DDDDDDD
        tanslate_des: 'translate(0px)',
        velocidad_elemen: '1s',
        velocidad_entre: 200,
        desplazamiento: true
      });
      //Compras


      //Catalogo ='D
      $('#divfiltros').efecto_aparecer({    //Invoca al plugin ='D'DDDDDDD
      velocidad_elemen: '2s',
        desplazamiento: true
      });
      $('#divmarcas').efecto_aparecer({    //Invoca al plugin ='D'DDDDDDD
        velocidad_elemen: '2s',
        desplazamiento: true
      });
      //
      $('#divtop').efecto_aparecer({    //Invoca al plugin ='D'DDDDDDD
        velocidad_elemen: '2s',
        desplazamiento: true
      });
    //Cada componente de .divarticulos se le aplica el efecto, por que si no solo se miraria el thumbnail
    //Aplico estos dos por que asi se hace mas rapido :D
      $('.divarticulos, .divarticulos img, .divarticulos h4, .divarticulos span, .divarticulos li, .divarticulos').efecto_aparecer({
        velocidad_elemen: '0.5s',
        velocidad_entre: 10,
        mos_ampliar: true
      });
      $('.divarticulostop, .divarticulostop img, .divarticulostop h4, .divarticulostop span, .divarticulostop li, .divarticulostop button').efecto_aparecer({
        velocidad_elemen: '0.3s',
        velocidad_entre: 15,
        mos_ampliar: true
      });
      //Catalogo ='D
  });
  //Todos ='D


  //Compras :D
  //Implementar plugin... "realizar pedido ='DD"
  $( '#tab_reap' ).click(function() {
      $('#reap .row .colordiv .row-normal, #reap .row .colordiv').efecto_aparecer({    //Invoca al plugin ='D'DDDDDDD
        tanslate_des: 'translateY(0px)',
        velocidad_elemen: '0.5s',
        velocidad_entre: 200,
        desplazamiento: true
      });
  });
  //
  //Compras :D
  //Plugiiiiiinnnnnn ='DDDDDDDDD
  jQuery.fn.efecto_aparecer = function(parametro) {
    //Parametros u opciones ='DD
    var opciones = {//Translate y opacity se definen mediante css (tambien), para que no se vea y para el efecto de traslacion css :'D
      //Parametros del efecto "mostrar_detras ='D"
      tanslate_des: 'translate(0px)',
      velocidad_elemen: '1s',
      velocidad_entre: 200,
      desplazamiento: false,
      //Parametros del efecto "mos_ampliar ='D"    
      mos_ampliar: false
    }//-----------Las propiedades del "parametro" 
    jQuery.extend(opciones, parametro);
    //------------las tendra ahora "opciones" ='DDD
    //Variables a ocupar
    var todos = $(this);
    var can_todos = $(this).length;//Obtengo el numero de elementos ='D
    var limpiar;
    //Arreglos para guardar las posiciones y alto de cada elemento ='DD
    var alto_elems = [];
    //
    function eliminar_css (){
      todos.css('-webkit-transition','');
    }

    this.each( function(i, el){//'i' muestra el indice y 'el' asume de = $(this)
      if ( opciones.mos_ampliar == true ) {
        alto_elems.push( $(el).height() );
        $(el).css('-webkit-transform','translateY(' + (alto_elems[i]/2) + 'px)');
        $(el).css('font-size','0px');
        $(el).css('height','0px');
      //$(el).css('opacity','1');
    }
      //console.log( alto_elems[i] );

      setTimeout(function(){//Asigno las propiedades a cada uno ='DD
        
        if ( opciones.desplazamiento == true ){//Se activara el efecto desplazamiento si asi se pidio el plugin ='DD'
          $(el).css('-webkit-transition', opciones.velocidad_elemen);
          $(el).css('opacity','1');
          $(el).css('-webkit-transform', opciones.tanslate_des);
        }
        else if ( opciones.mos_ampliar == true ) {
          $(el).css('-webkit-transform','');
          $(el).css('font-size','');
          $(el).css('height','');
          $(el).css('opacity','1');
          $(el).css('-webkit-transition', opciones.velocidad_elemen);
        }

        //Comparo si ya llego al ultimo elmento a aplicar la restauracion de -webkit-transition ='DDD
        if ( (i + 1) == can_todos){
          limpiar = setTimeout(function(){
            if ( (i + 1) == can_todos ){
              eliminar_css();
              clearTimeout(limpiar);//Entonces la funcion se aplicara hasta que 
            }//---se haya terminado la duracion del efecto del ultimo elemento, entonces pongo la duracion del ultimo elemento y ya ='DD
          },parseFloat(opciones.velocidad_elemen) * 1000);//Timer ='DD
        }


        //Derechos de autor jaja ='P' ("100" +...xd)
      },100 + ( i * opciones.velocidad_entre ));//multiplicacion (i*op..velo) = al tiempo de tardanza al aplicar la propiedad a los elementos y es una tabla, siempre tendra 200 milesimas de s de 

      return this;//----separacion ='D (el primero es instantaneo ='D...(100 + (0 * 200)) = 100, el segundo se añade mas tiempo de espera para ejecutar la funcion (200 ms)... (100 + (1 * 200)) = 300 y asi va ='D)
    });//Y ese tiempo de espera por la tabla (de multiplicar) que genera "i", y eso es lo que genera "el tiempo en medio de una transicion de un elemento y otra"
    //---Aunque la duracion individual de los efectos de los elmentos tendra cierto tiempo (el asignado e igual para todos) ='DD
  };
  //
  //
  //Plugin + cuando quiero que se vea al bajar el contenido en una pagina ='P'
  $(window).scroll(function(){
      var window_scroll = $(window).scrollTop(); // VALOR en pixeles que se baja con el scroll ='DD
      var window_tamañoH = $(window).height(); //Valor tamaño de pixeles de la pantalla (alto) ='PPP
      //Obtener el nombre de la pagina actual ='DD'
      var pagina = $('title').html();
      //Comrpas ='DD
      if ( pagina == "Compras" ){
        var pos_elementY = $(".divinopro_s").offset().top; //Valor de posicion en pixeles en el eje Y (que tan abajo esta el elemento ='DD')
        //Lo bajado (scroll (pixeles bajados)) mas el tamaño (pixeles visibles) logras llegar al elemento y verlo
        //--(nada) por que es el comienzo, es decir 1 pixel, le sumas 80 para que baje un poquito mas y al menos ya veas la mitad de donde aparecera ='DDD
        if ((window_scroll + window_tamañoH) > (pos_elementY + 200)) { // SI EL SCROLL HA SUPERADO EL ALTO DE TU DIV
          $('.divinopro_s').efecto_aparecer({ // Ahora solo ejecuto el plugin ='DD
            tanslate_des: 'translate(0px)',
            velocidad_elemen: '1s',
            velocidad_entre: 100,
            desplazamiento: true
          });
        }
      }
  });
  /*catalogo*/
  $("#btnbuscar").mousedown(function(e){
  //1: izquierda, 2: medio/ruleta, 3: derecho
    if(e.which == 3) {
      $(document).bind("contextmenu", function(e){
        //$("#menu").css({'display':'block', 'left':e.pageX, 'top':e.pageY});
        $("#txtBuscar").val('');
        $("#btnbuscar").focusout();
        $('input').attr('name','');
        window.location.href = "catalogo";
        return false;
      });
    }
  });
  $('[data-toggle="tooltip"]').tooltip();
  /*catalogo*/
  /*login*/
  $("#a_cerrar_sesion").click(function(){
    $('#frmlogin').submit();
  });
  limpiar = setTimeout(function(){
    if ( $(document).find('div.alert') ){
      $(document).find('div.alert').fadeOut('slow');
    }
  }, 3500);
  /*login*/

  //compras.php--->Cuando se debe mostrar los horarios con el dia seleccionado
  $('#datepicker').click(function(e) {
    $.ajax({
      type:'POST',
      url: 'compras-ajax.php',
      data: 'fecha_pedido='+ $('#datepicker').val(),
      success: function(valores){
        var datos = eval(valores);
        if ( datos[0] == true ) $('#horarios_entrega').html( datos[1] );
      }
    });
    return false;
  });
  //compras.php

  /*comentrarios*/
  //Lo hago con ajax previniendo algun posible error de reajuste con arturo :)
  $('#btna_comentario').click(function(e){
    //Hacemos el formulario :P
    var dt = new FormData();
    dt.append( "comentario", $('#txtcoment').val() );
    dt.append( "id_producto", $('#id_producto').val() );
    var url = 'coment-ajax.php';
    $.ajax({
      type:'POST',
      url:url,
      cache: false,
      contentType: false,
      processData: false,
      data: dt,
      success: function(valores){
        var datos = eval(valores);
        var mensaje = "";
        var tipo = 'Error.';
        if( datos == 1 ){
          tipo = 'Exito.';
          mensaje = 'Comentario añadido con exito';
        }
        else mensaje = 'Error: ' + datos;
        //$('#divcomentarios').append('<div class="alert alert-' + tipo + '" role="alert">' + mensaje + '</div>');
        swal( tipo, mensaje );
      }
    });
    return false;
  });
  //Cancelar
  $('#btnc_comentario').click(function(e){
    $('#txtcoment').val('');
  });
  /*comentrarios*/

  /*//<!-- BEGIN JIVOSITE CODE {literal} -->
  (function(){ var widget_id = 'Th1DWDZ94o';var d=document;var w=window;function l(){
  var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
  //<!-- BEGIN JIVOSITE CODE {literal} -->*/
});

//ESTO VA AFUERA POR QUE ASI ESTA EN EL EJEMPLO :O

function Mensaje( formulario, id_comentario, accion ){
  swal({
      title: "¿Está seguro de realizar la acción?",
      text: "No podra restablecer los datos.",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: 'btn-danger',
      confirmButtonText: 'Si, estoy seguro.',
      cancelButtonText: "Cancelar.",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
      if (isConfirm){
        if ( formulario == 0 ){//significa actua_compra
          actualizar_compras( id_comentario, accion );
        }
        if ( formulario == 'direcciones' ){//significa actua_compra
          elim_direccion( id_comentario );
        }
      }
      else {
        swal("Acción cancelada.", "Ningún cambio realizado", "error");
      }
    });
}

//ESTO VA AFUERA POR QUE ASI ESTA EN EL EJEMPLO :O (iba afuera de $function()
var id_presentacion_anterior = 0;
/*compras ajax*/
function actualizar_compras ( elemento, tipo_accion ){
  if ( tipo_accion == 1 ){
    //encontrar los datos :)
    var row = $(elemento).parents('.divinopro');
    //Asignar los datos
    var dt = new FormData();
    dt.append( "cantidad", $(row).find('.cantidad').val() );
    dt.append( "id_img_producto", $(row).find('.id_img_producto').attr('value') );
    dt.append( "tipo_accion", tipo_accion );//2 significa cambio_color y 1 cambio_cantidad
    dt.append( "id_presentacion", $(row).find('.id_presentacion').val() );//Agregamos
    $.ajax({
      type:'POST',
      url: 'compras-ajax.php',
      cache: false,
      contentType: false,
      processData: false,
      data: dt,
      success: function(valores){
        var datos = eval(valores);
        if( datos == true ){
          swal( 'Exito.', 'Cantidad del producto actualizada.' );
          //Actualizamos la vision de subtotal =}
          $(row).find('.divsub').find('p').html( '$' + ( parseFloat( $(row).find('.cantidad').val() ) * parseFloat( $(row).find('.producto_precio').html().substring(1) ) ).toFixed(2) );
          
          //Actualizamos el resumen del pedido en la otra pestaña
          $('#p_total_pago').html( "$" + parseFloat( parseFloat( /*Obtengo la resta de total pago - la cantidad actual del producto*/ parseFloat( $('#p_total_pago').html().substring(1) ) - parseFloat( parseFloat( $(row).find('.producto_precio').html().substring(1) ) * parseFloat( $(row).find('.cantidad').attr('value') ) ) /*Obtengo la resta de total pago - la cantidad actual del producto*/ ) + parseFloat( $(row).find('.cantidad').val() ) * parseFloat( $(row).find('.producto_precio').html().substring(1) ) ).toFixed(2) );
          //Actualizamos la cantidad de productos
          $('#p_total_can').html( ( parseInt( $('#p_total_can').html() ) - parseInt( $(row).find('.cantidad').attr('value') ) ) + parseInt( $(row).find('.cantidad').val() ) );
          
          //Anterior cantidad, o como viene cuando carga la pagina, por ejemplo ... actualizo el 'value' para ocuparlo como anterior, ya que este se queda asi por que no se acualiza solo, solo el .val es el que se actualiza :D
          $(row).find('.cantidad').attr( 'value', parseFloat( $(row).find('.cantidad').val() ) );
        }
        else{
          swal( 'Error.', datos );
        }
      }
    });
    return false;
  }
  else if ( tipo_accion == 2 ){
    //encontrar los datos :)
    var row = $(elemento).parents('.divinopro');
    /*var id_presentacion = $(elemento).val();
    var prueba = $(elemento).find('option').val(num_option).html();
    var id_img_producto = $(row).find('.id_img_producto').attr('value');
    console.log(num_option);
    console.log(prueba);*/
    $.ajax({
      type:'POST',
      url: 'compras-ajax.php',
      data: 'id_img_producto='+ $(row).find('.id_img_producto').attr('value')
             + '&tipo_accion='+tipo_accion
             + '&id_presentacion='+ $(elemento).val(),//Asignar los datos
      success: function(valores){
        var datos = eval(valores);
        if ( datos[0] == true ) ;
        else if( datos[1] == true ){
          //swal( "Exito.", "Color cambiado con exito." );
          $(row).find('img').attr( 'src', '../img/productos/'+datos[0]);//Actualizamos la imagen =}
          
          //Asigno el id_img_producto a la cruz, es estatico el id, se lo asigne por php
          $('span[onclick="javascript: Mensaje( 0, ' + $(row).find('.id_img_producto').attr('value') + ', 3 );"]').attr( 'onclick', 'javascript: Mensaje( 0, ' + datos[2] + ', 3 );' );

          //Asigno el nuevo id de imagen ='}
          $(row).find('.id_img_producto').attr('value', datos[2]);
        }
        else if ( datos[1] == 555 ){
          swal( "Error.", "Error: " + datos[0] );
          $(elemento).val( id_presentacion_anterior );
        }
        else{
          if ( datos == 23000 ){
            swal( "Error.", "No puede cambiar la presentacion del articulo al seleccionado, ya ha sido añadido anteriormente a su lista de compras.");
            $(elemento).val( id_presentacion_anterior );
          }
          else swal( "Error.", "Error: " + datos );
        }
        id_presentacion_anterior = $(elemento).val();
      }
    });
    return false;
  }
  else if ( tipo_accion == 3 ){//Cuando elimina uno de la lista :)
    //encontrar los datos :)
    $.ajax({
      type:'POST',
      url: 'compras-ajax.php',
      data: 'id_img_producto='+ elemento
             + '&id_presentacion=' + $('span[onclick="javascript: Mensaje( 0, ' + elemento + ', 3 );"]').parents('.divinopro').find('.id_presentacion').val()
             + '&tipo_accion='+tipo_accion,//Asignar los datos
      success: function(valores){
        var datos = eval(valores);
        if( datos[0] ){
          swal( "Exito.", "Producto eliminado con exito.");
          $('span[onclick="javascript: Mensaje( 0, ' + elemento + ', 3 );"]').parents('.divinopro').fadeOut();
        }
        else{
          mensaje = datos;
          swal( "Error.", "Error: "+ mensaje );
        }
      }
    });
    return false;
  }

  /*else if ( tipo_accion == 4 ){//Se activa cuando quiero obtener el dia de una fecha en especifico
    $.ajax({
      type:'POST',
      url: 'compras-ajax.php',
      data: 'fecha_pedido='+ $('#datepicker').val(),
      success: function(valores){
        var datos = eval(valores);
        if ( datos[0] == true ) console.log( datos[1] );
      }
    });
    return false;
  }*/
}
// //Compras ='DDD

/*infoproducto ajax*/
function actualizar_infopro ( elemento, tipo_accion ){
  if ( tipo_accion == 1 ){
    $.ajax({
      type:'POST',
      url: 'infopro-ajax.php',
      data: 'tipo_accion=' + tipo_accion
             + '&id_presentacion=' + $(elemento).val()
             + '&id_producto=' + $('#id_producto').val(),//Asignar los datos
      success: function(valores){
        var datos = eval(valores);
        if( datos[0] == true ){
          $('#slider_info_art').html(datos[1]);//Cargo imagenes
          //$('#scolor').attr( 'style', 'background-' + $('#select_color').find('option[value=' + $(elemento).val() + ']').attr('style') + ';' + $('#select_color').find('option[value=' + $(elemento).val() + ']').attr('style') + ';font-size: 40px;' );//Ahora a cargar los colores
          //$('#id_img_producto').attr( 'style', 'background-' + $('#select_color').find('option[value=' + $(elemento).val() + ']').attr('style') + ';' + $('#select_color').find('option[value=' + $(elemento).val() + ']').attr('style') + ';font-size: 40px;' );//Pasamos el actual id del color :)
          $('#btnanadircarrito').html( datos[2] );//Cambio texto btnacarrito si en dado caso ya fue añadido xd
          $('#btnanadircarritoo').html( datos[2] );
          $('#id_img_producto').val( datos[3] );//Añado el id de la imagen actual, (cambio de color :) :)
          $('#cantidad').val( datos[4] );//Muestro la cantidad escrita desde la base :)
          $('#cantidadd').val( datos[4] );
          //Colocar el color seleccionado :D
          $('#select_presentacion, #select_presentacionn').val( $(elemento).val() );
        }
        else{
          mensaje = datos;
          swal( "Error.", "Error: "+ mensaje );
        }
      }
    });
    return false;
  }
}
/*infoproducto ajax*/

/*btn a carrito*/
$('#btnanadircarrito').click(function(e) {
  //encontrar los datos :)
  var dt = new FormData();
  //dt.append( "id_cliente", id_cliente );
  dt.append( "id_img_producto", $('#id_img_producto').val() );
  dt.append( "id_presentacion", $('#select_presentacion').val() );
  dt.append( "cantidad", $('#cantidad').val() );
  dt.append( "tipo_accion", 1 );
  dt.append( "btnacarrito", 1 );
  //
  $.ajax({
    type:'POST',
    url: 'compras-ajax.php',
    cache: false,
    contentType: false,
    processData: false,
    data: dt,//Asignar los datos
    success: function(valores){
      var datos = eval(valores);
      if( datos == "añadio" ){
        swal( "Exito.", "Producto añadido con exito.");
        //Cambiamos la letra del boton xd
        $('#btnanadircarrito').html('Editar');
        $('#btnanadircarritoo').html('Editar');
        $('#cantidadd').val( parseInt( $('#cantidad').val() ) );//Cargar el valor ingresado en el otro por si acaso :)
      }
      else if( datos == "actualizo" ){
        swal( "Exito.", "Producto actualizado con exito.");
        $('#cantidadd').val( parseInt( $('#cantidad').val() ) );//Cargar el valor ingresado en el otro por si acaso :)
        //
      }
      else swal( "Error.", "Error: " + datos );
    }
  });
  return false;
});

//2° BOTOOOON!!!!!!!!!!!!
$('#btnanadircarritoo').click(function(e) {
  //encontrar los datos :)
  var dt = new FormData();
  //dt.append( "id_cliente", id_cliente );
  dt.append( "id_img_producto", $('#id_img_producto').val() );
  dt.append( "id_presentacion", $('#select_presentacionn').val() );
  dt.append( "cantidad", $('#cantidadd').val() );
  dt.append( "tipo_accion", 1 );
  dt.append( "btnacarrito", 1 );
  //
  $.ajax({
    type:'POST',
    url: 'compras-ajax.php',
    cache: false,
    contentType: false,
    processData: false,
    data: dt,//Asignar los datos
    success: function(valores){
      var datos = eval(valores);
      if( datos == "añadio" ){
        swal( "Exito.", "Producto añadido con exito.");
        //Cambiamos la letra del boton xd
        $('#btnanadircarrito').html('Editar');
        $('#btnanadircarritoo').html('Editar');
        $('#cantidad').val( parseInt( $('#cantidadd').val() ) );//Cargar el valor ingresado en el otro por si acaso :)
      }
      else if( datos == "actualizo" ){
        swal( "Exito.", "Producto actualizado con exito.");
        $('#cantidad').val( parseInt( $('#cantidadd').val() ) );//Cargar el valor ingresado en el otro por si acaso :)
        //
      }
      else swal( "Error.", "Error: " + datos );
    }
  });
  return false;
});

/*btn a carrito*/

/*Mostrar imagenes*/
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
if ( $('title').html() == 'Registrar' ) document.getElementById('pro_img_url').addEventListener('change', img_a_pro, false);
/*Mostrar imagenes*/

/*direcciones-crear-mas*/
if ( $('title').html() == 'Registrar' ){
  $('#mas_direcciones').click(function(){
    /*if ( $('a[id_direccion]').attr('id_direccion') != null ) $('#div_direcciones').append( '<div class="form-group"><div class="row"> <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10"><input class="form-control" autocomplete="off" onpaste=";return false" placeholder="Ingrese una dirección" /></div><div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><a class="glyphicon glyphicon-plus icono_tamano" onclick="$(this).a_direccion();"></a></div><div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><a onclick="$(this).parents(\'.form-group\').fadeOut();" class="glyphicon glyphicon-remove-circle icono_tamano"></a></div></div></div>' );
    else */$('#div_direcciones').append( '<div class="form-group"><div class="row"> <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10"><input class="form-control" autocomplete="off" onpaste=";return false" name="direcciones[]" placeholder="Ingrese una dirección" /></div><div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><a onclick="$(this).parents(\'.form-group\').fadeOut(); $(this).parents(\'.form-group\').remove();" class="glyphicon glyphicon-remove-circle icono_tamano"></a></div></div></div>' );
  });
}
/*direcciones-crear-mas*/

/*Acciones direcciones*/
jQuery.fn.e_direccion = function() {
  var id_direccion = $(this).attr( "id_direccion" );
  var direccion = $(this).parents(".form-group").find('input').val();
  $.ajax({
    type:'POST',
    url: 'direcciones-ajax.php',
    data: 'id_direccion=' + id_direccion + '&direccion=' + direccion,//Asignar los datos
    success: function(valores){
      var datos = eval(valores);
      mensajes_direcciones( datos );
    }
  });
  return false;
};

function elim_direccion ( id_direccion ){
  $.ajax({
    type:'POST',
    url: 'direcciones-ajax.php',
    data: 'id_direccion=' + id_direccion,//Asignar los datos
    success: function(valores){
      var datos = eval(valores);
      if ( datos === 'eliminado' ){
        $('a[id_direccion='+id_direccion+']').parents('.form-group').fadeOut();
        $('a[id_direccion='+id_direccion+']').parents('.form-group').remove();
      }
      mensajes_direcciones( datos );
    }
  });
}

function mensajes_direcciones ( datos ) {
  var numeros = /^[0-9]+$/;//Cuando añado por ajax, devuelvo un numero :D
  if ( numeros.test(datos) ) swal( "Exito.", "Direccion agregada." );
  else if ( datos === 'actualizado' ) swal( "Exito.", "Direccion actualizada." );
  else if ( datos === 'eliminado' ) swal( "Exito.", "Direccion eliminada." );
  else if ( datos === false ) swal( "Error.", "Problemas con el servidor." );
  else  swal( "Error.", "Error: " + datos );
}
/*Acciones direcciones*/

// //Mapa ='DDDD
// //

var myCenter=new google.maps.LatLng(13.707302, -89.238173);

function initialize(){
  var mapProp = {
    center: myCenter,
    zoom: 15,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };

  var map=new google.maps.Map(document.getElementById("divMapDDD"),mapProp);
  var map2=new google.maps.Map(document.getElementById("divMapDDD2"),mapProp);

  var marker=new google.maps.Marker({
    position: myCenter,
    animation: google.maps.Animation.BOUNCE,
    title:'ISA deli & smokehouse'
    //icon:'img/logo.png'
  });
  var marker2=new google.maps.Marker({
    position: myCenter,
    animation: google.maps.Animation.BOUNCE,
    title:'ISA deli & smokehouse'
    //icon:'img/logo.png'
  });

  marker.setMap(map);
  marker2.setMap(map2);
//
// Zoom de 9 cuando se clickea el marcador ='DDD
  google.maps.event.addListener(marker,'click',function() {
      map.setZoom(18);
      map.setCenter(marker.getPosition());
      map2.setZoom(18);
      map2.setCenter(marker.getPosition());
  });
  google.maps.event.addListener(marker2,'click',function() {
      map2.setZoom(18);
      map2.setCenter(marker.getPosition());
  });
}

google.maps.event.addDomListener(window, 'load', initialize);
// //
// //Maps ='DDD
// //