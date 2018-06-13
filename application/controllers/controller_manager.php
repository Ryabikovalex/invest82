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

        if (isset($_GET['action']))
        {
            $action = htmlspecialchars($_GET['action']);
            switch ($action)
            {
                case 'cron':

                    break;
                case 'delete':
                    $data['success'] = $this->model->delete_entry(htmlspecialchars($_GET['table']), htmlspecialchars($_GET['entry']));
                    break;
            }
        }

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
        $table = htmlspecialchars($_GET['t']);

        if (isset($_GET['action']))
        {
            if ( htmlspecialchars($_GET['action']) == 'toggle')
            {
                $data['success'] = $this->model->toggle_entry( $table, htmlspecialchars($_GET['entry']));
            }
        }

        $data['stat'] = $this->model->collect_statistic();
        switch ( $table)
        {
            case 'submit_products':
                $data['table'] = $this->model->show_new_products($from, $to);
                $table = 'submit_products';
                break;
            case 'submit_buyers':
                $data['table'] = $this->model->show_new_buyers($from, $to);
                break;
            case 'region':
                $data['table'] = $this->model->show_regions($from, $to);
            case 'city':
                $region_id = $_GET['region_id'] ?? 0;
                $data['table'] = $this->model->show_cities($from, $to, $region_id);
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
        View::generate('new_product_view.php', $data, 'manager/template_view.php');
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

            $data['stat'] = $this->model->collect_statistic();
            $data['header'] = 'Администрирование';
            View::generate('default_view.php',$data, 'manager/template_view.php');
        }
    }

}