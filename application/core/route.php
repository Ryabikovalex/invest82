<?php
final class Route
{
    public static $arg = [];
    /**
     * @var string URL без GET
     */
	public static $url = '/';
	private static $key_word = [ 'region', 'city', 'cat', 'subcat', 'i', 'part'];

    /**
     * @param $arr array Массив URL
     * @param $start_elem int начальная позиция
     * @param $key int ключ аргумента
     */
    private static function setParams($arr, $start_elem, $key)
    {
        $arr_size = count($arr);
        $i = $start_elem;
        $a = [];
        $k = 0;
        while ($i < $arr_size && !in_array($arr[$i], self::$key_word) && $arr[$i] != '')
        {
            $a[$k] = $arr[$i];
            $i++;
            $k++;
        }
        self::$arg[$key] = $a;
    }

    /**
     *  Запуск маршрутизации
     */
	public static function start()
	{
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        if (isset($_GET) && count($_GET) > 0)
        {
            array_pop($routes);
        }
        self::$url = implode('/', $routes);
        $routes_size = count($routes);


        // контроллер и действие по умолчанию
        $controller_name = 'main';
        $action_name = 'index';
        $start = 0;

        if ( !empty($routes[1]) && !in_array($routes[1], self::$key_word) )
        {
            $start = 2;
            $controller_name = $routes[1];
        }
        if ( !empty($routes[2]) && !in_array($routes[1], self::$key_word) && !in_array($routes[2], self::$key_word) )
        {
            $start = 3;
            $action_name = $routes[2];
        }
        for ($i=$start; $i<$routes_size; $i++)
        {
            if(!empty($routes[$i]) && in_array( $routes[$i], self::$key_word) )
            {
                self::setParams($routes, $i+1,  $routes[$i]);
            }
        }

        if (isset(self::$arg['subcat']) and !isset(self::$arg['cat']))
        {
            Route::ErrorPage404();
        }
        if (isset(self::$arg['city']) and !isset(self::$arg['region']))
        {
            Route::ErrorPage404();
        }

        session_start();
        

		// добавляем префиксы
		$model_name = 'model_'.$controller_name;
		$controller_name = 'controller_'.$controller_name;
		$action_name = 'action_'.$action_name;
		// подцепляем файл с классом модели (файла модели может и не быть)
		$model_file = strtolower($model_name).'.php';
		$model_path = "application/model/".$model_file;
		if(file_exists($model_path))
		{
			include "application/model/".$model_file;
		}

		// подцепляем файл с классом контроллера
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "application/controllers/".$controller_file;
		if(file_exists($controller_path))
		{
			include "application/controllers/".$controller_file;
		}
		else
		{
		    //Исключение
			Route::ErrorPage404();
		}
		
		// создаем контроллер
        $action = $action_name;
		if(class_exists($controller_name) &&  method_exists($controller_name, $action))
		{
		    $controller = new $controller_name();
			// вызываем действие контроллера 
			$controller->$action();
		}
		else
		{
			Route::ErrorPage404();
		}

		session_write_close();
	}

    /**
     * Функция для перенаправления посетителя
     * @param string $to
     */
	public static function Redirect(string $to)
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].$to;
        header('Location:'.$host);
    }

    /**
     * Ошибка 404
     */
    public static function ErrorPage404()// : void
	{
		$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
		header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404.html');
    }

    /**
     * Ошибка 400
     */
	public static function ErrorPage400()// : void
	{
		$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
		header('HTTP/1.1 400 Bad Request');
		header("Status: 400 Bad Request");
		header('Location:'.$host.'400');
	}
}
