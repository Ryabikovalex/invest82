<?php
class controller_shop extends controller
{
    function __construct()
    {
        $this->model = new model_shop();
    }

    public function action_index()
    {
        $this->action_list();
    }

    public function action_list()
    {
        $sort = (isset($_GET['sort_by']) and isset($_GET['sort'])) ? [ htmlspecialchars($_GET['sort']) => htmlspecialchars($_GET['sort_by'])]: [];
        $page = ( isset($_GET['page']) and $_GET['page']>0 ) ? (int)htmlspecialchars($_GET['page']) : 1;
        $from = ($page-1)*50;
        $to = $page * 50 - 1;


        $data['from'] = $page-1;
        $data['to'] = $page+1;

        $data['header'] = semanticCore::getHeader( Route::$arg);
        $data['items'] = $this->model->getList( $from, $to, Route::$arg, $sort);

        $this->call_view( 'list_view.php', $data);
    }

    public function action_add_buyer()
    {
        $data['header'] = 'Оставить заявку | invest82.ru';
        if (isset($_POST) and count($_POST) > 0)
        {
            $payload = [];
            foreach ($_POST as $k => $v)
            {
                $payload[ htmlspecialchars($k) ] = htmlspecialchars($v);
            }
            $data['form'] = $this->model->add_buyer($payload);
        }else
        {
            $data['region'] = $this->model->getFilters('region', 0);
            $data['cat'] = $this->model->getFilters( 'category', 0);
        }

        $this->call_view('add_buyer.php', $data);
    }

}