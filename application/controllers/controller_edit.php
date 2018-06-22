<?php

class controller_edit extends controller
{
    public function __construct()
    {
        $this->model = new model_edit();
    }

    public function action_index()
    {
        Route::ErrorPage400();
    }

    public function action_region()
    {
        $data = [];
        if ( !isset($_POST['entry']))
        {
            $data['entry'] = $this->model->get_entry( 'region', htmlspecialchars($_GET['entry']));

        }else{
            $entry = $_POST['entry'];
            unset($_POST['entry']);
            $param = $_POST;
            $param['is_enabled'] = $param['is_enabled'] == "on" ? 1 : 0;
            $data['success'] = $this->model->update_entry( 'region', $entry, $param);
        }

        $data['stat'] = $this->model->collect_statistic();
        $this->call_view('edit/region_view.php', $data);
    }

    public function action_city()
    {
        $data = [];
        if ( !isset($_POST['entry']))
        {
            $data['entry'] = $this->model->get_entry( 'city', htmlspecialchars($_GET['entry']));
        }else{
            $entry = $_POST['entry'];
            unset($_POST['entry']);
            $param = $_POST;
            $param['is_enabled'] = $param['is_enabled'] == "on" ? 1 : 0;
            $data['success'] = $this->model->update_entry( 'city', $entry, $param);
        }

        $data['stat'] = $this->model->collect_statistic();
        $this->call_view('edit/city_view.php', $data);
    }

    public function action_cat()
    {
        $data = [];
        if ( !isset($_POST['entry']))
        {
            $data['entry'] = $this->model->get_entry( 'categories', htmlspecialchars($_GET['entry']));
        }else{
            $entry = $_POST['entry'];
            unset($_POST['entry']);
            $param = $_POST;
            $param['is_enabled'] = $param['is_enabled'] == "on" ? 1 : 0;
            $data['success'] = $this->model->update_entry( 'categories', $entry, $param);
        }

        $data['stat'] = $this->model->collect_statistic();
        $this->call_view('edit/cat_view.php', $data);
    }
}