<?php

class controller_main extends controller
{
    public function __construct()
    {
        $this->model = new model_main();
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
                case 'delete':
                    $data['success'] = $this->model->delete_entry(htmlspecialchars($_GET['table']), htmlspecialchars($_GET['entry']));
                    break;
            }
        }

        $data['header'] = 'Администрирование';
        $data['stat'] = $this->model->collect_statistic();
        $data['table'] = $this->model->show_new_products($from, $to);
        $this->call_view('default_view.php', $data);
    }
}