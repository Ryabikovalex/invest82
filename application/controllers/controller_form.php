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
		Route::ErrorPage404();
	}


	public function action_sell_biznes()
	{
		if( isset($_POST) and count($_POST) > 0)
		{
		    $arr = [];
		    foreach ($_POST as $k => $v)
            {
                $arr[$k] = trim( htmlspecialchars($v) );
            }

			$data['success'] = $this->model->submit_biznes($arr);
		}
		$data['header'] = 'Продать бизнес';
		$this->call_view('form/sell_biznes_view.php', $data );
	}

	public function action_buy_biznes ()
    {
        if( isset($_POST) and count($_POST) > 0)
        {
            $arr = [];
            foreach ($_POST as $k => $v)
            {
                $arr[$k] = trim( htmlspecialchars($v) );
            }

            $data['success'] = $this->model->submit_buyer($arr);
        }
        $data['header'] = 'Оставить заявку на покупку бизнеса';
        $this->call_view('form/buy_biznes_view.php', $data );
    }
}

