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
            //$a->getMessage();
        }

    }

    /**
     * Сбор статистики и вывод новых поступлений для главной страницы
     * @return array
     */
    public function collect_statistic() : array
    {
        $result['regions_active_count'] = Database::run('SELECT COUNT(*) FROM `region` WHERE `country_id`=3159 AND `is_enabled`=1')->fetch(PDO::FETCH_NUM)[0];
        $result['regions_count'] = Database::run('SELECT COUNT(*) FROM `region` WHERE `country_id`=3159')->fetch(PDO::FETCH_NUM)[0];
        $result['city_count'] = Database::run('SELECT COUNT(*) FROM `city` WHERE `country_id`=3159')->fetch(PDO::FETCH_NUM)[0];
        $result['city_active_count'] = Database::run('SELECT COUNT(*) FROM `city` WHERE `country_id`=3159 AND `is_enabled`=1')->fetch(PDO::FETCH_NUM)[0];
        $result['cat_active_count'] = Database::run('SELECT COUNT(*) FROM `categories` WHERE `parent`=0 AND `is_enabled`=1')->fetch(PDO::FETCH_NUM)[0];
        $result['cat_count'] = Database::run('SELECT COUNT(*) FROM `categories` WHERE `parent`=0')->fetch(PDO::FETCH_NUM)[0];
        $result['subcat_active_count'] = Database::run('SELECT COUNT(*) FROM `categories` WHERE `parent`!=0 AND `is_enabled`=1')->fetch(PDO::FETCH_NUM)[0];
        $result['subcat_count'] = Database::run('SELECT COUNT(*) FROM `categories` WHERE `parent`!=0')->fetch(PDO::FETCH_NUM)[0];
        $result['products_count'] = Database::run('SELECT COUNT(*) FROM `products`')->fetch(PDO::FETCH_NUM)[0];
        $result['reports_count'] = 0;
        $result['submit_buyers_count'] = Database::run('SELECT COUNT(*) FROM `submit_buyers`')->fetch(PDO::FETCH_NUM)[0];
        $result['submit_products_count'] = Database::run('SELECT COUNT(*) FROM `submit_products`')->fetch(PDO::FETCH_NUM)[0];
        $result['brokers_count'] = Database::run('SELECT COUNT(*) FROM `brokers`')->fetch(PDO::FETCH_NUM)[0];
        $result['buyers_count'] = Database::run('SELECT COUNT(*) FROM `buyers`')->fetch(PDO::FETCH_NUM)[0];
        $result['customers_count'] = Database::run('SELECT COUNT(*) FROM `customers`')->fetch(PDO::FETCH_NUM)[0];
        return $result;
    }

    /**
     * Переключение записи
     * @param $table string Имя таблицы
     * @param $id
     *
     * @return mixed
     */
    public function toggle_entry($table,  $id)
    {
        $sql0 = str_ireplace( '{table}', $table, 'SELECT `is_enabled` FROM `{table}` WHERE `id`=?');
        $sql1 = str_ireplace( '{table}', $table, 'UPDATE `{table}` SET `is_enabled`={toggle} WHERE `id`='.$id);

        $t = (int)DataBase::run($sql0, [$id])->fetchColumn()[0];
        $toggle = ($t+1)%2;

        $sql1 = str_replace('{toggle}', $toggle, $sql1);
        $result = self::$DBH->query($sql1);
        return $result;
    }

    /**Удаление записии из таблицы
     * @param string $table Имя таблицы
     * @param $id
     *
     * @return PDOStatement
     */
    public function delete_entry( string $table, $id)
    {
        $sql = 'DELETE FROM `{table}` WHERE `id`=?';
        $sql = str_ireplace('{table}', $table, $sql);
        $stmt = Database::run($sql, [$id]);
        return $stmt->rowCount();
    }

    /**Краткая информация о брокерах для форм
     * @return array
     */
    public function get_brokers ()
    {
        return Database::run('SELECT `id`,`fio`, `A`.`name` FROM `brokers` LEFT JOIN (SELECT `id` AS `regId`,`name` FROM `region` WHERE `country_id`=3159) `A` ON `region_id`=`A`.`regId`')->fetchAll(PDO::FETCH_NUM);
    }
}