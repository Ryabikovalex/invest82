<?php
class View
{
	/**
	* Класс Видов отвечает за представление данных полученных из модели
	* По умолчанию функция генерации контента
	*/
	protected static $template_view = 'template_view.php'; // здесь можно указать общий вид по умолчанию.
	
	/**
    * Создаем страницу для пользователя
	* @param string $content_view Название вида для оторажения информации
	* @param array $data Информация
	*
	*/
	public static function generate($content_view, $data)
	{
		if(is_array($data)) {
			// преобразуем элементы массива в переменные
			extract($data);
		}
		//Подключаем нужный нам вид
		include 'application/views/'.self::$template_view;
	}
}
