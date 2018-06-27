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

function format_tel ( $tel )
{
    $phone = str_ireplace([')', ' ', '(', '-', '+'], '', $tel);
    $un = substr($phone, -7);
    $op = substr($phone, -10, 3);
    $code = substr($phone, 0, -10);

    return '+'.$code.' ('.$op.') '.substr($un, 0, 3).'-'.substr($un, 3, 2).'-'.substr($un, 5);
}