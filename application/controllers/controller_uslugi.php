<?php
class controller_uslugi extends controller
{
    public function __construct()
    {
        $this->model = new model_uslugi();
    }

    public function action_index()
    {
        $data['header'] = 'Услуги для продажи бизнеса';
        $data['uslugi'] = $this->model->getUslugi();

        $this->call_view('uslugi_view.php', $data);
    }
}