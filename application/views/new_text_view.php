<h2>Добавление уникального текста</h2>
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
}?>
<form action="/submit/text/" method="post">
    <div class="form-row">
        <div class="col-md-3 mb-2">
            <label for="cat">Выбрать категорию <span class="text-danger">*</span></label>
            <select name="cat" id="cat" class="form-control" required>
                <option value="" selected>Выбрать категорию</option>
                <?php $json = json_decode( file_get_contents(PATH['json_all'].'cat/index.json'), true, 3);
                foreach ($json as $k => $v)
                {
                    echo '<option value="'.$v[2].'">'.$v[1].'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-3 mb-2">
            <label for="region">Регион <span class="text-danger">*</span></label>
            <select name="region" id="region" class="form-control" required>
                <option value="" selected>Выбрать регион</option>
                <?php $json = json_decode( file_get_contents(PATH['json_all'].'region/index.json'), true, 3);
                foreach ($json as $k => $v)
                {
                    echo '<option value="'.$v[2].'">'.$v[1].'</option>';
                }
                ?>
            </select>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <label>Первый заголовок <span class="text-danger">*</span></label>
        <input class="form-control" name="h1" type="text" id="h1" required/>
    </div>
    <label>Первый текст <span class="text-danger">*</span></label>
    <textarea name="text1" class="form-control" rows="6"></textarea>

    <div class="col-md-4 mb-4">
        <label>Второй заголовок <span class="text-danger">*</span></label>
        <input class="form-control" name="h2" type="text" required/>
    </div>
    <label>Второй текст <span class="text-danger">*</span></label>
    <textarea name="text2" class="form-control" rows="6"></textarea><br/>

    <input class="btn btn-primary" type="submit" value="Задать">
</form>