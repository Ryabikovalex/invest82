<h1>Регистрация</h1><br>
<form enctype="multipart/form-data" class="signup" action="/form/sign_up" method="POST">
    <div class="form-group col-2">
        <p style='color:orange'><?php if (isset($error['login'])){ echo $error['login'];}?></p>
        <input class="form-input" type="text" name="login" placeholder="Логин" pattern="^[a-zA-Z0-9]+$" required>
        <p style='color:orange'><?php if (isset($error['email'])){echo $error['email'];} ?></p>
        <input class="form-input" type="email" name="email" placeholder="Эл. почта" required>
    </div>

    <div class="form-group col-2">
        <p style='color:orange'><?php if (isset($error['password'])){ if( is_string($error['password'])){echo $error['password'];}else{foreach ($error['password'] as $k => $m){echo $m."<br/>";}}}?></p>
        <input class="form-input" type="password" name="password0" placeholder="Пароль" required><br />
        <input class="form-input" type="password" name="password1" placeholder="Повторите пароль" required><br />
    </div>
    <div class="form-group col-2">
        <p style='color:orange'><?php if (isset($error['icon'])){ foreach ($error['icon'] as $k=>$message){echo $message;}}?></p>
        <input class="form-input" name="icon" type="file"  style="min-height: 10px"><br/>
    </div><br/>
     <button type="submit">
        Зарегистрироваться
    </button>
    <button type="reset">
        Стереть
    </button>
</form>
<?php if(isset($success)){ ?>
    <p style="color: green">
        <?php echo $success?>
    </p>
<?php }?>
