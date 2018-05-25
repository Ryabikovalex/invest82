<h2>Изменение пароля</h2><br>
<form class="signup" action="/form/change_password" method="POST">
    <div class="form-group col-2">
        <input class="form-input" type="password" name="password0" placeholder="Новый пароль">

    </div>
    <div class="form-group col-2">
        <p>Пароль должен быть длиной не менее 8 символов и содержать минимум одну заглавная букву и одну цифру</p>
    </div>
    <div class="form-group col-2">
        <input class="form-input" name="password1" type="password" placeholder="Введите пароль повторно">
    </div>
    <div class="form-group col-2">
        <p style='color:orange'><?php if (isset($error['password'])){echo $error['password'];} ?></p>
        <p style='color:green'><?php if (isset($success['password'])){echo $success['password'];} ?></p>
    </div>

    <div class="form-group col-2">
        <p>Введите старый пароль для потверждения действия</p><br/>
        <p style='color:orange'><?php if (isset($error['old_pass'])){ echo $error['old_pass'];}?></p>
        <input class="form-input" type="password" name="old_pass" placeholder="Пароль" required><br />
        <input type="hidden" name="validate_form" value="1">
    </div><br/>
    <button type="submit">
        Изменить
    </button>
    <button type="reset">
        Стереть
    </button>
</form>