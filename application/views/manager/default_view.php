<?php
//Проверка успешного завершенного действия
if (isset($success))
{
    if (is_object($success) == true)
    {
        ?><p style="color: green;">Успешно выполнено</p><?php
    }else{
        ?><p style="color: orange">Что-то пошло не так</p><?php
    }
}
?>
<ul>
    <li>
        <a href="/manager/cities">Show Cities</a>
    </li>
    <li>
        <a href="/manager/new/?t=cities">New city</a>
    </li>
    <li>
        <a href="/manager/products">Show products</a>
    </li>
    <li>
        <a href="/manager/new/?t=products">New product</a>
    </li>
    <li>
        <a href="/manager/show/?t=customers">Показать клиентов</a>
    </li>
</ul>

<!--Вывод категорий и их подкатегория -->
<?php list( $cat, $subcat) = array_values($stat['categories']);
foreach ($cat as $k => $val) {
    echo '<table style="display: inline-block" border="1">';
    list($id, $name, $translit, $is_enabled, ,) = array_values($val);
    $is = $is_enabled == 1 ? 'Отключить' : 'Включить';
    echo '
<tr>
    <th>'.$id.'</th>
    <th><h3>' . $name . '</h3></th>
    <th>'.$translit.'</th>
    <th><a href="/manager/?action=toggle&cat='.$id.'">'.$is.'</a></th>
</tr>
';
    //Начало подкатегорий
    echo '<tr>
    <th>id</th><th>Название подкатегорий</th><th>Translit</th><th>State</th>
</tr>';
    for ($i=0; $i < count($subcat[$k]); $i++)
    {
        list( $id, $name, $translit, $is_enabled, , ) = array_values($subcat[$k][$i]);
        $is = $is_enabled == 1 ? 'Отключить' : 'Включить';
        echo '
<tr>
    <td>'.$id.'</td>
    <td>' . $name . '</td>
    <td>'.$translit.'</td>
    <td><a href="/manager/?action=toggle&cat='.$id.'">'.$is.'</a></td>
</tr>
';
    }

    echo  '</table>';
}
?>
