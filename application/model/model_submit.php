<?php

class model_submit extends model{

    /** Одобрение заявок на продажу бизнеса
     * @param $entry string ID бизнеса
     *
     * @return array
     */
    public function product ( $entry)
    {
        $result = [];
        $sql0 = 'SELECT `id`, `name`, `A`.`fio`, `A`.`number`, `A`.`email`, `cost`, `earn_p_m`, `region_id`, `address`, `about`, `is_conf` FROM `submit_products` LEFT JOIN ( SELECT `id` AS `cusId`, `fio`, `number`, `email` FROM `customers`) `A` ON `customer_id`=`A`.`cusId` WHERE `id`=?';
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
}