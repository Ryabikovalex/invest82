<?php
class model_manager extends model
{
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
        $result['products_count'] = Database::run('SELECT COUNT(*) FROM `products`')->fetch(PDO::FETCH_NUM)[0];
        $result['reports_count'] = 0;
        $result['submit_buyers_count'] = Database::run('SELECT COUNT(*) FROM `submit_buyers`')->fetch(PDO::FETCH_NUM)[0];
        $result['submit_products_count'] = Database::run('SELECT COUNT(*) FROM `submit_products`')->fetch(PDO::FETCH_NUM)[0];
        $result['brokers_count'] = Database::run('SELECT COUNT(*) FROM `brokers`')->fetch(PDO::FETCH_NUM)[0];
        $result['buyers_count'] = Database::run('SELECT COUNT(*) FROM `buyers`')->fetch(PDO::FETCH_NUM)[0];
        $result['customers_count'] = Database::run('SELECT COUNT(*) FROM `customers`')->fetch(PDO::FETCH_NUM)[0];
        return $result;
    }

    /** Просмотреть новые бизнесы
     * @param $from
     * @param $to
     *
     * @return array список бизнесов
     */
    public function show_new_products($from, $to)
    {
        $result = [];
        $sbmt_sql = 'SELECT `id` AS `productID`, `name`, `cost`, `earn_p_m`, `C`.`regionName`, `address`, `about`, `added`, `is_conf`, `A`.`fio`, `A`.`number` FROM `submit_products` LEFT JOIN( SELECT `id` AS `cId`, `fio`, `number` FROM `customers` ) `A` ON `customer_id` = `A`.`cId` LEFT JOIN( SELECT `id` AS `rID`, `name` AS `regionName` FROM `region` WHERE `country_id` = 3159 ) `C` ON `region_id` = `C`.`rID` ORDER BY  `added` ASC LIMIT {from}, {to}';
        $sbmt_sql = str_ireplace( ['{from}', '{to}'], [ $from, $to], $sbmt_sql);
        $stmt = Database::run($sbmt_sql)->fetchAll(PDO::FETCH_NUM);
        foreach ($stmt as $k => $v)
        {
            $arr_size = count($v);
            for ( $i=0; $i < $arr_size; $i++)
            {
                if ( $i != 7 and $i != 8 and ($v[$i] === '' or $v[$i] === 0 or $v[$i] === null) )
                    $v[$i] = '<span class="text-secondary">Неизвестно</span>';
                if ($i == 7)
                {
                    if ( $v[$i]== '0000-00-00 00:00:00' )
                {
                    $v[$i] = '<p class="text-secondary">Неизвестно</p>';
                }else
                {
                    $v[$i] = date( 'd.m.Y', strtotime( substr($v[$i], 0, 10) ) );
                }
                }
                if ( $i == 8)
                {
                    if ($v[$i] == 1)
                        $v[$i] = '<span class="badge badge-danger">Конфидециально</span>';
                    else
                        $v[$i] = '';
                }
                if (($i == 2 or $i == 3) and is_int((int)$v[$i]) == true )
                {
                   $v[$i] = format_cost($v[$i]);
                }
            }
            $result[] = $v;
        }

        return $result;
    }

    /** Показывает регионы , кол-во брокеров и покупателей, городов
     * @param $from
     * @param $to
     *
     * @return array
     */
    public function show_regions( $from, $to)
    {
        $sql0 = 'SELECT `id`, `name`, `header`, `translit`, `is_enabled`,`A`.`cities`, `C`.`count`, `D`.`buyers` FROM `region` LEFT JOIN (SELECT `region_id` AS `regId`, COUNT(*) AS `cities` FROM `city`  WHERE `country_id`=3159 GROUP BY `regId`) `A` ON `id`=`A`.`regId` LEFT JOIN (SELECT `region_id` AS `rId`, COUNT(*) AS `count` FROM `brokers`) `C` ON `id`=`C`.`rId` LEFT JOIN (SELECT `region` AS `reId`, COUNT(*) AS `buyers` FROM `buyers`) `D` ON `id`=`D`.`reId` WHERE  `country_id`=3159 ORDER BY `name` ASC LIMIT {from},{to}';
        $sql0 = str_ireplace( ['{from}', '{to}'], [ $from, $to], $sql0);
        $stmt = Database::run($sql0)->fetchAll(PDO::FETCH_NUM);
        foreach ($stmt as $k => $arr)
        {
            foreach ($arr as $i => $v)
            {
                if (is_null($v))
                {
                    $stmt[$k][$i] = 0;
                }
            }
        }
        $result = $stmt;

        return $result;
    }

    public function show_cities($from, $to,int $region_id = 0)
    {
        $sql = 'SELECT `id`, `name`, `header`, `translit`, `is_enabled`, `region_id`, `A`.`regionName`, `B`.`products`, `C`.`buyers` FROM `city` LEFT JOIN (SELECT `id` AS `regId`, `name` AS `regionName` FROM `region`  WHERE `country_id`=3159) `A` ON `region_id`=`A`.`regId` LEFT JOIN (SELECT `city_id`, COUNT(*) AS `products` FROM `products` GROUP BY `city_id`) `B` ON `id`=`B`.`city_id` LEFT JOIN (SELECT `city` AS `bId`, COUNT(*) AS `buyers` FROM `buyers` GROUP BY `city`) `C` ON `id`=`bId`  WHERE  `country_id`=3159 {replace} ORDER BY `name` ASC LIMIT {from},{to}';
        $replace = ( $region_id !== 0 ) ? 'AND `region_id`='.$region_id : '';
        $sql = str_ireplace( ['{from}', '{to}', '{replace}'], [ $from, $to, $replace], $sql);

        $stmt = Database::run($sql)->fetchAll(PDO::FETCH_NUM);
        foreach ($stmt as $k => $arr)
        {
            foreach ($arr as $i => $v)
            {
                if (is_null($v))
                {
                    $stmt[$k][$i] = 0;
                }
            }
        }
        $result = $stmt;
        return $result;
    }

    public function show_new_buyers()
    {

    }

    /** Одобрение заявок на продажу бизнеса
     * @param $entry ID бизнеса
     *
     * @return array
     */
    public function submit_product ( $entry)
    {
        $result = [];
        $sql0 = 'SELECT `id`, `name`, `A`.`fio`, `A`.`number`, `A`.`email`, `cost`, `earn_p_m`, `address`, `about`, `is_conf` FROM `submit_products` LEFT JOIN ( SELECT `id` AS `cusId`, `fio`, `number`, `email` FROM `customers`) `A` ON `customer_id`=`A`.`cusId` WHERE `id`=?';
        $stmt = Database::run($sql0, [$entry])->fetchAll(PDO::FETCH_NUM)[0];
        foreach ($stmt as $k => $v)
        {
            if ( $v === null)
            {
                $result[] = '';
            }else
            {
                $result[] = $v;
            }
        }
        return $result;
    }

    /**Краткая информация о брокерах для форм
     * @return array
     */
    public function get_brokers ()
    {
        return Database::run('SELECT `id`,`fio`, `A`.`name` FROM `brokers` LEFT JOIN (SELECT `id` AS `regId`,`name` FROM `region` WHERE `country_id`=3159) `A` ON `region_id`=`A`.`regId`')->fetchAll(PDO::FETCH_NUM);
    }


    /** Публикация нового бизнеса
     * Сначала добавляется или обновляется информация о продавце\
     *  Затем добавляется продукт в базу
     *
     * @param $payload
     *
     * @return PDOStatement
     */
    public function public_product ( $payload)
    {
        $sql_cust_i = 'INSERT INTO `customers`( `fio`, `number`, `email`) VALUES ( ?, ?, ?)';
        $sql_cust_u = 'UPDATE `customers` SET `number`=? ,`email`=? WHERE `id`=?';
        $sql_product_i = 'INSERT INTO `products`(
        `name`,
        `customer_id`,
        `added`,
        `cost`,
        `earn_p_m`,
        `oborot_p_m`,
        `rashod_p_m`,
        `category_id`,
        `city_id`,
        `address`,
        `about`,
        `shtat`,
        `status`,
        `images`,
        `is_conf`,
        `broker_id`
        )
        VALUES( ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?, ?)';

        $customer = Database::run('SELECT * FROM `customers` WHERE `fio`=?', [$payload['fio']])->fetch(PDO::FETCH_ASSOC);
        if ( !$customer)
        {
            $s_cust = Database::run($sql_cust_i, [ $payload['fio'], $payload['number'], $payload['email']]);
            $cust_id = Database::run('SELECT * FROM `customers` WHERE `fio`=?', [$payload['fio']])->fetch(PDO::FETCH_COLUMN);
        }else
        {
            $cust_id = $customer['id'];
            $new_number = (strlen($payload['number']) > 0) ? $payload['number'] : $customer['number'];
            $new_email = (strlen($payload['email']) > 0) ? $payload['email'] : $customer['email'];
           $s_cust = Database::run($sql_cust_u, [ $new_number, $new_email, $customer['id']]);
        }

        $is_conf = (isset($payload['conf']) and $payload['conf'] == 'on') ? 1 : 0;
        $cat = (!isset($payload['subcat'])) ? $payload['cat'] : $payload['subcat'];

        if ($payload['id'] == 0)
        {
            $images = '[]';
        }else
        {
            $images = Database::run('SELECT `images` FROM `submit_products` WHERE `id`=?', [$payload['id']])->fetch(PDO::FETCH_COLUMN);
            Database::run('DELETE FROM `submit_products` WHERE `id`=?', [$payload['id']]);
        }
        $result = Database::run( $sql_product_i, [ $payload['name'], $cust_id, $payload['cost'], $payload['earn_p_m'], $payload['oborot_p_m'], $payload['rashod_p_m'], $cat, $payload['city'], $payload['address'], $payload['about'], $payload['shtat'], $images, $is_conf, $payload['broker']]);

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

    public function toggle_entry($table,  $id)
    {
        $sql0 = str_ireplace( '{table}', $table, 'SELECT `is_enabled` FROM `{table}` WHERE `id`=?');
        $sql1 = str_ireplace( '{table}', $table, 'UPDATE `{table}` SET `is_enabled`={toggle} WHERE `id`='.$id);

        $t = (int)DataBase::run($sql0, [$id])->fetchColumn()[0];
        $toggle = ($t+1)%2;

        $sql1 = str_replace('{toggle}', $toggle, $sql1);
        var_dump($sql1);
        $result = parent::$DBH->query($sql1);
        return $result;
    }

    public function delete_entry( string $table, $id)
    {
        $sql = 'DELETE FROM `{table}` WHERE `id`=?';
        $sql = str_ireplace('{table}', $table, $sql);
        $stmt = Database::run($sql, [$id]);
        return $stmt;
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