<form name="filter" action="">
<a href="" id="remove-cat">Сбросить категории</a>
<div id="cat-container" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
<?php
if(isset(Route::$arg['cat']) and count(Route::$arg['cat']) == 1)
{
    echo '<input name="cat" value="'.Route::$arg['cat'][0].'" checked hidden>';
    foreach (semanticCore::getSubFilter('cat', Route::$arg['cat'][0]) as $k => $arr)
    {
        $checked =  ( isset(Route::$arg['subcat']) && in_array($arr[1], Route::$arg['subcat']) ) ? 'checked': '';
        echo '<label><input type="checkbox" name="subcat" value="'.$arr[1].'" '.$checked.'>'.$arr[0].'</label>';
    }
}else{
    foreach (semanticCore::getFilter('cat') as $k => $arr)
    {
        $checked =  ( isset(Route::$arg['cat']) && in_array($arr[1], Route::$arg['cat']) ) ? 'checked': '';
        echo '<label><input type="radio" name="cat" value="'.$arr[1].'" '.$checked.'>'.$arr[0].'</label>';
    }
}?>
</div>
<br/>
<a href="" id="remove-place">Сбросить города</a>
<div id="place-container" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
<?php
if(isset(Route::$arg['region']) and count(Route::$arg['region']) == 1)
{
    echo '<input name="region" value="'.Route::$arg['region'][0].'" checked hidden>';
    foreach (semanticCore::getSubFilter('region', Route::$arg['region'][0]) as $k => $arr)
    {
        $checked =  ( isset(Route::$arg['city']) && in_array($arr[1], Route::$arg['city']) ) ? 'checked': '';
        echo '<label><input type="checkbox" name="city" value="'.$arr[1].'" '.$checked.'>'.$arr[0].'</label>';
    }
}else{
    foreach (semanticCore::getFilter('region') as $k => $arr)
    {
        $checked =  ( isset(Route::$arg['region']) &&  in_array($arr[1], Route::$arg['region']) ) ? 'checked': '';
        echo '<label><input type="radio" name="region" value="'.$arr[1].'" '.$checked.'>'.$arr[0].'</label>';
    }
}
?>
</div>
<button id="filter-submit" type="button">Применить фильтры</button>
</form>



<div>
    Отсортировать по цене: <a href="<?=Route::$url?>/?sort_by=cost&sort=1">Дороже</a> - <a href="<?=Route::$url?>/?sort_by=cost&sort=-1">Дешевле</a>
</div>
<div>
    `id`, `name`, `added`, `cost`, `category_id`, `city_id`,  `status`, `images`, `is_conf`, `CY`.`cityName`, `CY`.`cityTranslit`, `CY`.`cityE`, `R`.`regTranslit`, `R`.`regE`, `SC`.`scTranslit`, `SC`.`scE`, `CT`.`ctE`, `CT`.`ctTranslit`
<?php if ( !is_array($items) or count($items) == 0){?>
    <p>Ничего ненайдено</p>
<?php }else{  foreach ( $items as $k => $param){
    list($id, $name, $added, $cost, ,, $status, $images, $conf,  $cityName, $cityTranslit, , $regTranslit, , $subcatTranslit, , , $catTranslit) = $param;
?>
<div class="list-item" style="display: inline-block;">
    <table border="1">
        <tr>
            <th><?=$cityName?></th>
            <th><a href="/shop/product/i/<?=$id?>"><?=$name?></a></th>
        </tr>
        <tr>
            <td><?=format_cost($cost)?></td>
            <td><?=format_date($added)?></td>
        </tr>
        <p><?php echo ($is_conf == 1) ? 'Conf' : ''?></p>
    </table>
</div>
<?php }}?>
</div>
<div>
<?php if (isset($from)  and $from>0){?>
	<a href="<?=Route::$url?>/?page=<?= $from?>"> ← Назад</a>
    <?php }
if (isset($to) and $to>1){?>
    <a href="<?=Route::$url?>/?page=<?= $to?>">Вперед →</a>
<?php }?>
</div>
<script src="<?='/'.PATH['js'].'filters.js'?>"></script>