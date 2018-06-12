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

        $page = ( isset($_GET['page']) and $_GET['page']>0 ) ? (int)htmlspecialchars($_GET['page']) : 1;
        $from = ($page-1)*25;
        $to = $page * 25 - 1;

        $data['from'] = $page-1;
        $data['to'] = $page+1;

        $data['header'] = 'Администрирование';
        $data['stat'] = $this->model->collect_statistic();
        $data['table'] = $this->model->show_new_products($from, $to);
        View::generate('default_view.php', $data, 'manager/template_view.php');
    }

    public function action_show_table()
    {
        $page = ( isset($_GET['page']) and $_GET['page']>0 ) ? (int)htmlspecialchars($_GET['page']) : 1;
        $from = ($page-1)*25;
        $to = $page * 25 - 1;
        $data['from'] = $page-1;
        $data['to'] = $page+1;
        $table = '';

        $data['stat'] = $this->model->collect_statistic();
        switch (htmlspecialchars($_GET['t']))
        {
            case 'submit_products':
                $data['table'] = $this->model->show_new_products($from, $to);
                $table = 'submit_products';
                break;
            case 'submit_buyers':
                $data['table'] = $this->model->show_new_buyers($from, $to);
                break;
        }

        $data['header'] = 'Показ таблицы';
        View::generate('tables/'.$table.'_view.php', $data, 'manager/template_view.php');
    }

    public function action_submit_product()
    {
        $entry = (isset($_GET['entry'])) ? htmlspecialchars($_GET['entry']) : 1;
        if (isset($_GET['entry']))
        {
            $data['submit'] = $this->model->submit_product($entry);
        }else
        {
            $data['success'] = $this->model->public_product($_POST);
        }

        $data['header'] = 'Одобрение продукта';
        $data['stat'] = $this->model->collect_statistic();
        $data['brokers'] = $this->model->get_brokers();
        View::generate('tables/new_product_view.php', $data, 'manager/template_view.php');
    }

    /**
     * Авторизация в админ.панель
     */
    public function action_log_in()
    {
        $data =[];
        if (isset($_POST['auth']) and hash( 'sha256',htmlspecialchars($_POST['auth'])) === '36f50957f5e0b6ee3ef455674da35a86667f3314209dc1514c510fe95e840831')
        {
            $data['success'] = 1;
            if( !isset($_COOKIE['auth']) )
            {
                $_SESSION['auth'] = hash( 'sha256',htmlspecialchars($_POST['auth']));
            }
        }
        View::generate('', $data, 'manager/login_view.php');
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