<?php
class controller_main extends controller
{
    function __construct()
    {
    }

    public function action_index()
    {
        $data['header'] = 'Покупка и продажа готового бизнеса в России';

        $this::call_view('main_view.php', $data);
    }
}