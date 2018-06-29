<form name="filter" action="">
<span class="btn btn-link" id="remove-cat">Сбросить категории</span>
<div id="cat-container">
<?php
if(isset(Route::$arg['cat']) and count(Route::$arg['cat']) == 1)
{
    echo '<input name="cat" value="'.Route::$arg['cat'][0].'" hidden>';
    foreach (semanticCore::getSubFilter('cat', Route::$arg['cat'][0]) as $k => $arr)
    {
        $checked =  ( isset(Route::$arg['subcat']) && in_array($arr[1], Route::$arg['subcat']) ) ? 'checked': '';
        echo '<input type="checkbox" name="subcat" value="'.$arr[1].'" '.$checked.' hidden id="subcat'.$k.'"><label class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3" for="subcat'.$k.'"> '.$arr[0].'</label>';
    }
    echo '<script>document.querySelector("#cat-container").querySelector("input").checked = true</script>';
}else{
    foreach (semanticCore::getFilter('cat') as $k => $arr)
    {
        $checked =  ( isset(Route::$arg['cat']) && in_array($arr[1], Route::$arg['cat']) ) ? 'checked': '';
        echo '<input type="radio" name="cat" value="'.$arr[1].'" '.$checked.' hidden id="cat'.$k.'"><label class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3" for="cat'.$k.'"> '.$arr[0].'</label>';
    }
}?>
</div>
<br/>
<span class="btn btn-link"  id="remove-place">Сбросить города</span>
<div id="place-container">
<?php
if(isset(Route::$arg['region']) and count(Route::$arg['region']) == 1)
{
    echo '<input name="region" value="'.Route::$arg['region'][0].'" hidden>';
    foreach (semanticCore::getSubFilter('region', Route::$arg['region'][0]) as $k => $arr)
    {
        $checked =  ( isset(Route::$arg['city']) && in_array($arr[1], Route::$arg['city']) ) ? 'checked': '';
        echo '<input type="checkbox" name="city" value="'.$arr[1].'" '.$checked.' hidden id="city'.$k.'"><label class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3" for="city'.$k.'"> '.$arr[0].'</label>';
    }
    echo '<script>document.querySelector("#place-container").querySelector("input").checked = true</script>';
}else{
    foreach (semanticCore::getFilter('region') as $k => $arr)
    {
        $checked =  ( isset(Route::$arg['region']) &&  in_array($arr[1], Route::$arg['region']) ) ? 'checked': '';
        echo '<input type="radio" name="region" value="'.$arr[1].'" '.$checked.' hidden id="region'.$k.'"> <label class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3" for="region'.$k.'"> '.$arr[0].'</label>';
    }
}
?>
</div>
<button class="btn btn-outline-success" id="filter-submit" type="button">Применить фильтры</button>
</form>
<ul class="pagination justify-content-center">
    <li  class="page-item">
        <a class="page-link <?php echo (isset($from)  and $from>0) ? '' : 'disabled'?>" href="<?=Route::$url?>/?page=<?= $from?><?php echo (isset($_GET['part'])) ? '&part=1' : ''?>">← Назад</a>
    </li>
    <li class="page-item">
        <a  class="page-link <?php echo (isset($to) and $to>1) ? '' : 'disabled'?>" href="<?=Route::$url?>/?page=<?= $to?><?php echo (isset($_GET['part'])) ? '&part=1' : ''?>">Вперед →</a>
    </li>
</ul>
<div class="container-fluid h6">
    Отсортировать по цене: <a href="<?=Route::$url?>/?sort_by=cost&sort=1">Дороже</a> - <a href="<?=Route::$url?>/?sort_by=cost&sort=-1">Дешевле</a> -  <a href="<?=Route::$url?>/?sort_by=earn_p_m&sort=-1">Прибыльнее</a>
</div>

<div class="row justify-content-center">
 <?php if ( !is_array($items) or count($items) == 0){?>
    <p class="h4">Ничего не найдено</p>
<?php }else{  foreach ( $items as $k => $param){
    list($id, $name, $added, $cost, , , $status, $images, $conf,  $cityName, $cityTranslit, , $regTranslit, , $subcatTranslit, , , $catTranslit, $earn, $is_part) = $param;
    $image = json_decode($images, true)[0];
?>
 <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 list-item">
     <div  class="d-flex justify-content-center flex-column" style="margin: 3px;">
         <img class="container" src="<?=PATH['images_biznes'].$image['name'] ?? ''?>" alt="<?= $image['alt'] ?? 'image'?>" style="max-width: 24rem;">
         <div class="card-body">
             <p class="card-text">
                 <?php echo ($conf == 1) ? '<span class="badge badge-danger" style="font-size: 85%;">Конфидециально</span>' : ''?>
                 <?php echo ($status == 0) ? '<span class="badge badge-success " style="font-size: 85%;">Новинка</span>' : ''?>
             </p>
             <a href="/catalog/biznes/i/<?=$id?>"><h3 class="card-title h5"><?=$name?></h3></a>
             <p class="card-text" >
                 Стоимость : <?=format_cost($cost)?> руб.<br/>
                 Прибыль : <?=format_cost($earn)?> руб.<br/>
                 Добавлен : <?=format_date($added)?> <br/>
                 Город : <?=$cityName?>
             </p>
         </div>
     </div>
 </div>
<?php }}?>
</div>
<div>
</div>
<script src="<?=PATH['js'].'filters.js'?>"></script>