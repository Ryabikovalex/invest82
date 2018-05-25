<?php if (isset($error)){?>
    <h5><span class="important"><?=$error?></span></h5>
    <a href="/news" style="left: 45%;"><button> ← Назад</button></a><br />
<?php }else{?>
<h4><?= $theme?></h4>
<a href="/news"> ← Назад</a><br />
<small>Автор: <a href="/profile/user/<?= $author?>"><?=$author?></a>
Создан <?= $date_of_create?><br /></small>
<?= $content?>

<?php }?>
