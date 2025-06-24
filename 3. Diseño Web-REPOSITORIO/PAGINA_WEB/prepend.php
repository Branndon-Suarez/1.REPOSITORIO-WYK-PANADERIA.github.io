<?php
register_shutdown_function(function(){
    if(error_get_last()['type'] === E_ERROR){
        header("HTTP/1.0 500 Internal Server Error");
        include($_SERVER['DOCUMENT_ROOT'].'/PAGINA_WEB/500.html');
        exit();
    }
});
?>