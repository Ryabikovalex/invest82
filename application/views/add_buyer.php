<?php
if ( $form['success'] == true)
{
    echo '<p>Ваша заявка принята. Вернуться на <a href="/shop/list/">главную</a></p>';
}?>
<p>Бизнес-брокер уведомит вас о новых бизнесах по вашей заявке</p>
<form action="/shop/add_buyer" method="post">
    <p class="error" id="fio"></p>
    <input type="text" name="fio" placeholder="ФИО" pattern="" required><br/>

    <p class="error" id="number"></p>
    <input type="text" name="number" placeholder="Номер телефона" pattern="+7(\d{3})\d{7}" required><br/>

    <p class="error" id="email"></p>
    <input type="text" name="email" placeholder="Электронная почта" pattern=""><br/>

    <p class="error" id="text"></p>
    <textarea type="text" name="text" placeholder="..." required></textarea><br/>


    <select name="region">
        <?php
        foreach ( $region as $k => $reg)
        {
            list ( $name, $id) = $reg;
            echo '<option value="'.$id.'">'.$name.'</option>';
        }
        ?>
    </select><br/>
    <select name="car">
        <?php
        foreach ( $cat as $k => $reg)
        {
            list ( $name, $id) = $reg;
            echo '<option value="'.$id.'">'.$name.'</option>';
        }
        ?>
    </select><br/>

    <input type="submit" value="Оставить заявку">
    <input type="reset" value="Очистить поля">
</form>