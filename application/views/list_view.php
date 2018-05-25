<div>
    Sort by: <a href="<?=Route::$url?>/?sort_by=cost&sort=1">price ↓</a> - <a href="<?=Route::$url?>/?sort_by=cost&sort=-1">price ↑</a>;
            <a href="<?=Route::$url?>/?sort_by=city&sort=1">town ↓</a> - <a href="<?=Route::$url?>/?sort_by=city&sort=-1">town ↑</a>
            <a href="<?=Route::$url?>/?sort_by=name&sort=-1">name ↓</a>
</div>
<div>
<?php if (is_array($items) and count($items) == 0){?>
    <p>Empty<?=$_SERVER['HTTP_CONNECTION']?></p>
<?php }else{foreach ( $items as $k => $param){
    list($id, $name, $cost, $catTranslit, $subcatName, $subcatTranslit, $cityName, $cityTranslit) = array_values($param);
?>
<div class="list-item" style="display: inline-block;">
    <table border="1">
        <tr>
            <th><?=$subcatName?></th>
            <th><a href="/product/<?=$id?>"><?=$name?></a></th>
        </tr>
        <tr>
            <td><?=$cost?></td>
            <td<?=$cityName?></td>
        </tr>
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
