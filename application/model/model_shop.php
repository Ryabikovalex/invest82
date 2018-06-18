<?php
class model_shop extends model
{
    public function getList( int $from = 0,int $to = 49, $arg, ...$params)
    {
        list( $_sort) = $params;
        $sql = 'SELECT `id`, `name`, `added`, `cost`, `category_id`, `city_id`,  `status`, `images`, `is_conf`, `CY`.`cityName`, `CY`.`cityTranslit`, `CY`.`cityE`, `R`.`regTranslit`, `R`.`regE`, `SC`.`scTranslit`, `SC`.`scE`, `CT`.`ctE`, `CT`.`ctTranslit` FROM `products` LEFT JOIN (SELECT `id` AS `cityId`, `name` AS `cityName`, `region_id`, `translit` AS `cityTranslit`, `is_enabled` AS `cityE` FROM `city` WHERE `country_id`=3159) `CY` ON `city_id`=`CY`.`cityId` LEFT JOIN (SELECT `id` AS `regId`, `translit` AS `regTranslit`, `is_enabled` AS `regE` FROM `region` WHERE `country_id`=3159 ) `R` ON `CY`.`region_id`=`R`.`regId` LEFT JOIN (SELECT `id` AS `scId`, `translit` as `scTranslit`, `is_enabled` AS `scE`,`parent` FROM `categories` WHERE `parent`!=0) `SC` ON `category_id`=`SC`.`scId` LEFT JOIN ( SELECT `id` AS `ctId`, `is_enabled` AS `ctE`, `translit` AS `ctTranslit` FROM `categories` WHERE `parent`=0) `CT` ON `SC`.`parent`=`CT`.`ctId`';
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
                }

                $v = count($value) > 1 ? ' IN ("'.implode('", "', $value).'") ' : '="'.$value[0].'"';
                $sql.= ' AND '.$column.$v;
            }
        }

        $sql .= ' ORDER BY `added` DESC';

        $sql .= ' LIMIT {from}, {to}';
        $sql = str_replace('{from}', $from, $sql);
        $sql = str_replace('{to}', $to, $sql);
        $stmt = DataBase::run($sql, $payload);
        $fetch = $stmt->fetchAll(PDO::FETCH_NUM);
        return $fetch;
    }
}