<?php
class controller_show extends controller{

    public function __construct()
	{
		$this->model = new model_show();

	}

    /**
     * Нужно кидать исключение
     */
	public function action_index() : void
	{
		Route::ErrorPage400();
	}


	public function action_region()
	{

        $page = ( isset($_GET['page']) and $_GET['page']>0 ) ? (int)htmlspecialchars($_GET['page']) : 1;
        $from = ($page-1)*DB['per_page'];
        $to = $page  *DB['per_page'] - 1;
        $data['from'] = $page-1;
        $data['to'] = $page+1;

        if (isset($_GET['action']))
        {
            if ( htmlspecialchars($_GET['action']) == 'toggle')
            {
                $data['success'] = $this->model->toggle_entry( 'region', htmlspecialchars($_GET['entry']));
            }
        }

        $data['header'] = 'Показ таблицы';
        $data['stat'] = $this->model->collect_statistic();
        $data['table'] = $this->model->show_regions($from, $to);
        View::generate('show/region_view.php', $data);
	}

	public function action_cat()
    {
        $page = ( isset($_GET['page']) and $_GET['page']>0 ) ? (int)htmlspecialchars($_GET['page']) : 1;
        $from = ($page-1)*DB['per_page'];
        $to = $page  *DB['per_page'] - 1;
        $data['from'] = $page-1;
        $data['to'] = $page+1;

        if (isset($_GET['action']))
        {
            if ( htmlspecialchars($_GET['action']) == 'toggle')
            {
                $data['success'] = $this->model->toggle_entry( 'categories', htmlspecialchars($_GET['entry']));
            }
        }

        $data['header'] = 'Показ таблицы';
        $data['stat'] = $this->model->collect_statistic();
        $data['table'] = $this->model->show_categ($from, $to);
        View::generate('show/cat_view.php', $data);
    }

    public function action_city()
    {
        $page = ( isset($_GET['page']) and $_GET['page']>0 ) ? (int)htmlspecialchars($_GET['page']) : 1;
        $from = ($page-1)*DB['per_page'];
        $to = $page  *DB['per_page'] - 1;
        $data['from'] = $page-1;
        $data['to'] = $page+1;

        if (isset($_GET['action']))
        {
            if ( htmlspecialchars($_GET['action']) == 'toggle')
            {
                $data['success'] = $this->model->toggle_entry( 'city', htmlspecialchars($_GET['entry']));
            }
        }


        $data['header'] = 'Показ таблицы';
        $data['stat'] = $this->model->collect_statistic();

        $region_id = $_GET['region_id'] ?? 0;
        $data['table'] = $this->model->show_cities($from, $to, $region_id);
        View::generate('show/city_view.php', $data);
    }

    public function action_submit_products()
    {
        $page = ( isset($_GET['page']) and $_GET['page']>0 ) ? (int)htmlspecialchars($_GET['page']) : 1;
        $from = ($page-1)*DB['per_page'];
        $to = $page  *DB['per_page'] - 1;
        $data['from'] = $page-1;
        $data['to'] = $page+1;

        if (isset($_GET['action']))
        {
            if ( htmlspecialchars($_GET['action']) == 'delete')
            {
                $data['success'] = $this->model->delete_entry( 'submit_products', htmlspecialchars($_GET['entry']));
            }
        }


        $data['header'] = 'Показ таблицы';
        $data['stat'] = $this->model->collect_statistic();

        $region_id = $_GET['region_id'] ?? 0;
        $data['table'] = $this->model->show_new_products($from, $to, $region_id);
        View::generate('show/submit_products_view.php', $data);
    }
}

