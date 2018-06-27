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
        $data['items'] = $this->model->getList( $from, $to, Route::$arg, $sort);

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