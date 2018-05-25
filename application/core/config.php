<?php
function LOAD_CONFIGURATION ( $pathname)
{
    $array = parse_ini_file( $pathname, 1);
    foreach ($array as $name => $arr)
    {
      define( $name, $arr);
    }
}