<?php

class model_main extends model
{
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