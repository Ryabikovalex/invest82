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
<h2>
   Регионы
    <span type="button" class="btn btn-info">
        Всего <span class="badge badge-light"><?=$stat['regions_count']?></span>
    </span>
    <span type="button" class="btn btn-success">
        Активных на даныый момент <span class="badge badge-light"><?=$stat['regions_active_count']?></span>
    </span>
</h2>
<ul class="pagination justify-content-center">
    <?php $dp = (isset($from)and$from>0) ? '' : 'disabled';
    $dn = (isset($to) and $to>1) ? '' : 'disabled'?>
    <li class="page-item <?=$dp?>"><a class="page-link" href="<?=Route::$url?>&page=<?= $from?>"> ← Назад</a></li>
    <li class="page-item <?=$dn?>"><a class="page-link" href="<?=Route::$url?>&page=<?= $to?>">Вперед →</a></li>
</ul>

<p>Клик по статусу региона переключает его.</p>

<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead>
        <tr>
            <th class="col-lg-2  col-md-2"></th>
            <th>#</th>
            <th>Статус</th>
            <th class="col-lg-2 col-md-2">Регион</th>
            <th class="table-info">Брокеров</th>
            <th class="table-info">Покупателей</th>
            <th>Транслит</th>
            <th>Заголовок</th>
            <th class="table-info">Нас. пунктов</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($table as $k => $arr)
        {
            list( $id, $name, $header, $translit, $is_enabled, $cities, $brokers, $buyers) = $arr;
            $enable_url = Route::$url.'&action=toggle&entry='.$id;
            $enable_url.= (isset($_GET['page'])) ? '&page='.$_GET['page'] : '';
            $enable = ($is_enabled == 0) ? '<a href="'.$enable_url.'" class="badge badge-danger">Отключен</a>' : '<a href="'.$enable_url.'" class="badge badge-success">Активен</a>';
            echo '<tr>
<td><a class=" btn-link" href="/manager/edit/?t=region&entry='.$id.'">Редактировать</a> <a class=" btn-link" href="'.$_SERVER['PATH_INFO'].'?t=city&region_id='.$id.'">Показать города</a></td>
<td>'.$id.'</td>
<td>'.$enable.'</td>
<td>'.$name.'</td>
<td>'.$brokers.'</td>
<td>'.$buyers.'</td>
<td>'.$translit.'</td>
<td>'.$header.'</td>
<td>'.$cities.'</td>
    </tr>';}?>
        </tbody>
    </table>
</div>