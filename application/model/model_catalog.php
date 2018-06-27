<?php
class model_catalog extends model
{
    public function getList( int $from = 0,int $to = 49, $arg, ...$params)
    {
        list( $_sort) = $params;
        $sql = 'SELECT `id`, `name`, `added`, `cost`, `category_id`, `city_id`,  `status`, `images`, `is_conf`, `CY`.`cityName`, `CY`.`cityTranslit`, `CY`.`cityE`, `R`.`regTranslit`, `R`.`regE`, `SC`.`scTranslit`, `SC`.`scE`, `CT`.`ctE`, `CT`.`ctTranslit`, `earn_p_m`, `is_part` FROM `products` LEFT JOIN (SELECT `id` AS `cityId`, `name` AS `cityName`, `region_id`, `translit` AS `cityTranslit`, `is_enabled` AS `cityE` FROM `city` WHERE `country_id`=3159) `CY` ON `city_id`=`CY`.`cityId` LEFT JOIN (SELECT `id` AS `regId`, `translit` AS `regTranslit`, `is_enabled` AS `regE` FROM `region` WHERE `country_id`=3159 ) `R` ON `CY`.`region_id`=`R`.`regId` LEFT JOIN (SELECT `id` AS `scId`, `translit` as `scTranslit`, `is_enabled` AS `scE`,`parent` FROM `categories` WHERE `parent`!=0) `SC` ON `category_id`=`SC`.`scId` LEFT JOIN ( SELECT `id` AS `ctId`, `is_enabled` AS `ctE`, `translit` AS `ctTranslit` FROM `categories` WHERE `parent`=0) `CT` ON `SC`.`parent`=`CT`.`ctId`';
        $payload = [];

        $sql .= ' WHERE `CY`.`cityE`=1 AND `R`.`regE`=1 AND `SC`.`scE`=1 AND `CT`.`ctE`=1 ';
        if (count($arg) > 0)
        {
            foreach ($arg as $k =>$value)
            {
                switch ($k)
                {
                    case 'region':
                        $column = '`R`.`regTranslit`';
                        break;
                    case 'city':
                        $column = '`CY`.`cityTranslit`';
                        break;
                    case 'cat':
                        $column = '`CT`.`ctTranslit`';
                        break;
                    case 'subcat':
                        $column = '`SC`.`scTranslit`';
                        break;
                    case 'part':
                        continue 2;
                }

                $v = count($value) > 1 ? ' IN ("'.implode('", "', $value).'") ' : '="'.$value[0].'"';
                $sql.= ' AND '.$column.$v;
            }
        }

        if ( isset($arg['part']))
        {
            $sql .= ' AND `is_part`=1';
        }else
        {
            $sql .= ' AND `is_part`=0';
        }

        $sql .= ' ORDER BY `added` DESC';
        if (count($params) > 0 and count($params[0]) > 0)
        {
            $sort = $params[0];
            if ( array_keys($sort)[0] = -1)
                $s = 'DESC';
            else
                $s = 'ASC';
            $sql.= ', `'.array_values($sort)[0].'` '.$s.' ';
        }

        $sql .= ' LIMIT {from}, {to}';
        $sql = str_replace('{from}', $from, $sql);
        $sql = str_replace('{to}', $to, $sql);
        $stmt = DataBase::run($sql, $payload);
        $fetch = $stmt->fetchAll(PDO::FETCH_NUM);
        return $fetch;
    }

    public function getEntry ( $id)
    {
        $sql_p = 'SELECT  `name`, `added`, `cost`, `earn_p_m`, `oborot_p_m`, `rashod_p_m`, `R`.`regName`, `CY`.`cityName`, `address`, `about`, `shtat`, `status`, `images`, `is_conf`, `customer_id`, `BR`.`brName`, `BR`.`brTel` FROM `products` LEFT JOIN (SELECT `id` AS `cityId`, `name` AS `cityName`, `region_id` FROM `city` WHERE `country_id`=3159) `CY` ON `city_id`=`CY`.`cityId` LEFT JOIN (SELECT `id` AS `regId`, `name` AS `regName` FROM `region` WHERE `country_id`=3159 ) `R` ON `CY`.`region_id`=`R`.`regId` LEFT JOIN (SELECT `id` as `brId`, `fio` as `brName`, `number` AS `brTel` FROM `brokers`) `BR` ON `broker_id`=`BR`.`brId` WHERE `id`={id} LIMIT 1';
        $sql_customer = 'SELECT `fio` FROM `customers` WHERE `id`=?';

        $res = Database::run(str_ireplace('{id}', (int)$id, $sql_p), [])->fetch(PDO::FETCH_NUM);
        if ( $res[13] == 0)
        {
            $str = Database::run($sql_customer, [$res[14]])->fetch(PDO::FETCH_NUM)[0];
            $str = substr($str, strpos($str, ' '));
            $res[] = $str;
        }

        return $res;
    }
}