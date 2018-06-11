<?php
class model_manager extends model
{
    /**
     * Сбор статистики и вывод новых поступлений для главной страницы
     * @return array
     */
    public function collect_statistic($from, $to) : array
    {
        $result = [ 'submit_products' => []];
        $result['submit_products_count'] = Database::run('SELECT COUNT(`id`) FROM `submit_products`')->fetch(PDO::FETCH_NUM)[0];

        return $result;
    }

    public function show_new_products($from, $to)
    {
        $result = [];
        $sbmt_sql = 'SELECT `id` AS `productID`, `name`, `cost`, `earn_p_m`, `C`.`regionName`, `B`.`cityName`, `address`, `about`, `added`, `is_conf`, `A`.`fio`, `A`.`number` FROM `submit_products` LEFT JOIN( SELECT `id` AS `cId`, `fio`, `number` FROM `customers` ) `A` ON `customer_id` = `A`.`cId` LEFT JOIN( SELECT `id` AS `cityId`, `name` AS `cityName`, `region_id` as `regId` FROM `city` WHERE `country_id` = 3159 ) `B` ON `city_id` = `B`.`cityID` LEFT JOIN( SELECT `id` AS `rID`, `name` AS `regionName` FROM `region` WHERE `country_id` = 3159 ) `C` ON `B`.`regId` = `C`.`rID` ORDER BY  `added` ASC LIMIT {from}, {to}';
        $sbmt_sql = str_ireplace( ['{from}', '{to}'], [ $from, $to], $sbmt_sql);
        $stmt = Database::run($sbmt_sql)->fetchAll(PDO::FETCH_NUM);
        foreach ($stmt as $k => $v)
        {
            $arr_size = count($v);
            for ( $i=0; $i < $arr_size; $i++)
            {
                if ( $i != 8 and $i != 9 and ($v[$i] === '' or $v[$i] === 0 or $v[$i] === null) )
                    $v[$i] = '<span class="text-secondary">Неизвестно</span>';
                if ($i == 8)
                {
                    if ( $v[$i]== '0000-00-00 00:00:00' )
                {
                    $v[$i] = '<p class="text-secondary">Неизвестно</p>';
                }else
                {
                    $v[$i] = date( 'd.m.Y', strtotime( substr($v[$i], 0, 10) ) );
                }
                }
                if ( $i == 9)
                {
                    if ($v[$i] == 1)
                        $v[$i] = '<span class="badge badge-danger">Конфидециально</span>';
                    else
                        $v[$i] = '';
                }
            }
            $result[] = $v;
        }

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