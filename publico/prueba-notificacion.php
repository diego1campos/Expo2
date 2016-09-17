<?php
    //Se establece todas las clases o funciones necesarias ='D'
    require("../lib/database.php");
    require("../lib/validator.php");
    //!!Siempre deben de llamar de ultimo a page, por que sino, les pedira database y validator :)
    require("../lib/page.php");
    //Se llama a la funcion header que pone todos los css y para todos los .php de publico ='}
    Page::header("Catalogo");
    
?>
<div class="container-fluid margin_top_navbar">
    <script charset="UTF-8">
        function notifyMe() {
            //Vamos a comprobar si el navegador es compatible con las notificaciones
            if (!("Notification" in window)) {
                alert("This browser does not support desktop notification");
            }
            // Vamos a ver si ya se han concedido permisos de notificación
            else if (Notification.permission === "granted") {
                // Si está bien vamos a crear una notificación
                var body = "Hola";
                var icon = "http://www.elcapa8.com/img/favicon.ico";
                var title = "Notificación";
                var options = {
                    body: body,
                    icon: icon,
                    lang: "ES",
                    renotify: "true"
                }
                var notification = new Notification(title,options);
                var audio = new Audio('notificacion.mp3');
                audio.play();
                setTimeout(notification.close.bind(notification), 5000);
            }
            // De lo contrario, tenemos que pedir permiso al usuario
            else if (Notification.permission !== 'denied') {
                Notification.requestPermission(function (permission) {
                    // Si el usuario acepta, vamos a crear una notificación
                    if (permission === "granted") {
                        var notification = new Notification("Gracias, Ahora podras recibir notifiaciones de nuestra página");
                    }
                });
            }    
            // Por fin, si el usuario ha denegado notificaciones, y usted
            // Quiere ser respetuoso no hay necesidad de preocuparse más sobre ellos.
        }
        </script>
    <button onclick="notifyMe()">Notificame!</button>
</div>
<br>
<br>
<br>
<br>
<br>
<!--Se añade el pie de pagina ='DDD-->
<?php Page::footer(); ?>