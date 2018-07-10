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

    public function action_text()
    {
        if( count($_POST) > 0)
        {
            $arr = [];
            foreach ( $_POST as $k =>$v)
            {
                $arr[$k] = trim(htmlspecialchars($v));
            }
            $arr['text1'] = json_encode([ 'h' => $arr['h1'], 'c'=> $arr['text1']], JSON_INVALID_UTF8_IGNORE);
            $arr['text2'] = json_encode([ 'h' => $arr['h2'], 'c'=> $arr['text2']], JSON_INVALID_UTF8_IGNORE);

            $data['success'] = $this->model->public_text($arr);
        }
        $data['header'] = 'Задаит уникальные тексты';
        $data['stat'] = $this->model->collect_statistic();
        View::generate('new_text_view.php', $data);
    }

    public function action_region()
    {

    }
}