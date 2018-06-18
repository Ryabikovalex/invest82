<?php
//Проверка успешного завершенного действия
if (isset($success))
{
    if (is_object($success) == true)
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
Как только появится новый бизнес по вашему запросу, мнееджер уведомит вас.

<form action="/form/buy_biznes" method="post">
    <input type="text" name="fio" placeholder="fio" required>
    <input type="text" name="number" placeholder="number" required>
    <input type="text" name="email" placeholder="email"><br/>

    <select name="region" required>
        <?php $json = json_decode( file_get_contents(PATH['json_all'].'region/index.json'), true, 3);
        foreach ($json as $k => $v)
        {
            echo '<option value="'.$v[0].'" data-payload="'.$v[2].'">'.$v[1].'</option>';
        }
        ?>
    </select>
    <select name="cat" required>
        <?php $json = json_decode( file_get_contents(PATH['json_all'].'cat/index.json'), true, 3);
        foreach ($json as $k => $v)
        {
            echo '<option value="'.$v[0].'" data-payload="'.$v[2].'">'.$v[1].'</option>';
        }
        ?>
    </select><br/>
    Подробнее о желании купить бизнес<br/>
    <textarea name="about"></textarea>
    <input type="submit" value="Submit ">
</form>
