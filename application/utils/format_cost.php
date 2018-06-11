<?php
function cost_format( $v)
{
    $temp = str_split(strrev($v), 3);
    $v = strrev(implode( ' ,', $temp));
    return $v;
}