<?php
class controller_form extends controller{

    function __construct()
	{
		$this->model = new model_form();
	}

    /**
     * Нужно кидать исключение
     */
	public function action_index() : void
	{
		Route::Redirect('/400');
	}

    /**
     *  Авторизация
     */
	public function action_sign_in()
	{
		if(isset($_POST['log']) && isset($_POST['password'])){
			$log = trim($_POST['log']);
			$password = md5(md5(trim($_POST['password'])));
			$data = $this->model->sign_in($log, $password);
		}else{
			$data['login_status'] = "";
		}
		$data['header'] = 'Авторизация';
		$this->call_view('user/login_view.php', $data );
	}

    /**
     * Вызываем выход пользователя и возвращаеем на страницу авторизации
     */
    public function action_exit()
	{
		$data = $this->model->user_exit();
        $this->call_view('user/login_view.php', $data );
	}

    /**
     * Регистрация нового польщователя на сайте
     */
	public function action_sign_up()
    {
        if( isset($_POST['login']) and isset($_POST['email']) and isset($_POST['password0']) and isset($_POST['password1']))
        {
            $user = array('login' => $_POST['login'], 'email' => $_POST['email'], 'password0' => $_POST['password0'], 'password1' => $_POST['password1']);
            if (isset($_FILES['icon']) and !empty($_FILES['icon']['name']))
            {
                $user['icon'] = $_FILES['icon'];
            }
            $data = $this->model->set_new_user($user);
        }
        $data['header'] = 'Регистрация';
        $this->call_view( 'user/registry_view.php',$data);
    }

    /**
     * Изменение профиля пользователя
     * В форме обязательно должен лежать спрятанный input 'validate_form'
     */
    public function action_change_profile()
    {
        if( isset($_POST['validate_form']) and isset($_POST['password']))
        {
            $user['password']  = md5(md5($_POST['password']));
            if(isset($_POST['email']) and $_POST['email']!='')
            {
                $user['email'] = $_POST['email'];
            }
            if (isset($_FILES['icon']) and $_FILES['icon']['name']!='')
            {
                $user['icon'] = $_FILES['icon'];
            }
            if( isset($user['icon']) or isset($user['email']))
            {
                $data = $this->model->change_profile($user);
            }
        }
        $data['header'] = 'Изменение профиля';
        $this->call_view('user/change_profile_view.php', $data);

    }

    public function action_change_password()
    {
        if (isset($_POST['old_pass']) and isset($_POST['password0']) and isset($_POST['password1']))
        {
            $user['old_pass'] = md5(md5($_POST['old_pass']));
            $user['password0'] = $_POST['password0'];
            $user['password1'] = $_POST['password1'];

            $data = $this->model->change_password($user);
        }

        $data['header'] = 'Изменение пароля';
        $this->call_view( 'user/change_password_view.php', $data);
    }
}

