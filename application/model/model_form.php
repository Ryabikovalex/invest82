<?php
class model_form extends model{

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
                $query = 'UPDATE user SET user_icon=? WHERE user_login=?';
                $result = DataBase::run($query, array($format, $login));
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
	
	
    /**
     * Проводит авторизацию пользователя
     * @param string $log электронная почта или логин пользователя
     * @param string $password пароль
     *
     * @return array $data возвращаем данные
     */
	public function sign_in(string $log, string $password) : array
	{
		$data['header'] = 'Авторизация';
		if (preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $log))
		{
		    $str = 'user_email';
        }else
        {
            $str = 'user_login';
        }
		$query = 'SELECT user_id, user_login, user_email, user_activation, user_access FROM user WHERE '.$str.'=? AND user_password=?';
		$result = DataBase::run($query, [$log, $password])->fetch(PDO::FETCH_NUM);
		list( $id, $login, $email, $activate, $access) = $result;
		if( !isset($id)){
			$data['login_status'] = 'access_denied';
		}else{
			if($activate == 1){
				$data['login_status'] = 'access_granted';
				$_SESSION['uh'] = new user($id, $login, $email, $access);
			}elseif($activate == 0){
				$data['login_status'] = 'access_not_activated';
			}else{
			    $data['login_status'] = 'access_locked';
            }
		}
		return $data;
	}

    /**
     * Выход пользователя с сайта
     * @return array $data
     */
	public function user_exit() : array
    {
		$data['header'] = 'Выход';
		$data['login_status'] = '';
		unset($_SESSION['uh']);
		unset($_SESSION['PHPSESSID']);
        session_destroy();
		session_write_close();
		return $data;
	}

	/**
     * Создаем нового пользователя
     * @param array $user
     * В $user лежит данные нового пользователя
     * @return array $data
     */
	public function set_new_user(array $user ) : array
    {
        $data['header'] = 'Регистрация';
        //Проверки введенных данных
        if($user['password0'] !== $user['password1'])
        {
            $data['error']['password'] = 'Пароли не совпадают';
        }else
        {
			$valid = $this->validate_password($user['password0']);
            if(is_array($valid))
			{
				$data['error']['password'] = $valid;
			}
        }
        $query1 = 'SELECT user_id FROM user WHERE user_login=?';
        $query2 = 'SELECT user_id FROM user WHERE user_email=?';

        $result = DataBase::run($query1, [$user['login']])->fetchAll();
        if( count($result) != 0)
        {
            $data['error']['login'] = 'Логин уже занят';
        }
        $result = DataBase::run($query2, [$user['email']])->fetchAll();
        if( count($result) != 0)
        {
            $data['error']['email'] = 'Данная почту уже зарегистрированна на сайте';
        }
		if(isset($user['icon']) and !empty($user['icon']))
		{
			$data = array_merge($data, $this->upload_icon($user['icon'], $user['login']) );
			$image = false;
		}else{
			$data['icon'] = "def";
		}
			
		if( key_exists( 'error', $data) === false or empty($data['error']) )
        {
            $query3 = "INSERT INTO user( user_login, user_email, user_password, user_icon, user_access, user_activation, user_registry) VALUES ( ?, ?, ?, ?, ?, ?, NOW() )";
			$arr = [$user['login'], $user['email'], md5(md5($user['password0'])), $data['icon'], USER['default_access'], USER['default_activation']];
            $result = DataBase::run($query3, $arr);
			if( $result == true) 
			{
                $data['success'] = 'Письмо с потверждением отправлено на вашу электронную почту';
				
				if( isset($image) and $image === false)
				{
					$this->set_image_default($user['login']);
				}
				
                //var_dump(mail($user['email'], 'Activate your account', $message));
            }
        }
        return $data;
    }

    /**
     * @param  array $user авторизированный пользовател
     * @return array $data массив ошибок
     */
    public function change_profile(array $user)
    {
        $query = 'SELECT user_id FROM user WHERE user_password=? AND user_login=?';
        $query1 = 'SELECT user_id FROM user WHERE user_email=?';
        $query2 = 'UPDATE user SET user_email=? WHERE user_id=?';
		$data['error'] = null;
        
		if($result = DataBase::run($query, array($user['password'], $_SESSION['uh']->login))) {
            if (isset($user['email'])) {
                if ($user['email'] !== $_SESSION['uh']->getEmail()) {
                    if (count(DataBase::run($query1, array($user['email']))->fetchAll()) == 0) {
                        if (DataBase::run($query2, array($user['email'], $_SESSION['uh']->getId()))) {
                            $data['success']['email'] = 'Ваша почта изменена';
                            $_SESSION['uh']->setEmail($user['email']);
                        } else {
                            $data['error']['email'] = 'Не удалось обновить информацию.';
                        }
                    } else {
                        $data['error']['email'] = 'Новая почта уже зарегистрирована';
                    }
                } else {
                    $data['error']['email'] = 'Новая почта не должна совпадать со старой';
                }
            }
            if (isset($user['icon']))
            {
                $data = array_merge($data, $this->Upload_icon($user['icon'], $_SESSION['uh']->login));
            }
        }else{
            $data['error']['password'] = 'Неправильный пароль';
        }
        $data['header'] = 'Изменение профиля';
        return $data;
    }

    /**
     * @param array $user данные введенные авторизированным пользователем
     * @return array $data список ошибок
     */
    public function change_password(array $user)
    {
        $query = 'SELECT user_id FROM user WHERE user_password=? AND user_login=?';
        $data['error'] = null;
        $result = DataBase::run($query, array($user['old_pass'], $_SESSION['uh']->login))->fetchAll();
        if(count($result) == 1) {
            if($user['password0'] == $user['password1']) {
                $data['error']['password'] = $this->validate_password($user['password0']);
                if (is_null($data['error']['password'])) {
                    $query = 'UPDATE user SET user_password="' . md5(md5($user['password0'])) . '" WHERE user_id="' . $result[0][0] . '"';
                    if (parent::$DBH->query($query))
                    {
                        $data['success']['password'] = 'Пароль успешно изменен';
                    }else{
                        $data['error']['password'] = 'Что-то пошло не так';
                    }
                }
            }else
            {
                $data['error']['password'] = 'Пароли не совпадают';
            }
        }else{
            $data['error']['old_pass'] = 'Неправильный старый пароль';
        }

        return $data;
    }

    /**
     * @param string $password пароль на проверку
     * @return string $data
     */
    private function validate_password( string $password)
    {
        $data = null;
        if (count_chars($password) < 8  )
        {
            $data[] = 'Слишком короткий пароль';
        }elseif (count_chars($password) < 30  )
        {
            $data[] = 'Слишком Длинный пароль';
        }

        if(preg_match('/\S+/ius', $password))
        {
            if(!preg_match('/[A-Z]+/ius', $password)){
                $data[] = 'Пароль должен содержать прописную букву';
            }
            if(!preg_match('/\d+/ius', $password)){
                $data[] = 'Пароль должен содержать цифру';
            }
        }else{
            $data[] = 'Пароль не может содержать пустые символы';
        }

        return $data;
    }
}

