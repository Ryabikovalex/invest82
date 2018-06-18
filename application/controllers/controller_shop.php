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

    public function action_product()
    {
        $data['product'] = $this->model->getEntry( Route::$arg['i']);

        $data['header'] = $data['product'][0];
        $this->call_view('product_view.php', $data);
    }

}