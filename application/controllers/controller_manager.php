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
        $page = ( isset($_GET['page']) and $_GET['page']>0 ) ? htmlspecialchars($_GET['page']) : 1;
        $from = ($page-1)*50;
        $to = $page * 50 - 1;

        $data['data'] = $this->model->get_list('cities', $from, $to);
        $data['header'] = 'Список городов';
        $this->call_view('manager/cities_list_view.php', $data);
    }

    public function action_products()
    {
        $page = ( isset($_GET['page']) and $_GET['page']>0 ) ? htmlspecialchars($_GET['page']) : 1;
        $from = ($page-1)*50;
        $to = $page * 50 - 1;

        $param = array();
		$p = isset($_GET['param']) ? (int)htmlspecialchars($_GET['param']) : 1;

		$data = $this->model->get_list('products', $from, $to, $param);
        $data['header'] = 'Список товаров';
        $this->call_view('manager/products_list_view.php', $data);
    }


    public function action_edit()
    {
        if(!isset($_GET['edit']))
        {
            $table = htmlspecialchars($_GET['t']);
            $entry = htmlspecialchars($_GET['entry']);
            $data = $this->model->get_entry($table, $entry);
            $data['header'] = 'Редактирование';
            $this->call_view('manager/edit_view.php', $data);
        }else{
            $row = $_POST;
            unset($row['table']);
            unset($row['entry']);
            $table = $_POST['table'];
            $id = $_POST['entry'];
            $data = $this->model->edit_entry($row, $table, $id);
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
            $data['header'] = 'Администрирование';
            $this->call_view('manager/default_view.php',$data);
        }
    }

}