<?php
class controller_manager extends controller
{
    public function __construct()
    {
        $this->model = new model_manager();
    }


    /**
     *
     * Страница админинстратора
     */
    public function action_index()
    {
       $data['header'] = 'Администрирование';
       if (isset($_GET['action']))
       {
           switch ($_GET['action'])
           {
               case 'toggle':
                   $data['success'] = $this->model->toggle_entry(htmlentities($_GET['cat']));
                   break;
           }
       }
       $data['stat'] = $this->model->collect_statistic();
       $this->call_view('manager/default_view.php', $data);
    }

    public function action_cities()
    {
        $data = $this->get_list('cities');
        $data['header'] = '';
        $this->call_view('manager/cities_list_view.php', $data);
    }

    /**
     *  TODO show tables
     */
    public function action_products()
    {
        $param = array();
		$p = isset($_GET['param']) ? (int)$_GET['param'] : 1;
        switch ($_GET['param'])
		{
			default:
			case 1:
				$k = 'id';
				break;
			case 2:
				$k = 'theme';
				break;
			case 3:
				$k = 'author';
				break;
			case 4:
				$k = 'date_of_create';
				 break;
		}
		$param[$k] = isset($_GET['type']) ? $_GET['type']: 1;
        
		$data = $this->get_list('news', $param);
        $data['header'] = 'Список публикаций';
        $this->call_view('manager/news_list_view.php', $data);
    }


    public function action_edit()
    {
        if(!isset($_GET['success']))
        {
            $table = $_GET['t'];
            $entry = $_GET['entry'];
            $data = $this->model->get_entry($table, $entry);
            $data['header'] = 'Редактирование';
            $this->call_view('manager/city_edit_view.php', $data);
        }else{
            $row = $_POST;
            unset($row['table']);
            unset($row['entry']);
            $table = $_POST['table'];
            $id = $_POST['entry'];
            $data = $this->model->edit_entry($row, $table, $id);

            $data['header'] = 'Администрирование';
            $this->call_view('manager/default_view.php',$data);
        }
    }

}