<?php
//Проверка успешного завершенного действия
if (isset($success))
{
    if (is_object($success) == true and $success->rowCount() > 0)
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
<h2>
    Населенные пункты
    <span type="button" class="btn btn-info">
        Всего <span class="badge badge-light"><?=$stat['city_count']?></span>
    </span>
    <span type="button" class="btn btn-success">
        Активных на даныый момент <span class="badge badge-light"><?=$stat['city_active_count']?></span>
    </span>
</h2>
<ul class="pagination justify-content-center">
    <?php $dp = (isset($from)and$from>0) ? '' : 'disabled';
    $dn = (isset($to) and $to>1) ? '' : 'disabled'?>
    <li class="page-item <?=$dp?>"><a class="page-link" href="<?=Route::$url?>&page=<?= $from?><?php echo (isset($_GET['region_id'])) ? '&region_id='.$_GET['region_id'] : ''?>"> ← Назад</a></li>
    <li class="page-item <?=$dn?>"><a class="page-link" href="<?=Route::$url?>&page=<?= $to?><?php echo (isset($_GET['region_id'])) ? '&region_id='.$_GET['region_id'] : ''?>">Вперед →</a></li>
</ul>

<p>Клик по статусу города переключает его.</p>
<form action="<?=Route::$url?>/" method="get">
    <input name="t" value="<?=$_GET['t']?>" hidden>
    <div class="row">
        <div class="col">
            <select name="region_id" id="region" class="form-control"><option value="1998532" data-payload="adygeya">Адыгея</option><option value="3160" data-payload="altayskiy-kray">Алтайский край</option><option value="3223" data-payload="amurskaya-obl.">Амурская обл.</option><option value="3251" data-payload="arkhangelskaya-obl.">Архангельская обл.</option><option value="3282" data-payload="astrakhanskaya-obl.">Астраханская обл.</option><option value="3296" data-payload="bashkortostan-(bashkiriya)">Башкортостан (Башкирия)</option><option value="3352" data-payload="belgorodskaya-obl.">Белгородская обл.</option><option value="3371" data-payload="bryanskaya-obl.">Брянская обл.</option><option value="3407" data-payload="buryatiya">Бурятия</option><option value="3437" data-payload="vladimirskaya-obl.">Владимирская обл.</option><option value="3468" data-payload="volgogradskaya-obl.">Волгоградская обл.</option><option value="3503" data-payload="vologodskaya-obl.">Вологодская обл.</option><option value="3529" data-payload="voronezhskaya-obl.">Воронежская обл.</option><option value="3630" data-payload="dagestan">Дагестан</option><option value="3673" data-payload="evreyskaya-obl.">Еврейская обл.</option><option value="3675" data-payload="ivanovskaya-obl.">Ивановская обл.</option><option value="3703" data-payload="irkutskaya-obl.">Иркутская обл.</option><option value="3751" data-payload="kabardino-balkariya">Кабардино-Балкария</option><option value="3761" data-payload="kaliningradskaya-obl.">Калининградская обл.</option><option value="3827" data-payload="kalmykiya">Калмыкия</option><option value="3841" data-payload="kaluzhskaya-obl.">Калужская обл.</option><option value="3872" data-payload="kamchatskaya-obl.">Камчатская обл.</option><option value="3892" data-payload="kareliya">Карелия</option><option value="3921" data-payload="kemerovskaya-obl.">Кемеровская обл.</option><option value="3952" data-payload="kirovskaya-obl.">Кировская обл.</option><option value="3994" data-payload="komi">Коми</option><option value="4026" data-payload="kostromskaya-obl.">Костромская обл.</option><option value="4052" data-payload="krasnodarskiy-kray">Краснодарский край</option><option value="4105" data-payload="krasnoyarskiy-kray">Красноярский край</option><option value="10227" data-payload="krym">Крым</option><option value="4176" data-payload="kurganskaya-obl.">Курганская обл.</option><option value="4198" data-payload="kurskaya-obl.">Курская обл.</option><option value="4227" data-payload="lipeckaya-obl.">Липецкая обл.</option><option value="4243" data-payload="magadanskaya-obl.">Магаданская обл.</option><option value="4270" data-payload="mariy-el">Марий Эл</option><option value="4287" data-payload="mordoviya">Мордовия</option><option value="4481" data-payload="murmanskaya-obl.">Мурманская обл.</option><option value="3563" data-payload="nizhegorodskaya-(gorkovskaya)">Нижегородская (Горьковская)</option><option value="4503" data-payload="novgorodskaya-obl.">Новгородская обл.</option><option value="4528" data-payload="novosibirskaya-obl.">Новосибирская обл.</option><option value="4561" data-payload="omskaya-obl.">Омская обл.</option><option value="4593" data-payload="orenburgskaya-obl.">Оренбургская обл.</option><option value="4633" data-payload="orlovskaya-obl.">Орловская обл.</option><option value="4657" data-payload="penzenskaya-obl.">Пензенская обл.</option><option value="4689" data-payload="permskaya-obl.">Пермская обл.</option><option value="4734" data-payload="primorskiy-kray">Приморский край</option><option value="4773" data-payload="pskovskaya-obl.">Псковская обл.</option><option value="4800" data-payload="rostovskaya-obl.">Ростовская обл.</option><option value="4861" data-payload="ryazanskaya-obl.">Рязанская обл.</option><option value="4891" data-payload="samarskaya-obl.">Самарская обл.</option><option value="4925" data-payload="leningradskaya-obl.">Санкт-Петербург и область</option><option value="4969" data-payload="saratovskaya-obl.">Саратовская обл.</option><option value="5011" data-payload="sakha-(yakutiya)">Саха (Якутия)</option><option value="5052" data-payload="sakhalin">Сахалин</option><option value="5080" data-payload="sverdlovskaya-obl.">Свердловская обл.</option><option value="5151" data-payload="severnaya-osetiya">Северная Осетия</option><option value="5161" data-payload="smolenskaya-obl.">Смоленская обл.</option><option value="5191" data-payload="stavropolskiy-kray">Ставропольский край</option><option value="5225" data-payload="tambovskaya-obl.">Тамбовская обл.</option><option value="5246" data-payload="tatarstan">Татарстан</option><option value="3784" data-payload="tverskaya-obl.">Тверская обл.</option><option value="5291" data-payload="tomskaya-obl.">Томская обл.</option><option value="5312" data-payload="tuva-(tuvinskaya-resp.)">Тува (Тувинская Респ.)</option><option value="5326" data-payload="tulskaya-obl.">Тульская обл.</option><option value="5356" data-payload="tyumenskaya-obl.">Тюменская обл.</option><option value="5404" data-payload="udmurtiya">Удмуртия</option><option value="5432" data-payload="ulyanovskaya-obl.">Ульяновская обл.</option><option value="5458" data-payload="uralskaya-obl.">Уральская обл.</option><option value="5473" data-payload="khabarovskiy-kray">Хабаровский край</option><option value="2316497" data-payload="khakasiya">Хакасия</option><option value="2499002" data-payload="khanty-mansiyskiy-ao">Ханты-Мансийский АО</option><option value="5507" data-payload="chelyabinskaya-obl.">Челябинская обл.</option><option value="5543" data-payload="checheno-ingushetiya">Чечено-Ингушетия</option><option value="5555" data-payload="chitinskaya-obl.">Читинская обл.</option><option value="5600" data-payload="chuvashiya">Чувашия</option><option value="2415585" data-payload="chukotskiy-ao">Чукотский АО</option><option value="5019394" data-payload="yamalo-neneckiy-ao">Ямало-Ненецкий АО</option><option value="5625" data-payload="yaroslavskaya-obl.">Ярославская обл.</option></select>
        </div>
        <div class="col">
            <input type="submit" class="btn btn-primary" value="Выбрать">
        </div>
    </div>
</form>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead>
        <tr>
            <th class="col-lg-1  col-md-1"></th>
            <th>#</th>
            <th>Статус</th>
            <th class="col-lg-2 col-md-2">Город</th>
            <th class="table-info">Покупателей</th>
            <th class="table-info">Бизнесов</th>
            <th>Транслит</th>
            <th>Заголовок</th>
            <th>Регион</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($table as $k => $arr)
        {
            list( $id, $name, $header, $translit, $is_enabled, $region_id, $region_name, $products, $buyers) = $arr;
            $enable_url = Route::$url.'&action=toggle&entry='.$id;
            $enable_url.= (isset($_GET['page'])) ? '&page='.$_GET['page'] : '';
            $enable_url.= (isset($_GET['region_id'])) ? '&region_id='.$_GET['region_id'] : '';
            $enable = ($is_enabled == 0) ? '<a href="'.$enable_url.'" class="badge badge-danger">Отключен</a>' : '<a href="'.$enable_url.'" class="badge badge-success">Активен</a>';
            echo '<tr>
<td><a class=" btn-link" href="/manager/edit/?t=city&entry='.$id.'">Редактировать</a></td>
<td>'.$id.'</td>
<td>'.$enable.'</td>
<td>'.$name.'</td>
<td>'.$buyers.'</td>
<td>'.$products.'</td>
<td>'.$translit.'</td>
<td>'.$header.'</td>
<td><a class=" btn-link" href="'.Route::$url.'&region_id='.$region_id.'">'.$region_name.'</a></td>
    </tr>';}?>
        </tbody>
    </table>
</div>