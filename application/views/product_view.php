<?php list( $name, $date, $cost, $earn, $oborot, $rashod, $region, $city, $address, $about, $shtat, $status, $images, $is_conf, , $brName, $brTel) = $product;
?>
<a href="/shop/list/"> Back</a>
<table border="1">
    <thead>
        <tr>
            <th colspan="6"><?=$name?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="4" rowspan="4">Images</td>
            <td colspan="2">
                <?php
                switch ($status)
                {
                    case 0:
                        echo 'NEW';
                        break;
                    case 2:
                        echo 'SOLD OUT';
                        break;
                }?>
            </td>
        </tr>
        <tr>
            <td> Host :</td>
            <td><?php
            if ($is_conf == 0)
                echo $product[17];
            else
                echo 'Конфидециально';
            ?>
            </td>
        </tr>
        <tr>
            <td>Added</td><td><?=format_date($date)?></td>
        </tr>
        <tr>
            <td>Cost : </td><td><?=format_cost($cost)?></td>
        </tr>
        <tr>
            <td colspan="2">Location</td>
            <td colspan="4"><?=$region?> / <?=$city?> / <?=$address?></td>
        </tr>
        <tr>
            <td>Pribyl</td><td><?=format_cost($earn)?></td>
        </tr>
        <tr>
            <td>Oborot :</td><td><?=format_cost($oborot)?></td>
        </tr>
        <tr>
            <td>Rashod :</td><td><?=format_cost($rashod)?></td>
        </tr>
        <tr>
            <td>Shtat : </td><td><?=$shtat?></td>
        </tr>
        <tr>
            <td colspan="6" rowspan="4"><?=$about?></td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td>Broker : </td><td><?=$brName?> - <?=$brTel?></td>
        </tr>
    </tbody>
</table>
