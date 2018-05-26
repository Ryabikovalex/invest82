<a href="/manager">Return to main page</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Translit</th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach ( $data as $k => $value){
        list( $id, $name, $translit, ) = $value;
    echo '<tr>
        <td>'.$id.'</td>
        <td>'.$name.'</td>
        <td>'.$translit.'</td>
        <td><a href="/manager/edit/?t=cities&entry='.$id.'">Edit</a></td>
        <td><a href="/manager/remove/?t=cities&entry='.$id.'">Remove</a></td>
    </tr>';
    }?>
</table>