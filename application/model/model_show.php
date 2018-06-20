<?php
class model_show extends model{

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
}

