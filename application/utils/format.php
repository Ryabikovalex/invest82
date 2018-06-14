<?php
function format_cost ($v)
{
    $temp = str_split(strrev($v), 3);
    $v = strrev(implode( ' ,', $temp));
    return $v;
}

function format_date ($str_time)
{
    return date( 'd.m.Y', strtotime( substr($str_time, 0, 10) ) );
}