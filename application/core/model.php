<?php
class model
{
	/*
	* Класс Модели отвечает за получение данных
	* Имеет функию получения данных по умолчанию
	*/
	public static $DBH;

    /**
     * Model constructor
     * Подключаемся к MySQL
     */
	public function __construct()
    {
        try
        {
            self::$DBH = Database::instance( PDO['host'], PDO['database'], PDO['charset'], PDO['user'], PDO['password']);
        }catch(PDOException $a)
        {
            $a->getMessage();
        }

    }
	public function get_data()
	{
	}
}
