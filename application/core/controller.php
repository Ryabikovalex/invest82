<?php
abstract class controller {
	
	/**
	* Класс Контроллер отвечает за связь между видами и моделями
	* Имеет функцию по умолчанию
	* Все методы пользователя начинаются с action_
	*/

	protected $model;//Модель
	protected $data = null;
	
	//Конструктор
	function __construct()
	{

	}

	abstract public function action_index();

    /**
     * @param string $view Название вида
     * @param array $data Данные для отображения
     */
	public function call_view(string $view, array $data)
    {
	    View::generate( $view, $data);
    }
}
