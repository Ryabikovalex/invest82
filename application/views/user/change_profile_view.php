<h1>Измение профиля</h1><br>
<form enctype="multipart/form-data" class="signup" action="/form/change_profile" method="POST">
    <div class="form-group col-2">
        <input class="form-input" type="email" name="email" placeholder="Новая эл. почта">
    </div>
    <div class="form-group col-2">
        <p style='color:orange'><?php if (isset($error['email'])){echo $error['email'];} ?></p>
        <p style='color:green'><?php if (isset($success['email'])){echo $success['email'];} ?></p>
    </div>

    <div class="form-group col-2">
        <input class="form-input" name="icon" type="file"  style="min-height: 10px"><br/>
    </div>
    <div class="form-group col-2">
        <p style='color:orange'><?php if (isset($error['icon'])){ foreach ($error['icon'] as $k=>$message){echo $message;}}?></p>
        <p style='color:green'><?php if (isset($success['icon'])){echo $success['icon'];} ?></p>
    </div><br/>

    <div class="form-group col-2">
        <p>Введите пароль для потверждения действия</p><br/>
        <p style='color:orange'><?php if (isset($error['password'])){ echo $error['password'];}?></p>
        <input class="form-input" type="password" name="password" placeholder="Пароль" required><br />
        <input type="hidden" name="validate_form" value="1">
    </div><br/>
    <button type="submit">
        Изменить
    </button>
    <button type="reset">
        Стереть
    </button>
</form>