<h5>Редактирование </h5>
<form action="/manager/edit/?edit=1" method="POST">
<?php
foreach ($row as $k => $value)
{
    if ($k == 'source' or $k == 'about')
    {
        echo $k.' : <pre><textarea name="'.$k.'">'.$value.'</textarea></pre>';
    }else if ( $k == 'is_enabled')
    {
        $checked = $value == 1 ? 'checked' : '';
        echo '<input name="is_enabled" value="1" '.$checked.'/> enable <br/>';
    }else
    {
        ?><?=$k?> : <input type="text" name="<?= $k ?>" value="<?= $value ?>" required><br/><?php
    }
}
?>
    <input type="hidden" name="table" value="<?=$table?>">
    <input type="hidden" name="entry" value="<?=$entry?>">

    <input class="form-input" type="submit" value="Отредактировать">
</form>
