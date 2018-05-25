<?php

class Template
{
    public static $templates = [];
    public static function load(string $filename)
    {
        self::$templates = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].$filename), JSON_PARTIAL_OUTPUT_ON_ERROR | JSON_OBJECT_AS_ARRAY);
    }

    public static function title(int $level, array $params)
    {
        return str_replace( array_keys($params), array_values($params), self::$templates['title'][$level][0]);
    }
}