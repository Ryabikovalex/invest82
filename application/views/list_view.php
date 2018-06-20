<form name="filter" action="">
<span id="remove-cat">Сбросить категории</span>
<div id="cat-container" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
<?php
if(isset(Route::$arg['cat']) and count(Route::$arg['cat']) == 1)
{
    echo '<input name="cat" value="'.Route::$arg['cat'][0].'" hidden>';
    foreach (semanticCore::getSubFilter('cat', Route::$arg['cat'][0]) as $k => $arr)
    {
        $checked =  ( isset(Route::$arg['subcat']) && in_array($arr[1], Route::$arg['subcat']) ) ? 'checked': '';
        echo '<label><input type="checkbox" name="subcat" value="'.$arr[1].'" '.$checked.'>'.$arr[0].'</label>';
    }
    echo '<script>document.querySelector("#cat-container").querySelector("input").checked = true</script>';
}else{
    foreach (semanticCore::getFilter('cat') as $k => $arr)
    {
        $checked =  ( isset(Route::$arg['cat']) && in_array($arr[1], Route::$arg['cat']) ) ? 'checked': '';
        echo '<label><input type="radio" name="cat" value="'.$arr[1].'" '.$checked.'>'.$arr[0].'</label>';
    }
}?>
</div>
<br/>
<span id="remove-place">Сбросить города</span>
<div id="place-container" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
<?php
if(isset(Route::$arg['region']) and count(Route::$arg['region']) == 1)
{
    echo '<input name="region" value="'.Route::$arg['region'][0].'" hidden>';
    foreach (semanticCore::getSubFilter('region', Route::$arg['region'][0]) as $k => $arr)
    {
        $checked =  ( isset(Route::$arg['city']) && in_array($arr[1], Route::$arg['city']) ) ? 'checked': '';
        echo '<label><input type="checkbox" name="city" value="'.$arr[1].'" '.$checked.'>'.$arr[0].'</label>';
    }
    echo '<script>document.querySelector("#place-container").querySelector("input").checked = true</script>';
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
 <?php if ( !is_array($items) or count($items) == 0){?>
    <p>Ничего ненайдено</p>
<?php }else{  foreach ( $items as $k => $param){
    list($id, $name, $added, $cost, $catId, $cityId, $status, $images, $conf,  $cityName, $cityTranslit, , $regTranslit, , $subcatTranslit, , , $catTranslit) = $param;
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
        <p><?php echo ($conf == 1) ? 'Conf' : ''?></p>
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