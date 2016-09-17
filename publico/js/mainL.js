var count = 1;
    function setColor(btn, color) {
        var property = document.getElementById(btn);
        if (count == 0) {
            property.style.backgroundColor = "#FFFFFF"
            count = 1;        
        }
        else {
            property.style.backgroundColor = "#7FFF00"
            count = 0;
        }
    }

$(document).ready(function(){

    $('.prueba').click(function(){
        $(".prueba.activo")
            .css("background-color","")
            .removeClass("activo");

        $(this)
            .css("background-color","#049DBF")
            .addClass("activo");
    });
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(document).ready(function(){

    $('.prueba1').click(function(){
        $(".prueba1.activo")
            .css("background-color","")
            .removeClass("activo");

        $(this)
            .css("opacity","0.2")
            .addClass("activo");
    });
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

/*$("#lrevisar").click(function(){
    //$('#lrevisar').css("background-color","#308D7F");
    $('#lrevisar').addClass("active");
});
$("#lbene").click(function(){
    //$('#lrevisar').css("background-color","#308D7F");
    $('#lbene').addClass("active");

});*/