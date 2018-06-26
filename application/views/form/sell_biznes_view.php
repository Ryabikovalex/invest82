
<div class="w-100"></div>
<?php
//Проверка успешного завершенного действия
if (isset($success))
{
    if (is_object($success) == true)
    {
        ?><div class="alert alert-success alert-dismissible fade show" role="alert">
        Заявка принята. Вернуться на <a class="btn-link" href="/">главную</a> ?
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

<div class="w-100"></div>
<p>
    Вы можете добавить объявление на сайт или оставить свои контакты.
</p>
<form action="/form/sell_biznes" method="post">
    <div class="form-group col-mb-4 col-lg-8 col-xl-4 col-sm-12">
        <label> Фамили Имя Отчество</label>
        <input class="form-control" type="text" name="fio" placeholder="Иванов Иван Петрович" required>
    </div>
    <div class="form-group col-mb-4 col-lg-8 col-xl-4 col-sm-12">
        <label> Телефон</label>
        <input class="form-control" type="text" name="number" placeholder="+7 (000) 000-00-00">
    </div>
    <input class=" form-group btn btn-primary" type="submit" name="call" value="Перезвоните мне">

    <div class="form-group col-mb-7 col-lg-8 col-xl-7 col-sm-12">
        <label>Заголовок объявления</label>
        <input class="form-control" type="text" name="name" placeholder="">
    </div>

    <div class="form-group col-mb-7 col-lg-8 col-xl-7 col-sm-12">
        <label>Стоимость</label>
        <input class="form-control" type="text" name="name" placeholder="">
    </div>
    <div class="form-group col-mb-7 col-lg-8 col-xl-7 col-sm-12">
        <label>Ежемесячная прибыль</label>
        <div class="input-group">
            <input class="form-control" type="text" name="cost" placeholder="">
            <div class="input-group-append">
                <span class="input-group-text">руб. / месяц</span>
            </div>
        </div>
    </div>

    <div class="form-group col-mb-8 col-lg-8 col-xl-6 col-sm-12">
        <label>Выберите ваш регион</label>
        <select class="form-control" name="region" id="region">
            <?php $json = json_decode( file_get_contents(PATH['json_all'].'region/index.json'), true, 3);
            foreach ($json as $k => $v)
            {
                echo '<option value="'.$v[0].'" data-payload="'.$v[2].'">'.$v[1].'</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group col-mb-8 col-lg-8 col-xl-6 col-sm-12">
        <label>Адресс</label>
        <input  class="form-control" type="text" name="address" placeholder="город, улица, дом">
    </div>
    <div class="form-group col-mb-12 col-lg-12 col-xl-12 col-sm-12">
        <label>Расскажите подробнее о бизнесе</label>
        <small class="form-text text-muted">Подсказка</small><br/>
        <textarea class="form-control" name="about"></textarea>
    </div>
    <input class="btn btn-primary" type="submit" value="Отправить заявку">
</form>
<p class="h4">
    Сопутствующий услуги
</p>
<?php
    foreach ($uslugi as $k => $row)
    {
        list( $name, $cost) = $row;
        echo '<div class="col-12 d-flex">
            <p><b>'.$name.'</b>       от '.$cost.' руб.</p>
        </div>';
    }
?>

