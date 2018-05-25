<?php
//Page
$page = (isset($_GET['page']) and is_integer($_GET['page']) === true ) ? $_GET['page'] :  1;
$from = 50 * ($page - 1);
$to = 50 * $page - 1;


//Verify URL
$url = explode('/', $_SERVER['REQUEST_URI']);
$request = array_slice($url, 1);
$diff = array_diff($request, $verify);
var_dump($diff);

switch ($request[0])
{
    case 'admin':
        require_once PATH_M.'model_admin.class.php';
        break;
    case 'product':
        require_once PATH_M.'model_product.class.php';
        break;
    default:
        require_once PATH_M.'model_list.class.php';

        switch (count($request))
        {
            case 1:
                $r = model_list::getCategory( $request[0], $from , $to);
                if(count($r) === 0)
                {
                   $params['content'] = 'Скоро';
                    Templator::run($params);
                }else{
                    Templator::fill_template('content', $r, 'list-item.tpl');
                }
                break;
            case 2:

                break;
        }
        break;
}

//var_dump($request);