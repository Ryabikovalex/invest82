<form class="signin" action="/form/sign_in" method="POST">
    <h1>Авторизация</h1><br />
	<input class="form-input" type="text" name="log" placeholder="Эл. почта или логин" required><br />
	<input class="form-input" type="password" name="password" placeholder="Пароль" required><br />
	<button type="submit">
		Войти
	</button>
    <button type="reset">
        Стереть
    </button>
<?php if($login_status=='access_granted') { ?>
<p style="color:green">Авторизация прошла успешно.</p>
<?php } elseif($login_status=='access_denied') { ?>
<p style="color:red">Логин и/или пароль введены неверно.</p>
<?php } elseif ($login_status=='access_not_activated') {?>
<p style="color:orange">Аккаунт не активирован</p>
<?php } elseif ($login_status=='access_locked') {?>
<p style="color: red">Аккаунт заблокирован</p>
<?php }?>
    <br /><a href="/form/sign_up"> Регистрация</a>
</form>
