<?php
class controller_catalog extends controller
{
    function __construct()
    {
        $this->model = new model_catalog();
    }

    public function action_index()
    {
        $this->action_list();
    }

    public function action_list()
    {
        $sort = (isset($_GET['sort_by']) and isset($_GET['sort'])) ? [ htmlspecialchars($_GET['sort']) => htmlspecialchars($_GET['sort_by'])]: [];
        $page = ( isset($_GET['page']) and $_GET['page']>0 ) ? (int)htmlspecialchars($_GET['page']) : 1;
        $from = ($page-1)*DB['per_page'];
        $to = $page * DB['per_page'];


        $data['from'] = $page-1;
        $data['to'] = $page+1;

        $data['header'] = semanticCore::getHeader( Route::$arg);
        $data['title'] = semanticCore::getFullHeader($data['header'], ['mix' => 1, 'page'=> $page]);
        $data['description'] = ( $page == 1) ?  'Купить готовый и прибыльный бизнес в  Крыму. Покупайте бизнес у Инвест82.  Минимизируйте риски при покупке бизнеса.' : '';
        $data['items'] = $this->model->getList( $from, $to, Route::$arg, $sort);

        $data['content'] = semanticCore::getContent(Route::$arg);

        $this->call_view( 'list_view.php', $data);
    }

    public function action_biznes()
    {
        $data['product'] = $this->model->getEntry( Route::$arg['i'][0]);

        $data['header'] = $data['product'][0];
        $data['description'] = substr($data['product'][9], 0, 130).'...';
        $this->call_view('biznes_view.php', $data);
    }

}