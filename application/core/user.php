<?php
class user
{
    private $id;
    public $login;
    protected $access;
    protected $email;
    protected $date_of_registry;

    /**
     * @param int $id ID в базе данных
     * @param string $login Логин
     * @param string $email эл. почта польщователя
     * @param int $access Уровень доступа
     *
     * Создаем объект пользователя
     */
    public function __construct( int $id,string $login, string $email, int $access)
    {
        $this->id = $id;
        $this->login = $login;
        $this->access = $access;
        $this->email = $email;
    }

    /**
     * Показывает id пользователя в БД
     * @return int id пользлвателя
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Показывает уровень доступа
     * @return int Уровень доступа
     */
    public function getAccess()
    {
        return $this->access;
    }
    /**
     * Показывает эл. почту
     * @return string эл.почта
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Присваивает эл. почту
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

}