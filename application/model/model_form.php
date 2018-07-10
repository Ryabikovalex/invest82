<?php
class model_form extends model{

    public function submit_biznes ( $payload)
    {
        $sql_add = 'INSERT INTO `customers`(`fio`, `number`, `email`, `is_sell`, `required_broker`) VALUES ( ?, ?, "", 1, 0) ON DUPLICATE KEY UPDATE `is_sell`=1, `number`=?';
        $sql_add_b = 'INSERT INTO `customers`(`fio`, `number`, `email`, `is_sell`, `required_broker`) VALUES ( ?, ?, "", 1, 1) ON DUPLICATE KEY UPDATE `is_sell`=1, `number`=?';
        if ( count($payload) > 3)
        {
            $sql_find = 'SELECT `id` FROM `customers` WHERE `fio`=?';
            $sql1 = 'INSERT INTO `submit_products`( `name`, `customer_id`, `cost`, `earn_p_m`, `region_id`, `address`, `about`, `images`, `added`, `is_conf`) VALUES ( ?, ?, ?, ?, ?, ?, ?, "[]", NOW(), ?)';

            $fetch = Database::run($sql_find, [$payload['fio']])->fetchColumn();

            if ($fetch != '')
            {
                $customer_id = $fetch;
            }else
            {
                Database::run($sql_add, [ $payload['fio'], $payload['number'], $payload['number']]);
                $customer_id = Database::lastInsertId();
            }

            $is_conf = ( isset($payload['is_conf']) and $payload['is_conf']=='on') ? 1 : 0;

            $stmt = Database::run($sql1, [ $payload['name'], $customer_id, $payload['cost'], $payload['earn_p_m'], $payload['region'], $payload['address'], $payload['about'], $is_conf ]);
        }else{
            $stmt = Database::run($sql_add_b, [$payload['fio'], $payload['number'], $payload['number']] );
        }
        return $stmt;
    }

    public function get_uslugi()
    {
        $fetch = Database::run('SELECT `name`, `min_cost` FROM `uslugi` LIMIT 3')->fetchAll(PDO::FETCH_NUM);
        return $fetch;
    }

    /**
     * Проверка иконки пользователя перед загрузкой на сервер
     * @param array $icon Данные об иконке
     * @param string $login Логин польозователя
     * @return array Возвращает ошибки в случае неудачи
     */
    private function upload_icon(array $icon, string $login)
    {
        $this->set_image_default($login);
		
        $types = array( 'image/png', 'image/jpeg');
        $size = USER['default_icon_size'];
        if (empty($icon['type']) && !in_array($icon['type'], $types))
        {
            $data['error']['icon'][] = 'Формат файла .png, .jpeg';
        }
        if ($icon['size'] > $size) {
            $data['error']['icon'][] = 'Слишком большой файл';
        }
        $format = (!isset($icon['type'])) ? "def" : str_ireplace('image/', '', $icon['type']);
        $to = $_SERVER['DOCUMENT_ROOT'].USER['path_icon'].$login.".".$format;
        if (!isset($data['error']['icon'])) {
            if (!copy($icon['tmp_name'], $to))
            {
                $data['error']['icon'][] = 'Загрузка не удалась';
            }else {
                $data['icon'] = $format;
                // $query = 'UPDATE user SET user_icon=? WHERE user_login=?';
                //$result = DataBase::run($query, array($format, $login));
                if($result){
                    $data['success']['icon'] = 'Иконка успешно загружена';
                }
            }
        }
        return $data;
    }

	/**
     * Смена иконки пользователя по умолчанию
     * @param string $login Логин польозователя
     */	
	private function set_image_default( string $login)
	{
		$query = 'SELECT user_icon FROM user WHERE user_login=?';
        $prev = DataBase::run($query, [$login])->fetchAll()[0][0];
		$str = $_SERVER['DOCUMENT_ROOT'].USER['path_icon'].$login.".".$prev;
        unlink($str);
		$query = 'UPDATE user SET user_icon=? WHERE user_login=?';
		$res = DataBase::run($query, ["def", $login]);
	}
}

