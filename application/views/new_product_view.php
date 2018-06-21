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
    list( $id, $name, $fio, $number, $email, $cost, $earn_p_m, $region, $address, $about, $conf) = $submit;
}
?>
<form action="/submit/product/" method="post">
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
            <select name="region" id="region" class="form-control" required>
                <?php $json = json_decode( file_get_contents(PATH['json_all'].'region/index.json'), true, 3);
                foreach ($json as $k => $v)
                {
                    $check = ($region == $v[0]) ? 'selected' : '';
                    echo '<option value="'.$v[0].'" data-payload="'.$v[2].'" '.$check.'>'.$v[1].'</option>';
                }
                ?>
            </select>
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
            <select name="cat" id="cat" class="form-control" required>
                <?php $json = json_decode( file_get_contents(PATH['json_all'].'cat/index.json'), true, 3);
                foreach ($json as $k => $v)
                {
                    $check = ($region == $v[0]) ? 'selected' : '';
                    echo '<option value="'.$v[0].'" data-payload="'.$v[2].'" '.$check.'>'.$v[1].'</option>';
                }
                ?>
            </select>
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
<script src="/assets/js/all_place.js"></script>
<script src="/assets/js/all_cat.js"></script>