<?php
class DataBase
{
    protected static $instance = null;
    public function __construct() {}
    public function __clone() {}
    /**
     * Инициализирует Подключение к БД
     * @param string $host Названние хоста
     * @param string $name Название БД
     * @param string $charset Кодировка
     * @param string $user Пользователь
     * @param string $pass Пароль
     * @return null|PDO
     */
    public static function instance(string $host, string $name, string $charset, string $user,string $pass)
    {
        if (self::$instance === null)
        {
            $opt  = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => TRUE,
            );
            $dsn = 'mysql:host='.$host.';dbname='.$name.';charset='.$charset;
            self::$instance = new PDO($dsn, $user, $pass, $opt);
        }
        return self::$instance;
    }
    /** Вызывает методы PDO
     * @param $method
     * @param $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        return call_user_func_array(array(self::$instance, $method), $args);
    }
    /**
     * Подготавливаетт и выполняет запрос к БД
     * @param string $sql запрос подготовленный
     * @param array $args массив аргументов
     * @return PDOStatement результат
     */
    public static function run(string $sql, $args = array())
    {
        $stmt = self::$instance->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}