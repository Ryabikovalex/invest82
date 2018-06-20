<?php
class controller_about extends controller
{
    public function action_index()
    {
        $data['header'] = 'О нас';
        $this->call_view('about/index_view.php', $data);
    }
}