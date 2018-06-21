<h2>Редкатирование региона</h2>
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
if (isset($entry))
{
    list( $id, $name, $header, $translit, $is_enabled, ) = $entry;
}
?>
<form action="<?=Route::$url?>" method="post">
    <p>Поля помеченные <span class="text-danger">*</span> обязательны для заполнения</p>
    <input name="entry" type="text" value="<?php echo $id ?? 0?>" hidden>

    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="name">Название <span class="text-danger">*</span></label>
            <input name="name" type="text" class="form-control" id="name" placeholder="регион" value="<?php echo $name ?? ''?>" required>
        </div>
        <div class="w-100"></div>
        <div class="col-md-4 mb-3">
            <label for="translit">Транслитерация <span class="text-danger">*</span></label>
            <input name="translit" type="text" class="form-control" id="translit" placeholder="Транслит " value="<?php echo $translit ?? ''?>">
        </div>
        <div class="w-100"></div>
        <div class="col-md-4 mb-3">
            <label for="header">Заголовок <span class="text-danger">*</span></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">Купить бизнес в </span>
                </div>
                <input type="text" name="header" class="form-control" id="header" placeholder="Заголовок" value="<?php echo $header ?? ''?>" required>
            </div>
        </div>
    </div>
    <div class="form-group form-check">
        <input name="is_enabled"  type="checkbox" class="form-check-input" id="is_enabled" <?php if ($is_enabled == 1) echo 'checked'?>
        <h6>
            <label class="form-check-label" for="conf">Показывать на сайте</label>
        </h6>
    </div>
    <input type="submit" class="btn btn-primary" value="Обновить"/>
</form>