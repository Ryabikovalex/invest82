<?php
class Image
{
    public static $types = [ 'image/png', 'image/jpeg'];

    public static function verify($file)
    {
        if ( $file['size'] > DB['image_max'])
        {
            return 2;
        }
        if ( !in_array($file['type'], self::$types) )
            return 4;

        return 1;
    }
}