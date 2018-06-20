<?php
class controller_log extends controller
{
    public function __construct()
    {
        $this->model = new model_log();
    }

    public function action_index()
    {
        $this->action_in();
    }

    public function action_in()
    {
        $data =[];
        if (isset($_POST['pass']) && isset($_POST['login']))
        {
            $name = htmlspecialchars($_POST['login']);
            $hash = hash("sha256", htmlspecialchars($_POST['pass']));
            $data = $this->model->auth($name, $hash);
        }
        View::generate('', $data, 'login_view.php');
    }

    public function action_out()
    {
        unset($_SESSION['auth']);
        session_destroy();
        View::generate('', [], 'login_view.php');
    }
}