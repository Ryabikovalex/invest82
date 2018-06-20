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
            $data['success'] = $this->model->public_product($_POST);
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