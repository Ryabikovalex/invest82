<?php

class Templator
{
    protected static $template = 'index.tpl';
    public static $page_chunks = [];

    /**Создает новый обработанный chunk
     * @param string $name название шаблона
     * @param string $tpl_name имя файла шаблона
     * @param array $params параметры замены
     */
    public static function prepare_new(string $name, string $tpl_name, array $params)
    {
        $file = file_get_contents('app/views/'.$tpl_name);
        foreach ( $params as $name => $value)
        {
            $file = str_replace('[['.$name.']]', $value, $file);
        }
        self::$page_chunks[$name] = $file;
    }

    /**Обрабатывает фрагмент шаблона
     * @param string $name название загруженного шаблона
     * @param array $params параметры замены
     */
    public static function prepare( string $name, array $params)
    {
        $file = self::$page_chunks[$name];
        foreach ( $params as $name => $value)
        {
            $file = str_replace('[['.$name.']]', $value, $file);
        }
        self::$page_chunks[$name] = $file;
    }

    /**Создает новый чанк на основе нескольких одинаковых
     * @param string $new_name
     * @param array $params
     * @param string $tpl_name
     */
    public static function fill_template(string $new_name,array  $params,string $tpl_name)
    {
        $file = file_get_contents('app/views/'.$tpl_name);
        $chunk = '';
        for($i = 0; $i<count($params); $i++)
        {
            $new_file = $file;
            foreach ( $params[$i] as $name => $value)
            {
                $new_file = str_replace('[['.$name.']]', $value, $new_file);
            }
            $chunk .= $new_file;
        }
        self::$page_chunks[$new_name] = $chunk;
    }

    /**Возвращает все переменные в шаблоне
     * @param string $tpl_name
     * @return array
     */
    public static function get_template_variables( string $tpl_name)
    {
        $file = file_get_contents('app/views/'.$tpl_name);
        $match = [];
        preg_match_all('/\[\[(\w+)\]\]/', $file,$match);

        return $match[1];
    }

    public static function run( array $params, ...$arg)
    {
        $page = file_get_contents('app/views/'.self::$template);
        foreach ( self::$page_chunks as $name => $value)
        {
            $page = str_replace('[['.$name.']]', $value, $page);
        }
        foreach ( $params as $name => $value)
        {
            $page = str_replace('[['.$name.']]', $value, $page);
        }

        echo $page;
    }
}