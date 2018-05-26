<?php
final class Route
{
    public static $arg;
	public static $url;
	private static $key_word = 'p';
    private static function setParams($arr, $start_elem)
    {
        $arr_size = count($arr);
        for($i = $start_elem; $i < $arr_size; $i++)
        {
            array_push(self::$arg['p'], $arr[$i]);
        }
    }
    /**
     *  Запуск маршрутизации
     */
	public static function start()
	{
        /***
         * $routes = explode('/', $_SERVER['REQUEST_URI']);
        if (isset($_GET) and count($_GET) > 0)
        {
        array_pop($routes);
        }
        $routes_size = count($routes);

        $controller_name = (!empty($routes[1] and $routes[1] !== self::$key_word) ?  $routes[2] : 'list';
        $action_name = (!empty($routes[2] and $routes[2] !== self::$key_word) ?  $routes[2] : 'index';

        for ($i=0; $i<$routes_size; $i++){
        if(!empty($routes[$i]) and $routes[$i] === self::$key_word){
        self::setParams($routes, $i+1);
        }
        }
         */
	    // контроллер и действие по умолчанию
		$controller_name = 'list';
		$action_name = 'index';
		
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if (isset($_GET) and count($_GET) > 0)
        {
            array_pop($routes);
        }
        self::$url = implode('/', $routes);

		if (count($routes) > 1)
        {
            switch ($routes[1])
            {
                case 'manager':
                case 'error  ':
                    // получаем имя контроллера
                    if ( !empty($routes[1]) )
                        $controller_name = $routes[1];

                    // получаем имя экшена
                    if ( !empty($routes[2]))
                    {
                        $action_name = preg_match( '/\d+/', $routes[2]) ? 'index' : $routes[2] ;
                    }
                    for( $i = 3; $i < count($routes)-2; $i+=2) {
                        self::$arg[$routes[$i]] = htmlentities($routes[$i + 1]);
                    }
                    break;
                case 'product':
                    $controller_name = $routes[1];
                    self::$arg['product_id'] =  $routes[2];
                    break;
                default:
                        self::$arg['p'] = array_slice($routes, 1, 3);
                    break;
            }
        }else
        {
            self::$arg['p'] = [''];
        }

		// добавляем префиксы
		$model_name = 'model_'.$controller_name;
		$_SESSION['model_main'] = $model_name;
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
			//Route::ErrorPage404();
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
			//Route::ErrorPage404();
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
		header('Location:'.$host.'404');
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
