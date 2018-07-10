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
        if( $entry != 0)
        {
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
        $sql_cust_i = 'INSERT INTO `customers`( `fio`, `number`, `email`, `is_sell`) VALUES ( ?, ?, ?, 1)';
        $sql_cust_u = 'UPDATE `customers` SET `number`=? ,`email`=?, `is_sell`=1 WHERE `id`=?';
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
        `broker_id`,
        `is_part`
        )
        VALUES( ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, "", ?, ?, ?)';
        $sql_image_up = 'UPDATE `products` SET `images`=? WHERE `id`=?';

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
        $is_part = (isset($payload['part']) and $payload['part'] == 'on') ? 1 : 0;
        $cat = (!isset($payload['subcat'])) ? $payload['cat'] : $payload['subcat'];

        $result = Database::run( $sql_product_i, [ $payload['name'], $cust_id, $payload['cost'], $payload['earn_p_m'], $payload['oborot_p_m'], $payload['rashod_p_m'], $cat, $payload['city'], $payload['address'], $payload['about'], $payload['shtat'], $is_conf, $payload['broker'], $is_part]);

        $id = Database::lastInsertId();

        $n = [];
        $i = 1;
        foreach ($_FILES as $key => $file) {
            if ( Image::verify($file) == 1)
            {
                $hash =  substr(md5($id), 7);
                $path = $_SERVER['DOCUMENT_ROOT'].'/'.PATH['image_biznes'].$hash;
                mkdir( $path, 0766, TRUE);
                $ext = explode('/', $file['type'])[1];
                move_uploaded_file($file['tmp_name'], $path.'/'.$i.'.'.$ext);

                $new['name'] = $hash.'/'.$i.'.'.$ext;
                $new['alt'] = $payload['images_alt'][$i];
                $n[] = $new;
                $i++;
            }
        }
        $images = json_encode($n, JSON_OBJECT_AS_ARRAY);
        //var_dump($payload['images_alt'], json_encode($n, JSON_INVALID_UTF8_IGNORE | JSON_OBJECT_AS_ARRAY));

        $stmt = Database::run($sql_image_up, [$images, $id]);

        // Database::run('DELETE FROM `submit_products` WHERE `id`=?', [$payload['id']]);
        return $result;
    }

    public function public_text ($p)
    {
        $sql_f = 'SELECT `id` FROM `semantic_text` WHERE `cat`=? AND `subcat`=?';
        $sql_i = 'INSERT INTO `semantic_text`(`region`, `cat`, `text1`,`text2`) VALUE ( ?, ?, ?, ?)';
        $sql_u = 'UPDATE `semantic_text` SET `text1`=?, `text2`=? WHERE `id`=?';

        $f = Database::run($sql_f, [$p['cat'], $p['region']])->fetch(PDO::FETCH_NUM);
        if ( $f > 0)
        {
            $result = Database::run($sql_u, [$p['text1'], $p['text2'], $f]);
        }else
        {
            $result = Database::run($sql_i, [ $p['region'], $p['cat'], $p['text1'], $p['text2'] ]);
        }

        return $result;
    }
}