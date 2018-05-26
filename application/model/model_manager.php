<?php
class model_manager extends model
{
    /**
     * Сбор статистики и вывод категорий для главной страницы
     * @return array
     */
    public function collect_statistic() : array
    {
        $result = [ 'categories' => []];
        $sql0 = 'SELECT * FROM `categories` WHERE `categories`.`level` = 0';
        $sql1 = 'SELECT * FROM `categories` WHERE `categories`.`level` = 1 AND `categories`.`parent`=?';
        $sql2 = 'SELECT COUNT(`categories`.`id`) FROM `categories` WHERE `categories`.`level`=1 GROUP BY `categories`.`parent`  ORDER BY COUNT(`categories`.`id`) DESC';
        $MAX_ROWS = DataBase::run($sql2, [])->fetchAll(PDO::FETCH_COLUMN)[0];


        $cat_stmt = DataBase::run($sql0, [])->fetchAll(PDO::FETCH_NUM);
        $result['categories']['main'] = $cat_stmt;
        $subcat_stmt = [];
        for ($i=0; $i < sizeof($cat_stmt); $i++)
        {
            $_cat[] = $cat_stmt[$i][0];
            $subcat_stmt[] = DataBase::run($sql1, [$cat_stmt[$i][0]])->fetchAll(PDO::FETCH_NUM);
        }
        $result['categories']['sub'] = $subcat_stmt;

        //var_dump($subcat_stmt);

        return $result;
    }

    public function toggle_entry( $id)
    {
        $sql0 = 'SELECT `categories`.`is_enabled` FROM `categories` WHERE `categories`.`id`=?';
        $sql1 = 'UPDATE `categories` SET `categories`.`is_enabled`={toggle} WHERE `categories`.`id`='.$id;

        $t = (int)DataBase::run($sql0, [$id])->fetchColumn()[0];
        $toggle = ($t+1)%2;

        $sql1 = str_replace('{toggle}', $toggle, $sql1);
        $result = parent::$DBH->query($sql1);

            return $result;
    }



    /** Просмотр БД администраторами
     * @param string $db название таблицы
     * @param int $from
     * @param int $to
     * @param array $param параметры сортировки
     *
     * @return array $data
     */
    public function get_list(string $db, int $from = 0, int $to = 25, array $param = array()) : array
    {
        switch ($db) {
            case 'cities':
                $query = 'SELECT * FROM `cities`';
                break;
            case 'products':
                $query = 'SELECT `products`.`id`, `products`.`name`, `products`.`cost`, `B`.`name` AS `cityName`, `products`.`address`, `A`.`name` AS `catName`, `products`.`about` FROM `products` LEFT JOIN (SELECT `cities`.`id`, `cities`.`name` FROM `cities` ) `B` ON `products`.`city`=`B`.`id` LEFT JOIN (SELECT `categories`.`id`, `categories`.`name` FROM `categories`)`A` ON `products`.`category` = `A`.`id` ';
                break;
            case 'customers':
                break;
        }
        if (is_array($param) and count($param) !== 0)
        {
            $query .= ' ORDER BY '.array_keys($param)[0];
            switch(array_values($param)[0])
            {
                case 1:
                    $query .= ' ASC ';
                    break;
                case 2:
                    $query .= ' DESC ';
                    break;
            }
        }
        $query.= " LIMIT ".$from.", ".$to;
        var_dump($query);
        $result = Database::run($query, [])->fetchAll(PDO::FETCH_NUM);
        return $result;
    }

    /**
     * Выбор записи для редактирования
     * @param string $table Таблица
     * @param int $id Запись в таблице
     * @return array $data
     */
    public function get_entry(string $table,int $id) : array
    {
        $query = 'SELECT * FROM `'.$table.'` WHERE `id`=?';
        $data['row'] = Database::run($query, [ $id])->fetchAll()[0];
        if ($table == 'products')
        {
            $sql0 = 'SELECT `categories`.`id`,`categories`.`name` FROM `categories` WHERE `categories`.`level` =0 ';
            $sql1 = 'SELECT `categories`.`id`,`categories`.`name` FROM `categories` WHERE `categories`.`level` =1 ';
            $parents = Database::run($sql0, [])->fetchAll();
            $data['select'] = Database::run($sql1, [])->fetchAll(PDO::FETCH_NUM);
            var_dump($data['select'], $parents);
        }
        $data['table'] = $table;
        $data['entry'] = $id;
        var_dump($data['row']);
        unset($data['row']['id']);
        foreach (array_keys($data['row']) as $key )
        {
            if(is_int($key))
                unset($data['row'][$key]);
        }
        return $data;
    }

    /**
     * Обновление записи
     * @param array $row Новые данные
     * @param string $table название таблицы
     * @param int $id
     * @return array $data
     */
    public function edit_entry(array $row, string $table, int $id) : array
    {
        $query = 'UPDATE `'.$table.'` SET ';
        $keys = array_keys($row);
        $values = array_values($row);
        for ($i = 0; $i < count($keys); $i++)
        {
            $query.= ' `'.$keys[$i].'`=?';
            if (($i+1) < count($keys))
                $query.= ', ';
			$arr[] = $values[$i];
        }
        $query.= ' WHERE `id`='.$id;
        var_dump($row, $query);
        $data['success'] = Database::run($query, $arr);
        return $data;
    }
}