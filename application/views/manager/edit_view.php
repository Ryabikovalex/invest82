<h5>Редактирование </h5>
<form action="/manager/edit/?success=1" method="POST">
<?php
foreach ($row as $k => $value)
{
    if ($k == 'source')
    {
        echo '<pre><textarea class="form-input" style="height: 45em; color: black" name="source" required>'.$value.'</textarea></pre>';
    }else{
        ?><input class="form-input" type="text" name="<?=$k?>" value="<?=$value?>" required><br/><?php
    }
}
?>
    <input type="hidden" name="table" value="<?=$table?>">
    <input type="hidden" name="entry" value="<?=$entry?>">

    <input class="form-input" type="submit" value="Отредактировать">
</form>
