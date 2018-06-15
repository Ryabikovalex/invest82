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
<form action="/form/sell_biznes" method="post">
    <input type="text" name="name" placeholder="name" required>
    <input type="text" name="fio" placeholder="fio" required>
    <input type="text" name="number" placeholder="number">
    <input type="text" name="email" placeholder="email"><br/>

    <input type="text" name="cost" placeholder="cost" required>
    <input type="text" name="earn_p_m" placeholder="earn" required><br/>
    <select name="region" id="region" required>
        <?php $json = json_decode( file_get_contents(PATH['json_all'].'region/index.json'), true, 3);
        foreach ($json as $k => $v)
        {
            echo '<option value="'.$v[0].'" data-payload="'.$v[2].'">'.$v[1].'</option>';
        }
        ?>
    </select>
    <input type="text" name="address" placeholder="address" required><br/>

    <textarea name="about"></textarea>
    <label>
        <input type="checkbox" name="is_conf"> Конфидециально
    </label>
    <input type="submit" value="Submit ">
</form>
