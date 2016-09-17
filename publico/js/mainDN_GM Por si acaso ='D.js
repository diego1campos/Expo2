//Catalogoooo ='DDD

//invoco el plugin cuando el documento haya cargado ='D
$( document ).ready(function() {
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
    $('.divarticulos, .divarticulos img, .divarticulos h4, .divarticulos span, .divarticulos li, .divarticulos button').efecto_aparecer({
      velocidad_elemen: '0.3s',
      velocidad_entre: 40,
	  mos_ampliar: true
    });
    $('.divarticulostop, .divarticulostop img, .divarticulostop h4, .divarticulostop span, .divarticulostop li, .divarticulostop button').efecto_aparecer({
      velocidad_elemen: '0.5s',
      velocidad_entre: 30,
	  mos_ampliar: true
    });
});

//Copiare el plugin.......... no ocupo google maps aqui ='}'
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
  var todos = $(this);
  var can_todos = $(this).length;//Obtengo el numero de elementos ='D
  var limpiar;
  //Arreglos para guardar el alto de cada elemento ='DD
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
//Catalogoooo ='DDDDD