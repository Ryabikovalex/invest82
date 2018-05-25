<?php
function autoload( $class){
    $path_ctrl = "/application/controllers/";
    $path_model = "/application/models/";
    if ( file_exists($path_ctrl.$class.".class.php")){
        include $path_ctrl.$class.".class.php";
    }else if (file_exists($path_model.$class.".class.php"))
    {
        include $path_model.$class.".class.php";
    }
}
//spl_autoload_register( "autoload");