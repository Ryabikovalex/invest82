<?php
class controller_list extends controller
{
    function __construct()
    {
        $this->model = new model_list();
    }

    public function action_index()
    {
        $sort = (isset($_GET['sort_by']) and isset($_GET['sort'])) ? [ htmlspecialchars($_GET['sort']) => htmlspecialchars($_GET['sort_by'])]: [];
        $page = ( isset($_GET['page']) and $_GET['page']>0 ) ? htmlspecialchars($_GET['page']) : 1;
        $from = ($page-1)*50;
        $to = $page * 50 - 1;


        $data['from'] = $page-1;
        $data['to'] = $page+1;

        $data['items'] = $this->model->getList( $from, $to, Route::$arg['p'], $sort);

        //TODO genreate in template.json standart phrases
        switch (count(Route::$arg)[1])
        {
            case 0:
                $data['header'] = Template::title(0, []);
                break;
            case 1:
                $data['header'] = Template::title(1, ['%title%' => Route::$arg['p'][0]]);
                break;
            case 2:
                $data['header'] = Template::title(2, ['%title%' => Route::$arg['p'][0]]);
                break;
            case 3:
                $data['header'] = Template::title(3, ['%title%' => Route::$arg['p'][0]]);
                break;
        }


        $this->call_view( 'list_view.php', $data);
    }
}