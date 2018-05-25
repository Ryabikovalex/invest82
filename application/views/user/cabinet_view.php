<table class="profile">
    <tr>
        <th>
            <img class="profile_icon"  src="<?= $user['icon']?>">
        </th>
        <td rowspan="2" valign="top">
            <h3 style="text-align: center;"><?= $user['login'] ?></h3>
            <h6>Активность в новостях</h6>
            <?php if(is_array($user['activity']['news'])){foreach ($user['activity']['news'] as $k=>$n){echo "<a href='/news/post/".$n[0]."'> <li>".$n[1]."</li></a>";}}?>
        </td>
    </tr>
    <tr>
        <td>
            <p><b>Ваш адрес эл. почты :</b>  <?= $user['email'] ?></p>
            <p><b>Зарегистрированы </b>  <?= $user['registry'] ?></p><br/>
            <a href="/form/change_profile"><button> Изменить данные</button></a>
            <a href="/form/change_password"><button>Изменить пароль</button></a>
        </td>
        <td>

        </td>
    </tr>
</table>

