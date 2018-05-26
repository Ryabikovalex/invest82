<a href="/manager">Return to main page</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Cost</th>
        <th>City</th>
        <th>Address</th>
        <th>Category</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach ( $data as $k => $value){
        list( $id, $name, $cost, $city, $address, $category, $about ) = $value;
        echo '<tr>
        <td>'.$id.'</td>
        <td>'.$name.'</td>
        <td>'.$cost.'</td>
        <td>'.$city.'</td>
        <td>'.$address.'</td>
        <td>'.$category.'</td>
        <td> ... </td>
        <td><a href="/manager/edit/?t=products&entry='.$id.'">Edit</a></td>
        <td><a href="/manager/remove/?t=products&entry='.$id.'">Remove</a></td>
    </tr>';
    }?>
</table>