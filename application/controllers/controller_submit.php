<?php

class controller_submit extends controller{


    public function __construct()
    {
        $this->model = new model_submit();
    }

    public function action_index()
    {
        Route::ErrorPage400();
    }


    public function action_product()
    {
        $entry = (isset($_GET['entry'])) ? htmlspecialchars($_GET['entry']) : 1;
        if (isset($_GET['entry']))
        {
            $data['submit'] = $this->model->product($entry);
        }else
        {
            $arr = [];
            foreach ( $_POST as $k =>$v)
            {
                if ($k !== "с_images" and !preg_match('/^image_alt(\d{1})/', $k))
                {
                    $arr[$k] = trim(htmlspecialchars($v));
                }else if ( preg_match('/^image_alt(\d+)/', $k, $match) )
                {
                    $arr['images_alt'][ substr($k, 9 ) ] = trim(htmlspecialchars($v));
                }
            }
            $data['success'] = $this->model->public_product($arr);
        }

        $data['header'] = 'Одобрение продукта';
        $data['stat'] = $this->model->collect_statistic();
        $data['brokers'] = $this->model->get_brokers();
        View::generate('new_product_view.php', $data);
    }

    public function action_region()
    {

    }
}