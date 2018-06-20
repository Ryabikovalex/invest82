<?php
final class Route
{
    public static $arg = [];
    /**
     * @var string URL без GET
     */
	public static $url = '/';

    /**
     * @param $arr array Массив URL
     * @param $start_elem int начальная позиция
     * @param $key int ключ аргумента
     */

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


        // контроллер и действие по умолчанию
        $controller_name = 'main';
        $action_name = 'index';

        if ( !empty($routes[1]))
        {
            $controller_name = $routes[1];
        }
        if ( !empty($routes[2]) )
        {
            $action_name = $routes[2];
        }
        session_start();
        //Запрет на доступ к администрированию
        if (!isset($_SESSION['auth']) )
        {
            $controller_name = 'log';
            $action_name = 'in';
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
