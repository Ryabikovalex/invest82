<?php
if (isset($success))
{
    if (is_object($success) == true)
    {
        ?><p style="color: green;">Успешно выполнено</p><?php
    }else{
        ?><p style="color: orange">Что-то пошло не так</p><?php
    }
}
?>
<table class="manager">
    <?php/* list( $cat, $subcat) = $stat['categories'];var_dump($cat);?>
    <tr>
        <?php for ($i=0; $i < sizeof($cat); $i++){
            list($id, $name, $translit, $is_enabled, $level, $parent) = $cat[$i];
        ?>
        <th colspan="4"><h5><?=$name?></h5></th>

    </tr>
        <?php}*/?>
    <tr>

    </tr>
</table>
<h6><a href="/manager/cities">Cities</a></h6>
<a href="/manager/new/?t=cities">New city</a>