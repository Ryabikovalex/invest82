<h2>
    Населенные пункты
    <span type="button" class="btn btn-info">
        Всего <span class="badge badge-light"><?=$stat['city_count']?></span>
    </span>
    <span type="button" class="btn btn-success">
        Активных на даныый момент <span class="badge badge-light"><?=$stat['city_active_count']?></span>
    </span>
</h2>
<?php
//Проверка успешного завершенного действия
if (isset($success))
{
    if (is_object($success) == true and $success->rowCount() > 0)
    {
        ?><div class="alert alert-success alert-dismissible fade show" role="alert">
        Успешно выполнено
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div><?php
    }else{
        ?><div class="alert alert-warning alert-dismissible fade show" role="alert">
            Что-то пошло не так.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div><?php
    }
}
?>
<ul class="pagination justify-content-center">
    <?php $dp = (isset($from)and$from>0) ? '' : 'disabled';
    $dn = (isset($to) and $to>1) ? '' : 'disabled'?>
    <li class="page-item <?=$dp?>"><a class="page-link" href="<?=Route::$url?>&page=<?= $from?><?php echo (isset($_GET['region_id'])) ? '&region_id='.$_GET['region_id'] : ''?>"> ← Назад</a></li>
    <li class="page-item <?=$dn?>"><a class="page-link" href="<?=Route::$url?>&page=<?= $to?><?php echo (isset($_GET['region_id'])) ? '&region_id='.$_GET['region_id'] : ''?>">Вперед →</a></li>
</ul>

<p>Клик по статусу города переключает его.</p>
<form action="<?=Route::$url?>/" method="get">
    <div class="row">
        <div class="col">
            <select name="region_id" id="region" class="form-control">
                <?php $json = json_decode( file_get_contents(PATH['json_all'].'region/index.json'), true, 3);
                foreach ($json as $k => $v)
                {
                    echo '<option value="'.$v[0].'">'.$v[1].'</option>';
                }
                ?>
            </select>
        </div>
        <div class="col">
            <input type="submit" class="btn btn-primary" value="Выбрать">
        </div>
    </div>
</form>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead>
        <tr>
            <th class="col-lg-1  col-md-1"></th>
            <th>#</th>
            <th>Статус</th>
            <th class="col-lg-2 col-md-2">Город</th>
            <th class="table-info">Покупателей</th>
            <th class="table-info">Бизнесов</th>
            <th>Транслит</th>
            <th>Заголовок</th>
            <th>Регион</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($table as $k => $arr)
        {
            list( $id, $name, $header, $translit, $is_enabled, $region_id, $region_name, $products, $buyers) = $arr;
            $enable_url = Route::$url.'/?action=toggle&entry='.$id;
            $enable_url.= (isset($_GET['page'])) ? '&page='.$_GET['page'] : '';
            $enable_url.= (isset($_GET['region_id'])) ? '&region_id='.$_GET['region_id'] : '';
            $enable = ($is_enabled == 0) ? '<a href="'.$enable_url.'" class="badge badge-danger">Отключен</a>' : '<a href="'.$enable_url.'" class="badge badge-success">Активен</a>';
            echo '<tr>
<td><a class=" btn-link" href="/edit/city/?entry='.$id.'">Редактировать</a></td>
<td>'.$id.'</td>
<td>'.$enable.'</td>
<td>'.$name.'</td>
<td>'.$buyers.'</td>
<td>'.$products.'</td>
<td>'.$translit.'</td>
<td>'.$header.'</td>
<td><a class=" btn-link" href="'.Route::$url.'/?region_id='.$region_id.'">'.$region_name.'</a></td>
    </tr>';}?>
        </tbody>
    </table>
</div>