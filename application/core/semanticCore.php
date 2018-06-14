<?php

class semanticCore {
    protected static function getChunk ( &$var, $folder, $from, $param)
    {
        $file = '';
        $file = file_get_contents(PATH['json_user'].$folder.'/'.$from.'.json');
        $arr = json_decode($file, true, 3, JSON_INVALID_UTF8_IGNORE);
        $chunk = 0;
        $i = 0;
        while ($chunk == 0 and $i < count($arr))
        {
            if ( $arr[$i]['translit'] == $param)
            {
                $chunk = $arr[$i];
            }
            $i++;
        }
        $var = $chunk['header'];
    }

    public static function getHeader ( $params, $place = 'России', $cat = 'бизнес')
    {
        if ( isset($params['region']))
        {
            if ( isset($params['city']) and count($params['city']) == 1)
            {
                self::getChunk($place, 'region', $params['region'][0], $params['city'][0]);
            }else
            {
                self::getChunk($place, 'region', 'index', $params['region'][0]);
            }
        }
        if ( isset($params['cat']))
        {
            if ( isset($params['subcat']) and count($params['subcat']) == 1)
            {
                self::getChunk($cat, 'cat', $params['cat'][0], $params['subcat'][0]);
            }else
            {
                self::getChunk($cat, 'cat', 'index', $params['cat'][0]);
            }
        }
        $h = 'Купить '.$cat.' в '.$place;
        return $h;
    }
}