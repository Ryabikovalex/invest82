<h2>Добавление продукта</h2>
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
if (isset($submit))
{
    list( $id, $name, $fio, $number, $email, $cost, $earn_p_m, $address, $about, $conf) = $submit;
}
?>
<form action="/manager/submit_product/" method="post">
    <p>Поля помеченные <span class="text-danger">*</span> обязательны для заполнения</p>
    <input name="id" type="password" value="<?php echo $id ?? 0?>" hidden>
    <h3>Клиент</h3>
    <p>Если клиент уже продавал здесь бизнес, укажите только его ФИО.</p>
    <p>Если указан телефон уже существующего клиента, то он будет обновлен</p>
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="fio">ФИО <span class="text-danger">*</span></label>
            <input name="fio" type="text" class="form-control" id="fio" placeholder="ФИО" value="<?php echo $fio ?? ''?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="number">Телефон</label>
            <input name="number" type="text" class="form-control" id="number" placeholder="Телефон" value="<?php echo $number ?? ''?>">
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationCustomUsername">Электронная почта</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupPrepend">Email</span>
                </div>
                <input name="email" type="text" class="form-control" id="validationCustomUsername" placeholder="e-mail" aria-describedby="inputGroupPrepend" value="<?php echo $email ?? ''?>">
            </div>
        </div>
    </div>
    <div class="form-group form-check">
        <input name="conf"  type="checkbox" class="form-check-input" id="conf" <?php if ($conf == 1) echo 'checked'?>
        <label class="form-check-label" for="conf">Конфидециально</label>
    </div>

    <h4>Бизнес</h4>
    <div class="">
        <label for="name_biznes">Название бизнеса <span class="text-danger">*</span></label>
        <input name="name" type="text" class="form-control" id="name_biznes" placeholder="Наименование" value="<?php echo $name ?? ''?>" required>
    </div>
    <h4>Местоположение</h4>
    <div class="form-row">
        <div class="col-md-3 mb-2">
            <label for="region">Регион <span class="text-danger">*</span></label>
            <select name="region" id="region" class="form-control" required><option value="1998532" data-payload="adygeya">Адыгея</option><option value="3160" data-payload="altayskiy-kray">Алтайский край</option><option value="3223" data-payload="amurskaya-obl.">Амурская обл.</option><option value="3251" data-payload="arkhangelskaya-obl.">Архангельская обл.</option><option value="3282" data-payload="astrakhanskaya-obl.">Астраханская обл.</option><option value="3296" data-payload="bashkortostan-(bashkiriya)">Башкортостан (Башкирия)</option><option value="3352" data-payload="belgorodskaya-obl.">Белгородская обл.</option><option value="3371" data-payload="bryanskaya-obl.">Брянская обл.</option><option value="3407" data-payload="buryatiya">Бурятия</option><option value="3437" data-payload="vladimirskaya-obl.">Владимирская обл.</option><option value="3468" data-payload="volgogradskaya-obl.">Волгоградская обл.</option><option value="3503" data-payload="vologodskaya-obl.">Вологодская обл.</option><option value="3529" data-payload="voronezhskaya-obl.">Воронежская обл.</option><option value="3630" data-payload="dagestan">Дагестан</option><option value="3673" data-payload="evreyskaya-obl.">Еврейская обл.</option><option value="3675" data-payload="ivanovskaya-obl.">Ивановская обл.</option><option value="3703" data-payload="irkutskaya-obl.">Иркутская обл.</option><option value="3751" data-payload="kabardino-balkariya">Кабардино-Балкария</option><option value="3761" data-payload="kaliningradskaya-obl.">Калининградская обл.</option><option value="3827" data-payload="kalmykiya">Калмыкия</option><option value="3841" data-payload="kaluzhskaya-obl.">Калужская обл.</option><option value="3872" data-payload="kamchatskaya-obl.">Камчатская обл.</option><option value="3892" data-payload="kareliya">Карелия</option><option value="3921" data-payload="kemerovskaya-obl.">Кемеровская обл.</option><option value="3952" data-payload="kirovskaya-obl.">Кировская обл.</option><option value="3994" data-payload="komi">Коми</option><option value="4026" data-payload="kostromskaya-obl.">Костромская обл.</option><option value="4052" data-payload="krasnodarskiy-kray">Краснодарский край</option><option value="4105" data-payload="krasnoyarskiy-kray">Красноярский край</option><option value="10227" data-payload="krym">Крым</option><option value="4176" data-payload="kurganskaya-obl.">Курганская обл.</option><option value="4198" data-payload="kurskaya-obl.">Курская обл.</option><option value="4227" data-payload="lipeckaya-obl.">Липецкая обл.</option><option value="4243" data-payload="magadanskaya-obl.">Магаданская обл.</option><option value="4270" data-payload="mariy-el">Марий Эл</option><option value="4287" data-payload="mordoviya">Мордовия</option><option value="4481" data-payload="murmanskaya-obl.">Мурманская обл.</option><option value="3563" data-payload="nizhegorodskaya-(gorkovskaya)">Нижегородская (Горьковская)</option><option value="4503" data-payload="novgorodskaya-obl.">Новгородская обл.</option><option value="4528" data-payload="novosibirskaya-obl.">Новосибирская обл.</option><option value="4561" data-payload="omskaya-obl.">Омская обл.</option><option value="4593" data-payload="orenburgskaya-obl.">Оренбургская обл.</option><option value="4633" data-payload="orlovskaya-obl.">Орловская обл.</option><option value="4657" data-payload="penzenskaya-obl.">Пензенская обл.</option><option value="4689" data-payload="permskaya-obl.">Пермская обл.</option><option value="4734" data-payload="primorskiy-kray">Приморский край</option><option value="4773" data-payload="pskovskaya-obl.">Псковская обл.</option><option value="4800" data-payload="rostovskaya-obl.">Ростовская обл.</option><option value="4861" data-payload="ryazanskaya-obl.">Рязанская обл.</option><option value="4891" data-payload="samarskaya-obl.">Самарская обл.</option><option value="4925" data-payload="leningradskaya-obl.">Санкт-Петербург и область</option><option value="4969" data-payload="saratovskaya-obl.">Саратовская обл.</option><option value="5011" data-payload="sakha-(yakutiya)">Саха (Якутия)</option><option value="5052" data-payload="sakhalin">Сахалин</option><option value="5080" data-payload="sverdlovskaya-obl.">Свердловская обл.</option><option value="5151" data-payload="severnaya-osetiya">Северная Осетия</option><option value="5161" data-payload="smolenskaya-obl.">Смоленская обл.</option><option value="5191" data-payload="stavropolskiy-kray">Ставропольский край</option><option value="5225" data-payload="tambovskaya-obl.">Тамбовская обл.</option><option value="5246" data-payload="tatarstan">Татарстан</option><option value="3784" data-payload="tverskaya-obl.">Тверская обл.</option><option value="5291" data-payload="tomskaya-obl.">Томская обл.</option><option value="5312" data-payload="tuva-(tuvinskaya-resp.)">Тува (Тувинская Респ.)</option><option value="5326" data-payload="tulskaya-obl.">Тульская обл.</option><option value="5356" data-payload="tyumenskaya-obl.">Тюменская обл.</option><option value="5404" data-payload="udmurtiya">Удмуртия</option><option value="5432" data-payload="ulyanovskaya-obl.">Ульяновская обл.</option><option value="5458" data-payload="uralskaya-obl.">Уральская обл.</option><option value="5473" data-payload="khabarovskiy-kray">Хабаровский край</option><option value="2316497" data-payload="khakasiya">Хакасия</option><option value="2499002" data-payload="khanty-mansiyskiy-ao">Ханты-Мансийский АО</option><option value="5507" data-payload="chelyabinskaya-obl.">Челябинская обл.</option><option value="5543" data-payload="checheno-ingushetiya">Чечено-Ингушетия</option><option value="5555" data-payload="chitinskaya-obl.">Читинская обл.</option><option value="5600" data-payload="chuvashiya">Чувашия</option><option value="2415585" data-payload="chukotskiy-ao">Чукотский АО</option><option value="5019394" data-payload="yamalo-neneckiy-ao">Ямало-Ненецкий АО</option><option value="5625" data-payload="yaroslavskaya-obl.">Ярославская обл.</option></select>
        </div>
        <div class="col-md-3 mb-2">
            <label for="city">Город <span class="text-danger">*</span></label>
            <select name="city" class="form-control" id="city" required>
            </select>
        </div>
        <div class="col-md-3 mb-2">
            <label for="address">Адрес <span class="text-danger">*</span></label>
            <input name="address" type="text" class="form-control" id="address" placeholder="" value="<?php echo $address ?? ''?>" required>
        </div>
    </div>

    <h4>Финансы</h4>
    <div class="form-row">
        <div class="col-md-3 mb-2">
            <label for="input0">Cтоимость <span class="text-danger">*</span> </label>
            <input name="cost" type="text" class="form-control" id="input0" placeholder="" value="<?php echo $cost ?? ''?>" required>
        </div>
        <div class="col-md-3 mb-2">
            <label for="input1">Прибыль <span class="text-danger">*</span></label>
            <input name="earn_p_m" type="text" class="form-control" id="input1" placeholder="" value="<?php echo $earn_p_m ?? ''?>" required>
        </div>
        <div class="col-md-3 mb-2">
            <label for="input2">Обороты в месяц <span class="text-danger">*</span></label>
            <input name="oborot_p_m" type="text" class="form-control" id="input2" placeholder="" value="" required>
        </div>
        <div class="col-md-3 mb-2">
            <label for="input3">Расходы в месяц <span class="text-danger">*</span></label>
            <input name="rashod_p_m" type="text" class="form-control" id="input3" placeholder="" value="" required>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-3 mb-2">
            <label for="cat">Выбрать категорию <span class="text-danger">*</span></label>
            <select name="cat" id="cat" class="form-control" required><option value="2" data-payload="avtobiznes">Автобизнес</option><option value="11" data-payload="aptechnyy">Аптечный</option><option value="10" data-payload="arendnyy">Арендный</option><option value="22" data-payload="gostinichnyy">Гостиничный</option><option value="12" data-payload="dlya-detey-&amp;-obrazovanie">Для детей &amp; образование</option><option value="13" data-payload="doli-biznesa">Доли бизнеса</option><option value="23" data-payload="izdatelstva">Издательства</option><option value="5" data-payload="internet">Интернет</option><option value="6" data-payload="kom.-nedvizhimost">Ком. недвижимость</option><option value="14" data-payload="krasota-&amp;-zdorove">Красота &amp; здоровье</option><option value="24" data-payload="medicina">Медицина</option><option value="9" data-payload="oborudovanie">Оборудование</option><option value="8" data-payload="obschepit">Общепит</option><option value="3" data-payload="ooo">ООО</option><option value="21" data-payload="proizvodstvo">Производство</option><option value="15" data-payload="razvlecheniya-i-dosug">Развлечения и досуг</option><option value="16" data-payload="selkhoz">Сельхоз</option><option value="17" data-payload="stroitelnyy">Строительный</option><option value="1" data-payload="torgovlya-i-magaziny">Торговля и магазины</option><option value="18" data-payload="transportnyy">Транспортный</option><option value="7" data-payload="turizm">Туризм</option><option value="4" data-payload="uslugi-i-servis">Услуги и сервис</option><option value="19" data-payload="finansovo-strakhovoy">Финансово-страховой</option><option value="20" data-payload="franshizy">Франшизы</option></select>
        </div>
        <div class="col-md-3 mb-2">
            <label for="subcat">Выбрать подкатегорию</label>
            <select name="subcat" class="form-control" id="subcat">
            </select>
        </div>
    </div>


    <div class="col-md-3 mb-2">
        <label for="shtat">Штат сотрудников <span class="text-danger">*</span></label>
        <input name="shtat" type="text" class="form-control" id="shtat" placeholder="" value="" required>
    </div>
    <div class="form-group">
        <label for="about_area">О бизнесе</label>
        <small id="about_help" class="form-text text-muted">
            Описание бизнеса до 4096 символов
        </small><br/>
        <textarea name="about" class="form-control" id="about_area" rows="6"><?php echo  $about ?? ''?></textarea>
    </div>

    <div class="form-group">
        <label for="broker">Назначить брокера</label>
        <select name="broker" class="form-control" id="broker" required>
            <?php foreach ($brokers as $k => $v)
                {
                   echo '<option value="'.$v[0].'">'.$v[1].' [ '.$v[2].' ]</option>';
                }?>
        </select>
    </div>

    <input type="submit" class="btn btn-primary" value="Опубликовать на сайте"/>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let citySelect = document.querySelector('select#city');
        let subcatSelect = document.querySelector('select#subcat');
        function getSubParams( container, folder, val) {
            let req = new XMLHttpRequest();
            req.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    obj = JSON.parse(this.responseText);
                    if ( obj instanceof Array && obj.length > 0 )
                    {
                        container.innerHTML = '';
                        for ( let i=0; i < obj.length; i++)
                        {
                            let el = document.createElement('option');
                            el.value = obj[i].id;
                            el.innerHTML = obj[i].name;
                            container.appendChild(el    );
                        }
                    }
                }
            };
            req.open("GET", '/assets/json/manager/'+folder+'/'+val+'.json', true);
            req.send();
        }
        document.querySelector('select#region').onchange = function (e) {
            let val = e.target.selectedOptions[0].getAttribute('data-payload');
            let obj = [];
            console.log('event called');
            getSubParams( citySelect, e.target.name, val);
        };
        document.querySelector('select#cat').onchange = function (e) {
            let val = e.target.selectedOptions[0].getAttribute('data-payload');
            let obj = [];
            getSubParams( subcatSelect, e.target.name, val);
        };

    }, false);
</script>